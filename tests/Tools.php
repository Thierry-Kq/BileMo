<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class Tools extends ApiTestCase
{
    public function getToken($login, $password)
    {

        $response = static::createClient()->request(
            'POST',
            '/login',
            [
                'json' => [
                    'login' => $login,
                    'password' => $password,
                ],
            ]
        );

        return $response->toArray()['token'];
    }
}