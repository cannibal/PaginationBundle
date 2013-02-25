<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;

/**
 * This interface defines functionality for a paginator
 */
interface PaginatedCollectionInterface
{
    /**
     * This function returns the configuration for the paginator.
     *
     * @return mixed
     */
    public function getConfiguration();

    /**
     * This function should configure the wrapped paginator using the configuration provided.
     *
     * @param PaginationConfig $config
     * @return mixed
     */
    public function setConfiguration(PaginationConfig $config);

    /**
     * This function returns the wrapped paginator instance.
     *
     * @return mixed
     */
    public function getPaginator();

    /**
     * @return array
     */
    public function getResults();
}
