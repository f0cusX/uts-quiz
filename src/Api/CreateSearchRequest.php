<?php

namespace App\Api;

use App\Validator\Constraints\ExistsEntity;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSearchRequest
{
    /**
     * @Assert\NotBlank()
     * @ExistsEntity(class="App\Entity\City")
     * @var int
     */
    private $city;
    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual("today")
     * @var DateTime|null
     */
    private $checkIn;
    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(propertyPath="checkIn")
     * @var DateTime|null
     */
    private $checkOut;

    /**
     * CreateSearchRequest constructor.
     * @param int $city
     * @param DateTime|null $checkIn
     * @param DateTime|null $checkOut
     */
    public function __construct(int $city, ?DateTime $checkIn, ?DateTime $checkOut)
    {
        $this->city = $city;
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;
    }

    /**
     * @return int
     */
    public function getCity(): int
    {
        return $this->city;
    }

    /**
     * @return DateTime|null
     */
    public function getCheckIn(): ?DateTime
    {
        return $this->checkIn;
    }

    /**
     * @return DateTime|null
     */
    public function getCheckOut(): ?DateTime
    {
        return $this->checkOut;
    }
}