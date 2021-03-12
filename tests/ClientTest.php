<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class ClientTest extends ApiTestCase
{
    private $login = 'client-0';

    public function testGetClientWithoutToken(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/infos/' . $this->login);
        self::assertResponseStatusCodeSame('401');
    }

    public function testGetClientWithToken(): void
    {
        $tools = new Tools();
        $token = $tools->getToken($this->login, 'azerty');
        $client = static::createClient();

        $response = $client->request(
            'GET',
            '/infos/' . $this->login,
            [
                'auth_bearer' => $token,
            ]
        );
        self::assertCount(5, $response->toArray()['users']);
    }
}