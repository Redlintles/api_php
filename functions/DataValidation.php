<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";


function validateUsername(string $username)
{
    $regex = "/^[a-zA-Z]{8,46}(?:\d{0,4}?)$/";

    if(!preg_match($regex, $username)) {
        sendResponse(400, true, "Invalid Username, length must be in range(8,50) and it should not start with a number");
    }
}

function validatePassword($password)
{
    $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$/";
    if(!preg_match($regex, $password)) {

        sendResponse(400, true, "Invalid Password, length must be in range(8,30) and it should contain at least one uppercase letter, one lowercase, one number and one special character");
    }

}

function validateEmail($email)
{
    $regex = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";
    if(!preg_match($regex, $email)) {
        sendResponse(400, true, "Invalid Email(banana@gmail.com");

    }
}

function validatePermissionString(string $permissionString)
{
    $regex = "/^[0-1]{4}$/";
    if(!preg_match($regex, $permissionString)) {
        sendResponse(400, true, "Invalid permission string(1010");
        exit;
    }
}
