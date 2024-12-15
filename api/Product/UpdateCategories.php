<?php

use Propel\Runtime\Collection\Collection;

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/updateObject.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/collectionToArray.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dynamicQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateProductCategories");

$body = bodyParser();

$body = groupValidation($body, [
    "keys" => [
        "product_id?" => "validateInteger",
        "title?" => "validateInteger",
        "type" => ["validateIsInArray",["override", "insert", "delete"]],
        "categories" => "validateCapitalized"
    ],
    "at_least" => 3,
    "audit" => $auditObj
]);

$targetProduct = findSingle($body, [
    "keys" => [
        "product_id" => "validateInteger",
        "title" => "validateCapitalized"
    ],
    "audit" => $auditObj,
    "query" => \Buildings\ProductQuery::create()
]);


foreach ($body["categories"] as $categoryName) {
    $targetCategory = findSingle(["name" => $categoryName], [
        "keys" => [
            "name" => "validateCapitalized"
        ],
        "audit" => $auditObj,
        "query" => \Buildings\CategoryQuery::create()
    ]);
}

$productCategories = \Buildings\ProductCategoryQuery::create()->filterByIdProduct($targetProduct->getId())->find();

function deleteAll(\Propel\RUntime\Collection\Collection $arr)
{
    global $auditObj;
    foreach ($arr as $item) {
        $item->delete();

        if (!$item->isDeleted()) {
            sendResponse(400, true, "Category" . $item->getName() . "could not be deleted", [], ["audit" => $auditObj]);
        }
    }
}

echo "HERE";

if ($body["type"] === "delete") {
    $auditObj->setOperation("DeleteProductCategories");
    foreach ($productCategories as $pc) {
        $category = \Buildings\CategoryQuery::create()->findOneById($pc->getIdCategory());
        if (in_array($category->getName(), $body["categories"])) {
            $pc->delete();

            if (!$pc->isDeleted()) {
                sendResponse(400, true, "Category" . $item->getName() . "could not be deleted". ["audit" => $auditObj]);
            }

        }
    }

    $toReturn = array_map(function ($item) {
        $category = \Buildings\CategoryQuery::create()->findOneById($item["IdCategory"]);
        return $category->getName();
    }, collectionToArray($productCategories));

    $toReturn = array_values(array_diff($toReturn, $body["categories"]));

    sendResponse(200, false, "Categories deleted successfully", ["product" => $targetProduct, "deletedCategories" => $body["categories"], "remainingCategories" => $toReturn], ["audit" => $auditObj]);
} elseif ($body["type"] === "override") {
    $auditObj->setOperation("OverrideProductCategories");
    echo "Here";
    $toReturn = array_map(function ($item) {
        $category = \Buildings\CategoryQuery::create()->findOneById($item["IdCategory"]);
        return $category->getName();
    }, collectionToArray($productCategories));
    deleteAll($productCategories);
    foreach ($body["categories"] as $cName) {
        $category = \Buildings\CategoryQuery::create()->findOneByName($cName);
        $association = new \Buildings\ProductCategory();

        $association->setIdProduct($targetProduct->getId());
        $association->setIdCategory($category->getId());

        if (!$association->save()) {
            sendResponse(500, true, "An unexpected error ocurred, try again later", [], ["audit" => $auditObj]);
        }
    }
    sendResponse(200, false, "Product Categories overwritten succesfully", ["product" => $targetProduct,"oldCategories" => $toReturn, "newCategories" => $body["categories"]], ["audit" => $auditObj]);
} elseif ($body["type"] === "insert") {
    $auditObj->setOperation("InsertProductCategories");
    if (!$productCategories->isEmpty()) {

        $toInsert = array_map(function ($item) {
            $category = \Buildings\CategoryQuery::create()->findOneById($item["IdCategory"]);
            return $category->getName();
        }, collectionToArray($productCategories));

        $newCategories = array_values(array_unique(array_merge($toInsert, $body["categories"])));
        $toInsert = array_values(array_diff($body["categories"], $toInsert));
    } else {
        $toInsert = $body["categories"];
    }

    foreach ($toInsert as $cName) {
        $category = \Buildings\CategoryQuery::create()->findOneByName($cName);
        $association = new \Buildings\ProductCategory();

        $association->setIdProduct($targetProduct->getId());
        $association->setIdCategory($category->getId());

        if (!$association->save()) {
            sendResponse(500, true, "An unexpected error ocurred, try again later", [], ["audit" => $auditObj]);
        }
    }
    sendResponse(200, false, "Product Categories inserted succesfully", ["product" => $targetProduct->toArray(), "categories" => $newCategories, "addedCategories" => $toInsert], ["audit" => $auditObj]);

}
