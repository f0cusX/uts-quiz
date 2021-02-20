<?php

namespace App\Api;

use JsonSerializable;

/**
 * Class SearchResult
 * @package App\Api
 */
class SearchResult implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var Hotel */
    private $hotel;
    /** @var string */
    private $roomName;
    /** @var Money */
    private $price;
    /** @var Meal|null */
    private $meal;

    /**
     * SearchResult constructor.
     * @param int $id
     * @param Hotel $hotel
     * @param string $roomName
     * @param Money $price
     * @param Meal|null $meal
     */
    public function __construct(int $id, Hotel $hotel, string $roomName, Money $price, ?Meal $meal)
    {
        $this->id = $id;
        $this->hotel = $hotel;
        $this->roomName = $roomName;
        $this->price = $price;
        $this->meal = $meal;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Hotel
     */
    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    /**
     * @return string
     */
    public function getRoomName(): string
    {
        return $this->roomName;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @return Meal|null
     */
    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}
