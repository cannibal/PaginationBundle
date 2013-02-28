<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;

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
    public function setConfiguration(PaginationConfigInterface $config);

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
