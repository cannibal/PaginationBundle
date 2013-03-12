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
    public function getPage();

    public function getPerPage();

    public function getBypass();
}
