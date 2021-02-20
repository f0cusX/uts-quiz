<?php

namespace App\Api;

use JsonSerializable;

/**
 * Class City
 * @package App\Api
 */
class City implements JsonSerializable
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
     * @var Country
     */
    private $country;

    /**
     * City constructor.
     * @param int $id
     * @param string $name
     * @param Country $country
     */
    public function __construct(int $id, string $name, Country $country)
    {
        $this->id = $id;
        $this->name = $name;
        $this->country = $country;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}
