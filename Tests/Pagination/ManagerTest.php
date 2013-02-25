<?php
namespace Cannibal\Bundle\PaginationBundle\Tests\Pagination\Factory;

use PHPUnit_Framework_TestCase;

use Cannibal\Bundle\PaginationBundle\Pagination\Manager;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 02/01/13
 * Time: 18:20
 * To change this template use File | Settings | File Templates.
 */
class ManagerTest extends PHPUnit_Framework_TestCase
{
    public function getPaginatedItemsFactoryMock()
    {
        return $this->getMock('Cannibal\\Bundle\\PaginationBundle\\Pagination\\Factory\\PaginatedItemsFactory');
    }

    public function getManager($factoryMock)
    {
        return new Manager($factoryMock);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject||\Cannibal\Bundle\PaginationBundle\Pagination\Manager
     */
    public function getManagerMock($factory, $methods = array())
    {
        return $this->getMock('Cannibal\\Bundle\\PaginationBundle\\Pagination\\Manager', $methods, array($factory));
    }

    public function createAdapterMock(array $methods = array())
    {
        return $this->getMock('Pagerfanta\\Adapter\\AdapterInterface', $methods);
    }

    public function createQueryBuilderMock(array $methods = array())
    {
        return $this->getMock('Doctrine\\ORM\\QueryBuilder', $methods,  array(), '', false);
    }

    public function createCollectionMock(array $methods = array())
    {
        return $this->getMock('Doctrine\\Common\\Collections\\Collection', $methods, array(), '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject||\Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig
     */
    public function createConfigurationMock()
    {
        return $this->getMock('\\Cannibal\\Bundle\\PaginationBundle\\Pagination\\PaginationConfig');
    }

    public function testDefaults()
    {
        $factory = $this->getPaginatedItemsFactoryMock();
        $test = $this->getManager($factory);

        $this->assertEquals($factory, $test->getPaginatedItemsFactory());
    }

    public function testPaginateQuery()
    {
        $factory = $this->getPaginatedItemsFactoryMock();
        $test = $this->getManager($factory);

        $qb = $this->createQueryBuilderMock(array('getQuery'));
        $qb->expects($this->any())->method('getQuery')->will($this->returnValue('test'));

        $this->assertInstanceOf('Pagerfanta\\Adapter\\DoctrineORMAdapter', $test->paginateQuery($qb));
    }

    public function testPaginateCollection()
    {
        $factory = $this->getPaginatedItemsFactoryMock();
        $test = $this->getManager($factory);

        $collection = $this->createCollectionMock();

        $this->assertInstanceOf('Pagerfanta\\Adapter\\DoctrineCollectionAdapter', $test->paginateCollection($collection));
    }

    public function testPaginateArray()
    {
        $factory = $this->getPaginatedItemsFactoryMock();
        $test = $this->getManager($factory);

        $collection = array(new \stdClass());

        $this->assertInstanceOf('Pagerfanta\\Adapter\\ArrayAdapter', $test->paginateArray($collection));
    }

    public function testSelectAdapter()
    {
        $factory = $this->getPaginatedItemsFactoryMock();
        $test = $this->getManager($factory);

        $qb = $this->createQueryBuilderMock();
        $collection = $this->createCollectionMock();
        $array = array(new \stdClass());

        $adapter = $test->selectAdapter($qb);
        $this->assertInstanceOf('Pagerfanta\\Adapter\\DoctrineORMAdapter', $adapter);

        $adapter = $test->selectAdapter($collection);
        $this->assertInstanceOf('Pagerfanta\\Adapter\\DoctrineCollectionAdapter', $adapter);

        $adapter = $test->selectAdapter($array);
        $this->assertInstanceOf('Pagerfanta\\Adapter\\ArrayAdapter', $adapter);
    }

    public function testPaginate()
    {
        $factory = $this->getPaginatedItemsFactoryMock();
        $test = $this->getManagerMock($factory, array('selectAdapter', 'paginateItems'));

        $testAdapter = $this->createAdapterMock();

        $config = $this->createConfigurationMock();

        $test->expects($this->once())->method('selectAdapter')->with($testAdapter)->will($this->returnValue($testAdapter));
        $test->expects($this->once())->method('paginateItems')->with($testAdapter, $config)->will($this->returnValue(true));


        $test->paginate($testAdapter, $config);
    }
}
