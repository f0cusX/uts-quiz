<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency
{

    /**
     * @ORM\Id
     * @ORM\Column(length=3)
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $rate;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
