<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginator;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;

interface PaginatorInterface extends PaginatedCollectionInterface, PaginationConfigInterface {
    public function paginate($list, $page = null, $perPage = null, $bypass = null);

    public function getList();

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginator\PaginatorInterface
     */
    public function setList($list);

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginator\PaginatorInterface
     */
    public function setPage($page);

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginator\PaginatorInterface
     */
    public function setPerPage($perPage);

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginator\PaginatorInterface
     */
    public function setBypass($bypass);
}