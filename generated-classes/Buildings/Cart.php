<?php

namespace Buildings;

use Buildings\Base\Cart as BaseCart;

require_once __DIR__ . "/../../functions/collectionToArray.php";

/**
 * Skeleton subclass for representing a row from the 'cart' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Cart extends BaseCart
{
    public function addProduct(\Buildings\Product $targetProduct, int $qtd = 1)
    {
        $cartRows = \Buildings\CartProductQuery::create()->filterByIdCart($this->getId())->find();

        $alreadyInCart = false;
        foreach($cartRows as $row) {
            if($targetProduct->getId() === $row->getIdProduct()) {
                $row->setQuantity($row->getQuantity() + $qtd);
                $alreadyInCart = true;
                $row->save();
                break;
            }
        }

        if(!$alreadyInCart) {
            $row = new \Buildings\CartProduct();
            $row->setIdCart($this->getId());
            $row->setIdProduct($targetProduct->getId());
            $row->setQuantity($qtd);
            $row->save();
        }
    }

    public function removeProduct(\Buildings\Product $targetProduct, int $qtd = null)
    {
        $productRows = \Buildings\CartProductQuery::create()->filterByIdCart($this->getId())->find();

        foreach($productRows as $row) {
            if($row->getIdProduct() === $targetProduct->getId()) {

                if($qtd === null) {
                    $qtd = $row->getQuantity();
                }
                $newQtd = $row->getQuantity() - $qtd > 0 ? $row->getQuantity() - $qtd : 0;


                if($newQtd === 0) {
                    $row->delete();
                } else {
                    $row->setQuantity($newQtd);
                    $row->save();
                }
                break;
            }
        }
    }

    public function getProducts()
    {
        $cartProducts = \Buildings\CartProductQuery::create()->find();

        $result = [];

        $finalPrice = 0;

        foreach($cartProducts as $row) {
            $product = \Buildings\ProductQuery::create()
            ->useCartProductQuery()
                ->withColumn("CartProduct.quantity", "quantity")
            ->endUse()
            ->select(array("title","description","unity_price"))
            ->findOneById($row->getIdProduct());
            $arr = $product;
            $arr["final_price"] = $arr["quantity"] * $arr["unity_price"];
            $finalPrice += $arr["final_price"];
            array_push($result, $arr);
        }
        return [
            "products" => $result,
            "final_price" => $finalPrice
        ];

    }
}
