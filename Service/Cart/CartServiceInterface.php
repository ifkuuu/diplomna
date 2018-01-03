<?php

namespace Service\Cart;


interface CartServiceInterface
{
    public function addProduct($id, $quantity);

    public function removeProduct($id);

    public function getCartViewData();

    public function resetCart();
}
