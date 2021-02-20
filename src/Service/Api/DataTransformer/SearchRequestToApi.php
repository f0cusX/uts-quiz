<?php


namespace App\Service\Api\DataTransformer;


use App\Api\City;
use App\Api\SearchRequest;
use App\Entity\SearchRequest as SearchRequestEntity;
use App\Exception\UnsupportedTransformation;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class SearchRequestToApi implements DataTransformerInterface
{
    public function supports($data, string $targetClass): bool
    {
        return get_class($data) === SearchRequestEntity::class &&
            $targetClass === SearchRequest::class;
    }

    /**
     * @param SearchRequestEntity $data
     * @param string $targetClass
     * @param DataTransformer $transformer
     * @return SearchRequest
     * @throws UnsupportedTransformation
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): SearchRequest
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        return new SearchRequest(
            $data->getId(),
            $transformer->transform($data->getCity(), City::class),
            $data->getCheckIn(),
            $data->getCheckOut()
        );
    }
}