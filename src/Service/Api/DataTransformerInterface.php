<?php

namespace App\Service\Api;

interface DataTransformerInterface
{
    public function supports($data, string $targetClass): bool;

    /**
     * @param $data
     * @param string $targetClass
     * @param DataTransformer $transformer
     * @return mixed
     */
    public function transform($data, string $targetClass, DataTransformer $transformer);
}