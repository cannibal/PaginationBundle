<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Fetcher;

/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 28/02/2013
 * Time: 17:09
 * To change this template use File | Settings | File Templates.
 */
class PaginationFetcher
{
    public function fetchPaginationData(array $data)
    {
        $out = array();

        if(isset($data['page'])){
            $out['current'] = $data['page'];
        }

        if(isset($data['per_page'])){
            $out['itemsPerPage'] = $data['per_page'];
        }

        return $out;
    }
}
