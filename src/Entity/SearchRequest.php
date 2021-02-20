<?php

namespace App\Entity;

use App\Repository\SearchRequestRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchRequestRepository::class)
 */
class SearchRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(type="date")
     */
    private $checkIn;

    /**
     * @ORM\Column(type="date")
     */
    private $checkOut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCheckIn(): ?DateTimeInterface
    {
        return $this->checkIn;
    }

    public function setCheckIn(DateTimeInterface $checkIn): self
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    public function getCheckOut(): ?DateTimeInterface
    {
        return $this->checkOut;
    }

    public function setCheckOut(DateTimeInterface $checkOut): self
    {
        $this->checkOut = $checkOut;

        return $this;
    }
}
