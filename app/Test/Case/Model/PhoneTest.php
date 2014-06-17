<?php

App::uses('Phone', 'Model');

/**
 * Phone Test Case
 *
 */
class PhoneTest extends CakeTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.phone'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Phone = ClassRegistry::init('Phone');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Phone);

        parent::tearDown();
    }

    /**
     * test add phone
     * @covers Phone::add
     */
    public function testAdd()
    {
        $data = $this->createPhone();        
        $result = $this->Phone->add($data);
        $this->assertNotEquals(false, $result);
    }
    
    /**
     * test adding phone with a missing phone number
     * @covers Phone::add
     */
    public function testAdd_MissingNumber()
    {
        $this->validate('number', '');     
    }

    /**
     * test adding phone with an invalid phone number format
     * @covers Phone::add
     */
    public function testAdd_InvalidNumberFormat()
    {   
        $this->validate('number', '(555)-555-5555');
    }  
    
    /**
     * test adding phone with too many digits in the phone number
     * @covers Phone::add
     */
    public function testAdd_InvalidNumber_LengthLong()
    {   
        $this->validate('number', '5555-555-5555');
    }
    
    /**
     * test adding phone with too few digits in the phone number
     * @covers Phone::add
     */
    public function testAdd_InvalidNumber_LengthShort()
    {   
        $this->validate('number', '555-555-555');
    }    
    
    /**
     * test adding a phone with an invalid phone type
     * @covers Phone::add
     */
    public function testAdd_InvalidType()
    {   
        $this->validate('type', 'invalid');
    }
    
    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($key, $value)
    {
        $data = $this->createPhone();
        $data[$key] = $value;
        
        $result = $this->Phone->add($data);
        $this->assertFalse($result); 
    }   

    /**
     * helper method to create a valid phone data array
     * @return array with the phone properties
     */    
    private function createPhone()
    {
        return array(
            'number' => '555-555-5555',
            'type' => PhoneType::home
        );
    }

}
