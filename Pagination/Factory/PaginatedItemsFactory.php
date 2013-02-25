<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Factory;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginatedCollection;
use Pagerfanta\PagerfantaInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 08/12/12
 * Time: 21:10
 * To change this template use File | Settings | File Templates.
 */
class PaginatedItemsFactory
{
    /**
     * @param \Pagerfanta\PagerfantaInterface $adapter
     * @param \Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig $config
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\PaginatedCollection
     */
    public function createPaginatedItems(PagerfantaInterface $adapter,PaginationConfig $config)
    {
        return new PaginatedCollection($adapter, $config);
    }
}
