<?php

namespace App\Factory;

use App\Entity\Orders;
use App\Enum\OrdersStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Orders>
 */
final class OrdersFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Orders::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime('-3 years')),
            'customer' => UserFactory::new(),
            'ordersNumber' => self::faker()->randomNumber(),
            'paidAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime('-2 years')),
            'status'=> self::faker()->randomElement(OrdersStatus::cases())
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Orders $orders): void {})
        ;
    }
}
