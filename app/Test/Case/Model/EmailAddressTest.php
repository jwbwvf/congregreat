<?php

App::uses('EmailAddress', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');

/**
 * EmailAddress Test Case
 *
 */
class EmailAddressTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testAdd'                       => 1,        
        'testAdd_InvalidEmailAddress'   => 1,
    );
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.email_address'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->EmailAddress = ClassRegistry::init('EmailAddress');
        
        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);        
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailAddress);

        parent::tearDown();
    }

    /**
     * @covers EmailAddress::add
     */
    public function testAdd()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $data = array('email_address' => 'email@email.com');
        
        $this->EmailAddress->create();
        $result = $this->EmailAddress->save($data);
        $this->assertNotEqual(false, $result);
    }
    
    /**
     * test adding email address that is an invalid email format
     * @covers EmailAddress::add
     */
    public function testAdd_InvalidEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $data = array('email_address' => 'email.com');
        
        $this->EmailAddress->create();
        $result = $this->EmailAddress->save($data);
        $this->assertFalse($result);
    }
}
