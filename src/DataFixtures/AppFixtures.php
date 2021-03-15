<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private static $productsList = [
        'Aphone 9',
        'Aphone 9-X',
        'Aphone 10-2',
        'Aphone 10-2-pro',
        'Pamsung 11',
        'Pamsung 12',
        'Pamsung 12-pro',
        'Rokia 6.1',
        'Rokia 6.3',
        'Rokia 7',
        'Rokia 7 mini',
        'Xmeria 12',
        'Xmeria 13',
        'Xmeria 14',
        'Xmeria 15',
        'Papple 12',
        'Papple 13',
        'Papple 14',
        'Papple 15',
        'Papple 17',
        'low-Mo',
        'low-Mo pro',
        'low-Mo mini',
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

            $client->setLogin('client-' . $i);
            $client->setEmail('client-' . $i . '@gmail.com');
            $client->setPassword(
                $this->passwordEncoder->encodePassword($client, 'azerty')
            );


            // 50 Users by Client
            $numberOfUser = 50;
            $userCount = 0;
            while ($userCount < $numberOfUser) {
                $user = new User();

                $nameByClientAndCount = $client->getLogin() . '.' . $userCount;
                $user->setFirstName('User-' . $nameByClientAndCount);
                $user->setLastName('Owned by ' . $client->getLogin());
                $user->setEmail('user-' . $nameByClientAndCount . '@gmail.com');
                $user->setClient($client);

                $manager->persist($user);
                $userCount++;
            }
            $manager->persist($client);
        }


        // products
        $cents = '99';
        foreach (self::$productsList as $productName) {

            $price = random_int(500, 1500);

            $product = new Product();
            $product->setName($productName);
            $product->setPrice($price . '.' . $cents);
            $product->setAvailability(true);
            $product->setCurrency('EUR');
            $manager->persist($product);
        }

        $manager->flush();
    }
}
