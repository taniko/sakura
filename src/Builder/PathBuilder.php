<?php

namespace Taniko\Sakura\Builder;

use Taniko\Sakura\Attributes\Parameter;
use Taniko\Sakura\Attributes\Path;
use Taniko\Sakura\Attributes\Response;

class PathBuilder implements Builder
{
    /**
     * @param array<int, string> $actions
     */
    public function __construct(private array $actions)
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function build(): array
    {
        $data = [];
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
                        /** @var Path $pathSchema */
                        $pathSchema = $attribute->newInstance();
                        $operation = $pathSchema->getMethod();
                        $path = $pathSchema->getPath();
                        $schema += $pathSchema->jsonSerialize();
                    } elseif ($attribute->getName() === Parameter::class) {
                        $schema['parameters'][] = $attribute->newInstance();
                    } elseif ($attribute->getName() === Response::class) {
                        $response = [];
                        /** @var Response $responseSchema */
                        $responseSchema = $attribute->newInstance();
                        $response['content']['application/json'] = $responseSchema;
                        $schema['responses'][$responseSchema->getStatus()] = $response;
                    }
                }
                $data[$path][$operation] = $schema;
            }
        }
        return $data;
    }
}