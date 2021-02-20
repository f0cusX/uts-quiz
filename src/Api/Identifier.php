<?php


namespace App\Api;


class Identifier
{
    /**
     * @var int
     */
    private $id;

    /**
     * Identifier constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}