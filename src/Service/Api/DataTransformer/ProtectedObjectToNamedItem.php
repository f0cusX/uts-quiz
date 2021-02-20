<?php


namespace App\Service\Api\DataTransformer;


use App\Api\NamedItem;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class ProtectedObjectToNamedItem implements DataTransformerInterface
{
    public function supports($data, string $targetClass): bool
    {
        if ($targetClass !== NamedItem::class || !is_object($data)) {
            return false;
        }
        return method_exists($data, 'getId') && method_exists($data, 'getName');
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer): NamedItem
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }
        return new NamedItem((int)$data->getId(), (string)$data->getName());
    }
}