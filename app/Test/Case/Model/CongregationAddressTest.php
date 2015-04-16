<?php

App::uses('CongregationAddress', 'Model');
App::uses('CongregationAddressFixture', 'Fixture');
App::uses('SkipTestEvaluator', 'Test/Lib');

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
        $this->congregationAddresses = $congregationAddressFixture->records;

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

        $congregationAddressId = $this->congregationAddresses[0]['id'];
        $congregationAddress = $this->CongregationAddress->get($congregationAddressId);

        $this->assertEquals($this->congregationAddresses[0]['id'], $congregationAddress['CongregationAddress']['id']);
        $this->assertEquals($this->congregationAddresses[0]['street_address'], $congregationAddress['CongregationAddress']['street_address']);
        $this->assertEquals($this->congregationAddresses[0]['city'], $congregationAddress['CongregationAddress']['city']);
        $this->assertEquals($this->congregationAddresses[0]['state'], $congregationAddress['CongregationAddress']['state']);
        $this->assertEquals($this->congregationAddresses[0]['zipcode'], $congregationAddress['CongregationAddress']['zipcode']);
        $this->assertEquals($this->congregationAddresses[0]['country'], $congregationAddress['CongregationAddress']['country']);
    }

    /**
     * Test getting a CongregationAddress that doesn't exist will throw an exception
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationAddressId = $this->getNonFixtureId();

        $this->CongregationAddress->get($congregationAddressId);
    }

    /**
     * Finds an id that will not exist in the database at the start of a test
     * @return int
     */
    public function getNonFixtureId()
    {
        $congregationAddressIds = array();

        foreach($this->congregationAddresses as $congregationAddress)
        {
            $congregationAddressIds[] = $congregationAddress['id'];
        }

        for($count = 1; $count < count($congregationAddressIds); $count++)
        {
            if(!in_array($count, $congregationAddressIds)) {return $count;}
        }
    }
}
