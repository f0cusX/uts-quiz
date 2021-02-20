<?php

namespace App\Api;

use Symfony\Component\Validator\Constraints as Assert;

class Page
{
    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     * @Assert\Type("integer")
     * @var int
     */
    public $number = 1;
    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     * @Assert\Type("integer")
     * @var int
     */
    public $size = 20;
}