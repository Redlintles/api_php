<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/discount.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];


permissionValidator($apiKey, "READ");
$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("ReadProduct");
$body = bodyParser();



$targetProduct = findSingle($body, [
    "audit" => $auditObj,
    "keys" => ["product_id" => 'validateInteger',"title" => 'validateCapitalized'],
    "query" => \Buildings\ProductQuery::create(),
]);

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
