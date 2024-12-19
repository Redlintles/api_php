<?php

use Buildings\Base\DiscountQuery;
use Buildings\CategoryQuery;

/**
 * @param Buildings\Product $product Product to discount
 * @param string[] $categories Category array of the given product
 * @return array
 */

function getDiscounts(Buildings\Product $product, array $categories): array
{
    $categoriesId = [];
    $result = [];

    foreach ($categories as $cName) {
        $category = CategoryQuery::create()->findByName($cName);

        if (isset($category) && $category->count() > 0) {

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
        array_push($result, $discount);
    }
    foreach ($categoryDiscounts as $discount) {
        array_push($result, $discount);
    }

    return $result;
}


/**
 * @param Buildings\Product $product Product to discount
 * @param string[] $categories Category array of the given product
 * @return float
 */
function getDiscountsByFinalPrice(Buildings\Product $product, array $categories): float
{
    $price = $product->getUnityPrice();
    $final = 0;
    $discounts = getDiscounts($product, $categories);

    if (count($discounts) == 0) {
        return $price;
    }

    foreach ($discounts as $discount) {
        $final += (intval($discount->getPercent()) / 100) * $price;
    }


    return round($final, 2);

}

/**
 * @param Buildings\Product $product Product to discount
 * @param string[] $categories Category array of the given product
 * @return float
 */
function getIncrementalDiscounts(Buildings\Product $product, array $categories): float
{
    $price = $product->getUnityPrice();
    $discounts = getDiscounts($product, $categories);
    $priceArr = [$price];

    foreach ($discounts as $discount) {
        $last = $priceArr[count($priceArr) - 1];

        $d = ($discount->getPercent() / 100) * $last;

        array_push($priceArr, $last - $d);
    }

    return round($priceArr[count($priceArr) - 1], 2);
}
