<?php

namespace App\Service\Api\DataTransformer;

use App\Api\CreateSpecialOffer;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Discount;
use App\Entity\Hotel;
use App\Entity\SpecialOffer;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;

class CreateSearchOfferToEntity implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CreateSearchOfferToEntity constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data, string $targetClass): bool
    {
        return get_class($data) === CreateSpecialOffer::class &&
            $targetClass === SpecialOffer::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer)
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data CreateSpecialOffer */
        $entity = new SpecialOffer();
        $subject = $data->getSubject();
        switch ($subject->getEntityClass()) {
            case Hotel::class :
                /** @var Hotel $hotel */
                $hotel = $this->em->find(Hotel::class, $subject->getId());
                $entity->setHotel($hotel);
                break;
            case City::class :
                /** @var City $city */
                $city = $this->em->find(City::class, $subject->getId());
                $entity->setCity($city);
                break;
            case Country::class :
                /** @var Country $country */
                $country = $this->em->find(Country::class, $subject->getId());
                $entity->setCountry($country);
                break;
        }
        $entity->setDescription($data->getDescription());
        $entity->setDiscount(
            new Discount(
                $data->getDiscount()->getType(),
                $data->getDiscount()->getValue()
            )
        );

        return $entity;
    }
}