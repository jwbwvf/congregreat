<?php

App::uses('Member', 'Model');
App::uses('MemberBase', 'Test/Case/Model');

class MemberPhoneTest extends MemberBase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testAdd'                       => 1,
        'testAdd_InvalidPhoneNumber'    => 1,
        'testDelete'                    => 1,
        'testDelete_IsInUse'            => 1,
    );

    /**
     * test adding a phone number to an existing member
     * @covers Member::addPhoneNumber
     * @covers Member::isRelatedModelValid
     */
    public function testAdd()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $phoneData = array(
            'Member' => array('id' => 1), //id from member fixture record
            'Phone' => array('number' => '555-444-5555', 'type' => 'home')
        );

        $return = $this->Member->addPhoneNumber($phoneData);

        $this->assertNotEqual(false, $return);

        $sql  = $this->buildMembersPhoneNumberQuery($return['Phone']['id']);

        $dbo = $this->Member->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($phoneData['Phone']['number'], $row['phones']['number']);
        $this->assertEqual($phoneData['Phone']['type'], $row['phones']['type']);
        $this->assertEqual($phoneData['Member']['id'], $row['members']['id']);
    }

    /**
     * test adding an invalid phone number to an existing member
     * @covers Member::addPhoneNumber
     * @covers Member::isRelatedModelValid
     */
    public function testAdd_InvalidPhoneNumber()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $phoneData = array(
            'Member' => array('id' => 1), //id from member fixture record
            'Phone' => array('number' => '5555-444-5555', 'type' => 'home')
        );

        $return = $this->Member->addPhoneNumber($phoneData);

        $this->assertFalse($return);
    }

    /**
     * test deleting a phone number for a member
     * @covers Member::deletePhoneNumber
     */
    public function testDelete()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->Member->id = 1; //id from member fixture record

        $sql = "SELECT members_phones.phone_id, phones.id
                FROM members_phones
                JOIN phones ON members_phones.phone_id = phones.id
                WHERE member_id= '" . $this->Member->id . "'";

        $dbo = $this->Member->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertNotNull($row['members_phones']['phone_id']);
        $phoneId = $row['phones']['id'];
        $this->assertNotNull($phoneId);

        $this->Member->deletePhoneNumber($phoneId);

        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();

        $this->assertNull($rowAfter['members_phones']['phone_id']);
        $this->assertNull($rowAfter['phones']['id']);

        $sqlPhone = "SELECT id
                     FROM phones where phones.id= '" . $phoneId . "'";

        $dbo->rawQuery($sqlPhone);
        $rowPhone = $dbo->fetchRow();

        $this->assertNull($rowPhone['phones']['id']);
    }

    /**
     * test deleting a phone number for a member
     * that is being used by another member or member
     * the relationship should be deleted but the phone should not
     * @covers Member::deletePhoneNumber
     */
    public function testDelete_IsInUse()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $phoneData = array(
            'Member' => array('id' => 2), //id from member fixture record
            'Phone' => array('number' => '555-555-5555', 'type' => 'test') //matches existing phone from fixture record
        );

        $return = $this->Member->addPhoneNumber($phoneData);

        $this->assertNotEqual(false, $return);

        $this->Member->id = 1; //id from member fixture record

        $sql = "SELECT members_phones.phone_id, phones.id
                FROM members_phones
                JOIN phones ON members_phones.phone_id = phones.id
                WHERE member_id= '" . $this->Member->id . "'";

        $dbo = $this->Member->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertNotNull($row['members_phones']['phone_id']);
        $phoneId = $row['phones']['id'];
        $this->assertNotNull($phoneId);

        $this->Member->deletePhoneNumber($phoneId);

        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();

        $this->assertNull($rowAfter['members_phones']['phone_id']);
        $this->assertNull($rowAfter['phones']['id']);

        $sqlPhone = "SELECT id
                     FROM phones where phones.id= '" . $phoneId . "'";

        $dbo->rawQuery($sqlPhone);
        $rowPhone = $dbo->fetchRow();

        $this->assertNotNull($rowPhone['phones']['id']);
    }

    /**
     * builds the query to retrieve the member
     * associated to the phone
     * @param int $phoneId phone id
     * @return string
     */
    private function buildMembersPhoneNumberQuery($phoneId)
    {
        return "SELECT
                members.id,
                phones.number, phones.type
                FROM phones
                JOIN members_phones mp ON phones.id = mp.phone_id
                JOIN members ON mp.member_id = members.id
                WHERE phones.id = '" . $phoneId . "'";
    }

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.member',
        'app.phone',
        'app.members_phone',
        //needed because the Phone.isInUse checks for member or congregation using the phone number
        'app.congregation',
        'app.congregations_phone'
    );
}