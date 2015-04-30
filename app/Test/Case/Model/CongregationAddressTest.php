<?php

App::uses('CongregationAddress', 'Model');
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
        'testGet'                               => 1,
        'testGet_NotFound'                      => 1,
        'testSave'                              => 1,
        'testSave_InvalidZipcode_NonNumeric'    => 1,
        'testSave_InvalidZipcode_LengthLong'    => 1,
        'testSave_InvalidZipcode_LengthShort'   => 1,
        'testSave_InvalidState'                 => 1,
        'testSave_EmptyCity'                    => 1,
        'testSave_InvalidCountry'               => 1,
        'testSave_EmptyCountry'                 => 1,
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
     * @covers CongregationAddress::get
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
     * @covers CongregationAddress::save
     */
    public function testSave()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $addressData = $this->createAddress();

        $return = $this->CongregationAddress->save($addressData);

        $this->assertNotEqual(false, $return);

        $sql  = $this->buildCongregationAddressQuery($addressData['street_address']);

        $dbo = $this->CongregationAddress->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($addressData['street_address'], $row['congregation_addresses']['street_address']);
        $this->assertEqual($addressData['city'], $row['congregation_addresses']['city']);
        $this->assertEqual($addressData['state'], $row['congregation_addresses']['state']);
        $this->assertEqual($addressData['zipcode'], $row['congregation_addresses']['zipcode']);
        $this->assertEqual($addressData['country'], $row['congregation_addresses']['country']);
        $this->assertEqual($addressData['congregation_id'], $row['congregation_addresses']['congregation_id']);
    }

    /**
     * Test getting a CongregationAddress that doesn't exist will throw an exception
     * @covers CongregationAddress::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationAddressId = TestHelper::getNonFixtureId($this->congregationAddressRecords);

        $this->CongregationAddress->get($congregationAddressId);
    }

    /**
     * @covers CongregationAddress::save
     */
    public function testSave_InvalidZipcode_NonNumeric()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('zipcode', 'AAAAA');
    }

    /**
     * @covers CongregationAddress::save
     */
    public function testSave_InvalidZipcode_LengthLong()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('zipcode', '640555');
    }

    /**
     * @covers CongregationAddress::save
     */
    public function testSave_InvalidZipcode_LengthShort()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('zipcode', '6405');
    }

    /**
     * @covers CongregationAddress::save
     */
    public function testSave_InvalidState()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('state', 'invalid');
    }

    /**
     * @covers CongregationAddress::save
     */
    public function testSave_EmptyCity()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('city', '');
    }

    /**
     * @covers CongregationAddress::save
     */
    public function testSave_InvalidCountry()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('country', 'China');
    }

    /**
     * @covers CongregationAddress::save
     */
    public function testSave_EmptyCountry()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('country', '');
    }

    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($key, $value)
    {
        $data = $this->createAddress();
        $data[$key] = $value;

        $result = $this->CongregationAddress->save($data);
        $this->assertFalse($result);
    }

    public function buildCongregationAddressQuery($streetAddress)
    {
        return "SELECT
                congregation_id, street_address, city, state, zipcode, country
                FROM congregation_addresses
                WHERE congregation_addresses.street_address = '" . $streetAddress . "'";
    }

    /**
     * helper method to create a valid address data array
     * @return array with the address properties
     */
    private function createAddress()
    {
        return array(
            'congregation_id' => 1, //id from fixture
            'street_address' => '7 e elm st',
            'city' => 'gotham city',
            'state' => 'Missouri',
            'zipcode' => '64055',
            'country' => 'United States'
        );
    }
}
