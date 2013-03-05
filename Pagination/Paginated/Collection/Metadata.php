<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface;
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 28/02/2013
 * Time: 14:28
 * To change this template use File | Settings | File Templates.
 */
class Metadata implements MetadataInterface
{
    private $page;
    private $nextPage;
    private $previousPage;
    private $totalResults;
    private $totalPages;
    private $perPage;

    public function __construct()
    {
        $this->page = null;
        $this->nextPage = null;
        $this->previousPage = null;
        $this->totalResults = null;
        $this->totalPages = null;
        $this->perPage = null;
    }

    public function setNextPage($nextPage)
    {
        $this->nextPage = $nextPage;
    }

    public function getNextPage()
    {
        return $this->nextPage;
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

    public function setPreviousPage($previousPage)
    {
        $this->previousPage = $previousPage;
    }

    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }

    public function getTotalResults()
    {
        return $this->totalResults;
    }
}
