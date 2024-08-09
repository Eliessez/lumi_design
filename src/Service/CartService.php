<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    public function __construct(
        private ProductRepository $repository,
        private RequestStack $requestStack
    ) {
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function getCartContent(): array
    {
        $cart = $this->getSession()->get('cart', []);
        $dataCart = [];
        $totalCart = 0;

        foreach ($cart as $id => $quantity) {
            $product = $this->repository->find($id);
            if (!$product) {
                continue;
            }

            $total = $product->getPrice() * $quantity;

            $dataCart[] = [
                'product' => $product,
                'quantity' => $quantity,
                'total' => $total,
            ];

            $totalCart = $totalCart + $total;
        }

        return [
            'dataCart' => $dataCart,
            'total' => $totalCart
        ];
    }

    public function incrementProductQuantity(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->getSession()->set('cart', $cart);
    }

    public function decreaseProductQuantity(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $this->getSession()->set('cart', $cart);
    }

    public function removeProductFromCart(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);
        unset($cart[$id]);
        $this->getSession()->set('cart', $cart);
    }

    public function emptyCart(): void
    {
        $this->getSession()->remove('cart');
    }
}