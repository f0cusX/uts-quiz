<?php


namespace App\Service\Api\DataTransformer;

use App\Api\Hotel;
use App\Api\Meal;
use App\Api\Money;
use App\Api\SearchResult;
use App\Entity\SearchResult as SearchResultEntity;
use App\Exception\UnsupportedTransformation;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class SearchResultToApi implements DataTransformerInterface
{
    public function supports($data, string $targetClass): bool
    {
        return get_class($data) === SearchResultEntity::class &&
            $targetClass === SearchResult::class;
    }

    /**
     * @param SearchResultEntity $data
     * @param string $targetClass
     * @param DataTransformer $transformer
     * @return SearchResult
     * @throws UnsupportedTransformation
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): SearchResult
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        return new SearchResult(
            $data->getId(),
            $transformer->transform($data->getHotel(), Hotel::class),
            $data->getRoomName(),
            $transformer->transform($data->getPrice(), Money::class),
            $transformer->transform($data->getMeal(), Meal::class)
        );
    }
}