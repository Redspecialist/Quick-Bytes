<?php
	$host = "localhost";
	$user = "res_user";
	$dbpassword = "res_pass";
	$database = "restaurant_db";
	$res_tb = "restaurants";
	$review_tb = "reviews";
	

function selectRestaurant($criteria, $sort = null) {
	/* Connecting to the database */
	global $host, $user, $dbpassword, $database, $res_tb;
	$db_connection = new mysqli($host, $user, $dbpassword, $database);
	if ($db_connection->connect_error) {
		return null;
	} else {
		if ($sort == null) {
			$sort = "";
		} else {
			$sort = ' order by '.$sort;
		}
		if($criteria){
		    $criteria = ' where '.$criteria;
        }

		$query = 'select * from '.$res_tb.$criteria.$sort;
		/* Executing query */
		$result = $db_connection->query($query);
		/* Closing connection */
		$db_connection->close();
		
		if (!$result) {
			return [];
		} else {
		    $ret = [];
            while($recordArray = $result->fetch_array(MYSQLI_ASSOC)) {
                array_push($ret,new RestaurantRecord($recordArray["email"],$recordArray["name"],$recordArray["open"],$recordArray["close"],$recordArray["pictures"],$recordArray["address"],$recordArray["phone"],$recordArray["food"],$recordArray["synopsis"],$recordArray["password"],$recordArray["takeout"]));
            }
			return $ret;
		}
	}
}

function addRestaurant($name, $address, $phone, $email, $picture, $food, $open, $close,$synopsis, $password, $takeout = 0) {
	/* Connecting to the database */
	global $host, $user, $dbpassword, $database, $res_tb;
	$db_connection = new mysqli($host, $user, $dbpassword, $database);
	if ($db_connection->connect_error) {
		return null;
	} else {
	    $takeout = ($takeout? 1 : 0);
	    $picture = mysqli_real_escape_string($db_connection,$picture);
	    $synopsis = mysqli_real_escape_string($db_connection,$synopsis);
	    $name = mysqli_real_escape_string($db_connection,$name);
		$query = "insert into $res_tb (name,address,phone,email,pictures,food,open,close,synopsis,password,takeout) values(\"$name\", \"$address\", \"$phone\", \"$email\", \"$picture\",\"$food\", \"$open\", \"$close\", \"$synopsis\",\"$password\",$takeout)";
		/* Executing query */
		$result = $db_connection->query($query);
		/* Closing connection */
		$db_connection->close();
		echo $result;
		if (!$result) {
			return null;
		} else {
			return $result;
		}
	}
}

function deleteRestaurant($email) {
	/* Connecting to the database */
	global $host, $user, $dbpassword, $database, $res_tb, $review_tb;
	$db_connection = new mysqli($host, $user, $dbpassword, $database);
	if ($db_connection->connect_error) {
		return null;
	} else {
		$query = 'delete from '.$res_tb.' where email = "'.$email.'"';
		/* Executing query */
		$result = $db_connection->query($query);
		/* Closing connection */

		
		if (!$result) {
            $db_connection->close();
			return 0;

		} else {

            $query = 'delete from '.$review_tb.' where res_email = "'.$email.'"';
            $db_connection->query($query);
            $db_connection->close();
			return 1;
		}
	}
}

function printStars($stars){

    $rate = "<span class=\"stars\">";

    for($i = 0; $i < $stars; $i++ ){
        $rate .= "&#9733; ";
    }
    $rate .= "</span>";

    return $rate;
}

function addReview($email, $rating, $comment, $cus_name="Anonymous") {
	/* Connecting to the database */
	global $host, $user, $dbpassword, $database, $review_tb;
	$db_connection = new mysqli($host, $user, $dbpassword, $database);
	if ($db_connection->connect_error) {
		return null;
	} else {

        $comment = mysqli_real_escape_string($db_connection,$comment);
        $cus_name = mysqli_real_escape_string($db_connection,$cus_name);

		$query = "insert into {$review_tb} (res_email,cus_name,rating,comment) values(\"$email\", \"$cus_name\", \"$rating\", \"$comment\")";
		/* Executing query */
		$result = $db_connection->query($query);
		/* Closing connection */
		$db_connection->close();
		
		if (!$result) {
			return 0;
		} else {
			return 1;
		}
	}
}

//edits must be a hash that maps type of field to new value for that field
//EX. ["name"] => "new name" , ["close"] =>"9:00pm";
function updateRestaurant($email, $edits){
    global $host, $user, $dbpassword, $database, $res_tb;
    $db_connection = new mysqli($host, $user, $dbpassword, $database);
    if ($db_connection->connect_error || !$edits) {
        return null;
    } else {
        $selections = [];
        if(isset($edits["pictures"])){
            $edits["pictures"] = mysqli_real_escape_string($db_connection,$edits["pictures"]);
        }
        if(isset($edits["name"])){
            $edits["synopsis"] = mysqli_real_escape_string($db_connection,$edits["synopsis"]);
            $edits["name"] = mysqli_real_escape_string($db_connection,$edits["name"]);
        }

        foreach($edits as $key => $value){
            array_push($selections,"$key=\"$value\"");
        }

        $query = 'update '.$res_tb.' set '.join($selections,", ").' where email="'.$email.'"';
        /* Executing query */
        $result = $db_connection->query($query);
        /* Closing connection */
        $db_connection->close();

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }
}

function selectReview($criteria) {
	/* Connecting to the database */
	global $host, $user, $dbpassword, $database, $review_tb;
	$db_connection = new mysqli($host, $user, $dbpassword, $database);
	if ($db_connection->connect_error) {
		return null;
	} else {
		$query = 'select * from '.$review_tb.' where '.$criteria;
		/* Executing query */
		$result = $db_connection->query($query);
		/* Closing connection */
		$db_connection->close();
		
		if (!$result) {
			return false;
		} else {

		    $ret = [];
            while($recordArray = $result->fetch_array(MYSQLI_ASSOC)){
                array_push($ret,new ReviewRecord($recordArray["res_email"],$recordArray["rating"],$recordArray["comment"],$recordArray["cus_name"]));
            }

			return $ret;
		}
	}
}

function wrapit($header,$body){
    return <<<EOF
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>$header</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    
    <body>
        $body
    </body>
</html>
EOF;
}

function getCurrentTime(){
    $right = time()/60 % 60;
    $left = ((time()/3600 + 24)-4) %24;
    return $left.":".$right;
}
function currentlyOpen($open,$close,$query){
    $openTimes = explode(":",$open);
    $openTimes[0] = (int)($openTimes[0]);
    $openTimes[1] = (int)($openTimes[1]);
    $closeTimes = explode(":",$close);
    $closeTimes[0] = (int)($closeTimes[0]);
    $closeTimes[1] = (int)($closeTimes[1]);
    $qTimes = explode(":",$query);
    $qTimes[0] = (int)($qTimes[0]);
    $qTimes[1] = (int)($qTimes[1]);

    $ret = $qTimes[0] > $openTimes[0] || ($qTimes[0] == $openTimes[0] && $qTimes[1] >= $openTimes[1]);
    $ret = $ret && ($closeTimes[0] > $qTimes[0] || ($closeTimes[0] == $qTimes[0] && $closeTimes[1] >= $qTimes[1]));
    return $ret;
}


class RestaurantRecord{
    public $email;
    public $name;
    public $open;
    public $close;
    public $picture;
    public $address;
    public $phone;
    public $food;
    public $synopsis;
    public $password;
    public $takeout;

    public function __construct($eml, $nm, $opn,$cls, $pic, $addr, $phn, $fd, $syn,$pass,$tkot){
        $this->email = $eml;
        $this->name = $nm;
        $this->open = $opn;
        $this->close = $cls;
        $this->picture = $pic;
        $this->address = $addr;
        $this->phone = $phn;
        $this->food = $fd;
        $this->synopsis = $syn;
        $this->password = $pass;
        $this->takeout = $tkot;
    }
}

class ReviewRecord{
    public $restaurant;
    public $customerName;
    public $rating;
    public $comment;

    public function __construct($rest,$rate,$com,$cust = "Anonymous"){
        $this->customerName = $cust;
        $this->rating = $rate;
        $this->comment = $com;
        $this->restaurant = $rest;
    }


}

?>