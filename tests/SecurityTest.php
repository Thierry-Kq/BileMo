<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class SecurityTest extends ApiTestCase
{
    public function testGoodCredentials(): void
    {
        $response = static::createClient()->request(
            'POST',
            '/login',
            [
                'json' => [
                    'login' => 'client-0',
                    'password' => 'azerty',
                ],
            ]
        );
        $this->assertResponseIsSuccessful();
    }

    public function testBadCredentials(): void
    {
        $response = static::createClient()->request(
            'POST',
            '/login',
            [
                'json' => [
                    'login' => 'client-0',
                    'password' => 'wrong-password',
                ],
            ]
        );
        $this->assertResponseStatusCodeSame('401');
    }

    public function testNotAllowedMethod(): void
    {
        $methods = ['POST', 'PATCH', 'PUT', 'DELETE'];
        $client = static::createClient();

        foreach ($methods as $method) {
            $response = $client->request($method, 'infos/client-0');
            self::assertResponseStatusCodeSame('405');

            $response = $client->request($method, 'products');
            self::assertResponseStatusCodeSame('405');

            $response = $client->request($method, 'products/1');
            self::assertResponseStatusCodeSame('405');
        }
    }
}