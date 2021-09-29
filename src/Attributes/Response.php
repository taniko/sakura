<?php
declare(strict_types=1);

namespace Taniko\Sakura\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Response implements \JsonSerializable
{
    public function __construct(private int $status, private ?array $schema = null)
    {
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @throws \ReflectionException
     */
    public function jsonSerialize(): array
    {
        $schema = $this->schema;
        $data = [];
        $ref = $schema['ref'] ?? null;
        unset($schema['ref']);
        if (isset($schema)) $data['schema'] = $schema;
        if (isset($ref)) {
            $reflection = new \ReflectionClass($ref);
            foreach ($reflection->getMethods() as $method) {
                $hasSchemaAttribute = false;
                $methodSchema = [];
                foreach ($method->getAttributes() as $attribute) {
                    if ($attribute->getName() === Schema::class) {
                        $hasSchemaAttribute = true;
                    } else {
                        if ($attribute->getName() === Property::class) {
                            /** @var Property $property */
                            $property = $attribute->newInstance();
                            $methodSchema['properties'][$property->getName()] = $property;
                        }
                    }
                }
                if ($hasSchemaAttribute) {
                    $data['schema'] += $methodSchema;
                }
            }
            unset($schema['ref']);
        }
        return $data;
    }
}