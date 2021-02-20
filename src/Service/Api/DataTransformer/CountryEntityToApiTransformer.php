<?php

namespace App\Service\Api\DataTransformer;

use App\Entity\Country;
use App\Api\Country as ApiCountry;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class CountryEntityToApiTransformer implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return $data instanceof Country && $targetClass === ApiCountry::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): ApiCountry
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data Country */
        return new ApiCountry($data->getId(), $data->getName());
    }
}