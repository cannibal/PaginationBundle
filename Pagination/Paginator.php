<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination;

use Cannibal\Bundle\PaginationBundle\Pagination\Adapter\PaginationAdapter;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;
use Doctrine\Common\Collections\Collection;

use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;

use Doctrine\ORM\QueryBuilder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Cannibal\Bundle\PaginationBundle\Pagination\Exception\AdapterSelectionException;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Factory\PaginatedCollectionFactory;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\Factory\MetadataFactory;
use Cannibal\Bundle\PaginationBundle\Pagination\Exception\PaginationException;

use Cannibal\Bundle\PaginationBundle\Pagination\Fetcher\PaginationFetcher;
use Cannibal\Bundle\PaginationBundle\Pagination\Factory\PaginationConfigFactory;
use Cannibal\Bundle\PaginationBundle\Pagination\Adapter\PaginationAdapterInterface;


use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Form\FormFactoryInterface;


/**
 * This class provides functionality to extract pagination data from the request
 */
class Paginator
{
    private $request;
    private $pagerfanta;
    private $configFactory;
    private $paginatedCollectionFactory;
    private $metaFactory;
    private $fetcher;
    private $formFactory;
    private $validator;
    private $adapters;

    private $page;
    private $perPage;

    public function __construct(Request $request,
                                PaginatedCollectionFactory $paginatedItemsFactory,
                                MetadataFactory $metaFactory,
                                PaginationConfigFactory $configFactory,
                                PaginationFetcher $fetcher,
                                FormFactoryInterface $formFactory,
                                ValidatorInterface $validator,
                                array $adapters = array())
    {
        $this->request = $request;
        $this->paginatedCollectionFactory = $paginatedItemsFactory;
        $this->metaFactory = $metaFactory;
        $this->fetcher = $fetcher;
        $this->configFactory = $configFactory;
        $this->formFactory = $formFactory;
        $this->validator = $validator;
        $this->adapters = $adapters;
        $this->page = null;
        $this->perPage = null;
    }

    public function setAdapters(array $adapters)
    {
        $this->adapters = $adapters;
    }

    public function getAdapters()
    {
        return $this->adapters;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return \Symfony\Component\Form\FormFactoryInterface
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    public function setFetcher(PaginationFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function getFetcher()
    {
        return $this->fetcher;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function setPaginatedCollectionFactory(PaginatedCollectionFactory $paginatedItemsFactory)
    {
        $this->paginatedCollectionFactory = $paginatedItemsFactory;
    }

    public function setMetaFactory($metaFactory)
    {
        $this->metaFactory = $metaFactory;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\Factory\MetadataFactory
     */
    public function getMetaFactory()
    {
        return $this->metaFactory;
    }

    public function setConfigFactory(PaginationConfigFactory $configFactory)
    {
        $this->configFactory = $configFactory;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Factory\PaginationConfigFactory
     */
    public function getConfigFactory()
    {
        return $this->configFactory;
    }

    /**
     * @return Paginated\Factory\PaginatedCollectionFactory
     */
    public function getPaginatedCollectionFactory()
    {
        return $this->paginatedCollectionFactory;
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
                /** @var PaginationAdapterInterface $thirdPartyAdapter  */
                foreach($this->adapters as $thirdPartyAdapter){
                    if($thirdPartyAdapter instanceof AdapterInterface && $adapter instanceof PaginationAdapterInterface){
                        if($thirdPartyAdapter->supports($list)){
                            $adapter = $thirdPartyAdapter;
                            break;
                        }
                    }
                }

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

    public function getPaginationConfig(PaginationConfigInterface $config)
    {
        $configFactory = $this->getConfigFactory();
        $type = $configFactory->createPaginationType();

        $form = $this->getFormFactory()->create($type, $config);

        $data = $this->getFetcher()->fetchPaginationData($this->getRequest()->query->all());

        $form->bind($data);

        return $config;
    }

    /**
     * @param $list
     * @param null $page
     * @param null $perPage
     * @param bool $ignorePagination
     * @return Paginated\PaginatedCollectionInterface
     * @throws Exception\PaginationException
     * @throws Exception\AdapterSelectionException
     */
    public function paginate($list, $page = null, $perPage = null, $ignorePagination = false)
    {
        $config = $this->getConfigFactory()->createPaginationConfiguration();

        if($ignorePagination == true){
            $config->setBypass(true);
        }
        elseif(!is_null($page) || !is_null($perPage)){
            if(!is_null($page)){
                $config->setPage($page);
            }

            if(!is_null($perPage)){
                $config->setPerPage($perPage);
            }
        }
        else{
            $this->getPaginationConfig($config);
        }

        $errors = $this->getValidator()->validate($config);

        if(count($errors) > 0){
            $error = new PaginationException('The pagination configuration was invalid');
            $error->setPaginationErrors($errors);
            throw $error;
        }

        $adapter = $this->selectAdapter($list);

        if($config->getBypass()){
            $out = $this->bypassPagination($adapter, $config);
        }
        else{
            if($adapter == null){
                throw new AdapterSelectionException(sprintf('Could not find adapter for type %s', gettype($list)));
            }
            $out = $this->paginateItems($adapter, $config);
        }

        return $out;
    }

    /**
     * @param \Pagerfanta\Adapter\AdapterInterface $adapter
     * @param PaginationConfigInterface $config
     */
    protected function bypassPagination(AdapterInterface $adapter, PaginationConfigInterface $config)
    {
        $out = $this->getPaginatedCollectionFactory()->createArrayCollection();
        $results = $adapter->getSlice(0, $adapter->getNbResults());
        $out->setResults($results->getArrayCopy());
        $meta = $this->getMetaFactory()->createPaginatedCollectionMetadata();
        $meta->setTotalResults(count($out->getResults()));
        $out->setMetadata($meta);

        return $out;
    }

    /**
     * @param \Pagerfanta\Adapter\AdapterInterface $adapter
     * @param PaginationConfig $config
     * @return PaginatedCollectionInterface
     */
    protected function paginateItems(AdapterInterface $adapter, PaginationConfigInterface $config)
    {
        $pagerfanta = $this->createPagerfanta($adapter);

        $pagerfanta->setMaxPerPage($config->getPerPage());
        $out = $this->getPaginatedCollectionFactory()->createPagerfantaBasedCollection($pagerfanta);

        $totalPages = $pagerfanta->getNbPages();
        $current = $config->getPage();

        if($current <= $totalPages && $current > 0){
            $pagerfanta->setCurrentPage($current);
        }
        else{
            $pagerfanta->setCurrentPage(1);
            $out = $this->getPaginatedCollectionFactory()->createEmptyCollection();
        }

        $next = $pagerfanta->hasNextPage() ? $pagerfanta->getNextPage() : null;
        $previous = $pagerfanta->hasPreviousPage() ? $pagerfanta->getPreviousPage() : null;

        $metadata = $this->getMetaFactory()->createPaginatedCollectionMetadata();
        $metadata->setPage($current);
        $metadata->setNextPage($next);
        $metadata->setPreviousPage($previous);
        $metadata->setPerPage($config->getPerPage());
        $metadata->setTotalResults($pagerfanta->getNbResults());
        $metadata->setTotalPages($totalPages);

        $out->setMetadata($metadata);

        return $out;
    }
}
