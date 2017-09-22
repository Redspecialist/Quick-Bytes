<?php
require_once "support.php";
if (session_status() != PHP_SESSION_NONE) {
    session_destroy();
}
$bottompart = "";


if(isset($_POST['submit1'])){
    $x = $_POST["username"];
    $sort = null;
    $check = selectRestaurant("email=\"".$x."\"");

    if(count($check)>0 && $check[0]->password == $_POST["password"]){
        session_start();
        $_SESSION["email"] = $_POST["username"];
        header('Location: ./changeinfo.php');
    }
    else{
        $bottompart = "<h4>A record with that password username combination could not be found</h4>";
    }
}

$body = <<<EOPAGE

        <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url("res.png");
        }
        #rcorners {
             border-radius: 25px;
             border: 2px solid brown;
             background:rgba(214, 209, 209,0.5);
             padding: 50px;
             width: 500px;
             height: 500px;
             text-align: center;
             margin: auto;
             margin-top: 50px;
        }
        
        h3 {
	        color: Black;
	        font-family: 'Droid Serif';
	        border-bottom: 3px solid #E65634;
        	border-top: 3px solid #E65634;
	        font-size: 15px;
	        font-weight: 400;
        	line-height: 60px;
	        margin: 0 auto 45px;
        	max-width: 600px;
        	padding: 5px 0;
        	text-align: center;
        }
        
        #black {
            color: Brown;
	        font-family: 'Ubuntu';
	        font-size: 20px;
	        font-weight: 300;
	        line-height: 36px;
	        margin: 20px;
	        max-width: 400px;
	        text-align: left;
        }

        p {
	        color: Black;
	        font-family: 'Ubuntu';
	        font-size: 20px;
	        font-weight: 300;
	        line-height: 36px;
	        margin: 20px;
	        left-margin: auto;
	        max-width: 400px;
	        text-align: left;
        }

        a {
	        color: #E65634;	
        }

        a:hover {
	        color: #fff;
        }

        </style>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Ubuntu:300italic,400,400italic,700,700italic' rel='stylesheet' type='text/css'>
        <fieldset id="rcorners">
       
		<form action="{$_SERVER["PHP_SELF"]}" method="post">
				
            <h1><Strong>Restaurant Login</Strong></h1>
            
            <h3><em>We hope you find everything you're looking for.</em></h3>

            <b>Email:<b> <input type="text" name="username">
            <br><br>

            <b>Password:<b> <input type="password" name="password">
            <br><br><br>
            
            <button type="submit" name = "submit1" class="smoothScroll btn btn-default" value="Login">Submit</button>
            <a href="./index.php"><input type="button" class="smoothScroll btn btn-default" value="Return to Main Page"/></a>
            </form>
            <br><br>
            <a href="./setup.php">Set Up New Account</a>
            $bottompart
        </fieldset>
        <br><br><br>
<p><em>“Life in the restaurant business can provide a start in the working world for young people or a stable living for many Americans and their families”</em></p>
<b id="black">-Kevin McCarthy</b>

EOPAGE;

echo wrapit("Login Service",$body);

?>