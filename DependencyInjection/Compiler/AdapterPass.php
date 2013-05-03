<?php
namespace Cannibal\Bundle\PaginationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AdapterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tagged = $container->findTaggedServiceIds('cannibal_pagination.adapter');

        $container->getDefinition('pagination.manager')
            ->replaceArgument(7, $tagged);
    }
}