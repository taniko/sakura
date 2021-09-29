<?php

namespace Taniko\Sakura\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Property implements \JsonSerializable
{
    /**
     * @param string $name
     * @param array<string, mixed> $options
     */
    public function __construct(private string $name, private array $options)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return $this->options;
    }
}