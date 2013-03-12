<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface;

/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 05/03/2013
 * Time: 14:39
 * To change this template use File | Settings | File Templates.
 */
class ArrayCollection implements PaginatedCollectionInterface, MetadataInterface
{
    private $metadata;
    private $results;

    public function __construct()
    {
        $this->metadata = null;
        $this->results = array();
    }

    /**
     * This function returns the wrapped paginator instance.
     *
     * @return mixed
     */
    public function getAdapter()
    {
        return null;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    public function setResults(array $results)
    {
        $this->results = $results;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    public function getPage()
    {
        return $this->getMetadata()->getPage();
    }

    public function getPerPage()
    {
        return $this->getMetadata()->getPerPage();
    }

    public function getNextPage()
    {
        return $this->getMetadata()->getNextPage();
    }

    public function getPreviousPage()
    {
        return $this->getMetadata()->getPreviousPage();
    }

    public function getTotalResults()
    {
        return $this->getMetadata()->getTotalResults();
    }

    public function getTotalPages()
    {
        return $this->getMetadata()->getTotalPages();
    }

    public function setMetadata(MetadataInterface $metadata)
    {
        $this->metadata = $metadata;
    }
}
