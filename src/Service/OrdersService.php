<?php

namespace App\Service;

use App\Entity\OrderItem;
use App\Entity\Orders;
use App\Entity\User;
use App\Repository\ProductRepository;

class OrdersService
{
    public function __construct(private ProductRepository $repository) {}

    public function createOrder(User $user, array $cart)
    {
        $order = new Orders();
        $order->setCustomer($user);

        $total = 0;
        foreach ($cart as $key => $quantity) {
            $product = $this->repository->find($key);
            $price = $product->getPrice();
            $total = $total + ($price * $quantity);

            $orderItem = new OrderItem();
            $orderItem->setQuantity($quantity);
            $orderItem->setPrice($price);
            $orderItem->setProduct($product);
            $order->addOrderItem($orderItem);
        }
        $order->setTotal($total);

        return $order;
    }
}