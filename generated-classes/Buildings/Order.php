<?php

namespace Buildings;

use Buildings\Base\Order as BaseOrder;

/**
 * Skeleton subclass for representing a row from the 'orders' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Order extends BaseOrder
{
    public function addProduct(\Buildings\Product $targetProduct, int $qtd = 1)
    {
        $orderRows = \Buildings\OrderProductQuery::create()->filterByIdOrder($this->getId())->find();

        $alreadyInOrder = false;

        foreach ($orderRows as $row) {
            if ($targetProduct->getId() === $row->getIdProduct()) {
                $row->setQuantity($row->getQuantity() + $qtd);
                $alreadyInOrder = true;
                $row->save();
                break;
            }
        }

        if (!$alreadyInOrder) {
            $row = new \Buildings\OrderProduct();
            $row->setIdOrder($this->getId());
            $row->setIdProduct($targetProduct->getId());
            $row->setQuantity($qtd);
            $row->save();
        }
    }

    public function removeProduct(\Buildings\Product $targetProduct, int $qtd = null)
    {
        $productRows = \Buildings\OrderProductQuery::create()->filterByIdOrder($this->getId())->find();

        foreach ($productRows as $row) {
            if ($row->getIdProduct() === $targetProduct->getId()) {

                if ($qtd === null) {
                    $qtd = $row->getQuantity();
                }
                $newQtd = $row->getQuantity() - $qtd > 0 ? $row->getQuantity() - $qtd : 0;


                if ($newQtd === 0) {
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
        $orderProducts = \Buildings\OrderProductQuery::create()->find();

        $result = [];

        $finalPrice = 0;

        foreach ($orderProducts as $row) {
            $product = \Buildings\OrderQuery::create()
            ->useOrderProductQuery()
                ->withColumn("OrderProduct.quantity", "quantity")
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
