<?php


namespace App\Api;

use JsonSerializable;

/**
 * Class Money
 * @package App\Api
 */
class Money implements JsonSerializable
{
    /**
     * @var float
     */
    private $amount;
    /**
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}