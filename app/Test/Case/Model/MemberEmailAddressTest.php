<?php

App::uses('MemberEmailAddress', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

class MemberEmailAddressTest extends CakeTestCase
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

        $this->MemberEmailAddress = ClassRegistry::init('MemberEmailAddress');

        $memberEmailAddressFixture = new MemberEmailAddressFixture();
        $this->memberEmailAddressRecords = $memberEmailAddressFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MemberEmailAddress);

        parent::tearDown();
    }

    /**
     * @covers MemberEmailAddress::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $memberEmailAddressRecord = $this->memberEmailAddressRecords[0];
        $memberEmailAddress = $this->MemberEmailAddress->get($memberEmailAddressRecord['id']);


        $this->assertEquals($memberEmailAddressRecord['id'], $memberEmailAddress['MemberEmailAddress']['id']);
        $this->assertEquals($memberEmailAddressRecord['email_address'], $memberEmailAddress['MemberEmailAddress']['email_address']);
    }

    /**
     * Test getting a MemberEmailAddress that doesn't exist will throw an exception
     * @covers MemberEmailAddress::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $memberEmailAddressId = TestHelper::getNonFixtureId($this->memberEmailAddressRecords);

        $this->MemberEmailAddress->get($memberEmailAddressId);
    }

    /**
     * @covers MemberEmailAddress::save
     */
    public function testSave()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $emailAddressData = array(
            'member_id' => 1, //id from member fixture record
            'email_address' => 'emailAddress@emails.com'
        );

        $this->MemberEmailAddress->save($emailAddressData);

        $this->assertGreaterThan(0, $this->MemberEmailAddress->id);

        $sql  = $this->buildMembersEmailAddressQuery($this->MemberEmailAddress->id);

        $dbo = $this->MemberEmailAddress->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($emailAddressData['email_address'], $row['member_email_addresses']['email_address']);
        $this->assertEqual($emailAddressData['member_id'], $row['member_email_addresses']['member_id']);
    }

    /**
     * tests adding an invalid email address to an existing member
     * @covers MemberEmailAddress::save
     */
    public function testSave_InvalidEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $emailAddressData = array(
            'member_id' => 1, //id from member fixture record
            'email_address' => 'emailAddressemails.com'
        );

        $return = $this->MemberEmailAddress->save($emailAddressData);

        $this->assertFalse($return);
    }

    /**
     * builds the query to retrieve the members
     * associated to the email address
     * @param int $emailAddressId
     * @return string
     */
    private function buildMembersEmailAddressQuery($id)
    {
        return "SELECT
                member_id,
                email_address
                FROM member_email_addresses
                WHERE id = '" . $id . "'";
    }

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.member',
        'app.member_email_address'
    );
}

