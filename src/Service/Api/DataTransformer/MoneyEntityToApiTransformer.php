<?php

namespace App\Service\Api\DataTransformer;

use App\Entity\Money;
use App\Api\Money as ApiMoney;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class MoneyEntityToApiTransformer implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return $data instanceof Money && $targetClass === ApiMoney::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): ApiMoney
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data Money */
        return new ApiMoney($data->getAmount(), $data->getCurrency());
    }
}