<?php

namespace App\Api;

use JsonSerializable;

/**
 * Class Currency
 * @package App\Api
 */
class Currency implements JsonSerializable
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var float
     */
    private $rate;

    /**
     * Currency constructor.
     * @param string $id
     * @param float $rate
     */
    public function __construct(string $id, float $rate)
    {
        $this->id = $id;
        $this->rate = $rate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}
