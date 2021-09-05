# sakura

## Generate schema
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

$generator = new \Taniko\Sakura\Generator('application', '1.0.0');
$generator->actions([
    Action::class,
]);
echo $generator->generate();
```