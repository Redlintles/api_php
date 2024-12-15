<?php

use Buildings\Base\Category;
use Buildings\Base\DiscountQuery;
use Buildings\CategoryQuery;

function getDiscountsByFinalPrice($product, $categories)
{
    $price = $product->getUnityPrice();

    $final = 0;


    $categoriesId = [];


    foreach ($categories as $cName) {
        $category = CategoryQuery::create()->findByName($cName);

        if (isset($category)) {

            array_push($categoriesId, $category[0]->getId());
        }
    };



    $productDiscounts = dynamicQuery(DiscountQuery::create(), [
        "idProduct" => $product->getId(),
        "type" => "P"
    ]);

    $categoryDiscounts = dynamicQuery(DiscountQuery::create(), [
        "idCategory" => $categoriesId,
        "type" => "C"
    ]);



    foreach ($productDiscounts as $discount) {

        $final += ($discount->getPercent() / 100) * $price;
    }

    foreach ($categoryDiscounts as $discount) {
        $final += ($discount->getPercent() / 100) * $price;
    }

    return $final;

}


function getIncrementalDiscounts($product)
{


}
