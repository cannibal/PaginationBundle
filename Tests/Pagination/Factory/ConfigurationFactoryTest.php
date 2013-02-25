<?php
namespace Cannibal\Bundle\PaginationBundle\Tests\Pagination\Factory;

use PHPUnit_Framework_TestCase;

use Cannibal\Bundle\PaginationBundle\Pagination\Factory\PaginationConfigFactory;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 02/01/13
 * Time: 15:38
 * To change this template use File | Settings | File Templates.
 */
class ConfigurationFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return \Cannibal\Bundle\PaginationBundle\Pagination\Factory\PaginationConfigurationFactory
     */
    public function getPaginationConfigFactory()
    {
        return new PaginationConfigFactory();
    }

    public function testCreatePaginationConfiguration()
    {
        $factory = $this->getPaginationConfigFactory();

        $out = $factory->createPaginationConfiguration(2, 20);

        $this->assertInstanceOf('Cannibal\\Bundle\\PaginationBundle\\Pagination\\PaginationConfigInterface', $out);
        $this->assertEquals($out->getCurrent(), 2);
        $this->assertEquals($out->getItemsPerPage(), 20);
    }
}
