<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginator;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;

interface PaginatorInterface extends PaginatedCollectionInterface, PaginationConfigInterface {

    /**
     * @param null $listIn
     * @param null $page
     * @param null $perPage
     * @param null $bypass
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginator\PaginatorInterface
     */
    public function paginate($listIn = null, $page = null, $perPage = null, $bypass = null);

    /**
     * @return mixed
     */
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

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginator\PaginatorInterface
     */
    public function setRequestData(array $requestData);

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginator\PaginatorInterface
     */
    public function setAllowBypass($bypass);
}