<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class PaginationException extends \InvalidArgumentException
{
    private $paginationErrors;
    private $paginationMetadata;

    public function __construct()
    {
        $this->paginationErrors = null;
        $this->paginationMetadata = null;
    }

    public function setPaginationMetadata($paginationMetadata)
    {
        $this->paginationMetadata = $paginationMetadata;
    }

    public function getPaginationMetadata()
    {
        return $this->paginationMetadata;
    }

    public function setPaginationErrors(ConstraintViolationList $paginationErrors)
    {
        $this->paginationErrors = $paginationErrors;
    }

    public function getPaginationErrors()
    {
        return $this->paginationErrors;
    }
}
