<?php

App::uses('Congregation', 'Model');
App::uses('CongregationTestHelper', 'Test');
App::uses('CongregationBase', 'Test/Case/Model');

class CongregationPhoneTest extends CongregationBase
{        
    /**
     * test adding a phone number to an existing congregation
     * @covers Congregation::addPhoneNumber
     * @covers Congregation::isRelatedModelValid
     */
    public function testAddPhoneNumber()
    {
        $this->Congregation->add($this->congregationAddData);
        
        $phoneData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'Phone' => array('number' => '555-444-5555', 'type' => 'home')
        );
        
        $return = $this->Congregation->addPhoneNumber($phoneData);
        
        $this->assertNotEqual(false, $return);
            
        $sql  = $this->buildCongregationsPhoneNumberQuery($return['Phone']['id']);
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($phoneData['Phone']['number'], $row['phones']['number']);
        $this->assertEqual($phoneData['Phone']['type'], $row['phones']['type']);
        $this->assertEqual($phoneData['Congregation']['id'], $row['congregations']['id']);
    }        

    /**
     * test adding an invalid phone number to an existing congregation
     * @covers Congregation::addPhoneNumber
     * @covers Congregation::isRelatedModelValid
     */
    public function testAddPhoneNumber_InvalidPhoneNumber()
    {
        $this->Congregation->add($this->congregationAddData);
        
        $phoneData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'Phone' => array('number' => '5555-444-5555', 'type' => 'home')
        );
        
        $return = $this->Congregation->addPhoneNumber($phoneData);
        
        $this->assertFalse($return);        
    }   
    
    /**
     * test deleting a phone number for a congregation
     * @covers Congregation::deletePhoneNumber
     */
    public function testDeletePhoneNumber()
    {
        $this->Congregation->add($this->congregationAddData);
        
        $sql = "SELECT congregations_phones.phone_id, phones.id 
                FROM congregations_phones
                JOIN phones ON congregations_phones.phone_id = phones.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['congregations_phones']['phone_id']);
        $phoneId = $row['phones']['id'];
        $this->assertNotNull($phoneId);
               
        $this->Congregation->deletePhoneNumber($phoneId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['congregations_phones']['phone_id']);
        $this->assertNull($rowAfter['phones']['id']);
        
        $sqlPhone = "SELECT id 
                     FROM phones where phones.id= '" . $phoneId . "'";
        
        $dbo->rawQuery($sqlPhone);
        $rowPhone = $dbo->fetchRow();        
        
        $this->assertNull($rowPhone['phones']['id']);
    }    
    
    /**
     * test deleting a phone number for a congregation
     * that is being used by another congregation or member
     * the relationship should be deleted but the phone should not
     * @covers Congregation::deletePhoneNumber
     */
    public function testDeletePhoneNumber_IsInUse()
    {
        $this->Congregation->add($this->congregationAddData);                
        
        $secondCongregationData = $this->congregationAddData;
        $secondCongregationData['Congregation']['name'] = 'secondName';
        
        $congregation = ClassRegistry::init('Congregation');
        $congregation->add($secondCongregationData);
        
        $sql = "SELECT congregations_phones.phone_id, phones.id 
                FROM congregations_phones
                JOIN phones ON congregations_phones.phone_id = phones.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['congregations_phones']['phone_id']);
        $phoneId = $row['phones']['id'];
        $this->assertNotNull($phoneId);
               
        $this->Congregation->deletePhoneNumber($phoneId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['congregations_phones']['phone_id']);
        $this->assertNull($rowAfter['phones']['id']);
        
        $sqlPhone = "SELECT id 
                     FROM phones where phones.id= '" . $phoneId . "'";
        
        $dbo->rawQuery($sqlPhone);
        $rowPhone = $dbo->fetchRow();        
        
        $this->assertNotNull($rowPhone['phones']['id']);
    } 
       
    /**
     * builds the query to retrieve the congregation
     * associated to the phone
     * @param int $phoneId phone id
     * @return string
     */    
    private function buildCongregationsPhoneNumberQuery($phoneId)
    {
        return "SELECT 
                congregations.id, 
                phones.number, phones.type
                FROM phones
                JOIN congregations_phones cp ON phones.id = cp.phone_id
                JOIN congregations ON cp.congregation_id = congregations.id
                WHERE phones.id = '" . $phoneId . "'";
    }
}