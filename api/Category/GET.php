<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/collectionToArray.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("GetCategory");

$body = bodyParser();

$regex = $body["regex"];

$categories = \Buildings\CategoryQuery::create()->find();

$filtered = [];

foreach($categories as $category) {
    if(@preg_match($regex, $category->getName())) {
        array_push($filtered, $category->getName());
    }
}

if(!count($filtered)) {
    sendResponse(400, true, "Empty result, is pattern '$regex'
    
    valid?", [
        "regex" => $regex,
        "categories" => $filtered
    ], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(200, false, "Categories fetched successfully", [
        "regex" => $regex,
        "categories" => $filtered
    ], [
        "audit" => $auditObj
    ]);
}
