<?php


namespace App\Service\Api;


use App\Exception\UnsupportedTransformation;

class DataTransformer
{
    /**
     * @var DataTransformerInterface[]
     */
    protected $transformers = [];

    public function registerTransformer(DataTransformerInterface $transformer)
    {
        $this->transformers[] = $transformer;
    }

    public function transform($data, string $targetClass)
    {
        if (null === $data) {
            return null;
        }
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($data, $targetClass)) {
                return $transformer->transform($data, $targetClass, $this);
            }
        }
        throw new UnsupportedTransformation($data, $targetClass);
    }

    public function transformCollection(iterable $collection, string $targetClass): array
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = $this->transform($item, $targetClass);
        }
        return $result;
    }
}