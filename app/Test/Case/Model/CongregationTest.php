<?php

App::uses('Congregation', 'Model');

/**
 * Congregation Test Case
 *
 */
class CongregationTest extends CakeTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.address',
        'app.addresses_congregation',
        'app.email_address',
        'app.congregations_email_address',
        'app.phone',
        'app.congregations_phone'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Congregation = ClassRegistry::init('Congregation');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Congregation);

        parent::tearDown();
    }

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
        $data = $this->createCongregationsAddData();
        
        $return = $this->Congregation->add($data);

        $this->assertTrue($return);
        
        $dbo = $this->Congregation->getDataSource();
        $sql = $this->buildCongregationsAddDataQuery();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($data['Congregation']['name'], $row['congregations']['name']);
        $this->assertEqual($data['Congregation']['website'], $row['congregations']['website']);
        $this->assertEqual($data['EmailAddress']['email_address'], $row['email_addresses']['email_address']);
        $this->assertEqual($data['Phone']['number'], $row['phones']['number']);
        $this->assertEqual($data['Phone']['type'], $row['phones']['type']);
        $this->assertEqual($data['Address']['street_address'], $row['addresses']['street_address']);
        $this->assertEqual($data['Address']['city'], $row['addresses']['city']);
        $this->assertEqual($data['Address']['state'], $row['addresses']['state']);
        $this->assertEqual($data['Address']['zipcode'], $row['addresses']['zipcode']);
        $this->assertEqual($data['Address']['country'], $row['addresses']['country']);
    } 

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
     * test adding a phone number to an existing congregation
     * @covers Congregation::addPhoneNumber
     * @covers Congregation::isRelatedModelValid
     */
    public function testAddPhoneNumber()
    {
        $congregationData = $this->createCongregationsAddData();
        $this->Congregation->add($congregationData);
        
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
        $congregationData = $this->createCongregationsAddData();
        $this->Congregation->add($congregationData);
        
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
        $congregationData = $this->createCongregationsAddData();
        $this->Congregation->add($congregationData);
        
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
        $congregationData = $this->createCongregationsAddData();
        $this->Congregation->add($congregationData);                
        
        $secondCongregationData = $this->createCongregationsAddData();
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
     * test adding an email address to an existing congregation
     * @covers Congregation::addEmailAddress
     * @covers Congregation::isRelatedModelValid
     */
    public function testAddEmailAddress()
    {
        $congregationData = $this->createCongregationsAddData();
        $this->Congregation->add($congregationData);
        
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
                $congregationData = $this->createCongregationsAddData();
        $this->Congregation->add($congregationData);
        
        $emailAddressData = array(
            'Congregation' => array('id' => $this->Congregation->id),
            'EmailAddress' => array('email_address' => 'emailAddressemails.com')
        );
        
        $return = $this->Congregation->addEmailAddress($emailAddressData);
        
        $this->assertFalse($return);
    }

    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($model, $key, $value)
    {
        $data = $this->createCongregationsAddData();
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
            congregations.name, congregations.website,
            addresses.street_address, addresses.city, addresses.state, addresses.zipcode, addresses.country,
            email_addresses.email_address,
            phones.number, phones.type
            FROM congregations
            JOIN addresses_congregations ac ON congregations.id = ac.congregation_id
            JOIN congregations_phones cp ON congregations.id = cp.congregation_id
            JOIN congregations_email_addresses cea ON congregations.id = cea.congregation_id
            JOIN addresses ON ac.address_id = addresses.id
            JOIN email_addresses ON cea.email_address_id = email_addresses.id
            JOIN phones ON cp.phone_id = phones.id
            WHERE congregations.name = 'testCongregation'";        
    }
    
    /**
     * creates the data submitted from View/Congregations/add.ctp
     * @return array
     */
    private function createCongregationsAddData()
    {
        return array(
            'Congregation' => array(
                'name' => 'testCongregation',
                'website' => 'testCongregation.org'
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
