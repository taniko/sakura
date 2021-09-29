<?php

namespace Taniko\Sakura\Action\User;

use Taniko\Sakura\Action\Action;
use Taniko\Sakura\Attributes\Parameter;
use Taniko\Sakura\Attributes\Path;
use Taniko\Sakura\Http\Response\Response;
use Taniko\Sakura\Http\Response\User\GetUserResponse;

class GetUserAction extends Action
{
    #[
        Path(Path::GET, '/users/{id}', summary: 'Get user by ID'),
        Parameter('id', Parameter::PATH, schema: ['type' => 'integer', 'format' => 'int64']),
        \Taniko\Sakura\Attributes\Response(200, schema: ['ref' => GetUserResponse::class]),
    ]
    public function action(array $request): Response
    {
        return new GetUserResponse(1, 'sakura');
    }
}