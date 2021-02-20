<?php

namespace App\Service\Api\DataTransformer;

use App\Api\City;
use App\Entity\Hotel;
use App\Api\Hotel as ApiHotel;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class HotelEntityToApiTransformer implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return $data instanceof Hotel && $targetClass === ApiHotel::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): ApiHotel
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data Hotel */
        return new ApiHotel(
            $data->getId(),
            $data->getName(),
            $transformer->transform($data->getCity(), City::class)
        );
    }
}