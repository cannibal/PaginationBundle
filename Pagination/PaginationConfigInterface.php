<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 27/12/12
 * Time: 23:30
 * To change this template use File | Settings | File Templates.
 */
interface PaginationConfigInterface
{
    public function getCurrent();

    public function getItemsPerPage();

    public function getNext();

    public function getPrevious();

    public function getTotalItems();

    public function getTotalPages();

    /**
     * @return array
     */
    public function toArray();
}
