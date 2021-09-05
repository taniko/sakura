<?php
declare(strict_types=1);

namespace Taniko\Sakura;

use Symfony\Component\Yaml\Yaml;

class Generator
{
    private const VERSION = '3.0.8';
    private array $actions = [];

    public function __construct(private string $title, private string $version, private array $server = [])
    {
    }

    /**
     * @param array $actions
     */
    public function actions(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    public function generate(): string
    {
        $data = [
            'openapi' => Generator::VERSION,
            'servers' => $this->server,
            'info' => [
                'title' => $this->title,
                'version' => $this->version,
            ],
            'paths' => [],
        ];

        foreach ($this->actions as $action) {
            $reflection = new \ReflectionClass($action);
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $keys = array_map(fn($attribute) => $attribute->getName(), $method->getAttributes());
                if (count(array_intersect([Path::class, Parameter::class, Response::class], $keys)) !== 3) {
                    continue;
                }
                $operation = null;
                $path = null;
                $schema = [];
                foreach ($method->getAttributes() as $attribute) {
                    if ($attribute->getName() === Path::class) {
                        $v = $attribute->newInstance()->data();
                        $operation = $v['method'];
                        $path = $v['path'];
                        unset($v['method'], $v['path']);
                        $schema += $v;
                    } elseif ($attribute->getName() === Parameter::class) {
                        $schema['parameters'][] = $attribute->newInstance()->data();
                    } elseif ($attribute->getName() === Response::class) {
                        $response = $attribute->newInstance()->data();
                        $status = $response['status'];
                        $content = $response['content'];
                        unset($response['status'], $response['content']);
                        $response['content']['application/json'] = $content;
                        $schema['responses'][$status] = $response;
                    }
                }
                $data['paths'][$path][$operation] = $schema;
            }
        }
        return Yaml::dump($data, 100, 2, flags: Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE);
    }
}