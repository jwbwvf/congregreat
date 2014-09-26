<?php

App::uses('Congregation', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');

class CongregationEmailAddressTest extends CongregationBase
{   
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testAddEmailAddress'                       => 1,        
        'testAddEmailAddress_InvalidEmailAddress'   => 1,
        'testDeleteEmailAddress'                    => 1,
        'testDeleteEmailAddress_IsInUse'            => 1,
    );
    
    /**
     * test adding an email address to an existing congregation
     * @covers Congregation::addEmailAddress
     * @covers Congregation::isRelatedModelValid
     */
    public function testAddEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        
        $emailAddressData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'EmailAddress' => array('email_address' => 'emailAddress@emails.com')
        );
        
        $return = $this->Congregation->addEmailAddress($emailAddressData);
        
        $this->assertNotEqual(false, $return);
            
        $sql  = $this->buildCongregationsEmailAddressQuery($return['EmailAddress']['id']);
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($emailAddressData['EmailAddress']['email_address'], $row['email_addresses']['email_address']);
        $this->assertEqual($emailAddressData['Congregation']['id'], $row['congregations']['id']);        
    }
    
    /**
     * tests adding an invalid email address to an existing congregation
     * @covers Congregation::addEmailAddress
     * @covers Congregation::isRelatedModelValid
     */
    public function testAddEmailAddress_InvalidEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        
        $emailAddressData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'EmailAddress' => array('email_address' => 'emailAddressemails.com')
        );
        
        $return = $this->Congregation->addEmailAddress($emailAddressData);
        
        $this->assertFalse($return);
    }
    
    public function testDeleteEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        
        $sql = "SELECT congregations_email_addresses.email_address_id, email_addresses.id 
                FROM congregations_email_addresses
                JOIN email_addresses ON congregations_email_addresses.email_address_id = email_addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['congregations_email_addresses']['email_address_id']);
        $emailAddressId = $row['email_addresses']['id'];
        $this->assertNotNull($emailAddressId);
               
        $this->Congregation->deleteEmailAddress($emailAddressId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['congregations_email_addresses']['email_address_id']);
        $this->assertNull($rowAfter['email_addresses']['id']);
        
        $sqlEmailAddress = "SELECT id 
                     FROM email_addresses where email_addresses.id= '" . $emailAddressId . "'";
        
        $dbo->rawQuery($sqlEmailAddress);
        $rowEmailAddress = $dbo->fetchRow();        
        
        $this->assertNull($rowEmailAddress['email_addresses']['id']);        
    }
    
    public function testDeleteEmailAddress_IsInUse()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        
        $secondCongregationData = $this->congregationAddData;
        $secondCongregationData['Congregation']['name'] = 'secondName';
        
        $congregation = ClassRegistry::init('Congregation');
        $congregation->add($secondCongregationData);
        
        $sql = "SELECT congregations_email_addresses.email_address_id, email_addresses.id 
                FROM congregations_email_addresses
                JOIN email_addresses ON congregations_email_addresses.email_address_id = email_addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";
        
        $dbo = $this->Congregation->getDataSource();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertNotNull($row['congregations_email_addresses']['email_address_id']);
        $emailAddressId = $row['email_addresses']['id'];
        $this->assertNotNull($emailAddressId);

        $this->Congregation->deleteEmailAddress($emailAddressId);        
                        
        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();        
        
        $this->assertNull($rowAfter['congregations_email_addresses']['email_address_id']);
        $this->assertNull($rowAfter['email_addresses']['id']);
        
        $sqlEmailAddress = "SELECT id 
                     FROM email_addresses where email_addresses.id= '" . $emailAddressId . "'";
        
        $dbo->rawQuery($sqlEmailAddress);
        $rowEmailAddress = $dbo->fetchRow();        
        
        $this->assertNotNull($rowEmailAddress['email_addresses']['id']);         
    } 

    /**
     * builds the query to retrieve the congregations
     * associated to the email address
     * @param int $emailAddressId
     * @return string
     */
    private function buildCongregationsEmailAddressQuery($emailAddressId)
    {
        return "SELECT 
                congregations.id, 
                email_addresses.email_address
                FROM email_addresses
                JOIN congregations_email_addresses cea ON email_addresses.id = cea.email_address_id
                JOIN congregations ON cea.congregation_id = congregations.id
                WHERE email_addresses.id = '" . $emailAddressId . "'";        
    }     
}