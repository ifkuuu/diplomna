<?php

namespace Data\Orders;


use Data\City;
use Data\Products\Product;
use Data\Users\User;

class Order
{
    private $id;

    /** @var  User */
    private $user;

    /** @var  Product[] */
    private $products;

    /** @var  City */
    private $city;

    private $description;

    private $address;

    private $orderCost;

    private $createdOn;

    private $paymentMethod;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts(array $products)
    {
        $this->products = $products;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return htmlspecialchars($this->description);
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return htmlspecialchars($this->address);
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getOrderCost()
    {
        return $this->orderCost;
    }

    /**
     * @param mixed $orderCost
     */
    public function setOrderCost($orderCost)
    {
        $this->orderCost = $orderCost;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param mixed $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return htmlspecialchars($this->paymentMethod);
    }

    /**
     * @param mixed $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }
}
