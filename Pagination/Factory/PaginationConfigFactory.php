<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Factory;

use Cannibal\Bundle\PaginationBundle\Form\Type\PaginationConfigType;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;
use Cannibal\Bundle\PaginationBundle\Pagination\Factory\PaginationConfigFactoryInterface;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 04/12/12
 * Time: 22:14
 * To change this template use File | Settings | File Templates.
 */
class PaginationConfigFactory implements PaginationConfigFactoryInterface
{
    public function createPaginationType()
    {
        return new PaginationConfigType();
    }

    public function createPaginationConfiguration()
    {
        $config = new PaginationConfig();

        return $config;
    }
}
