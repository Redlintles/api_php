<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$body = bodyParser();
$auditObj = new AuditObj($apiKey, "DELETE", $request);

permissionValidator($apiKey, "DELETE");
$auditObj->setOperation("DeleteProduct");

function decrementProduct(array $body, AuditObj $auditObj)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";


    $targetProduct = findSingle($body, [
        "product_id" => "id",
    ], \Buildings\ProductQuery::create(), true, $auditObj);

    Validate::validateInteger($body["quantity"]);
    $targetProduct->decrementProduct($body["quantity"]);
    sendResponse(400, true, "Product decremented by ".$body["quantity"]. " successfully(total=" . $targetProduct->getInStock() . ")", ["product" => $targetProduct->toArray()], ["audit" => $auditObj]);
}

function deleteProduct(array $body, AuditObj $auditObj)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";


    $targetProduct = findSingle($body, [
        "product_id" => "id",
    ], \Buildings\ProductQuery::create(), true, $auditObj);

    $targetProduct->delete();

    if ($targetProduct->isDeleted()) {
        sendResponse(200, false, "Product " . $targetProduct->getTitle() ." Deleted successfully", [], ["audit" => $auditObj]);
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }
}

if (!isset($body["type"])) {
    sendResponse(400, true, "Type field is not set, must be 'del' or 'dec'", [], ["audit" => $auditObj]);
} elseif ($body["type"] === "dec") {
    decrementProduct($body, $auditObj);
} elseif ($body["type"] === "del") {
    deleteProduct($body, $auditObj);
}
