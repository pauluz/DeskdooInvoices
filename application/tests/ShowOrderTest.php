<?php
/**
 * pZ:
 *
 * phpunit application/tests/ShowOrderTest.php
 *
 * http://phpunit.de/manual/current/en/fixtures.html
 *
 * order:
 * - setUpBeforeClass() - run App - create clean database and add FIXTURES
 * - setUp()            - additinal data to DB (append)
 * - --> testOne()
 * - tearDown()         - nothing
 * - .setUp()           - copy clean DB and add data (append)
 * - --> testTwo()
 * - tearDown()
 * - tearDownAfterClass() - unlinkg DB file
 *
 * S - Skipped
 * F - Failed
 * I - Incomplete
 */

class ShowOrderTest extends \PHPUnit_Framework_TestCase 
{
    // pZ: must be static
    public static function setUpBeforeClass()
    {
        print(__FUNCTION__ . "()\n");
    }

    protected function setUp()
    {
        print(__FUNCTION__ . "()\n");
    }

    protected function tearDown()
    {
        print(__FUNCTION__ . "()\n");
    }

    // pZ: must be static
    public static function tearDownAfterClass()
    {
        print(__FUNCTION__ . "()\n");
    }

    public function testOne()
    {
        echo "--> testOne()\n";
        $this->assertTrue(true);
        $this->assertFalse(false);
    }

    public function testTwo()
    {
        echo "--> testTwo()\n";
//        $this->markTestIncomplete('Test Incomplete.');
//        $this->markTestSkipped('Test Skipped');
//        $this->fail('Test fail');
        $this->assertTrue(true);
        $this->assertFalse(false);
    }
}
