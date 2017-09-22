<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 5/1/2017
 * Time: 9:41 PM
 */

require_once("support.php");
require("personalRestaurantPage.php");
if(isset($_GET['email'])){
    $email = $_GET['email'];
}
if(isset($_POST['review'])) {
    $rating = $_POST['review'];
    $comment = (isset($_POST['comment'])? $_POST['comment'] : "");
    $cus_name = (isset($_POST["name"]) && $_POST["name"]?  $_POST["name"]: "Anonymous");
    addReview($email, $rating, $comment, $cus_name);
}

$topPart = generateTable($email);

$topPart .= <<<EOBODY
        <h3>Comment and rate</h3>
		<form action="{$_SERVER["PHP_SELF"]}?email=$email" method="post">
			<strong>Name: </strong><input type="text" name="name"/>
            
			<strong>Rating: </strong><input type="number" min="1" max="5" name="review"  required/><br>
			<br><br>
			<textarea rows="3" cols="80" name="comment"></textarea> <br>
			<input type="submit" name="submitInfoButton" value="Post Review"/>	
			<a href="./searchFood.php"><input type="button" value="Create New Search"/></a>
			<a href="./index.php"><input type="button" value="Return to Main Page"/></a>
		</form>	
        
EOBODY;


$custReviews = selectReview("Res_Email=\"$email\"");
$reviews = (count($custReviews) == 0 ? "<p>Be the first to comment!</p><hr>" : "<p>".count($custReviews)." Comments</p><hr>");

foreach ($custReviews as $a){
    $reviews .= "<span class='comment-title'><br>".$a->customerName.": <span class='stars' style='font-size:1em'>".printStars($a->rating)."</span></span>".($a->comment ? "<br>"."Comment: ".$a->comment: "")."<br><br><hr>";
}
//echo wrapit(selectRestaurant("Email=\"$email\"")[0]->name,$topPart.$reviews);
$rname = selectRestaurant("Email=\"$email\"")[0]->name;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $rname ?></title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="contact">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
					<h1 class="heading"><?php echo $rname ?></h1>
					<hr>
				</div>
				<div class="col-md-offset-1 col-md-10 col-sm-12">
					<div class="col-md-3 col-sm-3"></div>
					<div class="col-md-10 col-sm-10">
						<?php echo $topPart.$reviews ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
