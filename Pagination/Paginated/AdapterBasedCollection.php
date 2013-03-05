<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface;

use Pagerfanta\PagerfantaInterface;

/**
 * This class represents paginated items
 */
class AdapterBasedCollection implements PaginatedCollectionInterface, MetadataInterface
{
    private $metadata;

    private $adapter;

    public function __construct(PagerfantaInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->metadata = null;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setMetadata(MetadataInterface $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->getAdapter()->getCurrentPageResults()->getArrayCopy();
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
}
