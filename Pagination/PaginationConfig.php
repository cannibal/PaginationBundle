<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;

/**
 * A Generic class to represent pagination settings
 */
class PaginationConfig implements PaginationConfigInterface
{
    private $itemsPerPage;
    private $current;

    public function __construct()
    {
        $this->itemsPerPage = null;
        $this->current = null;
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
}
