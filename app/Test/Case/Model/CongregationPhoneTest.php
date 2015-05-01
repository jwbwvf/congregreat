<?php

App::uses('Congregation', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

/**
 * @covers CongregationPhone
 */
class CongregationPhoneTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'                               => 1,
        'testGet_NotFound'                      => 1,
        'testSave'                              => 1,
        'testSave_MissingNumber'                => 1,
        'testSave_InvalidNumberFormat'          => 1,
        'testSave_InvalidNumber_LengthLong'     => 1,
        'testSave_InvalidNumber_LengthShort'    => 1,
        'testSave_InvalidType'                  => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_phone'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->CongregationPhone = ClassRegistry::init('CongregationPhone');

        $congregationPhoneFixture = new CongregationPhoneFixture();
        $this->congregationPhoneRecords = $congregationPhoneFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CongregationPhone);

        parent::tearDown();
    }

    /**
     * @covers CongregationPhone::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationPhoneRecord = $this->congregationPhoneRecords[0];
        $congregationPhone = $this->CongregationPhone->get($congregationPhoneRecord['id']);

        $this->assertEquals($congregationPhoneRecord['id'], $congregationPhone['CongregationPhone']['id']);
        $this->assertEquals($congregationPhoneRecord['number'], $congregationPhone['CongregationPhone']['number']);
        $this->assertEquals($congregationPhoneRecord['type'], $congregationPhone['CongregationPhone']['type']);
    }

    /**
     * @covers CongregationPhone::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationPhoneId = TestHelper::getNonFixtureId($this->congregationPhoneRecords);

        $this->CongregationPhone->get($congregationPhoneId);
    }

    /**
     * @covers CongregationPhone::save
     */
    public function testSave()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $phoneData = array(
            'congregation_id' => 1, //id from congregation fixture record
            'number' => '555-444-5555',
            'type' => 'home'
        );

        $this->CongregationPhone->save($phoneData);

        $this->assertGreaterThan(0, $this->CongregationPhone->id);

        $sql  = $this->buildCongregationsPhoneNumberQuery($this->CongregationPhone->id);

        $dbo = $this->CongregationPhone->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($phoneData['number'], $row['congregation_phones']['number']);
        $this->assertEqual($phoneData['type'], $row['congregation_phones']['type']);
        $this->assertEqual($phoneData['congregation_id'], $row['congregation_phones']['congregation_id']);
    }

    /**
     * test adding phone with a missing phone number
     * @covers CongregationPhone::save
     */
    public function testSave_MissingNumber()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '');
    }

    /**
     * test adding phone with an invalid phone number format
     * @covers CongregationPhone::save
     */
    public function testSave_InvalidNumberFormat()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '(555)-555-5555');
    }

    /**
     * test adding phone with too many digits in the phone number
     * @covers CongregationPhone::save
     */
    public function testSave_InvalidNumber_LengthLong()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '5555-555-5555');
    }

    /**
     * test adding phone with too few digits in the phone number
     * @covers CongregationPhone::save
     */
    public function testSave_InvalidNumber_LengthShort()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '555-555-555');
    }

    /**
     * test adding a phone with an invalid phone type
     * @covers CongregationPhone::save
     */
    public function testSave_InvalidType()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('type', 'invalid');
    }

    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($key, $value)
    {
        $data = $this->createPhone();
        $data[$key] = $value;

        $result = $this->CongregationPhone->save($data);
        $this->assertFalse($result);
    }

    /**
     * helper method to create a valid phone data array
     * @return array with the phone properties
     */
    private function createPhone()
    {
        return array(
            'congregation_id' => 1, //id from fixture
            'number' => '555-555-5555',
            'type' => PhoneType::home
        );
    }

    /**
     * builds the query to retrieve the congregation
     * associated to the phone
     * @param int $phoneId phone id
     * @return string
     */
    private function buildCongregationsPhoneNumberQuery($id)
    {
        return "SELECT
                congregation_id, number, type
                FROM congregation_phones
                WHERE id = '" . $id . "'";
    }
}