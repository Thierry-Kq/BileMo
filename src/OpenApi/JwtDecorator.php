<?php
// api/src/OpenApi/JwtDecorator.php

declare(strict_types=1);

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

final class JwtDecorator implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(
        OpenApiFactoryInterface $decorated
    ) {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['/login'] = new \ArrayObject(
            [
                'type' => 'object',
                'properties' => [
                    'login' => [
                        'type' => 'string',
                        'example' => 'johndoe@example.com',
                    ],
                    'password' => [
                        'type' => 'string',
                        'example' => 'apassword',
                    ],
                ],
            ]
        );

        return $openApi;
    }
}