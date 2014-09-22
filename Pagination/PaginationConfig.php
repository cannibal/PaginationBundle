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
    private $bypass;

    public function __construct()
    {
        $this->perPage = 10;
        $this->page = 1;
        $this->bypass = false;
    }

    public function setBypass($bypass)
    {
        $this->bypass = $bypass;
    }

    public function getBypass()
    {
        return $this->bypass;
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
