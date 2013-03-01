<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\Factory;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\Metadata;

/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 28/02/2013
 * Time: 15:58
 * To change this template use File | Settings | File Templates.
 */
class MetadataFactory
{
    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\Metadata
     */
    public function createPaginatedCollectionMetadata()
    {
        return new Metadata();
    }
}
