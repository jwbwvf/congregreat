<?php

App::uses('MemberAddress', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

class MemberAddressTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    public $tests = array(
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
        'app.member',
        'app.member_address'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->MemberAddress = ClassRegistry::init('MemberAddress');

        if (in_array(1, $this->tests, true))
        {
            $memberAddressFixture = new MemberAddressFixture();
            $this->memberAddressRecords = $memberAddressFixture->records;
        }

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MemberAddress);

        parent::tearDown();
    }

    /**
     * Test getting a MemberAddress by id will return the correct information
     * @covers MemberAddress::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $memberAddressRecord = $this->memberAddressRecords[0];
        $memberAddress = $this->MemberAddress->get($memberAddressRecord['id']);

        $this->assertEquals($memberAddressRecord['id'], $memberAddress['MemberAddress']['id']);
        $this->assertEquals($memberAddressRecord['street_address'], $memberAddress['MemberAddress']['street_address']);
        $this->assertEquals($memberAddressRecord['city'], $memberAddress['MemberAddress']['city']);
        $this->assertEquals($memberAddressRecord['state'], $memberAddress['MemberAddress']['state']);
        $this->assertEquals($memberAddressRecord['zipcode'], $memberAddress['MemberAddress']['zipcode']);
        $this->assertEquals($memberAddressRecord['country'], $memberAddress['MemberAddress']['country']);
    }

    /**
     * Test getting a MemberAddress that doesn't exist will throw an exception
     * @covers MemberAddress::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $memberAddressId = TestHelper::getNonFixtureId($this->memberAddressRecords);

        $this->MemberAddress->get($memberAddressId);
    }

    /**
     * @covers MemberAddress::save
     */
    public function testSave()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $addressData = $this->createAddress();

        $this->MemberAddress->save($addressData);

        $this->assertGreaterThan(0, $this->MemberAddress->id);

        $sql  = $this->buildMemberAddressQuery($this->MemberAddress->id);

        $dbo = $this->MemberAddress->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($addressData['street_address'], $row['member_addresses']['street_address']);
        $this->assertEqual($addressData['city'], $row['member_addresses']['city']);
        $this->assertEqual($addressData['state'], $row['member_addresses']['state']);
        $this->assertEqual($addressData['zipcode'], $row['member_addresses']['zipcode']);
        $this->assertEqual($addressData['country'], $row['member_addresses']['country']);
        $this->assertEqual($addressData['member_id'], $row['member_addresses']['member_id']);
    }

    /**
     * @covers MemberAddress::save
     */
    public function testSave_InvalidZipcode_NonNumeric()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('zipcode', 'AAAAA');
    }

    /**
     * @covers MemberAddress::save
     */
    public function testSave_InvalidZipcode_LengthLong()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('zipcode', '640555');
    }

    /**
     * @covers MemberAddress::save
     */
    public function testSave_InvalidZipcode_LengthShort()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('zipcode', '6405');
    }

    /**
     * @covers MemberAddress::save
     */
    public function testSave_InvalidState()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('state', 'invalid');
    }

    /**
     * @covers MemberAddress::save
     */
    public function testSave_EmptyCity()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('city', '');
    }

    /**
     * @covers MemberAddress::save
     */
    public function testSave_InvalidCountry()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('country', 'China');
    }

    /**
     * @covers MemberAddress::save
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

        $result = $this->MemberAddress->save($data);
        $this->assertFalse($result);
    }

    /**
     * helper method to create a valid address data array
     * @return array with the address properties
     */
    private function createAddress()
    {
        return array(
            'member_id' => 1, //id from fixture
            'street_address' => '7 e elm st',
            'city' => 'gotham city',
            'state' => 'Missouri',
            'zipcode' => '64055',
            'country' => 'United States'
        );
    }

    public function buildMemberAddressQuery($id)
    {
        return "SELECT
                member_id, street_address, city, state, zipcode, country
                FROM member_addresses
                WHERE id = '" . $id . "'";
    }
}