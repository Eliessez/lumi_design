<?php

namespace App\Factory;

use App\Entity\Product;
use DateTimeImmutable;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Product>
 */
final class ProductFactory extends PersistentProxyObjectFactory
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
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' =>\DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 year')),
            'updatedAt' =>  new DateTimeImmutable(),
            'name' => self::faker()->randomElement(['pull','t-shirt','pantalon','sweat','short','chaussure','chemise','boxer','calecon',]),
            'stock' => self::faker()->randomNumber(3,false),
            'description'=>self::faker()->sentence(),
            'price'=>self::faker()->randomFloat(2,10,100),
            'category'=> CategoryFactory::new(),
            'picture'=> self::faker()->imageUrl(width: 800, height: 600),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Product $product): void {})
        ;
    }
}
