<?php

namespace Cannibal\Bundle\PaginationBundle;

use Cannibal\Bundle\PaginationBundle\DependencyInjection\Compiler\AdapterPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CannibalPaginationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AdapterPass());
    }
}
