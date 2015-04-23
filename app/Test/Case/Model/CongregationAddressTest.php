<?php

App::uses('CongregationAddress', 'Model');
App::uses('CongregationAddressFixture', 'Fixture');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

/**
 * @covers CongregationAddress
 */
class CongregationAddressTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'           => 1,
        'testGet_NotFound'  => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_address'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->CongregationAddress = ClassRegistry::init('CongregationAddress');

        $congregationAddressFixture = new CongregationAddressFixture();
        $this->congregationAddressRecords = $congregationAddressFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CongregationAddress);

        parent::tearDown();
    }

    /**
     * Test getting a CongreationAddress by id will return the correct information
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationAddressRecord = $this->congregationAddressRecords[0];
        $congregationAddress = $this->CongregationAddress->get($congregationAddressRecord['id']);

        $this->assertEquals($congregationAddressRecord['id'], $congregationAddress['CongregationAddress']['id']);
        $this->assertEquals($congregationAddressRecord['street_address'], $congregationAddress['CongregationAddress']['street_address']);
        $this->assertEquals($congregationAddressRecord['city'], $congregationAddress['CongregationAddress']['city']);
        $this->assertEquals($congregationAddressRecord['state'], $congregationAddress['CongregationAddress']['state']);
        $this->assertEquals($congregationAddressRecord['zipcode'], $congregationAddress['CongregationAddress']['zipcode']);
        $this->assertEquals($congregationAddressRecord['country'], $congregationAddress['CongregationAddress']['country']);
    }

    /**
     * Test getting a CongregationAddress that doesn't exist will throw an exception
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationAddressId = TestHelper::getNonFixtureId($this->congregationAddressRecords);

        $this->CongregationAddress->get($congregationAddressId);
    }
}
