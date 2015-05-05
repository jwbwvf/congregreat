<?php

App::uses('Member', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

/**
 * @covers Member
 *
 */
class MemberTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'                           => 1,
        'testGet_NotFound'                  => 1,
        'testAdd'                           => 1,
        'testAdd_MissingCongregationId'     => 1,
        'testAdd_MissingFirstName'          => 1,
        'testAdd_MissingLastName'           => 1,
        'testAdd_InvalidEmail'              => 1,
        'testAdd_InvalidAddress'            => 1,
        'testAdd_InvalidPhoneNumber'        => 1,
        'testDelete'                        => 1,
        'testDelete_ExistingAssociations'   => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.member',
        'app.congregation',
        'app.anniversary',
        'app.member_address',
        'app.member_email_address',
        'app.member_phone',
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Member = ClassRegistry::init('Member');

        $memberFixture = new MemberFixture();
        $this->memberRecords = $memberFixture->records;

        $congregationFixture = new CongregationFixture();
        $this->congregationRecords = $congregationFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Member);

        parent::tearDown();
    }

    /**
     * @covers Member::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $memberRecord = $this->memberRecords[0];
        $congregationRecord = $this->congregationRecords[0];
        $this->assertEquals($memberRecord['congregation_id'], $congregationRecord['id']);

        $member = $this->Member->get($memberRecord['id']);

        $this->assertEquals($memberRecord['id'], $member['Member']['id']);
        $this->assertEquals($memberRecord['first_name'], $member['Member']['first_name']);
        $this->assertEquals($memberRecord['last_name'], $member['Member']['last_name']);
        $this->assertEquals($memberRecord['middle_name'], $member['Member']['middle_name']);
        $this->assertEquals($memberRecord['profile_picture'], $member['Member']['profile_picture']);
        $this->assertEquals($memberRecord['baptized'], $member['Member']['baptized']);
        $this->assertEquals($memberRecord['congregation_id'], $member['Congregation']['id']);
        $this->assertEquals($congregationRecord['name'], $member['Congregation']['name']);
    }

    /**
     * @covers Member::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $memberId = TestHelper::getNonFixtureId($this->memberRecords);

        $this->Member->get($memberId);
    }

    /**
     * test adding a member with all it's related data: phone, email, address
     * @covers Member::add
     */
    public function testAdd()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->Member->add($this->memberAddData);

        $this->assertGreaterThan(0, $this->Member->id);

        $dbo = $this->Member->getDataSource();
        $sql = $this->buildMembersAddDataQuery($this->Member->id);
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($this->memberAddData['Member']['congregation_id'], $row['members']['congregation_id']);
        $this->assertEqual($this->memberAddData['Member']['first_name'], $row['members']['first_name']);
        $this->assertEqual($this->memberAddData['Member']['last_name'], $row['members']['last_name']);
        $this->assertEqual($this->memberAddData['Member']['middle_name'], $row['members']['middle_name']);
        $this->assertEqual($this->memberAddData['Member']['gender'], $row['members']['gender']);
        $this->assertEqual($this->memberAddData['Member']['birth_date'], $row['members']['birth_date']);
        $this->assertEqual($this->memberAddData['Member']['baptized'], $row['members']['baptized']);
        $this->assertEqual($this->memberAddData['Member']['profile_picture'], $row['members']['profile_picture']);
        $this->assertEqual($this->memberAddData['Member']['anniversary_id'], $row['members']['anniversary_id']);
        $this->assertEqual($this->memberAddData['MemberEmailAddress']['email_address'], $row['member_email_addresses']['email_address']);
        $this->assertEqual($this->memberAddData['MemberPhone']['number'], $row['member_phones']['number']);
        $this->assertEqual($this->memberAddData['MemberPhone']['type'], $row['member_phones']['type']);
        $this->assertEqual($this->memberAddData['MemberAddress']['street_address'], $row['member_addresses']['street_address']);
        $this->assertEqual($this->memberAddData['MemberAddress']['city'], $row['member_addresses']['city']);
        $this->assertEqual($this->memberAddData['MemberAddress']['state'], $row['member_addresses']['state']);
        $this->assertEqual($this->memberAddData['MemberAddress']['zipcode'], $row['member_addresses']['zipcode']);
        $this->assertEqual($this->memberAddData['MemberAddress']['country'], $row['member_addresses']['country']);
    }

    /**
     * @covers Member::add
     */
    public function testAdd_MissingCongregationId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('Member', 'congregation_id', '');
    }

    /**
     * @covers Member::add
     */
    public function testAdd_MissingFirstName()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('Member', 'first_name', '');
    }

    public function testAdd_MissingLastName()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('Member', 'last_name', '');
    }

    /**
     * test adding a member that has an invalid email address
     * @covers Member::add
     */
    public function testAdd_InvalidEmail()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('MemberEmailAddress', 'email_address', 'invalidEmail@nowhere');
    }

    /**
     * test adding a member that has an invalid address
     * @covers Member::add
     */
    public function testAdd_InvalidAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('MemberAddress', 'zipcode', '6405A');
    }

    /**
     * test adding a member that has an invalid phone number
     * @covers Member::add
     */
    public function testAdd_InvalidPhoneNumber()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('MemberPhone', 'number', '5555-555-5555');
    }

    /**
     * test deleting a member and all it's
     * associated models
     * @covers Member::delete
     */
    public function testDelete()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->Member->add($this->memberAddData);

        $this->assertGreaterThan(0, $this->Member->id);

        $dbo = $this->Member->getDataSource();
        $sql = $this->buildMembersAddDataQuery($this->Member->id);
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->Member->delete($row['members']['id']);

        $sqlAfterDeleteMember = "SELECT * FROM members WHERE id='" . $row['members']['id'] . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM member_addresses WHERE id='" . $row['member_addresses']['id'] . "'";
        $sqlAfterDeletePhone = "SELECT * FROM member_phones WHERE id='" . $row['member_phones']['id'] . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM member_email_addresses WHERE id='" . $row['member_email_addresses']['id'] . "'";

        $dbo->rawQuery($sqlAfterDeleteMember);
        $rowAfterDeleteMember = $dbo->fetchRow();
        $this->assertFalse($rowAfterDeleteMember);

        $dbo->rawQuery($sqlAfterDeleteAddress);
        $rowAfterDeleteAddress = $dbo->fetchRow();
        $this->assertFalse($rowAfterDeleteAddress);

        $dbo->rawQuery($sqlAfterDeletePhone);
        $rowAfterDeletePhone = $dbo->fetchRow();
        $this->assertFalse($rowAfterDeletePhone);

        $dbo->rawQuery($sqlAfterDeleteEmailAddress);
        $rowAfterDeleteEmailAddress = $dbo->fetchRow();
        $this->assertFalse($rowAfterDeleteEmailAddress);
    }

//    public function testStoreProfilePicture()
//    {
//	$data['Member'] = array('profile_picture' => array(
//		'name' => 'test.jpg',
//		'type' => 'image/jpeg',
//		'tmp_name' => '../../Test/client/img/test.jpg',
//		'error' => 0,
//		'size' => 19385
//            )
//        );

//        $return = $this->Member->storeProfilePicture($data);
//        if (is_uploaded_file($data['Member']['profile_picture']['tmp_name']))
//        {
//            move_uploaded_file($data['Member']['profile_picture']['tmp_name'],
//                    '../webroot/img/members/' . $data['Member']['profile_picture']['name']);
//
//            return $data['Member']['profile_picture']['name'];
//        }
//
//        return "";
//    }

//    public function testStoreProfilePicture_NoFile()
//    {
//
//    }

    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($model, $key, $value)
    {
        $data = $this->memberAddData;
        $data[$model][$key] = $value;

        if($this->Member->add($data))
        {
            //returns the validation rule data
            $validationMessage = $this->Member->$model->validate[$key]['message'];
            //returns any validation errors that occurred on save
            $validationErrors = $this->Member->$model->validationErrors;
        }
        else
        {
            //returns the validation rule data
            $validationMessage = $this->Member->validate[$key]['message'];
            //returns any validation errors that occurred on save
            $validationErrors = $this->Member->validationErrors;
        }
        $this->assertEquals($validationErrors[$key][0], $validationMessage);
    }

    /**
     * builds the query to retrieve the member and all it's associated data from an add
     * @return string
     */
    private function buildMembersAddDataQuery($memberId)
    {
        return "SELECT
            members.id, members.congregation_id, members.first_name, members.last_name, members.middle_name,
            members.gender, members.birth_date, members.baptized, members.profile_picture, members.anniversary_id,
            member_addresses.street_address, member_addresses.city, member_addresses.state, member_addresses.zipcode,
            member_addresses.country, member_addresses.id,
            member_email_addresses.email_address, member_email_addresses.id,
            member_phones.number, member_phones.type, member_phones.id
            FROM members
            JOIN member_addresses ON members.id = member_addresses.member_id
            JOIN member_phones ON members.id = member_phones.member_id
            JOIN member_email_addresses ON members.id = member_email_addresses.member_id
            WHERE members.id = '" . $memberId . "'";
    }

    public $memberAddData = array(
        'Member' => array(
            'congregation_id' => '1',
            'first_name' => 'testFirstName',
            'last_name' => 'testLastName',
            'middle_name' => 'testMiddleName',
            'gender' => 'Male',
            'birth_date' => '1980-06-01',
            'baptized' => '1',
            'profile_picture' => 'testFirstName testLastName.jpg',
            'anniversary_id' => '1'
        ),
        'MemberEmailAddress' => array(
            'email_address' => 'test@test.com'
        ),
        'MemberPhone' => array(
            'number' => '555-555-5555',
            'type' => 'home'
        ),
        'MemberAddress' => array(
            'street_address' => '123 elm st.',
            'city' => 'kc',
            'state' => 'Missouri',
            'zipcode' => '66066',
            'country' => 'United States'
        )
    );
}
