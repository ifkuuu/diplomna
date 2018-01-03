<?php
/**
 * Created by PhpStorm.
 * User: ifkuuu
 * Date: 27.12.2017 г.
 * Time: 20:57 ч.
 */

namespace Data\Products;


class CartViewData
{
    /**
     * @var Product[]
     */
    private $cartProducts;

    private $totalCartPrice;

    private $productQuantity;

    /**
     * @return mixed
     */
    public function getProductQuantity($id)
    {
        return $this->productQuantity[$id];
    }

    /**
     * @param mixed $productQuantity
     */
    public function setProductQuantity($id, $productQuantity)
    {
        $this->productQuantity[$id] = $productQuantity;
    }

    /**
     * @return Product[]
     */
    public function getCartProducts(): array
    {
        return $this->cartProducts;
    }

    /**
     * @param Product[] $cartProducts
     */
    public function setCartProducts(array $cartProducts)
    {
        $this->cartProducts = $cartProducts;
    }

    /**
     * @return mixed
     */
    public function getTotalCartPrice()
    {
        return $this->totalCartPrice;
    }

    /**
     * @param mixed $totalCartPrice
     */
    public function setTotalCartPrice($totalCartPrice)
    {
        $this->totalCartPrice = $totalCartPrice;
    }
}