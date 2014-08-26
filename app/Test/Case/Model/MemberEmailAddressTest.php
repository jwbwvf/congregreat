<?php

App::uses('Member', 'Model');
App::uses('MemberBase', 'Test/Case/Model');

class MemberEmailAddressTest extends MemberBase
{
    /**
     * test adding an email address to an existing member
     * @covers Member::addEmailAddress
     * @covers Member::isRelatedModelValid
     */
    public function testAddEmailAddress()
    {
        $this->Member->add($this->memberAddData);
        
        $emailAddressData = array(
            'Member' => array('id' => $this->Member->id),
            'EmailAddress' => array('email_address' => 'emailAddress@emails.com')
        );
        
        $return = $this->Member->addEmailAddress($emailAddressData);
        
        $this->assertNotEqual(false, $return);
            
        $sql  = $this->buildMembersEmailAddressQuery($return['EmailAddress']['id']);
        
        $dbo = $this->Member->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($emailAddressData['EmailAddress']['email_address'], $row['email_addresses']['email_address']);
        $this->assertEqual($emailAddressData['Member']['id'], $row['members']['id']);        
    }    
    
    /**
     * tests adding an invalid email address to an existing member
     * @covers Member::addEmailAddress
     * @covers Member::isRelatedModelValid
     */
    public function testAddEmailAddress_InvalidEmailAddress()
    {
        $this->Member->add($this->memberAddData);
        
        $emailAddressData = array(
            'Member' => array('id' => $this->Member->id),
            'EmailAddress' => array('email_address' => 'emailAddressemails.com')
        );
        
        $return = $this->Member->addEmailAddress($emailAddressData);
        
        $this->assertFalse($return);
    }    
    
    public function testDeleteEmailAddress()
    {
        $this->Member->add($this->memberAddData);
        
        $sql = "SELECT email_addresses_members.email_address_id, email_addresses.id 
                FROM email_addresses_members
                JOIN email_addresses ON email_addresses_members.email_address_id = email_addresses.id
                WHERE member_id= '" . $this->Member->id . "'";
        
        $dbo = $this->Member->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['email_addresses_members']['email_address_id']);
        $emailAddressId = $row['email_addresses']['id'];
        $this->assertNotNull($emailAddressId);
               
        $this->Member->deleteEmailAddress($emailAddressId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['email_addresses_members']['email_address_id']);
        $this->assertNull($rowAfter['email_addresses']['id']);
        
        $sqlEmailAddress = "SELECT id 
                     FROM email_addresses where email_addresses.id= '" . $emailAddressId . "'";
        
        $dbo->rawQuery($sqlEmailAddress);
        $rowEmailAddress = $dbo->fetchRow();        
        
        $this->assertNull($rowEmailAddress['email_addresses']['id']);        
    }    
    
    public function testDeleteEmailAddress_IsInUse()
    {
        $this->Member->add($this->memberAddData);
        
        $secondMemberData = $this->memberAddData;
        $secondMemberData['Member']['name'] = 'secondName';
        
        $member = ClassRegistry::init('Member');
        $member->add($secondMemberData);
        
        $sql = "SELECT email_addresses_members.email_address_id, email_addresses.id 
                FROM email_addresses_members
                JOIN email_addresses ON email_addresses_members.email_address_id = email_addresses.id
                WHERE member_id= '" . $this->Member->id . "'";
        
        $dbo = $this->Member->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['email_addresses_members']['email_address_id']);
        $emailAddressId = $row['email_addresses']['id'];
        $this->assertNotNull($emailAddressId);

        $this->Member->deleteEmailAddress($emailAddressId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['email_addresses_members']['email_address_id']);
        $this->assertNull($rowAfter['email_addresses']['id']);
        
        $sqlEmailAddress = "SELECT id 
                     FROM email_addresses where email_addresses.id= '" . $emailAddressId . "'";
        
        $dbo->rawQuery($sqlEmailAddress);
        $rowEmailAddress = $dbo->fetchRow();        
        
        $this->assertNotNull($rowEmailAddress['email_addresses']['id']);         
    }     
    
    /**
     * builds the query to retrieve the members
     * associated to the email address
     * @param int $emailAddressId
     * @return string
     */
    private function buildMembersEmailAddressQuery($emailAddressId)
    {
        return "SELECT 
                members.id, 
                email_addresses.email_address
                FROM email_addresses
                JOIN email_addresses_members eam ON email_addresses.id = eam.email_address_id
                JOIN members ON eam.member_id = members.id
                WHERE email_addresses.id = '" . $emailAddressId . "'";        
    }     
}

