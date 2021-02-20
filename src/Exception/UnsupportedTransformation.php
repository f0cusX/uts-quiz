<?php

namespace App\Exception;

use Exception;

class UnsupportedTransformation extends Exception
{
    public function __construct($data, string $targetClass)
    {
        if (is_object($data)) {
            $from = get_class($data);
        } else {
            $from = gettype($data);
        }
        parent::__construct(
            sprintf(
                'Data transformer from %s to %s is not registered',
                $from, $targetClass
            ),
            500
        );
    }
}