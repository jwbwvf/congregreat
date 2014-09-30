<?php

App::uses('Address', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');

/**
 * Address Test Case
 *
 */
class AddressTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(        
        'testAdd_InvalidZipcode_NonNumeric'     => 1,
        'testAdd_InvalidZipcode_LengthLong'     => 1,
        'testAdd_InvalidZipcode_LengthShort'    => 1,
        'testAdd_InvalidState'                  => 1,        
        'testAdd_EmptyCity'                     => 1,
        'testAdd_InvalidCountry'                => 1,
        'testAdd_EmptyCountry'                  => 1,
    );
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.address'
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
        
        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
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
    public function testAdd_InvalidZipcode_NonNumeric()
    {           
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('zipcode', 'AAAAA');
    }

    /**
     * @covers Address::add
     */    
    public function testAdd_InvalidZipcode_LengthLong()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('zipcode', '640555');
    }
    
    /**
     * @covers Address::add
     */    
    public function testAdd_InvalidZipcode_LengthShort()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('zipcode', '6405');
    }    

    /**
     * @covers Address::add
     */    
    public function testAdd_InvalidState()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('state', 'invalid');
    }    
    
    /**
     * @covers Address::add
     */        
    public function testAdd_EmptyCity()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('city', '');     
    }
    
    /**
     * @covers Address::add
     */        
    public function testAdd_InvalidCountry()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('country', 'China');              
    }
    
    /**
     * @covers Address::add
     */        
    public function testAdd_EmptyCountry()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
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
        
        $this->Address->create();
        $result = $this->Address->save($data);
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
