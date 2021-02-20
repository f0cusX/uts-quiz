<?php

namespace App\Service\Api\DataTransformer;

use App\Api\Country;
use App\Api\Discount;
use App\Api\NamedItem;
use App\Api\SpecialOffer;
use App\Entity\SpecialOffer as SpecialOfferEntity;
use App\Exception\UnsupportedTransformation;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class SpecialOfferToApi implements DataTransformerInterface
{
    public function supports($data, string $targetClass): bool
    {
        return get_class($data) === SpecialOfferEntity::class &&
            $targetClass === SpecialOffer::class;
    }

    /**
     * @param SpecialOfferEntity $data
     * @param string $targetClass
     * @param DataTransformer $transformer
     * @return SpecialOffer
     * @throws UnsupportedTransformation
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): SpecialOffer
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        return new SpecialOffer(
            $data->getId(),
            $transformer->transform($data->getCountry(), Country::class),
            $transformer->transform($data->getCity(), NamedItem::class),
            $transformer->transform($data->getHotel(), NamedItem::class),
            $data->getDescription(),
            $transformer->transform($data->getDiscount(), Discount::class)
        );
    }

}