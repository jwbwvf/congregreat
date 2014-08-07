<?php

App::uses('Congregation', 'Model');
App::uses('CongregationTestHelper', 'Test');
App::uses('CongregationBase', 'Test/Case/Model');

/**
 * Congregation Test Case
 *
 */
class CongregationTest extends CongregationBase
{
    /**
     * test adding a congregation with
     * all of it's related data
     * phone, email, address
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     * @covers Congregation::saveModels
     * @covers Congregation::saveRelatedModel
     */
    public function testAdd()
    {       
        $return = $this->Congregation->add($this->congregationAddData);
        $this->assertTrue($return);
        
        $dbo = $this->Congregation->getDataSource();
        $sql = $this->buildCongregationsAddDataQuery();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($this->congregationAddData['Congregation']['name'], $row['congregations']['name']);
        $this->assertEqual($this->congregationAddData['Congregation']['website'], $row['congregations']['website']);
        $this->assertEqual($this->congregationAddData['EmailAddress']['email_address'], $row['email_addresses']['email_address']);
        $this->assertEqual($this->congregationAddData['Phone']['number'], $row['phones']['number']);
        $this->assertEqual($this->congregationAddData['Phone']['type'], $row['phones']['type']);
        $this->assertEqual($this->congregationAddData['Address']['street_address'], $row['addresses']['street_address']);
        $this->assertEqual($this->congregationAddData['Address']['city'], $row['addresses']['city']);
        $this->assertEqual($this->congregationAddData['Address']['state'], $row['addresses']['state']);
        $this->assertEqual($this->congregationAddData['Address']['zipcode'], $row['addresses']['zipcode']);
        $this->assertEqual($this->congregationAddData['Address']['country'], $row['addresses']['country']);
    } 

    //todo add tests for multiple congregations
    //some sharing data others not sharing any 
    
    /**
     * test adding a congregation that is missing a name
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */
    public function testAdd_MissingName()
    {        
        $this->validate('Congregation', 'name', '');
    }
    
    /**
     * test adding a congregation that is missing a website
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */
    public function testAdd_MissingWebsite()
    {        
        $this->validate('Congregation', 'website', '');
    }    

    /**
     * test adding a congregation that has an invalid email address
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */
    public function testAdd_InvalidEmail()
    {
        $this->validate('EmailAddress', 'email_address', 'invalidEmail@nowhere');      
    }    

    /**
     * test adding a congregation that has an invalid address
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */
    public function testAdd_InvalidAddress()
    {
        $this->validate('Address', 'zipcode', '6405A');
    }        
    
    /**
     * test adding a congregation that has an invalid phone number
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */    
    public function testAdd_InvalidPhoneNumber()
    {
        $this->validate('Phone', 'number', '5555-555-5555');       
    }     
    
    /**
     * test deleting a congregation and all it's
     * associated models
     * @covers Congregation::delete
     * @covers Congregation::deleteAddress
     * @covers Congregation::deleteEmailAddress
     * @covers Congregation::deletePhoneNumber
     * @covers Congregation::deleteModel
     */
    public function testDelete()
    {
        $this->Congregation->add($this->congregationAddData);      
        
        $dbo = $this->Congregation->getDataSource();
        $sql = $this->buildCongregationsAddDataQuery();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->Congregation->delete($row['congregations']['id']);
        
        $sqlAfterDeleteCongregation = "SELECT * FROM congregations WHERE id='" . $row['congregations']['id'] . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM addresses WHERE id='" . $row['addresses']['id'] . "'";
        $sqlAfterDeletePhone = "SELECT * FROM phones WHERE id='" . $row['phones']['id'] . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM email_addresses WHERE id='" . $row['email_addresses']['id'] . "'";
        
        $dbo->rawQuery($sqlAfterDeleteCongregation);
        $rowAfterDeleteCongregation = $dbo->fetchRow();        
        $this->assertFalse($rowAfterDeleteCongregation);
        
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
     * test deleting a congregation that has the same 
     * address, email address, phone number associated
     * to another congregation
     * @covers Congregation::delete
     * @covers Congregation::deleteAddress
     * @covers Congregation::deleteEmailAddress
     * @covers Congregation::deletePhoneNumber
     * @covers Congregation::deleteModel
     */
    public function testDelete_ExistingAssociations()
    {
        $return = $this->Congregation->add($this->congregationAddData);
        $this->assertTrue($return);        
        
        $secondCongregationData = $this->congregationAddData;
        $secondCongregationData['Congregation']['name'] = 'secondName';
        
        $congregation = ClassRegistry::init('Congregation');
        $congregation->add($secondCongregationData);        
        
        $dbo = $this->Congregation->getDataSource();
        $sql = $this->buildCongregationsAddDataQuery();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->Congregation->delete($row['congregations']['id']);
        
        $sqlAfterDeleteCongregation = "SELECT * FROM congregations WHERE id='" . $row['congregations']['id'] . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM addresses WHERE id='" . $row['addresses']['id'] . "'";
        $sqlAfterDeletePhone = "SELECT * FROM phones WHERE id='" . $row['phones']['id'] . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM email_addresses WHERE id='" . $row['email_addresses']['id'] . "'";
        
        $dbo->rawQuery($sqlAfterDeleteCongregation);
        $rowAfterDeleteCongregation = $dbo->fetchRow();        
        $this->assertFalse($rowAfterDeleteCongregation);
        
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
    
    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($model, $key, $value)
    {
        $data = $this->congregationAddData;
        $data[$model][$key] = $value;
        
        $result = $this->Congregation->add($data);
        $this->assertFalse($result); 
    }          

    /**
     * builds the query to retrieve the congregation
     * and all it's associated data from an add
     * @return string
     */
    private function buildCongregationsAddDataQuery()
    {
        return "SELECT
            congregations.name, congregations.website, congregations.id,
            addresses.street_address, addresses.city, addresses.state, addresses.zipcode, addresses.country, addresses.id,
            email_addresses.email_address, email_addresses.id,
            phones.number, phones.type, phones.id
            FROM congregations
            JOIN addresses_congregations ac ON congregations.id = ac.congregation_id
            JOIN congregations_phones cp ON congregations.id = cp.congregation_id
            JOIN congregations_email_addresses cea ON congregations.id = cea.congregation_id
            JOIN addresses ON ac.address_id = addresses.id
            JOIN email_addresses ON cea.email_address_id = email_addresses.id
            JOIN phones ON cp.phone_id = phones.id
            WHERE congregations.name = 'testCongregation'";        
    }    
}
