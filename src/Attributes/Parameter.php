<?php
declare(strict_types=1);

namespace Taniko\Sakura\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Parameter implements \JsonSerializable
{
    public const QUERY = 'query';
    public const HEADER = 'header';
    public const PATH = 'path';
    public const COOKIE = 'cookie';

    public function __construct(
        private string  $name,
        private string  $in,
        private ?string $description = null,
        private ?bool   $required = null,
        private ?bool   $deprecated = null,
        private ?bool   $allowEmptyValue = null,
        private mixed   $example = null,
        private ?array  $examples = null,
        private ?array  $schema = null,
    )
    {
    }

    /**
     * @return array{name: string, in: string, description?: string, required?: bool, deprecated?: bool, allowEmptyValue?: bool}
     */
    public function jsonSerialize(): array
    {
        $data = [
            'name' => $this->name,
            'in' => $this->in,
        ];
        if (isset($this->description)) $data['description'] = $this->description;
        if (isset($this->required)) $data['required'] = $this->required;
        if (isset($this->deprecated)) $data['deprecated'] = $this->deprecated;
        if (isset($this->allowEmptyValue)) $data['allowEmptyValue'] = $this->allowEmptyValue;
        if (isset($this->example)) $data['example'] = $this->example;
        if (isset($this->examples)) $data['examples'] = $this->examples;
        if (isset($this->schema)) $data['schema'] = $this->schema;
        return $data;
    }
}