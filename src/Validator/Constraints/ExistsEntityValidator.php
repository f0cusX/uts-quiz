<?php

namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ExistsEntityValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ExistsEntityValidator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ExistsEntity) {
            throw new UnexpectedTypeException($constraint, ExistsEntity::class);
        }

        if (!$constraint->class && !$constraint->callback) {
            throw new ConstraintDefinitionException('Either "class" or "callback" must be specified on constraint ExistsEntity.');
        }

        if (null === $value) {
            return;
        }

        if ($constraint->callback) {
            if (!is_callable($class = [$this->context->getObject(), $constraint->callback])
                && !is_callable($class = [$this->context->getClassName(), $constraint->callback])
                && !is_callable($class = $constraint->callback)
            ) {
                throw new ConstraintDefinitionException('The Choice constraint expects a valid callback.');
            }
            $class = $class();
        } else {
            $class = $constraint->class;
        }

        if (!$this->em->find($class, $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}