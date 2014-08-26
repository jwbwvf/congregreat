<?php

App::uses('Member', 'Model');
App::uses('MemberBase', 'Test/Case/Model');

class MemberPhoneTest extends MemberBase
{
    /**
     * test adding a phone number to an existing member
     * @covers Member::addPhoneNumber
     * @covers Member::isRelatedModelValid
     */
    public function testAddPhoneNumber()
    {
        $this->Member->add($this->memberAddData);
        
        $phoneData = array(
            'Member' => array('id' => $this->Member->id),
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
    public function testAddPhoneNumber_InvalidPhoneNumber()
    {
        $this->Member->add($this->memberAddData);
        
        $phoneData = array(
            'Member' => array('id' => $this->Member->id),
            'Phone' => array('number' => '5555-444-5555', 'type' => 'home')
        );
        
        $return = $this->Member->addPhoneNumber($phoneData);
        
        $this->assertFalse($return);        
    }   
    
    /**
     * test deleting a phone number for a member
     * @covers Member::deletePhoneNumber
     */
    public function testDeletePhoneNumber()
    {
        $this->Member->add($this->memberAddData);
        
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
    public function testDeletePhoneNumber_IsInUse()
    {
        $this->Member->add($this->memberAddData);                
        
        $secondMemberData = $this->memberAddData;
        $secondMemberData['Member']['name'] = 'secondName';
        
        $member = ClassRegistry::init('Member');
        $member->add($secondMemberData);
        
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
}