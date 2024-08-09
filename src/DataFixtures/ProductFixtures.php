<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    public function __construct()
    {
        $this->faker = \Faker\Factory::create('fr_FR');
        $this->faker->addProvider(new \Faker\Provider\FakeCar($this->faker));
        $this->faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($this->faker));
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; $i++) {

            $product = new Product();
            $product
            ->setName($this->faker->sentence(3))
            ->setPicture($this->faker->imageUrl(width: 800, height: 600))
            ->setPrice($this->faker->randomFloat(2, 10, 100))
            ->setStock($this->faker->numberBetween(0, 1000))
            ->setUpdatedAt(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-3 months')))
            ->setCategory($this->getReference('CATEGORY' . mt_rand(0, 9)));



            $manager->persist($product);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
