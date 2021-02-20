<?php

namespace App\Api;

use JsonSerializable;

/**
 * Class Hotel
 * @package App\Api
 */
class Hotel implements JsonSerializable
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
     * @var City
     */
    private $city;

    /**
     * Hotel constructor.
     * @param int $id
     * @param string $name
     * @param City $city
     */
    public function __construct(int $id, string $name, City $city)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}
