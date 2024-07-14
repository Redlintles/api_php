<?php

use Buildings\Category;

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/verifyUnicity.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "CREATE");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("AddCategory");


$category = new Category();


if(isset($body["name"])) {
    $validateCapitalized($body["name"]);
    verifyUnicity(\Buildings\CategoryQuery::create(), "name", $body["name"]);
    $category->setName($body["name"]);
    $category->save();
    sendResponse(200, false, "Category Created Successfully", ["category" => $category->toArray()], ["audit" => $auditObj]);
} else {
    sendResponse(400, true, "Category Name field not set", [], ["audit" => $auditObj]);
}
