<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends Exception
{
    private $details = [];

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (is_array($message)) {
            $this->details = $message;
            $message = 'Bad request';
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    public static function fromViolations(ConstraintViolationListInterface $list): self
    {
        $message = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($list as $violation) {
            $message[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage()
            ];
        }

        return new self($message);
    }
}