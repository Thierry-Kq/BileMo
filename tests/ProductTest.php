<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class ProductTest extends ApiTestCase
{
    public function testGetProductsWithoutToken(): void
    {
        $client = static::createClient();

        $urls = ['/products', '/products/1'];
        foreach ($urls as $url) {
            $response = $client->request('GET', $url);
            self::assertResponseStatusCodeSame('401');
        }
    }

    public function testGetProductsWithToken(): void
    {
        $tools = new Tools();
        $token = $tools->getToken('client-0', 'azerty');
        $client = static::createClient();

        //
        $response = $client->request(
            'GET',
            '/products',
            [
                'auth_bearer' => $token,
            ]
        );
        self::assertCount(4, $response->toArray()['hydra:member']);

        //
        $response = $client->request(
            'GET',
            '/products/1',
            [
                'auth_bearer' => $token,
            ]
        );

        self::assertEquals('Aphone 9', $response->toArray()['name']);
    }
}