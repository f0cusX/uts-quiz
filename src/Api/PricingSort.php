<?php

namespace App\Api;

use Symfony\Component\Validator\Constraints as Assert;

class PricingSort
{
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"price","name"})
     * @var string
     */
    public $property = 'price';
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"asc","desc","ASC","DESC"})
     * @var string
     */
    public $order = 'asc';
}