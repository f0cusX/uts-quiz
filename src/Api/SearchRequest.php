<?php

namespace App\Api;

use DateTimeInterface;
use JsonSerializable;

/**
 * Class SearchRequest
 * @package App\Api
 */
class SearchRequest implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var City */
    private $city;
    /** @var DateTimeInterface */
    private $checkIn;
    /** @var DateTimeInterface */
    private $checkOut;

    /**
     * SearchRequest constructor.
     * @param int $id
     * @param City $city
     * @param DateTimeInterface $checkIn
     * @param DateTimeInterface $checkOut
     */
    public function __construct(int $id, City $city, DateTimeInterface $checkIn, DateTimeInterface $checkOut)
    {
        $this->id = $id;
        $this->city = $city;
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCheckIn(): DateTimeInterface
    {
        return $this->checkIn;
    }

    public function getCheckOut(): DateTimeInterface
    {
        return $this->checkOut;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'checkIn' => $this->checkIn->format('Y-m-d'),
            'checkOut' => $this->checkOut->format('Y-m-d')
        ];
    }
}
