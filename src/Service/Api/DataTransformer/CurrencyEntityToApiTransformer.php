<?php

namespace App\Service\Api\DataTransformer;

use App\Entity\Currency;
use App\Api\Currency as ApiCurrency;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class CurrencyEntityToApiTransformer implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return $data instanceof Currency && $targetClass === ApiCurrency::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): ApiCurrency
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data Currency */
        return new ApiCurrency(
            $data->getId(),
            $data->getRate()
        );
    }
}