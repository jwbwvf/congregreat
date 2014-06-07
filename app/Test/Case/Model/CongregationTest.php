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
}
