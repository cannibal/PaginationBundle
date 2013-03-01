<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\PaginatedCollectionMetadataInterface;

use Pagerfanta\PagerfantaInterface;

/**
 * This class represents paginated items
 */
class PaginatedCollection implements PaginatedCollectionInterface, PaginatedCollectionMetadataInterface
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

    public function setMetadata(PaginatedCollectionMetadataInterface $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\PaginatedCollectionMetadataInterface
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
        return $this->getAdapter()->getCurrentPageResults()->getArray();
    }

    public function getCurrent()
    {
        return $this->getMetadata()->getCurrent();
    }

    public function getItemsPerPage()
    {
        return $this->getMetadata()->getItemsPerPage();
    }

    public function getNext()
    {
        return $this->getMetadata()->getNext();
    }

    public function getPrevious()
    {
        return $this->getMetadata()->getPrevious();
    }

    public function getTotalItems()
    {
        return $this->getMetadata()->getTotalItems();
    }

    public function getTotalPages()
    {
        return $this->getMetadata()->getTotalPages();
    }
}
