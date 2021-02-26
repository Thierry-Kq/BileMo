<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private static $productsList = [
        'Aphone 9',
        'Pamsung 11',
        'Rokia 6.1',
        'Xmeria 12',
    ];

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // 10 client
        for ($i = 0; $i < 10; $i++) {

            $client = new Client();

            $client->setLogin('azerty-' . $i);
            $client->setPassword(
                $this->passwordEncoder->encodePassword($client, 'azerty')
            );
            $manager->persist($client);
        }

        // products
        foreach (self::$productsList as $productName) {

            $product = new Product();
            $product->setName($productName);
            $product->setAvailability(true);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
