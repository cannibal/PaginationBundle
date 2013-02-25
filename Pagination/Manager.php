<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;

use Symfony\Component\HttpFoundation\Request;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;
use Doctrine\Common\Collections\Collection;

use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;

use Doctrine\ORM\QueryBuilder;

use Symfony\Component\HttpFoundation\Response;

use Cannibal\Bundle\PaginationBundle\Pagination\Exception\AdapterSelectionException;
use Cannibal\Bundle\PaginationBundle\Pagination\Factory\PaginatedItemsFactory;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginatedCollectionInterface;
/**
 * This class provides functionality to extract pagination data from the request
 */
class Manager
{
    private $request;
    private $pagerfanta;
    private $config;
    private $paginatedItemsFactory;

    public function __construct(PaginatedItemsFactory $paginatedItemsFactory)
    {
        $this->paginatedItemsFactory = $paginatedItemsFactory;
    }

    public function setPaginatedItemsFactory(PaginatedItemsFactory $paginatedItemsFactory)
    {
        $this->paginatedItemsFactory = $paginatedItemsFactory;
    }

    /**
     * @return Factory\PaginatedItemsFactory
     */
    public function getPaginatedItemsFactory()
    {
        return $this->paginatedItemsFactory;
    }

    public function createPagerfanta(AdapterInterface $adapter)
    {
        return new Pagerfanta($adapter);
    }

    public function paginateQuery(QueryBuilder $queryBuilder)
    {
        return new DoctrineORMAdapter($queryBuilder);
    }

    public function paginateCollection(Collection $collection)
    {
        return new DoctrineCollectionAdapter($collection);
    }

    public function paginateArray(array $collection)
    {
        return new ArrayAdapter($collection);
    }

    public function selectAdapter($list)
    {
        $type = gettype($list);
        $adapter = null;
        switch($type){
            case 'object':
                if($list instanceof Collection){
                    $adapter = $this->paginateCollection($list);
                }
                elseif($list instanceof QueryBuilder){
                    $adapter = $this->paginateQuery($list);
                }
                break;
            case 'array':
                $adapter = $this->paginateArray($list);
                break;
        }

        return $adapter;
    }

    /**
     * @param $list
     * @param PaginationConfig $config
     * @return PaginatedCollectionInterface
     * @throws Exception\AdapterSelectionException
     */
    public function paginate($list, PaginationConfig $config)
    {
        $adapter = $this->selectAdapter($list);

        if($adapter == null){
            throw new AdapterSelectionException(sprintf('Could not find adapter for type %s', gettype($list)));
        }

        return $this->paginateItems($adapter, $config);
    }

    /**
     * @param \Pagerfanta\Adapter\AdapterInterface $adapter
     * @param PaginationConfig $config
     * @return PaginatedCollection
     */
    protected function paginateItems(AdapterInterface $adapter, PaginationConfig $config)
    {
        $pagerfanta = $this->createPagerfanta($adapter);

        $pagerfanta->setMaxPerPage($config->getItemsPerPage());
        $pagerfanta->setCurrentPage($config->getCurrent());

        $next = $pagerfanta->hasNextPage() ? $pagerfanta->getNextPage() : null;
        $previous = $pagerfanta->hasPreviousPage() ? $pagerfanta->getPreviousPage() : null;

        $config->setNext($next);
        $config->setPrevious($previous);

        $config->setTotalPages($pagerfanta->getNbPages());
        $config->setTotalItems($pagerfanta->getNbResults());

        return $this->getPaginatedItemsFactory()->createPaginatedItems($pagerfanta, $config);
    }
}
