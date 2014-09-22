<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Fetcher;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;

class PaginationFetcher
{
    public function fetchPaginationData(array $data, $allowBypass = false)
    {
        $out = new PaginationConfig();

        if(isset($data['page'])){
            $out->setPage(intval($data['page']));
        }

        if(isset($data['per_page'])){
            if($data['per_page'] == 'all'){
                if($allowBypass == true){
                    $out->setBypass(true);
                }
            }
            else{
                $out->setPerPage($data['per_page']);
            }
        }

        return $out;
    }
}
