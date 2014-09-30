<?php

App::uses('Phone', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');

/**
 * Phone Test Case
 *
 */
class PhoneTest extends CakeTestCase
{

    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testAdd'                           => 1,        
        'testAdd_MissingNumber'             => 1,
        'testAdd_InvalidNumberFormat'       => 1,
        'testAdd_InvalidNumber_LengthLong'  => 1,
        'testAdd_InvalidNumber_LengthShort' => 1,        
        'testAdd_testAdd_InvalidType'       => 1,
    );
    
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
        
        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
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
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $data = $this->createPhone();
        
        $this->Phone->create();
        $result = $this->Phone->save($data);
        $this->assertNotEquals(false, $result);
    }
    
    /**
     * test adding phone with a missing phone number
     * @covers Phone::add
     */
    public function testAdd_MissingNumber()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('number', '');     
    }

    /**
     * test adding phone with an invalid phone number format
     * @covers Phone::add
     */
    public function testAdd_InvalidNumberFormat()
    {   
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('number', '(555)-555-5555');
    }  
    
    /**
     * test adding phone with too many digits in the phone number
     * @covers Phone::add
     */
    public function testAdd_InvalidNumber_LengthLong()
    {   
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('number', '5555-555-5555');
    }
    
    /**
     * test adding phone with too few digits in the phone number
     * @covers Phone::add
     */
    public function testAdd_InvalidNumber_LengthShort()
    {   
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('number', '555-555-555');
    }    
    
    /**
     * test adding a phone with an invalid phone type
     * @covers Phone::add
     */
    public function testAdd_InvalidType()
    {   
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
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
        
        $this->Phone->create();
        $result = $this->Phone->save($data);
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
