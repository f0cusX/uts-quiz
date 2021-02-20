<?php

namespace App\Service\Api\DataTransformer;

use App\Api\CreateSearchRequest;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use DateTime;
use LogicException;

class StdToCreateSearchRequest implements DataTransformerInterface
{

    public function supports($data, string $targetClass): bool
    {
        return get_class($data) === 'stdClass' &&
            $targetClass === CreateSearchRequest::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): CreateSearchRequest
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        $checkIn = DateTime::createFromFormat('Y-m-d', $data->checkIn);
        $checkOut = DateTime::createFromFormat('Y-m-d', $data->checkOut);
        return new CreateSearchRequest(
            $data->city ?? 0,
            $checkIn ?: null,
            $checkOut ?: null
        );
    }
}