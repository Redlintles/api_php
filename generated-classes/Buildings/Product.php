<?php

namespace Buildings;

use Buildings\Base\Product as BaseProduct;

/**
 * Skeleton subclass for representing a row from the 'product' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Product extends BaseProduct
{
    public function decrementProduct(int $qtd)
    {
        $newQtd = $this->getInStock() - $qtd > 0 ? $this->getInStock() - $qtd : 0;
        $this->setInStock($newQtd);
        $this->save();
    }

    public function incrementProduct(int $qtd)
    {
        $newQtd = $this->getInStock() + $qtd;
        $this->setInStock($newQtd);
        $this->save();
    }

}
