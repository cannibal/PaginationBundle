<?php
namespace Cannibal\Bundle\PaginationBundle\Tests\Pagination\Factory;

use PHPUnit_Framework_TestCase;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Factory\PaginatedCollectionFactory;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 02/01/13
 * Time: 15:38
 * To change this template use File | Settings | File Templates.
 */
class PaginatedCollectionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Paginated\Factory\PaginatedCollectionFactory
     */
    public function getPaginatedItemsFactory()
    {
        return new PaginatedCollectionFactory();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject||\Cannibal\Bundle\PaginationBundle\Pagination\
     */
    public function createConfigurationMock()
    {
        return $this->getMock('\\Cannibal\\Bundle\\PaginationBundle\\Pagination\\Paginated\\Collection\\Metadata');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject||\Pagerfanta\PagerfantaInterface
     */
    public function createPagerfantaMock()
    {
        return $this->getMock('Pagerfanta\\PagerfantaInterface');
    }

    public function testCreatePaginatedItems()
    {
        $factory = $this->getPaginatedItemsFactory();

        $adapter = $this->createPagerfantaMock();
        $configuration = $this->createConfigurationMock();
        $out = $factory->createPagerfantaBasedCollection($adapter);

        $this->assertInstanceOf('Cannibal\\Bundle\\PaginationBundle\\Pagination\\PaginatedCollection', $out);
        $this->assertEquals($out->getAdapter(), $adapter);
        $this->assertEquals($out->getMetadata(), $configuration);
    }
}
