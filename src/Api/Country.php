<?php

namespace App\Api;

use JsonSerializable;

/**
 * Class Country
 * @package App\Api
 */
class Country implements JsonSerializable
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Country constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}
