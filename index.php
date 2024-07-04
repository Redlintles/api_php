<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/conf/config.php";


$request = $_SERVER["REQUEST_URI"];

switch ($request) {
    case "/":
        echo "<h1>Hello World!</h1>";
        break;
    case "/api/Message":
        require __DIR__ . "/api/Message.php";
        break;
}
