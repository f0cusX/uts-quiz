<?php

namespace App\Service\Api\DataTransformer;

use App\Entity\Discount;
use App\Api\Discount as ApiDiscount;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class DiscountEntityToApiTransformer implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return $data instanceof Discount && $targetClass === ApiDiscount::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): ApiDiscount
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data Discount */
        return new ApiDiscount($data->getType(), $data->getValue());
    }
}