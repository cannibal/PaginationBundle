<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Factory;

/**
 * Defines functionality for a pagination configuration factory
 */
interface PaginationConfigFactoryInterface
{
    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface
     */
    public function createPaginationConfiguration();
}
