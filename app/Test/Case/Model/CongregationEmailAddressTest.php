<?php

App::uses('Congregation', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

/**
 * @covers CongregationEmailAddress
 */
class CongregationEmailAddressTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'                       => 1,
        'testGet_NotFound'              => 1,
        'testSave'                      => 1,
        'testSave_InvalidEmailAddress'  => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_email_address'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->CongregationEmailAddress = ClassRegistry::init('CongregationEmailAddress');

        $congregationEmailAddressFixture = new CongregationEmailAddressFixture();
        $this->congregationEmailAddressRecords = $congregationEmailAddressFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CongregationEmailAddress);

        parent::tearDown();
    }

    /**
     * @covers CongregationEmailAddress::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationEmailAddressRecord = $this->congregationEmailAddressRecords[0];
        $congregationEmailAddress = $this->CongregationEmailAddress->get($congregationEmailAddressRecord['id']);


        $this->assertEquals($congregationEmailAddressRecord['id'], $congregationEmailAddress['CongregationEmailAddress']['id']);
        $this->assertEquals($congregationEmailAddressRecord['email_address'], $congregationEmailAddress['CongregationEmailAddress']['email_address']);
    }

    /**
     * Test getting a CongregationEmailAddress that doesn't exist will throw an exception
     * @covers CongregationEmailAddress::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationEmailAddressId = TestHelper::getNonFixtureId($this->congregationEmailAddressRecords);

        $this->CongregationEmailAddress->get($congregationEmailAddressId);
    }

    /**
     * @covers CongregationEmailAddress::save
     */
    public function testSave()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $emailAddressData = array(
                'congregation_id' => 1, //id from congregation fixture record
                'email_address' => 'emailAddress@emails.com'
        );

        $this->CongregationEmailAddress->save($emailAddressData);

        $this->assertGreaterThan(0, $this->CongregationEmailAddress->id);

        $sql  = $this->buildCongregationsEmailAddressQuery($this->CongregationEmailAddress->id);

        $dbo = $this->CongregationEmailAddress->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($emailAddressData['email_address'], $row['congregation_email_addresses']['email_address']);
        $this->assertEqual($emailAddressData['congregation_id'], $row['congregation_email_addresses']['congregation_id']);
    }

    /**
     * @covers CongregationEmailAddress::save
     */
    public function testSave_InvalidEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $emailAddressData = array(
            'congregation_id' => 1, //id from congregation fixture record
            'email_address' => 'emailAddressemails.com'
        );

        $return = $this->CongregationEmailAddress->save($emailAddressData);

        $this->assertFalse($return);
    }

    /**
     * builds a query to get fields for CongregationEmailAddress to verify save
     * @param int $congregationEmailAddressId
     * @return string
     */
    private function buildCongregationsEmailAddressQuery($congregationEmailAddressId)
    {
        return "SELECT
                congregation_id, email_address
                FROM congregation_email_addresses
                WHERE congregation_email_addresses.id = '" . $congregationEmailAddressId . "'";
    }
}