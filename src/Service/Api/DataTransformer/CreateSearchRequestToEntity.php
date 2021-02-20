<?php

namespace App\Service\Api\DataTransformer;

use App\Api\CreateSearchRequest;
use App\Entity\City;
use App\Entity\SearchRequest;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;

class CreateSearchRequestToEntity implements DataTransformerInterface
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
        return get_class($data) === CreateSearchRequest::class &&
            $targetClass === SearchRequest::class;
    }

    /**
     * @param CreateSearchRequest $data
     * @param string $targetClass
     * @param DataTransformer $transformer
     * @return SearchRequest
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): SearchRequest
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }

        $entity = new SearchRequest();
        /** @var City $city */
        $city = $this->em->find(City::class, $data->getCity());
        $entity
            ->setCity($city)
            ->setCheckIn($data->getCheckIn())
            ->setCheckOut($data->getCheckOut())
        ;

        return $entity;
    }
}