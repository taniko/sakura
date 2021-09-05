<?php
declare(strict_types=1);

namespace Taniko\Sakura;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Parameter
{
    public function __construct(
        private string       $name,
        private string       $in,
        private mixed $schema,
        private ?string      $description = null,
        private ?bool        $required = null,
        private ?bool        $deprecated = null,
        private ?bool        $allowEmptyValue = null,
        private mixed        $example = null,
        private ?array       $examples = null,
    )
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function data(): array
    {
        $data = [
            'name' => $this->name,
            'in' => $this->in,
            'schema' => $this->schema,
        ];
        if (isset($this->description)) $data['description'] = $this->description;
        if (isset($this->required)) $data['required'] = $this->required;
        if (isset($this->deprecated)) $data['deprecated'] = $this->deprecated;
        if (isset($this->allowEmptyValue)) $data['allowEmptyValue'] = $this->allowEmptyValue;
        if (isset($this->example)) $data['example'] = $this->example;
        if (isset($this->examples)) $data['examples'] = $this->examples;
        return $data;
    }
}