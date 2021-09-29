<?php

namespace Taniko\Sakura\Http\Response\User;

use Taniko\Sakura\Attributes\Schema;
use Taniko\Sakura\Http\Response\Response;
use Taniko\Sakura\Attributes\Property;

class GetUserResponse extends Response
{

    public function __construct(private int $id, private string $username)
    {
    }

    #[
        Schema('GetUserResponse'),
        Property('id', [
            'type' => 'integer',
            'format' => 'int64',
            'minimum' => 1,
            'description' => 'User ID'
        ]),
        Property('username', [
            'type' => 'string',
            'description' => 'Username',
            'default' => 'sakura',
        ])
    ]
    /**
     * @return array{id: int, username: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
        ];
    }
}