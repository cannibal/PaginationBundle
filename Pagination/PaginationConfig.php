<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;

/**
 * A Generic class to represent pagination settings
 */
class PaginationConfig implements PaginationConfigInterface
{
    protected $itemsPerPage;
    protected $current;
    protected $next;
    protected $previous;
    protected $totalPages;
    protected $totalItems;

    public function __construct()
    {
        $this->itemsPerPage = null;
        $this->current = null;
        $this->next = null;
        $this->previous = null;
        $this->totalItems = null;
        $this->totalPages = null;
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

    public function toArray()
    {
        return array(
            'current'=>$this->getCurrent(),
            'limit'=>$this->getItemsPerPage(),
            'next'=>$this->getNext(),
            'previous'=>$this->getPrevious(),
            'total-pages'=>$this->getTotalPages(),
            'total-items'=>$this->getTotalItems()
        );
    }


}
