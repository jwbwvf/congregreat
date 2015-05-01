<?php

App::uses('Member', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');

/**
 * Member Test Case
 *
 */
class MemberTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
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
     * test adding a member with all it's related data: phone, email, address
     *
     */
    public function testAdd()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $return = $this->Member->add($this->memberAddData);
        $this->assertTrue($return);

        $dbo = $this->Member->getDataSource();
        $sql = $this->buildMembersAddDataQuery();
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
        $this->assertEqual($this->memberAddData['EmailAddress']['email_address'], $row['email_addresses']['email_address']);
        $this->assertEqual($this->memberAddData['Phone']['number'], $row['phones']['number']);
        $this->assertEqual($this->memberAddData['Phone']['type'], $row['phones']['type']);
        $this->assertEqual($this->memberAddData['Address']['street_address'], $row['addresses']['street_address']);
        $this->assertEqual($this->memberAddData['Address']['city'], $row['addresses']['city']);
        $this->assertEqual($this->memberAddData['Address']['state'], $row['addresses']['state']);
        $this->assertEqual($this->memberAddData['Address']['zipcode'], $row['addresses']['zipcode']);
        $this->assertEqual($this->memberAddData['Address']['country'], $row['addresses']['country']);
    }

    public function testAdd_MissingCongregationId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('Member', 'congregation_id', '');
    }

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
     * @covers Member::createModels
     * @covers Member::areModelsValid
     */
    public function testAdd_InvalidEmail()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('EmailAddress', 'email_address', 'invalidEmail@nowhere');
    }

    /**
     * test adding a member that has an invalid address
     * @covers Member::add
     * @covers Member::createModels
     * @covers Member::areModelsValid
     */
    public function testAdd_InvalidAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('Address', 'zipcode', '6405A');
    }

    /**
     * test adding a member that has an invalid phone number
     * @covers Member::add
     * @covers Member::createModels
     * @covers Member::areModelsValid
     */
    public function testAdd_InvalidPhoneNumber()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('Phone', 'number', '5555-555-5555');
    }

    /**
     * test deleting a member and all it's
     * associated models
     * @covers Member::delete
     * @covers Member::deleteAddress
     * @covers Member::deleteEmailAddress
     * @covers Member::deletePhoneNumber
     * @covers Member::deleteModel
     */
    public function testDelete()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->Member->add($this->memberAddData);

        $dbo = $this->Member->getDataSource();
        $sql = $this->buildMembersAddDataQuery();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->Member->delete($row['members']['id']);

        $sqlAfterDeleteMember = "SELECT * FROM members WHERE id='" . $row['members']['id'] . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM addresses WHERE id='" . $row['addresses']['id'] . "'";
        $sqlAfterDeletePhone = "SELECT * FROM phones WHERE id='" . $row['phones']['id'] . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM email_addresses WHERE id='" . $row['email_addresses']['id'] . "'";

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

    /**
     * test deleting a member that has the same
     * address, email address, phone number associated
     * to another member
     * @covers Member::delete
     * @covers Member::deleteAddress
     * @covers Member::deleteEmailAddress
     * @covers Member::deletePhoneNumber
     * @covers Member::deleteModel
     */
    public function testDelete_ExistingAssociations()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $return = $this->Member->add($this->memberAddData);
        $this->assertTrue($return);

        $secondMemberData = $this->memberAddData;
        $secondMemberData['Member']['name'] = 'secondName';

        $member = ClassRegistry::init('Member');
        $member->add($secondMemberData);

        $dbo = $this->Member->getDataSource();
        $sql = $this->buildMembersAddDataQuery();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->Member->delete($row['members']['id']);

        $sqlAfterDeleteMember = "SELECT * FROM members WHERE id='" . $row['members']['id'] . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM addresses WHERE id='" . $row['addresses']['id'] . "'";
        $sqlAfterDeletePhone = "SELECT * FROM phones WHERE id='" . $row['phones']['id'] . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM email_addresses WHERE id='" . $row['email_addresses']['id'] . "'";

        $dbo->rawQuery($sqlAfterDeleteMember);
        $rowAfterDeleteMember = $dbo->fetchRow();
        $this->assertFalse($rowAfterDeleteMember);

        $dbo->rawQuery($sqlAfterDeleteAddress);
        $rowAfterDeleteAddress = $dbo->fetchRow();
        $this->assertEquals($rowAfterDeleteAddress['addresses']['id'], $row['addresses']['id']);

        $dbo->rawQuery($sqlAfterDeletePhone);
        $rowAfterDeletePhone = $dbo->fetchRow();
        $this->assertEquals($rowAfterDeletePhone['phones']['id'], $row['phones']['id']);

        $dbo->rawQuery($sqlAfterDeleteEmailAddress);
        $rowAfterDeleteEmailAddress = $dbo->fetchRow();
        $this->assertEquals($rowAfterDeleteEmailAddress['email_addresses']['id'], $row['email_addresses']['id']);
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
    private function buildMembersAddDataQuery()
    {
        return "SELECT
            members.id, members.congregation_id, members.first_name, members.last_name, members.middle_name,
            members.gender, members.birth_date, members.baptized, members.profile_picture, members.anniversary_id,
            addresses.street_address, addresses.city, addresses.state, addresses.zipcode, addresses.country, addresses.id,
            email_addresses.email_address, email_addresses.id,
            phones.number, phones.type, phones.id
            FROM members
            JOIN addresses_members am ON members.id = am.member_id
            JOIN members_phones mp ON members.id = mp.member_id
            JOIN email_addresses_members eam ON members.id = eam.member_id
            JOIN addresses ON am.address_id = addresses.id
            JOIN email_addresses ON eam.email_address_id = email_addresses.id
            JOIN phones ON mp.phone_id = phones.id
            WHERE members.first_name = 'testFirstName'";
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
        'EmailAddress' => array(
            'email_address' => 'test@test.com'
        ),
        'Phone' => array(
            'number' => '555-555-5555',
            'type' => 'home'
        ),
        'Address' => array(
            'street_address' => '123 elm st.',
            'city' => 'kc',
            'state' => 'Missouri',
            'zipcode' => '66066',
            'country' => 'United States'
        )
    );
}
