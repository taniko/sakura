<?php
require_once __DIR__ . '/../vendor/autoload.php';

$generator = new \Taniko\Sakura\Generator('sample application', '1.0.0');
$generator->actions([
    \Taniko\Sakura\Action\User\GetUserAction::class,
]);
echo $generator->run();