<?php


namespace App\Service\Api\DataTransformer;


use App\Api\NamedItem;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class PublicObjectToNamedItem implements DataTransformerInterface
{
    public function supports($data, string $targetClass): bool
    {
        if ($targetClass !== NamedItem::class || !is_object($data)) {
            return false;
        }
        return property_exists($data, 'id') && property_exists($data, 'name');
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): NamedItem
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        return new NamedItem((int)$data->id, (string)$data->name);
    }
}