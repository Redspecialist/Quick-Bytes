<?php
/**
 * Created by PhpStorm.
 * User: Brendan
 * Date: 4/17/2017
 * Time: 3:18 PM
 */


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Search Local Food Options</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="contact">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
					<h1 class="heading">Find Something To Eat</h1>
					<hr>
				</div>
				<div class="col-md-offset-1 col-md-10 col-sm-12">
					
					
					<form action="listResults.php" method="get">
						<div class="col-md-3 col-sm-3"></div>
					  <div class="col-md-3 col-sm-3">
							<label>Type of Food:</label>
							<select multiple name="typeOfFood[]" required>
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
                            <br>
                            <br>
                            <label>Sort by:</label>
                            <select name="sortby" colspan>
                                 <option value="rating">Rating</option>
                                 <option value="open">Opening Time</option>
                                 <option value="close">Closing Time</option>
                                 <option value="name">Name</option>
                                 <option value="address">Address</option>
                          </select>
							</div>
							<div class="col-md-3 col-sm-3">
							<input type="text" name="resturaunt" placeholder="Restauraunt Name" class="form-control"><br>
							<label><input type="checkbox" name="takeout"> Can Order Ahead<label><br>
							<label><input type="checkbox" name="open"> Currently Open</label><br>

					  </div>
						<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
							<input type="submit" value="Search For Food" class="form-control">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>