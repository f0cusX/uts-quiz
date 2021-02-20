<?php

namespace App\Entity;

/**
 * Class ProviderOffer
 * @package App\Entity
 */
class ProviderOffer
{
    /**
     * @var int
     */
    private $hotel;
    /**
     * @var string
     */
    private $roomName;
    /**
     * @var Money
     */
    private $price;
    /**
     * @var int|null
     */
    private $meal;

    /**
     * ProviderOffer constructor.
     * @param int $hotel
     * @param string $roomName
     * @param Money $price
     * @param int|null $meal
     */
    public function __construct(int $hotel, string $roomName, Money $price, ?int $meal)
    {
        $this->hotel = $hotel;
        $this->roomName = $roomName;
        $this->price = $price;
        $this->meal = $meal;
    }

    /**
     * @return int
     */
    public function getHotel(): int
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
     * @return int|null
     */
    public function getMeal(): ?int
    {
        return $this->meal;
    }
}