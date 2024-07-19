<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";

function validationFactory(string $regex, string $message)
{
    return function (string | array $toValidate) use ($regex, $message) {
        if(is_array($toValidate)) {
            foreach($toValidate as $item) {
                if(!preg_match($regex, $item)) {
                    sendResponse(400, true, $message);
                }
            }
        } else {
            if(!preg_match($regex, $toValidate)) {
                sendResponse(400, true, $message);
            }
        }
    };
}


class Validate
{
    private static function validationFactory(string $regex, string $message)
    {
        return function (string | array $toValidate) use ($regex, $message) {
            if(is_array($toValidate)) {
                foreach($toValidate as $item) {
                    if(!preg_match($regex, $item)) {
                        sendResponse(400, true, $message);
                    }
                }
            } else {
                if(!preg_match($regex, $toValidate)) {
                    sendResponse(400, true, $message);
                }
            }
        };
    }


    public static function validateUsername(string $data)
    {
        $__validateUsername = self::validationFactory(...[
            "/^[a-zA-Z]{8,46}(?:\d{0,4}?)$/",
            "Invalid Username, length must be in range(8,50) and it should not start with a number"
        ]);
        $__validateUsername($data);
        return true;

    }

    public static function validateEmail(string $data)
    {
        $__validateEmail = self::validationFactory(...[
            "/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]+$/",
            "Invalid Email(banana@gmail.com)"
        ]);
        $__validateEmail($data);
        return true;
    }
    public static function validatePassword(string $data)
    {

        $__validatePassword = self::validationFactory(...[
            "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$/",
            "Invalid Password, length must be in range(8,30) and it should contain at least one uppercase letter, one lowercase, one number and one special character"

        ]);
        $__validatePassword($data);
        return true;
    }
    public static function validatePhoneNumber(string $data)
    {

        $__validatePhoneNumber = self::validationFactory(...[
                "/^[0-9]{11,15}$/",
                "Invalid Phone Number, min is 11 digits and max is 15"
        ]);
        $__validatePhoneNumber($data);
        return true;
    }
    public static function validatePermissionString(string $data)
    {

        $__validatePermissionString = self::validationFactory(...[
                "/^[0-1]{4}$/",
                "Invalid permission string, it should look like as '1010'"
        ]);
        $__validatePermissionString($data);
        return true;
    }
    public static function validateInteger(string $data)
    {

        $__validateInteger = self::validationFactory(...[
                "/^\d+$/",
                "Invalid Input (must be an integer)"
        ]);
        $__validateInteger($data);
        return true;
    }
    public static function validateState(string $data)
    {

        $__validateState = self::validationFactory(...[
                "/^[A-Z]{2}$/",
                "Invalid state(must be a capitalized string"
        ]);
        $__validateState($data);
        return true;
    }
    public static function validateHouseNumber(string $data)
    {

        $__validateHouseNumber = self::validationFactory(...[
                "/^[A-Za-z0-9\-\/\s]{1,10}$/",
                "Invalid houseNumber(must be a capitalized string"
        ]);
        $__validateHouseNumber($data);
        return true;
    }
    public static function validateCapitalized(string $data)
    {

        $__validateCapitalized = self::validationFactory(...[
               "/^(?:[A-Z][a-z]+\s?)+$/",
                "Invalid Capitalized String(must be a capitalized string)"
        ]);
        $__validateCapitalized($data);
        return true;
    }
    public static function validateUnityPrice(string $data)
    {

        $__validateUnityPrice = self::validationFactory(...[
                "/^[0-9]+\.[0-9]{2}$/",
                "Invalid Unity Price format is (10.99)"
        ]);
        $__validateUnityPrice($data);
        return true;
    }
    public static function validateDate(string $data)
    {

        $__validateDate = self::validationFactory(...[
            "/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/",
            "Invalid date, must be in format '2024-01-01 23:59:02' "
        ]);
        $__validateDate($data);
        return true;
    }


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
    "/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]+$/",
    "Invalid Email(banana@gmail.com)"
);

$validatePermissionString = validationFactory(
    "/^[0-1]{4}$/",
    "Invalid permission string, it should look like as '1010'"
);

$validateInteger = validationFactory(
    "/^\d+$/",
    "Invalid ID(must be a number)"
);

$validateState = validationFactory(
    "/^[A-Z]{2}$/",
    "Invalid state(must be a capitalized string"
);

$validateCapitalized = validationFactory(
    "/^(?:[A-Z][a-z]+\s?)+$/",
    "Invalid Capitalized String(must be a capitalized string)"
);

$validateHouseNumber = validationFactory(
    "/^[A-Za-z0-9\-\/\s]{1,10}$/",
    "Invalid houseNumber(must be a capitalized string"
);
$validatePhoneNumber = validationFactory(
    "/^[0-9]{11,15}$/",
    "Invalid Phone Number, min is 11 digits and max is 15"
);

$validateUnityPrice = validationFactory(
    "/^[0-9]+\.[0-9]{2}$/",
    "Invalid Unity Price format is (10.99)"
);

$validateDate = validationFactory(
    "/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/",
    "Invalid date, must be in format '2024-01-01 23:59:02' "
);

$validateIsInArray = function (string $string, array $arr) {

    if(!in_array($string, $arr, true)) {
        sendResponse(400, true, "Invalid key, $string must be in " . implode(",", $arr));
    }
};

$validateExpiration = function (string $date1, string $date2) {
    $timestamp1 = strtotime($date1);
    $timestamp2 = strtotime($date2);

    if($timestamp1 > $timestamp2) {
        sendResponse(400, true, "Invalid expiration, it should be a later time than start time");
    }
};

$validateIsInRange = function (int $val, int $min = 0, int $max = INF) {
    if(!($min < $val && $val < $max)) {
        sendResponse(400, true, "Invalid number, it should be in range ($min,$max)");
    }
};
