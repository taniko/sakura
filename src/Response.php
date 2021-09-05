<?php
declare(strict_types=1);

namespace Taniko\Sakura;

use Attribute;
use JetBrains\PhpStorm\ArrayShape;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Response
{
    public function __construct(
        private int     $status,
        private string  $description,
        private ?array  $headers = null,
        private mixed   $content = null,
        private ?string $contentRef = null,
    )
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function data(): array
    {
        $data = [
            'status' => $this->status,
            'description' => $this->description,
        ];
        if (isset($this->content)) $data['content'] = $this->content;
        if (
            isset($this->contentRef)
            && class_exists($this->contentRef)
            && in_array(\JsonSerializable::class, class_implements($this->contentRef))
        ) {
            $ref = new \ReflectionClass($this->contentRef);
            $content = $ref->getMethod('jsonSerialize')
                    ->getAttributes(ArrayShape::class)[0]
                    ->getArguments() ?? null;
            if (isset($content)) $data['content'] = $content;
        }
        if (isset($this->headers)) $data['headers'] = $this->headers;
        if (isset($this->headers)) $data['headers'] = $this->headers;
        return $data;
    }
}