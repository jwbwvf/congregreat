<?php

App::uses('Congregation', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');

class CongregationAddressTest extends CongregationBase
{     
    public function testAddAddress()
    {        
        $this->Congregation->add($this->congregationAddData);
        
        $addressData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'Florida',
                'zipcode' => '66000',
                'country' => 'United States'
            )
        );
        
        $return = $this->Congregation->addAddress($addressData);
        
        $this->assertNotEqual(false, $return);
        
        $sql  = $this->buildCongregationsAddressQuery($return['Address']['id']);
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($addressData['Address']['street_address'], $row['addresses']['street_address']);
        $this->assertEqual($addressData['Address']['city'], $row['addresses']['city']);
        $this->assertEqual($addressData['Address']['state'], $row['addresses']['state']);
        $this->assertEqual($addressData['Address']['zipcode'], $row['addresses']['zipcode']);
        $this->assertEqual($addressData['Address']['country'], $row['addresses']['country']);
        $this->assertEqual($addressData['Congregation']['id'], $row['congregations']['id']);        
    }
    
    public function testAddAddress_InvalidState()
    {
        $this->Congregation->add($this->congregationAddData);
        
        $addressData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'invalid',
                'zipcode' => '66000',
                'country' => 'United States'
            )
        );
        
        $return = $this->Congregation->addAddress($addressData);
        
        $this->assertEqual(false, $return);        
    }
    
    public function testAddAddress_InvalidZipcode()
    {
        $this->Congregation->add($this->congregationAddData);
        
        $addressData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'Florida',
                'zipcode' => '6600A',
                'country' => 'United States'
            )
        );
        
        $return = $this->Congregation->addAddress($addressData);
        
        $this->assertEqual(false, $return);        
    }   
    
    public function testDeleteAddress()
    {        
        $this->Congregation->add($this->congregationAddData);
        
        $sql = "SELECT addresses_congregations.address_id, addresses.id 
                FROM addresses_congregations
                JOIN addresses ON addresses_congregations.address_id = addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['addresses_congregations']['address_id']);
        $addressId = $row['addresses']['id'];
        $this->assertNotNull($addressId);
                  
        $this->Congregation->deleteAddress($addressId);        

        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['addresses_congregations']['address_id']);
        $this->assertNull($rowAfter['addresses']['id']);
        
        $sqlAddress = "SELECT id 
                     FROM addresses where addresses.id= '" . $addressId . "'";
        
        $dbo->rawQuery($sqlAddress);
        $rowAddress = $dbo->fetchRow();        
        
        $this->assertNull($rowAddress['addresses']['id']);                     
    }
    
    public function testDeleteAddress_IsInUse()
    {
        $this->Congregation->add($this->congregationAddData);
        
        $secondCongregationData = $this->congregationAddData;
        $secondCongregationData['Congregation']['name'] = 'secondName';
        
        $congregation = ClassRegistry::init('Congregation');
        $congregation->add($secondCongregationData);
        
        $sql = "SELECT addresses_congregations.address_id, addresses.id 
                FROM addresses_congregations
                JOIN addresses ON addresses_congregations.address_id = addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['addresses_congregations']['address_id']);
        $addressId = $row['addresses']['id'];
        $this->assertNotNull($addressId);
               
        $this->Congregation->deleteAddress($addressId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['addresses_congregations']['address_id']);
        $this->assertNull($rowAfter['addresses']['id']);
        
        $sqlAddress = "SELECT id 
                     FROM addresses where addresses.id= '" . $addressId . "'";
        
        $dbo->rawQuery($sqlAddress);
        $rowAddress = $dbo->fetchRow();        
        
        $this->assertNotNull($rowAddress['addresses']['id']);                   
    }

    private function buildCongregationsAddressQuery($addressId)
    {
        return "SELECT 
                congregations.id, 
                addresses.street_address, addresses.city, addresses.state, addresses.zipcode, addresses.country
                FROM addresses
                JOIN addresses_congregations ac ON addresses.id = ac.address_id
                JOIN congregations ON ac.congregation_id = congregations.id
                WHERE addresses.id = '" . $addressId . "'";          
    }
}
