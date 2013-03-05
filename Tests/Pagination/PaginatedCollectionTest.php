<?php
namespace Cannibal\Bundle\PaginationBundle\Tests\Pagination;

use Cannibal\Bundle\PaginationBundle\Pagination\Paginated\AdapterBasedCollection;
use PHPUnit_Framework_TestCase;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 02/01/13
 * Time: 23:28
 * To change this template use File | Settings | File Templates.
 */
class PaginatedCollectionTest extends PHPUnit_Framework_TestCase
{
    public function createAdapterMock(array $methods = array())
    {
        return $this->getMock('Pagerfanta\\Adapter\\AdapterInterface', $methods);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject||\Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig
     */
    public function createConfigurationMock()
    {
        return $this->getMock('\\Cannibal\\Bundle\\PaginationBundle\\Pagination\\PaginationConfig');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject||\Pagerfanta\PagerfantaInterface
     */
    public function createPagerfantaMock()
    {
        return $this->getMock('Pagerfanta\\PagerfantaInterface');
    }

    public function testDefaults()
    {
        $mockPager = $this->createPagerfantaMock();
        $confMock = $this->createConfigurationMock();

        $out = new AdapterBasedCollection($mockPager, $confMock);

        $this->assertEquals($mockPager, $out->getAdapter());
        $this->assertEquals($confMock, $out->getConfiguration());
        $this->assertNull($out->getResults());
    }


}
