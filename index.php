<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Quick Bytes</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>


<body>
<?php
	/**
	 * Created by PhpStorm.
	 * User: Brendan
	 * Date: 5/7/2017
	 * Time: 1:23 AM
	 */
	require_once("support.php");
	session_start();
	session_destroy();

?>


<!-- home section -->
<section id="home">
	<div class="container">
		<div class="row">
			<div>
				<h1>QUICK BYTES</h1>
                <h2>No need to <i>wait</i> for dinner</h2>
				<form action="./searchFood.php" method="get" name="searchForm">
					<a class="smoothScroll btn btn-default" onclick="document.forms['searchForm'].submit(); return false;">Search Database</a>
					<!--input type="submit" value="Search Database"-->
				</form>
				<form action="./login.php" method="get" name="loginForm">
					<a href="#" class="smoothScroll btn btn-default" onclick="document.forms['loginForm'].submit(); return false;">Login</a>
					<!--input type="submit" value="Login"-->
				</form>
				
			</div>
		</div>
	</div>		
</section>
