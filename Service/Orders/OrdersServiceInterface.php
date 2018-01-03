<?php

namespace Service\Orders;


interface OrdersServiceInterface
{
    public function createOrder(int $userId,
                                int $cityId,
                                string $address,
                                string $description,
                                array $productsQuantity,
                                array $productsPrice,
                                float $orderCost,
                                string $paymentMethod);

    public function getAllOrders(int $userId);

    public function getOrder(int $orderId);
}
