<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 4/29/2017
 * Time: 2:11 PM
 */
require_once("support.php");
function generateTable($userEmail){
    $body = "<table><tr><td class='restPage' style='text-align: center;'>";
    $restaurant = selectRestaurant("Email=\"$userEmail\"")[0];
    $image = $restaurant->picture;
    $phone = "(".substr($restaurant->phone,0,3).") ".substr($restaurant->phone,3,3)."-".substr($restaurant->phone,6,4);
    $email = "<a href=\"mailto:$restaurant->email\">".$restaurant->email."</a>";
    $address = $restaurant->address;
    $food_type = substr($restaurant->food,0,1).strtolower(substr($restaurant->food,1));
    $open = $restaurant->open;
    $close = $restaurant->close;
    $synopsis = $restaurant->synopsis;
    $hasOrderAhead = ($restaurant->takeout? "Call Ahead ordering available<br>": "");
    $body.='<img src="data:image/jpeg;base64,'.base64_encode($image).'" style="width:400px;height:228px;"></td>';
    $body.="<td class='restPage'>".$phone."<br>".$hasOrderAhead.$email."<br>".$address."<br>".$food_type." meal choices<br>Hours: ".$open."-".$close."<br></td></tr>";
    $body.="<tr><td colspan='2' class='restPage' >".$synopsis."</td></tr></table>";
    return $body;
}


?>