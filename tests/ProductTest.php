<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class ProductTest extends ApiTestCase
{
    public function testGetProductsWithoutToken(): void
    {
        $client = static::createClient();

        $urls = ['v1/products', 'v1/products/1'];
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
            'v1/products',
            [
                'auth_bearer' => $token,
            ]
        );

        self::assertEquals(23, $response->toArray()['hydra:totalItems']);
        self::assertCount(10, $response->toArray()['hydra:member']);

        //
        $response = $client->request(
            'GET',
            'v1/products/1',
            [
                'auth_bearer' => $token,
            ]
        );

        self::assertEquals('Aphone 9', $response->toArray()['name']);
    }
}