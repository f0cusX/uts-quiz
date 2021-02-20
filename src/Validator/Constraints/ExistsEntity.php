<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ExistsEntity
 * @package App\Validator\Constraints
 * @Annotation
 */
class ExistsEntity extends Constraint
{
    public $class;
    public $callback;
    public $message = 'Entity not found';
}