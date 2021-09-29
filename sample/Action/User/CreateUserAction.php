<?php

namespace Taniko\Sakura\Action\User;

use Taniko\Sakura\Action\Action;
use Taniko\Sakura\Attributes\Path;
use Taniko\Sakura\Http\Response\Response;
use Taniko\Sakura\Http\Response\User\CreateUserResponse;

class CreateUserAction extends Action
{
    #[Path(Path::POST, '/users')]
    public function action(array $request): Response
    {
        return new CreateUserResponse(1, 'sakura') ;
    }
}