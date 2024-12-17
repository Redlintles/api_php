<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/discount.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$body = bodyParser();
$auditObj = new AuditObj($apiKey, "READ", $request);
permissionValidator($apiKey, "READ");
$auditObj->setOperation("ReadProduct");

$targetProduct = findSingle($body, [
    "product_id" => "id",
], \Buildings\ProductQuery::create(), true, $auditObj);


$categories = \Buildings\ProductCategoryQuery::create()->findByIdProduct($targetProduct);

$productCategories = [];
foreach ($categories as $c) {
    $category = \Buildings\CategoryQuery::create()->findOneById($c->getIdCategory());
    array_push($productCategories, $category->getName());
}


$discountedPrice = getDiscountsByFinalPrice($targetProduct, $productCategories);
$incrementalDiscountedPrice = getIncrementalDiscounts($targetProduct, $productCategories);

sendResponse(
    200,
    false,
    "Product found successfully",
    [
        "product" => $targetProduct->toArray(),
  "categories" => $productCategories,
   "discounted_price" => $discountedPrice,
   "incremental_discounted_price" => $incrementalDiscountedPrice
],
    [
    "audit" => $auditObj
]
);
