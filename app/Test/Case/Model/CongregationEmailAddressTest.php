<?php

App::uses('Congregation', 'Model');
App::uses('CongregationEmailAddressFixuture', 'Fixture');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

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

    protected $skipTestEvaluator;


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
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationEmailAddressId = TestHelper::getNonFixtureId($this->congregationEmailAddressRecords);

        $this->CongregationEmailAddress->get($congregationEmailAddressId);
    }

    /**
     * test adding an email address to an existing congregation
     */
    public function testSave()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationId = 1; //id from congregation fixture record
        $emailAddress = 'emailAddress@emails.com';
        $emailAddressData = array(
            'CongregationEmailAddress' => array('congregation_id' => $congregationId, 'email_address' => $emailAddress)
        );

        $this->CongregationEmailAddress->save($emailAddressData);

        $this->assertGreaterThan(0, $this->CongregationEmailAddress->id);

        $sql  = $this->buildCongregationsEmailAddressQuery($emailAddress);

        $dbo = $this->CongregationEmailAddress->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($emailAddress, $row['congregation_email_addresses']['email_address']);
        $this->assertEqual($congregationId, $row['congregation_email_addresses']['congregation_id']);
    }

    /**
     * tests adding an invalid email address to an existing congregation
     */
    public function testSave_InvalidEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationId = 1; //id from congregation fixture record
        $invalidEmailAddress = 'emailAddressemails.com';
        $emailAddressData = array(
            'CongregationEmailAddress' => array('congregation_id' => $congregationId, 'email_address' => $invalidEmailAddress)
        );

        $return = $this->CongregationEmailAddress->save($emailAddressData);

        $this->assertFalse($return);
    }

    /**
     * builds the query to retrieve the congregations
     * associated to the email address
     * @param int $emailAddressId
     * @return string
     */
    private function buildCongregationsEmailAddressQuery($emailAddress)
    {
        return "SELECT
                congregation_id, email_address
                FROM congregation_email_addresses
                WHERE congregation_email_addresses.email_address = '" . $emailAddress . "'";
    }

     /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_email_address'
    );
}