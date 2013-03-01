<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;

/**
 * A Generic class to represent pagination settings
 */
class PaginationConfig implements PaginationConfigInterface
{
    private $perPage;
    private $page;

    public function __construct()
    {
        $this->perPage = null;
        $this->page = null;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }
}
