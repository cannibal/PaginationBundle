<?php
namespace Cannibal\Bundle\PaginationBundle\Pagination\Paginator;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\EmptyCollection;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Adapter\PaginationAdapterInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfigInterface;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Factory\PaginatedCollectionFactory;
use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\Factory\MetadataFactory;
use Cannibal\Bundle\PaginationBundle\Pagination\Fetcher\PaginationFetcher;
use Cannibal\Bundle\PaginationBundle\Form\Type\PaginatorType;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\ValidatorInterface;

use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\QueryBuilder;

use Cannibal\Bundle\PaginationBundle\Pagination\Exception\PaginationException;
use Cannibal\Bundle\PaginationBundle\Pagination\Exception\AdapterSelectionException;

class Paginator implements PaginatorInterface
{
    private $requestData;

    private $bypass;
    private $page;
    private $perPage;

    private $paginatedCollection;
    private $selectedAdapter;
    private $adapters;

    private $fetcher;
    private $formFactory;
    private $validator;
    private $metaFactory;
    private $paginatedCollectionFactory;

    private $list;

    private $results;

    public function __construct(
        PaginatedCollectionFactory $pCFactory,
        MetadataFactory $metaFactory,
        PaginationFetcher $fetcher,
        FormFactoryInterface $formFactory,
        ValidatorInterface $validator,
        array $adapters = array()
    )
    {
        $this->fetcher = $fetcher;
        $this->formFactory = $formFactory;
        $this->validator = $validator;

        $this->requestData = null;

        $this->perPage = 10;
        $this->page = 1;
        $this->bypass = false;

        $this->paginatedCollectionFactory = $pCFactory;
        $this->metaFactory = $metaFactory;
        $this->paginatedCollection = null;
        $this->selectedAdapter = null;

        $this->adapters = $adapters;
        $this->results = null;
    }

    protected function createPagerfanta(AdapterInterface $adapter)
    {
        return new Pagerfanta($adapter);
    }

    protected function createPaginationType()
    {
        return new PaginatorType();
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    public function setList($list)
    {
        $this->list = $list;
        return $this;
    }

    public function getList()
    {
        return $this->list;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\Factory\MetadataFactory
     */
    protected function getMetaFactory()
    {
        return $this->metaFactory;
    }

    public function setFetcher($fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @return PaginationFetcher
     */
    public function getFetcher()
    {
        return $this->fetcher;
    }

    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * @return PaginatedCollectionFactory
     */
    protected function getPaginatedCollectionFactory()
    {
        return $this->paginatedCollectionFactory;
    }

    public function setAdapters($adapters)
    {
        $this->adapters = $adapters;
    }

    public function getAdapters()
    {
        return $this->adapters;
    }

    public function setPaginatedCollection($paginatedCollection)
    {
        $this->paginatedCollection = $paginatedCollection;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\PaginatedCollectionInterface
     */
    public function getPaginatedCollection()
    {
        return $this->paginatedCollection;
    }

    public function setRequestData(array $requestData)
    {
        $type = $this->createPaginationType();
        $form = $this->getFormFactory()->create($type, $this);

        $data = $this->getFetcher()->fetchPaginationData($requestData);
        $form->bind($data);

        $this->requestData = $requestData;

        return $this;
    }

    public function getRequestData()
    {
        return $this->requestData;
    }

    public function setSelectedAdapter($selectedAdapter)
    {
        $this->selectedAdapter = $selectedAdapter;
    }

    public function getSelectedAdapter()
    {
        return $this->selectedAdapter;
    }

    public function selectAdapter($list)
    {
        $type = gettype($list);
        $adapter = null;
        switch ($type) {
            case 'array':
                $adapter = new ArrayAdapter($list);
                break;
            case 'object':
                /** @var PaginationAdapterInterface $thirdPartyAdapter */
                foreach ($this->getAdapters() as $thirdPartyAdapter) {
                    if ($thirdPartyAdapter instanceof AdapterInterface && $thirdPartyAdapter instanceof PaginationAdapterInterface) {
                        if ($thirdPartyAdapter->supports($list)) {
                            $adapter = $thirdPartyAdapter;
                            $adapter->setList($list);
                            break;
                        }
                    }
                }

                if ($list instanceof Collection) {
                    $adapter = new DoctrineCollectionAdapter($list);
                }
                elseif ($list instanceof QueryBuilder) {
                    $adapter = new DoctrineORMAdapter($list);
                }

                if($adapter == null){
                    throw new AdapterSelectionException(sprintf('Could not find adapter for type %s', $type));
                }

                break;
        }

        $this->setSelectedAdapter($adapter);
    }

    /**
     * @param \Pagerfanta\Adapter\AdapterInterface $adapter
     * @param PaginationConfigInterface $config
     */
    protected function createUnboundedCollection()
    {
        $adapter = $this->getAdapter();

        $out = $this->getPaginatedCollectionFactory()->createArrayCollection();
        /** @var \ArrayIterator $results */
        $results = $adapter->getSlice(0, $adapter->getNbResults());
        $out->setResults($results->getArrayCopy());
        $meta = $this->getMetaFactory()->createPaginatedCollectionMetadata();
        $meta->setTotalResults(count($out->getResults()));
        $out->setMetadata($meta);

        return $out;
    }

    /**
     * @param AdapterInterface $adapter
     * @param PaginationConfigInterface $config
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\AdapterBasedCollection|\Cannibal\Bundle\PaginationBundle\Pagination\Paginated\EmptyCollection
     */
    protected function createPaginatedCollection()
    {
        $adapter = $this->getAdapter();
        $paginatedCollectionFactory = $this->getPaginatedCollectionFactory();

        $perPage = $this->getPerPage();
        $current = $this->getPage();

        $pf = $this->createPagerfanta($adapter);
        $pf->setMaxPerPage($perPage);

        $out = $paginatedCollectionFactory->createPagerfantaBasedCollection($pf);
        $totalPages = $pf->getNbPages();

        if ($current <= $totalPages && $current > 0) {
            $pf->setCurrentPage($current);
        }
        else {
            $pf->setCurrentPage(1);
            $out = $paginatedCollectionFactory->createEmptyCollection();
        }

        $next = $pf->hasNextPage() ? $pf->getNextPage() : null;
        $previous = $pf->hasPreviousPage() ? $pf->getPreviousPage() : null;

        $metadata = $this->getMetaFactory()->createPaginatedCollectionMetadata();
        $metadata->setPage($current);
        $metadata->setNextPage($next);
        $metadata->setPreviousPage($previous);
        $metadata->setPerPage($perPage);
        $metadata->setTotalResults($pf->getNbResults());
        $metadata->setTotalPages($totalPages);

        $out->setMetadata($metadata);

        return $out;
    }

    /**
     * @param null $page
     * @param null $perPage
     * @param null $bypass
     * @throws \Cannibal\Bundle\PaginationBundle\Pagination\Exception\PaginationException
     */
    public function paginate($list = null, $page = null, $perPage = null, $bypass = null)
    {
        if($list != null){
            $this->setList($list);
        }
        else{
            $list = $this->getList();
        }

        if(!is_null($page) || !is_null($perPage) || !is_null($bypass)){
            if(!is_null($page)){
                $this->setPage($page);
            }
            if(!is_null($perPage)){
                $this->setPerPage($perPage);
            }
            if(!is_null($bypass)){
                $this->setBypass($bypass);
            }
        }

        $errors = $this->getValidator()->validate($this);
        if(count($errors) > 0){
            $error = new PaginationException('The pagination configuration was invalid');
            $error->setPaginationErrors($errors);
            throw $error;
        }



        $this->selectAdapter($list);

        if($list == null){
            $out = new EmptyCollection();
        }
        elseif($this->getBypass()){
            $out = $this->createUnboundedCollection();
        }
        else{
            $out = $this->createPaginatedCollection();
        }

        $this->setPaginatedCollection($out);

        return $this;
    }


    //PaginatedCollectionInterface

    /**
     * This function returns the wrapped paginator instance.
     *
     * @return mixed|null
     */
    public function getAdapter()
    {
        return $this->selectedAdapter;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        $out =  $this->getPaginatedCollection()->getResults();
        return $out;
    }

    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Collection\MetadataInterface
     */
    public function getMetadata()
    {
        return $this->getPaginatedCollection()->getMetadata();
    }

    public function setMetadata(MetadataInterface $metadata)
    {
        return $this->getPaginatedCollection()->setMetadata($metadata);
    }


    //PaginationConfigInterface
    public function setBypass($bypass)
    {
        $this->bypass = $bypass;
        return $this;
    }

    public function getBypass()
    {
        return $this->bypass;
    }

    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }
}