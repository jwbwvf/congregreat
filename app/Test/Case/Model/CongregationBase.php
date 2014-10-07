<?php

App::uses('SkipTestEvaluator', 'Test/Lib');

class CongregationBase extends CakeTestCase
{
    protected $skipTestEvaluator;
    
    public $congregationAddData = array(
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

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.member',
        'app.congregation',
        'app.address',
        'app.addresses_congregation',
        'app.email_address',
        'app.congregations_email_address',
        'app.phone',
        'app.congregations_phone',
        'app.addresses_member',
        'app.email_addresses_member',
        'app.members_phone',
        'app.congregation_follow_request',
        'app.congregation_follow'
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
        
        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
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
    
    public function test()
    {
        //prevent test failure for not having a test
        $this->markTestSkipped('fake test to prevent failure for base class not having a test.');
    }
}
