<?php
/**
 * Created by PhpStorm.
 * User: Brendan
 * Date: 4/17/2017
 * Time: 3:28 PM
 */
declare(strict_types=1);
require_once("support.php");

$FOODIMAGES = array(
    "MEXICAN" => "mexican.jpg",
    "CHINESE" => "chinese.jpg",
    "BURGER" => "burger.jpg",
    "INDIAN" => "indian.jpg",
    "MEDITERRANEAN" => "mediterranean.jpg",
    "PIZZA" => "pizza.jpg",
    "ICECREAM" => "icecream.jpg",
    "SANDWICHES" => "sandwiches.jpg",
    "FALAFEL" => "falafel.jpg",
    "VIETNAMESE" => "vietnamese.jpg"
);
$body = <<<EOF

    <form action="searchFood.php" method="post">
        <a href="./index.php"><input type="button" value="Return to Main Page"></a>
        <input type="submit" value="Change Search requirements">
    </form>

EOF;
;
$noHit = true;
$criteria = [];
$sort = null;
$isOpen = false;

if(isset($_GET["resturaunt"])) {
    if ($_GET["resturaunt"] != ""){
        array_push($criteria, 'name="' . addslashes($_GET["resturaunt"]) . '" ');
    }
}
if(isset($_GET["sortby"])){
    $sort = $_GET["sortby"];
}
if(isset($_GET["takeout"])){
    array_push($criteria,"takeout=".($_GET["takeout"] == "on" ? "true": "false"));
}
if(isset($_GET["typeOfFood"])){
    $all = [];
    foreach ($_GET["typeOfFood"] as $choice){
        array_push($all, "food=\"".$choice."\"");
    }

    array_push($criteria,"(".join(" OR ",$all).")");
}
$isOpen = isset($_GET["open"]);

$pages = [];
$ratingSort = array(
    0 => [],
    1 => [],
    2 => [],
    3 => [],
    4 => [],
    5 => []
);

foreach(selectRestaurant(join(" AND ",$criteria),($sort != "rating"? $sort : null)) as $restaurant){
    $rating = 0;
    $totalEvals = 0;

    foreach(selectReview("res_email=\"".$restaurant->email."\"") as $review){
        $rating += (int)$review->rating;
        $totalEvals++;
    }
    $rating = (int)($totalEvals > 0? $rating/$totalEvals : $rating);
    if(!$isOpen || currentlyOpen($restaurant->open,$restaurant->close,getCurrentTime())) {
        $noHit = false;
        if ($sort == "rating") {
            array_push($ratingSort[$rating], build_document($restaurant, $rating));
        } else {
            $body .= build_document($restaurant, $rating);
        }
    }
}

$body1 = "";
if($sort == "rating"){
    for($i = 5; $i >= 0; $i--){
        foreach($ratingSort[$i] as $restaurant){
            $body1 .= $restaurant;
        }
    }
}

if($noHit){
    $body1 .= "<h1><strong>Sorry! We couldn't Find anything! :(</strong></h1>";
}
$body .= "<hr>";
//echo wrapit("Search Results",$body);

function build_document($restaurant,$stars){

    global $FOODIMAGES;
    $rate = "<div class='stars'>";

    for($i = 0; $i < $stars; $i++ ){
        $rate .= "&#9733; ";
    }

    $rate .= "</div>";
    $food = $restaurant->food;
    $phoneNum = "(".substr($restaurant->phone,0,3).") ".substr($restaurant->phone,3,3)."-".substr($restaurant->phone,6,4);


    $ret = <<<EOF
    
    <table style="width: 100%">
    <tr>
        <td style="text-align:left;">
            <h2><a href="viewPageClient.php?email=$restaurant->email">$restaurant->name</a></h2>
        </td>
        <td rowspan=2 style="text-align:center;">
            $rate
        </td>
        <td rowspan=3 style="text-align:right;">
            <img src="$FOODIMAGES[$food]" alt="$FOODIMAGES[$food]" height=150 width=120></img>
        </td>
    </tr>
    <tr>
        <td style="text-align:left;">
            Address: $restaurant->address
        </td>
    </tr>
        <td style="text-align:left;">
            Hours: $restaurant->open-$restaurant->close
        </td>
        <td style="text-align:center;">
            Phone: $phoneNum
        </td>
    <tr>
    </tr>
    </table>
    <hr>
EOF;

    return $ret;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Result List</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="contact">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
					<h1 class="heading">Result List</h1>
					<hr>
				</div>
				<div class="col-md-offset-1 col-md-10 col-sm-12">
					<div class="col-md-3 col-sm-3"></div>
					<div class="col-md-12 col-sm-12 text-center">
						<?php echo $body ?>
					</div>
                    <div class="col-md-12 col-sm-12">
                        <?php echo $body1 ?>
                    </div>
				</div>
			</div>
		</div>
	</section>
</body>
