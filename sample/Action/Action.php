<?php

namespace Taniko\Sakura\Action;

use Taniko\Sakura\Http\Response\Response;

abstract class Action
{
    abstract public function action(array $request): Response;
}