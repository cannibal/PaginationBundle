<?php
namespace Cannibal\Bundle\PaginationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AdapterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tagged = $container->findTaggedServiceIds('cannibal_pagination.adapter');

        $adapters = array();
        foreach($tagged as $serviceId => $definition){
            $serviceDefinition = $container->getDefinition($serviceId);
            $adapters[] = $serviceDefinition;
        }

        $container->getDefinition('cannibal_paginator')
            ->replaceArgument(5, $adapters);
    }
}