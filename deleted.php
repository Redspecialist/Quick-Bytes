<?php
require_once("support.php");

session_start();
$email = $_SESSION["email"];

deleteRestaurant($email);


session_destroy();
header("Location: ./index.php")
?>