<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/conf/config.php";

require __DIR__ . "/functions/initDb.php";
require __DIR__ . "/functions/ApiKeyValidation.php";

initRoot();
apiKeyValidator();



$request = $_SERVER["REQUEST_URI"];

switch ($request) {
    case "/":
        echo "<h1>Hello World!</h1>";
        break;
    case "/api/Message":
        require __DIR__ . "/api/admin.php";
        break;
}
