<?php

namespace App\DataFixtures;

use App\Factory\OrderItemFactory;
use App\Factory\OrdersFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        OrderItemFactory::createMany(20);
        OrdersFactory::createMany(20);
        ProductFactory::createMany(20);
        UserFactory::createMany(20);




        $manager->flush();
    }
}
