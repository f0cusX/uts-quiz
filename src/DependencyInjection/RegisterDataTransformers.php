<?php

namespace App\DependencyInjection;

use App\Service\Api\DataTransformer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterDataTransformers implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $dataTransformer = $container->getDefinition(DataTransformer::class);
        foreach ($container->findTaggedServiceIds('app.data_transformer') as $id => $tags)
        {
            $dataTransformer->addMethodCall('registerTransformer', [new Reference($id)]);
        }
    }
}