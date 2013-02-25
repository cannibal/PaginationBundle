<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;
use Pagerfanta\PagerfantaInterface;

/**
 * This class represents paginated items
 */
class PaginatedCollection
{
    private $configuration;

    private $adapter;

    public function __construct(PagerfantaInterface $adapter,PaginationConfig $config)
    {
        $this->configuration = $config;
        $this->adapter = $adapter;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->getAdapter()->getCurrentPageResults();
    }
}
