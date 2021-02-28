<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private static $productsList = [
        'Aphone 9',
        'Pamsung 11',
        'Rokia 6.1',
        'Xmeria 12',
    ];


    public function load(ObjectManager $manager)
    {

        foreach (self::$productsList as $productName) {

            $product = new Product();
            $product->setName($productName);
            $product->setAvailability(true);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
