<?php
declare(strict_types=1);

namespace Taniko\Sakura;

use Attribute;
use JetBrains\PhpStorm\ArrayShape;

#[Attribute(Attribute::TARGET_METHOD)]
class Path
{
    public function __construct(
        private string  $method,
        private string  $path,
        private ?array  $tags = null,
        private ?string $summary = null,
        private ?string $description = null,
        private ?bool   $deprecated = null,
        private ?array  $security = null,
    )
    {
        $this->method = strtolower($this->method);
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'method' => "string",
        'path' => "string",
        'security' => "array|null",
        'deprecated' => "bool|null",
        'description' => "null|string",
        'summary' => "null|string",
        'tags' => "array|null"
    ])]
    public function data(): array
    {
        $data = [
            'method' => $this->method,
            'path' => $this->path,
        ];
        if (isset($this->tags)) $data['tags'] = $this->tags;
        if (isset($this->summary)) $data['summary'] = $this->summary;
        if (isset($this->description)) $data['description'] = $this->description;
        if (isset($this->deprecated)) $data['deprecated'] = $this->deprecated;
        if (isset($this->security)) $data['security'] = $this->security;
        return $data;
    }
}