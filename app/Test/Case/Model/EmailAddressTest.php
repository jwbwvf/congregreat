<?php

App::uses('EmailAddress', 'Model');

/**
 * EmailAddress Test Case
 *
 */
class EmailAddressTest extends CakeTestCase
{

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
        $data = array('email_address' => 'email@email.com');
        
        $result = $this->EmailAddress->add($data);
        $this->assertNotEqual(false, $result);
    }
    
    /**
     * test adding email address that is an invalid email format
     * @covers EmailAddress::add
     */
    public function testAdd_InvalidEmailAddress()
    {
        $data = array('email_address' => 'email.com');
        
        $result = $this->EmailAddress->add($data);
        $this->assertFalse($result);
    }
}
