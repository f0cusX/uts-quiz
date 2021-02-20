<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Money
 * @package App\Entity
 * @ORM\Embeddable()
 */
class Money
{
    /**
     * @ORM\Column(type="decimal", precision=2, scale=8)
     * @var float
     */
    private $amount;
    /**
     * @ORM\Column(length=3)
     * @var string
     */
    private $currency;

    /**
     * Money constructor.
     * @param float $amount
     * @param string $currency
     */
    public function __construct(float $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return (float)$this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}