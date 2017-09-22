<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 5/1/2017
 * Time: 9:16 PM
 */
//require_once("support.php");
include "personalRestaurantPage.php";
session_start();
$email = $_SESSION['email'];

$body = generateTable($email);;
$rname = selectRestaurant("Email=\"$email\"")[0]->name;

$body .= "<form action=\"changeinfo.php\" style='display: inline'>
    <input type=\"submit\" value='Continue Editing'>
</form>";
$body .= "<form action=\"index.php\" style='display: inline'>
    <input type=\"submit\" value='Return to Front Page'>
</form>";
$body .= "</body>";

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
                    <?php echo $body ?>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
