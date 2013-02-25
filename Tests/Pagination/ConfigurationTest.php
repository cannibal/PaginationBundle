<?php
namespace Cannibal\Bundle\PaginationBundle\Tests\Pagination;

use PHPUnit_Framework_TestCase;

use Cannibal\Bundle\PaginationBundle\Pagination\PaginationConfig;

/**
 * Created by JetBrains PhpStorm.
 * User: mv
 * Date: 02/01/13
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */
class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function getConfiguration()
    {
        return new PaginationConfig();
    }

    public function testDefaults()
    {
        $test = $this->getConfiguration();

        $this->assertNull($test->getCurrent());
        $this->assertNull($test->getItemsPerPage());
        $this->assertNull($test->getNext());
        $this->assertNull($test->getPrevious());
        $this->assertNull($test->getTotalItems());
        $this->assertNull($test->getTotalPages());
    }

    public function testSetGetters()
    {
        $test = $this->getConfiguration();
    }
}
