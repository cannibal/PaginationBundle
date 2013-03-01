<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\PaginatedCollectionMetadataInterface;
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 28/02/2013
 * Time: 14:28
 * To change this template use File | Settings | File Templates.
 */
class Metadata implements PaginatedCollectionMetadataInterface
{
    private $current;
    private $next;
    private $previous;
    private $totalItems;
    private $totalPages;
    private $itemsPerPage;

    public function __construct()
    {
        $this->current = null;
        $this->next = null;
        $this->previous = null;
        $this->totalItems = null;
        $this->totalPages = null;
        $this->itemsPerPage = null;
    }

    public function setCurrent($current)
    {
        $this->current = $current;
    }

    public function getCurrent()
    {
        return $this->current;
    }

    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function setNext($next)
    {
        $this->next = $next;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setPrevious($previous)
    {
        $this->previous = $previous;
    }

    public function getPrevious()
    {
        return $this->previous;
    }

    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }

    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }
}
