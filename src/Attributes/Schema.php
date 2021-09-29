<?php
declare(strict_types=1);

namespace Taniko\Sakura\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Schema implements \JsonSerializable
{
    public function __construct(private string $name)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}