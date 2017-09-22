/**
 * Created by Helen on 5/6/2017.
 */
"use strict";

function checkIntent(comment){
    return confirm(comment);
}

function validate(){

    let errors="";
    let valid = true;


    if(document.getElementById("password").value != document.getElementById("confirmation").value) {
        errors += "Password and Password Confirmation fields do not match\n";
        valid = false;
    }

    if(!(validTime(document.getElementById("open").value) && validTime(document.getElementById("close").value) && timeComesAfter(document.getElementById("open").value,document.getElementById("close").value))){

        errors += "Invalid Hours provided\n";
        valid = false;

    }

    let phone_p1 = document.getElementById("phone1").value;
    let phone_p2 = document.getElementById("phone2").value;
    let phone_p3 = document.getElementById("phone3").value;

    if(!((isNum(phone_p1) && phone_p1.length == 3) && (isNum(phone_p2) && phone_p2.length == 3) && (isNum(phone_p3) && phone_p3.length == 4))){

        errors += "Invalid phone number\n";
        valid = false;
    }

    if(!document.getElementById("yes").checked && !document.getElementById("no").checked){
        errors += "Order Ahead Option not selected\n";
        valid = false;
    }

    if(!valid){
        alert(errors);
    }

    return valid;
}

function timeComesAfter(before,query){
    let beforeTimes = before.split(":")
    beforeTimes[0] = Number(beforeTimes[0]);
    beforeTimes[1] = Number(beforeTimes[1]);
    let queryTimes = query.split(":")
    queryTimes[0] = Number(queryTimes[0]);
    queryTimes[1] = Number(queryTimes[1]);

    return queryTimes[0] > beforeTimes[0] || (queryTimes[0] == beforeTimes[0] && beforeTimes[1] < queryTimes[1])
}


function validTime(time){

    let $hr_min = time.split(":");

    if($hr_min.length == 2){

        if(!isNaN($hr_min[0]) && !isNaN($hr_min[1])){
            if(0 <= Number($hr_min[0]) && Number($hr_min[0]) < 24 && 0 <= Number($hr_min[1]) && Number($hr_min[1]) < 60){
                return true;
            }
        }
    }
    return false;
}
function isNum(num){

    return !isNaN(num);
}