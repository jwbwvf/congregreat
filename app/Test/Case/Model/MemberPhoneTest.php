<?php

App::uses('MemberPhone', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

class MemberPhoneTest extends CakeTestCase
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
        'app.member',
        'app.member_phone'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->MemberPhone = ClassRegistry::init('MemberPhone');

        $memberPhoneFixture = new MemberPhoneFixture();
        $this->memberPhoneRecords = $memberPhoneFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MemberPhone);

        parent::tearDown();
    }

    /**
     * @covers MemberPhone::save
     */
    public function testSave()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $phoneData = array(
            'member_id' => 1, //id from member fixture record
            'number' => '555-444-5555',
            'type' => 'home'
        );

        $this->MemberPhone->save($phoneData);

        $this->assertGreaterThan(0, $this->MemberPhone->id);

        $sql  = $this->buildMembersPhoneNumberQuery($this->MemberPhone->id);

        $dbo = $this->MemberPhone->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($phoneData['number'], $row['member_phones']['number']);
        $this->assertEqual($phoneData['type'], $row['member_phones']['type']);
        $this->assertEqual($phoneData['member_id'], $row['member_phones']['member_id']);
    }

    /**
     * test adding phone with a missing phone number
     * @covers MemberPhone::save
     */
    public function testSave_MissingNumber()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '');
    }

    /**
     * test adding phone with an invalid phone number format
     * @covers MemberPhone::save
     */
    public function testSave_InvalidNumberFormat()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '(555)-555-5555');
    }

    /**
     * test adding phone with too many digits in the phone number
     * @covers MemberPhone::save
     */
    public function testSave_InvalidNumber_LengthLong()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '5555-555-5555');
    }

    /**
     * test adding phone with too few digits in the phone number
     * @covers MemberPhone::save
     */
    public function testSave_InvalidNumber_LengthShort()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('number', '555-555-555');
    }

    /**
     * test adding a phone with an invalid phone type
     * @covers MemberPhone::save
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

        $result = $this->MemberPhone->save($data);
        $this->assertFalse($result);
    }

    /**
     * helper method to create a valid phone data array
     * @return array with the phone properties
     */
    private function createPhone()
    {
        return array(
            'member_id' => 1, //id from fixture
            'number' => '555-555-5555',
            'type' => PhoneType::home
        );
    }

    /**
     * builds the query to retrieve the member
     * associated to the phone
     * @param int $phoneId phone id
     * @return string
     */
    private function buildMembersPhoneNumberQuery($id)
    {
        return "SELECT
                member_id, number, type
                FROM member_phones
                WHERE id = '" . $id . "'";
    }
}