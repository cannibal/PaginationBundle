<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface;

/**
 * This interface defines functionality for a paginator
 */
interface PaginatedCollectionInterface
{
    /**
     * This function returns the wrapped paginator instance.
     *
     * @return mixed|null
     */
    public function getAdapter();

    /**
     * @return array
     */
    public function getResults();

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface
     */
    public function getMetadata();

    public function setMetadata(MetadataInterface $metadata);
}
