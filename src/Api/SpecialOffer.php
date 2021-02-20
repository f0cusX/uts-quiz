<?php

namespace App\Api;

use JsonSerializable;

/**
 * Class SpecialOffer
 * @package App\Api
 */
class SpecialOffer implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var Country */
    private $country;
    /** @var NamedItem|null */
    private $city;
    /** @var NamedItem|null */
    private $hotel;
    /** @var string */
    private $description;
    /** @var Discount */
    private $discount;

    /**
     * SpecialOffer constructor.
     * @param int $id
     * @param Country $country
     * @param NamedItem|null $city
     * @param NamedItem|null $hotel
     * @param string $description
     * @param Discount $discount
     */
    public function __construct(int $id, Country $country, ?NamedItem $city, ?NamedItem $hotel, string $description, Discount $discount)
    {
        $this->id = $id;
        $this->country = $country;
        $this->city = $city;
        $this->hotel = $hotel;
        $this->description = $description;
        $this->discount = $discount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?NamedItem
    {
        return $this->city;
    }

    /**
     * @return Hotel|null
     */
    public function getHotel(): ?NamedItem
    {
        return $this->hotel;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Discount
     */
    public function getDiscount(): Discount
    {
        return $this->discount;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}
