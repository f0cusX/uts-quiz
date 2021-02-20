<?php


namespace App\Service\Api\DataTransformer;


use App\Api\Identifier;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class MixedToIdentifier implements DataTransformerInterface
{
    public function supports($data, string $targetClass): bool
    {
        if ($targetClass !== Identifier::class) {
            return false;
        }
        if (is_object($data)) {
            return method_exists($data, 'getId') || property_exists($data, 'id');
        }
        if (is_array($data)) {
            return !empty($data['id']);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): Identifier
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        if (is_object($data)) {
            if (property_exists($data, 'id')) {
                return new Identifier((int)$data->id);
            }
            return new Identifier((int)$data->getId());
        }
        return new Identifier((int)$data['id']);
    }
}