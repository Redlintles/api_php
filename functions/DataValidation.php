<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";

function validationFactory(string $regex, string $message)
{
    return function (string $toValidate) use ($regex, $message) {
        if(!preg_match($regex, $toValidate)) {
            sendResponse(400, true, $message);
        }
    };
}

$validateUsername = validationFactory(
    "/^[a-zA-Z]{8,46}(?:\d{0,4}?)$/",
    "Invalid Username, length must be in range(8,50) and it should not start with a number"
);

$validatePassword = validationFactory(
    "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$/",
    "Invalid Password, length must be in range(8,30) and it should contain at least one uppercase letter, one lowercase, one number and one special character"
);

$validateEmail = validationFactory(
    "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/",
    "Invalid Email(banana@gmail.com"
);

$validatePermissionString = validationFactory(
    "/^[0-1]{4}$/",
    "Invalid permission string, it should look like as '1010'"
);

$validateId = validationFactory(
    "/^\d+$/",
    "Invalid ID(must be a number)"
);

$validateState = validationFactory(
    "/^[A-Z]{2}$/",
    "Invalid state(must be a capitalized string"
);

$validateLocation = validationFactory(
    "/^(?:[A-Z][a-z]+\s?)+$/",
    "Invalid location(must be a capitalized string"
);

$validateHouseNumber = validationFactory(
    "/^[A-Za-z0-9\-\/\s]{1,10}$/",
    "Invalid houseNumber(must be a capitalized string"
);
