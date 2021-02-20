<?php

namespace App\Service\Api\DataTransformer;

use App\Api\Country;
use App\Entity\City;
use App\Api\City as ApiCity;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class CityEntityToApiTransformer implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return $data instanceof City && $targetClass === ApiCity::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): ApiCity
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data City */
        return new ApiCity(
            $data->getId(),
            $data->getName(),
            $transformer->transform($data->getCountry(), Country::class)
        );
    }
}