<?php

namespace Service\Orders;


use Data\City;
use Data\Orders\Order;
use Service\ProductServiceInterface;
use Service\UserServiceInterface;

class OrdersService implements OrdersServiceInterface
{

    private $db;

    private $productService;

    private $userService;

    public function __construct(\PDO $db, ProductServiceInterface $productService, UserServiceInterface $userService)
    {
        $this->db = $db;
        $this->productService = $productService;
        $this->userService = $userService;
    }

    public function createOrder(int $userId,
                                int $cityId,
                                string $address,
                                string $description,
                                array $productsQuantities,
                                array $productsPrice,
                                float $orderCost,
                                string $paymentMethod)
    {
        $query = "
                        INSERT INTO orders (
                              user_id, 
                              city_id, 
                              address, 
                              description,
                              order_total_cost,
                              payment_method,
                              created_on
                        ) VALUES (
                              ?, 
                              ?, 
                              ?, 
                              ?,
                              ?,
                              ?,
                              DEFAULT
                        );
                ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $userId,
                $cityId,
                $address,
                $description,
                $orderCost,
                $paymentMethod
            ]
        );

        $lastId = $this->db->lastInsertId();

        foreach ($productsQuantities as $productId => $productQuantity) {
            $query = "
                            INSERT INTO order_products (
                                  order_id, 
                                  product_variant_id,
                                  product_variant_cost,
                                  quantity
                            ) VALUES (
                                  ?, 
                                  ?, 
                                  ?,
                                  ?
                            ); 
                    ";
            $stmt = $this->db->prepare($query);

            $result = $stmt->execute([
                $lastId,
                $productId,
                $productsPrice[$productId],
                $productQuantity
            ]);
        }

        return $lastId;
    }

    public function getAllOrders(int $userId)
    {
        $query = "SELECT
                    id
                  FROM orders
                  WHERE user_id = ?
                  ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        $result = $stmt->fetchAll();
        if (!$result) {
            // This user has no Orders.
            return false;
        }

        $ordersArr = [];
        foreach ($result as $row) {
            $ordersArr[] = $this->getOrder($row['id']);
        }
        return $ordersArr;
    }

    public function getOrder(int $orderId)
    {
        $order = new Order();

        $query = "SELECT
                    op.product_variant_id as product_id
                  FROM orders as o
                  JOIN order_products as op ON op.order_id = o.id
                  WHERE o.id = ?;
                  ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result) {
            throw new \Exception("Няма намерени продукти обвързани с тази поръчка!");
        }
        $productsArr = [];
        foreach ($result as $productIdsArr) {
            $id = $productIdsArr['product_id'];
            $productsArr[] = $this->productService->getProductInfo($id);
        }

        $order->setProducts($productsArr);

        $query = "SELECT user_id FROM orders WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $userId = $stmt->fetch()[0];
        if (!$userId) {
            throw new \Exception("Няма намерен потребител обвързан с тази поръчка!");
        }
        $user = $this->userService->loadUser($userId);

        $order->setUser($user);

        $query = "SELECT
                    c.id as id,
                    c.city_name as name,
                    c.post_code as postCode
                  FROM orders as o
                  JOIN cities as c ON c.id = o.city_id
                  WHERE o.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $city = $stmt->fetchObject(City::class);
        if (!$city) {
            throw new \Exception("Няма намерен град обвързан с тази поръчка!");
        }

        $order->setCity($city);

        $query = "SELECT
                      id,
                      address,
                      order_total_cost as orderCost,
                      description,
                      created_on as createdOn,
                      payment_method as paymentMethod
                  FROM orders
                  WHERE id = ?
                  ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            throw new \Exception("Няма открити данни за тази поръчка!");
        }

        $order->setId($orderId);
        $order->setAddress($result['address']);
        $order->setOrderCost($result['orderCost']);
        $order->setDescription($result['description']);
        $order->setCreatedOn($result['createdOn']);
        $order->setPaymentMethod($result['paymentMethod']);

        return $order;
    }
}
