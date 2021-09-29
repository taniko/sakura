<?php
declare(strict_types=1);

namespace Taniko\Sakura\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Path implements \JsonSerializable
{
    public const GET = 'get';
    public const POST = 'post';
    public const DELETE = 'delete';
    public const PUT = 'put';
    public const PATCH = 'patch';

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

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array{method: string, path: string, security?: array, deprecated?: bool, description?: bool, summary?: string, tags?: array<int, string>}
     *
     */
    public function jsonSerialize(): array
    {
        $data = [];
        if (isset($this->tags)) $data['tags'] = $this->tags;
        if (isset($this->summary)) $data['summary'] = $this->summary;
        if (isset($this->description)) $data['description'] = $this->description;
        if (isset($this->deprecated)) $data['deprecated'] = $this->deprecated;
        if (isset($this->security)) $data['security'] = $this->security;
        return $data;
    }
}