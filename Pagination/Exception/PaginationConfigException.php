<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class PaginationConfigException extends \InvalidArgumentException
{
    private $paginationErrors;

    public function setPaginationErrors(ConstraintViolationList $paginationErrors)
    {
        $this->paginationErrors = $paginationErrors;
    }

    public function getPaginationErrors()
    {
        return $this->paginationErrors;
    }
}
