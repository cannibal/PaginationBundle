<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Adapter;


interface PaginationAdapterInterface
{
    public function supports($classname);
}