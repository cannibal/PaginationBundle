<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;

/**
 * This interface defines functionality for a paginator
 */
interface PaginatedCollectionInterface
{
    /**
     * This function returns the wrapped paginator instance.
     *
     * @return mixed
     */
    public function getAdapter();

    /**
     * @return array
     */
    public function getResults();
}
