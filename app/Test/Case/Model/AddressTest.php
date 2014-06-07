<?php

App::uses('Address', 'Model');

/**
 * Address Test Case
 *
 */
class AddressTest extends CakeTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.address',
//        'app.congregation',
//        'app.addresses_congregation',
//        'app.email_address',
//        'app.email_addresses_congregation',
//        'app.phone',
//        'app.congregations_phone'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Address = ClassRegistry::init('Address');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Address);

        parent::tearDown();
    }

    /**
     * @covers Address::add
     */
    public function testAdd()
    {
        $data = $this->createAddress();        
        $result = $this->Address->add($data);        
        $this->assertNotEqual(false, $result); 
    }

    /**
     * @covers Address::add
     */
    public function testAdd_InvalidZipcode_NonNumeric()
    {           
        $this->validate('zipcode', 'AAAAA');
    }

    /**
     * @covers Address::add
     */    
    public function testAdd_InvalidZipcode_LengthLong()
    {
        $this->validate('zipcode', '640555');
    }
    
    /**
     * @covers Address::add
     */    
    public function testAdd_InvalidZipcode_LengthShort()
    {
        $this->validate('zipcode', '6405');
    }    

    /**
     * @covers Address::add
     */    
    public function testAdd_InvalidState()
    {
        $this->validate('state', 'invalid');
    }    
    
    /**
     * @covers Address::add
     */        
    public function testAdd_EmptyCity()
    {
        $this->validate('city', '');     
    }
    
    /**
     * @covers Address::add
     */        
    public function testAdd_InvalidCountry()
    {
        $this->validate('country', 'China');              
    }
    
    /**
     * @covers Address::add
     */        
    public function testAdd_EmptyCountry()
    {
        $this->validate('country', '');
    }
    
    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($key, $value)
    {
        $data = $this->createAddress();
        $data[$key] = $value;
        
        $result = $this->Address->add($data);
        $this->assertFalse($result); 
    }
            
    /**
     * helper method to create a valid address data array
     * @return array with the address properties
     */
    private function createAddress()
    {
        return array(
            'street_address' => '7 e elm st',
            'city' => 'gotham city',
            'state' => 'Missouri',
            'zipcode' => '64055', 
            'country' => 'United States'
        );
    }
}
