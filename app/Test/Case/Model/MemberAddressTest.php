<?php

App::uses('Member', 'Model');
App::uses('MemberBase', 'Test/Case/Model');

class MemberAddressTest extends MemberBase
{
   public function testAddAddress()
    {        
        $this->Member->add($this->memberAddData);
        
        $addressData = array(
            'Member' => array('id' => $this->Member->id),
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'Florida',
                'zipcode' => '66000',
                'country' => 'United States'
            )
        );
        
        $return = $this->Member->addAddress($addressData);
        
        $this->assertNotEqual(false, $return);
        
        $sql  = $this->buildMembersAddressQuery($return['Address']['id']);
        
        $dbo = $this->Member->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($addressData['Address']['street_address'], $row['addresses']['street_address']);
        $this->assertEqual($addressData['Address']['city'], $row['addresses']['city']);
        $this->assertEqual($addressData['Address']['state'], $row['addresses']['state']);
        $this->assertEqual($addressData['Address']['zipcode'], $row['addresses']['zipcode']);
        $this->assertEqual($addressData['Address']['country'], $row['addresses']['country']);
        $this->assertEqual($addressData['Member']['id'], $row['members']['id']);        
    }
    
    public function testAddAddress_InvalidState()
    {
        $this->Member->add($this->memberAddData);
        
        $addressData = array(
            'Member' => array('id' => $this->Member->id),
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'invalid',
                'zipcode' => '66000',
                'country' => 'United States'
            )
        );
        
        $return = $this->Member->addAddress($addressData);
        
        $this->assertEqual(false, $return);        
    }
    
    public function testAddAddress_InvalidZipcode()
    {
        $this->Member->add($this->memberAddData);
        
        $addressData = array(
            'Member' => array('id' => $this->Member->id),
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'Florida',
                'zipcode' => '6600A',
                'country' => 'United States'
            )
        );
        
        $return = $this->Member->addAddress($addressData);
        
        $this->assertEqual(false, $return);        
    }   
    
    public function testDeleteAddress()
    {
        $this->Member->add($this->memberAddData);
        
        $sql = "SELECT addresses_members.address_id, addresses.id 
                FROM addresses_members
                JOIN addresses ON addresses_members.address_id = addresses.id
                WHERE member_id= '" . $this->Member->id . "'";
        
        $dbo = $this->Member->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['addresses_members']['address_id']);
        $addressId = $row['addresses']['id'];
        $this->assertNotNull($addressId);
               
        $this->Member->deleteAddress($addressId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['addresses_members']['address_id']);
        $this->assertNull($rowAfter['addresses']['id']);
        
        $sqlAddress = "SELECT id 
                     FROM addresses where addresses.id= '" . $addressId . "'";
        
        $dbo->rawQuery($sqlAddress);
        $rowAddress = $dbo->fetchRow();        
        
        $this->assertNull($rowAddress['addresses']['id']);                     
    }
    
    public function testDeleteAddress_IsInUse()
    {
        $this->Member->add($this->memberAddData);
        
        $secondMemberData = $this->memberAddData;
        $secondMemberData['Member']['name'] = 'secondName';
        
        $member = ClassRegistry::init('Member');
        $member->add($secondMemberData);
        
        $sql = "SELECT addresses_members.address_id, addresses.id 
                FROM addresses_members
                JOIN addresses ON addresses_members.address_id = addresses.id
                WHERE member_id= '" . $this->Member->id . "'";
        
        $dbo = $this->Member->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['addresses_members']['address_id']);
        $addressId = $row['addresses']['id'];
        $this->assertNotNull($addressId);
               
        $this->Member->deleteAddress($addressId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['addresses_members']['address_id']);
        $this->assertNull($rowAfter['addresses']['id']);
        
        $sqlAddress = "SELECT id 
                     FROM addresses where addresses.id= '" . $addressId . "'";
        
        $dbo->rawQuery($sqlAddress);
        $rowAddress = $dbo->fetchRow();        
        
        $this->assertNotNull($rowAddress['addresses']['id']);                   
    }

    private function buildMembersAddressQuery($addressId)
    {
        return "SELECT 
                members.id, 
                addresses.street_address, addresses.city, addresses.state, addresses.zipcode, addresses.country
                FROM addresses
                JOIN addresses_members am ON addresses.id = am.address_id
                JOIN members ON am.member_id = members.id
                WHERE addresses.id = '" . $addressId . "'";          
    }    
}