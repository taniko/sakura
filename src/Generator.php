<?php
declare(strict_types=1);

namespace Taniko\Sakura;

use Symfony\Component\Yaml\Yaml;
use Taniko\Sakura\Builder\PathBuilder;

class Generator
{
    private const VERSION = '3.1.0';
    private array $actions = [];

    public function __construct(private string $title, private string $version, private array $server = [])
    {
    }

    /**
     * @param array<int, string> $actions
     */
    public function actions(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @throws \ReflectionException
     */
    public function run(): string
    {
        $pathBuilder = new PathBuilder($this->actions);
        $data = [
            'openapi' => Generator::VERSION,
            'servers' => $this->server,
            'info' => [
                'title' => $this->title,
                'version' => $this->version,
            ],
            'paths' => $pathBuilder->build(),
        ];
        return Yaml::dump(json_decode(json_encode($data), true), 100, 2, flags: Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE);
    }
}