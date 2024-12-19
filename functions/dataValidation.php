<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";






/**
 * A Class for centering validation logic
 *
 */
class Validate
{
    /**
     * A factory for simple validation functions
     * The callable returned functions receives Strings or arrays and call sendResponse with 400 status code if the validation fails
     * @param string $regex The Regex to be applied
     * @param string $message The Message returned in the case of error
     * @return callable Returns the validation function
     */
    private static function validationFactory(string $regex, string $message)
    {
        return function (string | array $toValidate) use ($regex, $message) {
            if (is_array($toValidate)) {
                foreach ($toValidate as $item) {
                    if (!preg_match($regex, $item)) {
                        sendResponse(400, true, $message);
                    }
                }
            } else {
                if (!preg_match($regex, $toValidate)) {
                    sendResponse(400, true, $message);
                }
            }
        };
    }

    /**
     * Validate an username based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateUsername(array | string $data): bool
    {
        $__validateUsername = self::validationFactory(...[
            "/^[a-zA-Z]{8,46}(?:\d{0,4}?)$/",
            "Invalid Username, length must be in range(8,50) and it should not start with a number"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateUsername($val);
            }
        } else {
            $__validateUsername($data);
        }
        return true;

    }

    /**
     * Validate an email based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateEmail(array | string $data): bool
    {
        $__validateEmail = self::validationFactory(...[
            "/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]+$/",
            "Invalid Email(banana@gmail.com)"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateEmail($val);
            }
        } else {
            $__validateEmail($data);
        }
        return true;
    }
    /**
     * Validate a password based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validatePassword(array | string $data): bool
    {

        $__validatePassword = self::validationFactory(...[
            "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$/",
            "Invalid Password, length must be in range(8,30) and it should contain at least one uppercase letter, one lowercase, one number and one special character"

        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validatePassword($val);
            }
        } else {
            $__validatePassword($data);
        }
        return true;
    }
    /**
     * Validate a phone number based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validatePhoneNumber(array | string $data): bool
    {

        $__validatePhoneNumber = self::validationFactory(...[
                "/^[0-9]{11,15}$/",
                "Invalid Phone Number, min is 11 digits and max is 15"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validatePhoneNumber($val);
            }
        } else {
            $__validatePhoneNumber($data);
        }
        return true;
    }
    /**
     * Validate a permission string based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validatePermissionString(array | string $data): bool
    {

        $__validatePermissionString = self::validationFactory(...[
                "/^[0-1]{4}$/",
                "Invalid permission string, it should look like as '1010'"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validatePermissionString($val);
            }
        } else {
            $__validatePermissionString($data);
        }
        return true;
    }
    /**
     * Validate an integer string based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateInteger(array | string $data): bool
    {

        $__validateInteger = self::validationFactory(...[
                "/^\d+$/",
                "Invalid Input (must be an integer)"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateInteger($val);
            }
        } else {
            $__validateInteger($data);
        }
        return true;
    }
    /**
     * Validate a country state code based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateState(array | string $data): bool
    {

        $__validateState = self::validationFactory(...[
                "/^[A-Z]{2}$/",
                "Invalid state(must be a capitalized string"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateState($val);
            }
        } else {
            $__validateState($data);
        }
        return true;
    }
    /**
     * Validate a house number code based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateHouseNumber(array | string $data): bool
    {

        $__validateHouseNumber = self::validationFactory(...[
                "/^[A-Za-z0-9\-\/\s]{1,10}$/",
                "Invalid houseNumber(must be a capitalized string"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateHouseNumber($val);
            }
        } else {
            $__validateHouseNumber($data);
        }
        return true;
    }
    /**
     * Validate a capitalized string based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateCapitalized(array | string $data): bool
    {

        $__validateCapitalized = self::validationFactory(...[
               "/^(?:[A-Z][a-z]+\s?)+$/",
                "Invalid Capitalized String(must be a capitalized string)"
        ]);

        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateCapitalized($val);
            }
        } else {
            $__validateCapitalized($data);
        }


        return true;
    }
    /**
     * Validate a product unity price based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateUnityPrice(array | string $data): bool
    {

        $__validateUnityPrice = self::validationFactory(...[
                "/^[0-9]+\.[0-9]{2}$/",
                "Invalid Unity Price format is (10.99)"
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateUnityPrice($val);
            }
        } else {
            $__validateUnityPrice($data);
        }


        return true;
    }
    /**
     * Validate a date based on a regex
     * @param string[]|string $data the data to be validated
     * @return bool always return true or an error if the validation fails
     */
    public static function validateDate(array | string $data): bool
    {

        $__validateDate = self::validationFactory(...[
            "/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/",
            "Invalid date, must be in format '2024-01-01 23:59:02' "
        ]);
        if (is_array($data)) {

            foreach ($data as $val) {
                $__validateDate($val);
            }
        } else {
            $__validateDate($data);
        }
        return true;
    }
    /**
     * checks if a value exists in an array
     * @param string $data the data to be validated
     * @param string[] $arr The array that will be checked
     * @return bool always return true or an error if the validation fails
     */

    public static function validateIsInArray(string $data, array $arr): bool
    {

        $__validateIsInArray = function (string $string, array $arr) {

            if (!in_array($string, $arr, true)) {
                sendResponse(400, true, "Invalid key, $string must be in " . implode(",", $arr));
            }
        };

        $__validateIsInArray($data, $arr);


        return true;
    }

    public static function validateExpirationTimeBefore(string $dateString)
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);

        if ($date && $date->format('Y-m-d H:i:s') === $dateString) {
            $now = new DateTime();

            if ($date < $now) {
                sendResponse(422, true, "A data do desconto está no passado!", []);
            }

        }

        sendResponse(422, true, "A data está no formato incorreto");


    }


}
