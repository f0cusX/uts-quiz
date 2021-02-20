<?php

namespace App\Api;

use Symfony\Component\Validator\Constraints as Assert;

class DefaultSort
{
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"name"})
     * @var string
     */
    public $property = 'name';
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"asc","desc","ASC","DESC"})
     * @var string
     */
    public $order = 'asc';
}