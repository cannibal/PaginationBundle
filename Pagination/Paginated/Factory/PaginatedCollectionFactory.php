<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Factory;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollection;
use Pagerfanta\PagerfantaInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 08/12/12
 * Time: 21:10
 * To change this template use File | Settings | File Templates.
 */
class PaginatedCollectionFactory
{
    /**
     * @param \Pagerfanta\PagerfantaInterface $adapter
     * @param \Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig $config
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollection
     */
    public function createPaginatedCollection(PagerfantaInterface $adapter)
    {
        return new PaginatedCollection($adapter);
    }
}
