<?php
declare(strict_types=1);

namespace Taniko\Sakura\Model;


class User
{
    /**
     * @param int $id
     * @param string $username
     */
    public function __construct(private int $id, private string $username)
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}