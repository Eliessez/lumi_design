<?php

namespace App\EventListener;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: 'prePersist', entity: Product::class)]
#[AsEntityListener(event: 'preUpdate', entity: Product::class)]
class SluggerListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Product $product)
    {
        $this->generateSlug($product);
    }

    public function preUpdate(Product $product)
    { 
        $this->generateSlug($product);
    }

    private function generateSlug($product)
    {
        $product->setSlug($this->slugger->slug($product->getName())->lower());
    }
}
