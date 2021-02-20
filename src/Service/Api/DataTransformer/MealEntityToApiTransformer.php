<?php

namespace App\Service\Api\DataTransformer;

use App\Entity\Meal;
use App\Api\Meal as ApiMeal;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class MealEntityToApiTransformer implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return $data instanceof Meal && $targetClass === ApiMeal::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): ApiMeal
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        /* @var $data Meal */
        return new ApiMeal($data->getId(), $data->getName());
    }
}