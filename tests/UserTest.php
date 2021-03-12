<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class UserTest extends ApiTestCase
{
    private $login = 'client-0';

    public function testGetUsersWithoutToken(): void
    {
        $client = static::createClient();

        //
        $response = $client->request('GET', 'users');
        self::assertResponseStatusCodeSame('403');

        //
        $response = $client->request('GET', 'users/1');
        self::assertResponseStatusCodeSame('401');
    }

    public function testGetAndPatchUsersWithToken(): void
    {
        $tools = new Tools();
        $token = $tools->getToken($this->login, 'azerty');
        $client = static::createClient();

        //
        $response = $client->request(
            'GET',
            '/users',
            [
                'auth_bearer' => $token,
            ]
        );
        self::assertCount(5, $response->toArray()['hydra:member']);

        //
        $response = $client->request(
            'GET',
            '/users/1',
            [
                'auth_bearer' => $token,
            ]
        );

        self::assertEquals('User-client-0.0', $response->toArray()['firstName']);

        //
        $response = $client->request(
            'GET',
            '/users/10',
            [
                'auth_bearer' => $token,
            ]
        );
        self::assertResponseStatusCodeSame('403');

        //
        $user = ['firstName' => 'azerty', 'lastName' => 'azerty', 'email' => 'azerty@gmail.com'];
        $response = $client->request(
            'PATCH',
            '/users/4',
            [
                'auth_bearer' => $token,
                'json' => $user,
            ]
        );
        self::assertResponseStatusCodeSame('200');
    }
}