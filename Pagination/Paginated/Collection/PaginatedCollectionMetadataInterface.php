<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection;

/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 28/02/2013
 * Time: 14:29
 * To change this template use File | Settings | File Templates.
 */
interface PaginatedCollectionMetadataInterface
{
    /**
     * Returns the current page
     *
     * @return mixed
     */
    public function getCurrent();

    public function getItemsPerPage();

    public function getNext();

    public function getPrevious();

    public function getTotalItems();

    public function getTotalPages();
}
