<?php



require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("GetSeller");

$body = bodyParser();

$body = groupValidation($body, [
    "keys" => [
        "seller_id?" => "validateInteger",
        "username?" => "validateUsername"
    ],
    "at_least" => 1,
    "audit" => $auditObj
]);


$targetSeller = findSingle($body, [
    "seller_id" => "id",
], \Buildings\SellerQuery::create(), true, $auditObj);


if (isset($targetSeller)) {
    sendResponse(200, false, "Seller fetched successfully", [
        "seller" => $targetSeller->toArray()
    ], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
