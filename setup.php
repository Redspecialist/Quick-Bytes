<?php
require_once "support.php";

$host = "localhost";
$user = "res_user";
$dbpassword = "res_pass";
$database = "restaurant_db";
$res_tb = "restaurants";
$review_tb = "reviews";
$warningText = "";
$order = false;
$newName = (isset($_POST["name"])?$_POST["name"]:"");
$newOpen = (isset($_POST["open"])? $_POST["open"] : "");
$newClose = (isset($_POST["close"])? $_POST["close"] : "");
$newEmail = (isset($_POST["email"])? $_POST["email"] : "");
$newAddress = (isset($_POST["address_line1"])? $_POST["address_line1"] : "");
$phone1 = (isset($_POST["phone1"])? $_POST["phone1"]: "");
$phone2 = (isset($_POST["phone2"])? $_POST["phone2"]: "");
$phone3 = (isset($_POST["phone3"])? $_POST["phone3"]: "");
$newFood = (isset($_POST["food"])? $_POST["food"]: "");
$newSynopsis = (isset($_POST["synopsis"])? $_POST["synopsis"]: "");
$orderYes =  "";
$orderNo = "";
if(isset($_POST['submit1'])) {
    session_start();
    $newOpen = (strlen($_POST["open"])== 4? "0".$_POST["open"]: $_POST["open"]);
    $newClose = (strlen($_POST["close"])== 4? "0".$_POST["close"]: $_POST["close"]);;
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];
    $newPassword = $_POST["password"];
    $newPhone = $phone1.$phone2.$phone3;
    $order = $_POST["orderAhead"] == "yes";
    $pictureData = file_get_contents($_FILES["restaurant_Picture"]["tmp_name"]);
    $orderYes = ($order? "checked" : "");
    $orderNo = ($order? "" : "checked");

    if (!addRestaurant($newName, $newAddress, $newPhone, $newEmail, $pictureData, $newFood, $newOpen, $newClose, $newSynopsis, $newPassword, $order)) {
        $warningText = "<span style=\"color:red\">*Email Already Taken</span>";
    } else {
        header('Location: viewPageRestaurant.php');

    }
}
    $body = <<<EOPAGE
    <script type="text/javascript" src="validate.js"></script>
<form action="{$_SERVER["PHP_SELF"]}" enctype="multipart/form-data"  onsubmit="return validate();" method="post">


    
    
    Email: <input type="email" name="email" value="{$newEmail}" required maxlength=200> $warningText
    <br><br>
    
    Password: <input type="password" name="password" id="password" required maxlength=64>
    <br><br>
    Password Confirmation: <input type="password" id="confirmation" required maxlength=64>
    <br><br>
    
    Restaurant name: <input type="text" name="name" value="{$newName}" maxlength=50 required>
    <br><br>

    Hours: <input type="text" name="open" id="open" maxlength=5 value="{$newOpen}" size=4 required> - <input type="text" value="{$newClose}" name="close" id="close" size=4 maxlength=5 required>
    <br><br>

    Pictures: <input type="file" name="restaurant_Picture" required>
    
    <br><br>

    Address: <br>
    <input type="text" name="address_line1" value="{$newAddress}" size=50 required><br><br>
    <br>

    Phone: <input type="text" name="phone1" id="phone1" size=3 value="{$phone1}" maxlength=3 required> - <input type="text" name="phone2" value="{$phone2}" id="phone2" size=3 maxlength=3 required> - <input type="text" name="phone3" value="{$phone3}" id="phone3" size=4 maxlength=4 required>
    <br><br>
    
    Do You provide online or call ahead ordering? 
    <label><input type="radio" name="orderAhead" id="yes" value="yes" $orderYes>Yes</input></label>
    <label><input type="radio" name="orderAhead" id="no" value="no" $orderNo>No</input></label>
    <br><br>
    
    Food Type: 
    <select name="food">
        <option value="Mexican">Mexican</option>
        <option value="Chinese">Chinese</option>
        <option value="Burger">Burgers</option>
        <option value="Indian">Indian</option>
        <option value="Mediterranean">Mediterranean</option>
        <option value="Pizza">Pizza</option>
        <option value="Icecream">Icecream</option>
        <option value="Sandwiches">Sandwiches</option>
        <option value="Falafel">Falafel</option>
        <option value="Vietnamese">Vietnamese</option>
    </select>
    <br><br>

    Synopsis (5000 character Maximum)<br> <textarea maxlength=5000 name="synopsis" rows="4" cols="60">$newSynopsis</textarea>
    <br><br>

    <input type="submit" name="submit1" value="Commit Changes"/>
    <a href="./login.php"><input type="button" value="Return to Login"/></a>
    <a href="./index.php"><input type="button" value="Return to Main Page"/></a>
</form>

EOPAGE;

    //echo wrapit("Setup Account",$body);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Setup Account</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="contact">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
					<h1 class="heading">Welcome! Let's Set Up <i>Your</i> Account!</h1>
					<hr>
				</div>
				<div class="col-md-offset-1 col-md-10 col-sm-12">
					<div class="col-md-3 col-sm-3"></div>
					<div class="col-md-8 col-sm-8">
						<?php echo $body ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
