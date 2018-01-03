<?php

namespace Service\Cart;


use Data\Products\CartViewData;
use Service\ProductService;
use Service\ProductServiceInterface;

class CartService implements CartServiceInterface
{

    /**
     * @var ProductService
     */
    private $productService;

    private $cartContents = [];

    private $totalPrice;

    private $totalItems;

    /**
     * CartService constructor.
     * @param $SESSION
     * @param ProductServiceInterface $productService
     */
    public function __construct(&$SESSION, ProductServiceInterface $productService)
    {
        $this->productService = $productService;
        $this->cartContents = !empty($SESSION['cartContents']) ? $SESSION['cartContents'] : NULL;
        $this->totalItems = $SESSION['totalItems'] = !empty($SESSION['totalItems']) ? $SESSION['totalItems'] : 0;
        $this->totalPrice = $SESSION['totalCartAmount'] = !empty($SESSION['totalCartAmount']) ? $SESSION['totalCartAmount'] : 0;
    }

    public function addProduct($id, $quantity = 1)
    {
        $this->cartContents[$id]['id'] = $id;
        $this->cartContents[$id]['qty'] = !isset($this->cartContents[$id]['qty']) ? 0 : $this->cartContents[$id]['qty'];
        $this->cartContents[$id]['qty'] += $quantity;

        $product = $this->productService->getProductInfo($id);
        $productStock = $product->getStock();

        if ($quantity > $productStock) {
            throw new \Exception("Съжаляваме, но на склад имаме {$productStock} бройки");
        }
        $product->setStock($productStock - $quantity);
        $this->productService->updateProductStock($id, $product->getStock());

        if ($product->getDiscountedPrice() !== null) {
            $this->totalPrice += $product->getDiscountedPrice() * $quantity;
        } else {
            $this->totalPrice += $product->getPrice() * $quantity;
        }

        $this->saveCart();
        return true;
    }

    public function removeProduct($id)
    {
        $quantity = $this->cartContents[$id]['qty'];
        unset($this->cartContents[$id]);


        // Loads product.
        $product = $this->productService->getProductInfo($id);
        // Sets the stock of the product object.
        $product->setStock($product->getStock() + $quantity);
        // Updates the Database with the new stock.
        $this->productService->updateProductStock($id, $product->getStock());

        if ($product->getDiscountedPrice() !== null) {
            $this->totalPrice -= $product->getDiscountedPrice() * $quantity;
        } else {
            $this->totalPrice -= $product->getPrice() * $quantity;
        }

        $this->saveCart();
        return true;
    }

    public function getCartViewData()
    {
        $cartViewData = new CartViewData();

        if (!isset($this->cartContents)) {
            return false;
        }

        $productsArr = [];
        $totalPrice = 0;
        foreach ($this->cartContents as $id => $item) {
            foreach ($item as $key => $value) {
                if ($key === 'qty') {
                    $cartViewData->setProductQuantity($id, $value);
                }
            }
            $product = $this->productService->getProductInfo($id);
            if ($product->getDiscountedPrice() !== null) {
                $totalPrice += $cartViewData->getProductQuantity($id) * $product->getDiscountedPrice();
            } else {
                $totalPrice += $cartViewData->getProductQuantity($id) * $product->getPrice();
            }
            $productsArr[$id] = $product;
        }

        $cartViewData->setCartProducts($productsArr);
        $cartViewData->setTotalCartPrice($totalPrice);
        $this->totalPrice = $totalPrice;
        $this->totalItems = count($this->cartContents);

        return $cartViewData;
    }

    protected function saveCart(){
        $this->totalItems = count($this->cartContents);
        $_SESSION['cartContents'] = $this->cartContents;
        $this->totalPrice = round($this->totalPrice, 2);
        $_SESSION['totalCartAmount'] = $this->totalPrice;
        $_SESSION['totalItems'] = $this->totalItems;
        return TRUE;
    }

    public function resetCart()
    {
        $this->cartContents = NULL;
        $this->totalPrice = 0;
        return $this->saveCart();
    }
}
