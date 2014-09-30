<?php

App::uses('SkipTestEvaluator', 'Test/Lib');

class MemberBase extends CakeTestCase
{
    protected $skipTestEvaluator;
    
    public $memberAddData = array(
            'Member' => array(
                'congregation_id' => '1',
                'first_name' => 'testFirstName',
                'last_name' => 'testLastName',
                'middle_name' => 'testMiddleName',
                'gender' => 'Male',
                'birth_date' => '1980-06-01',
                'baptized' => '1',
                'profile_picture' => 'testFirstName testLastName.jpg',
                'anniversary_id' => '1'
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
        'app.anniversary',
//        'app.user',
//        'app.absence',
//        'app.contribution',
//        'app.member_task_assignment',
        'app.addresses_member',
        'app.email_addresses_member',
//        'app.group',
//        'app.groups_member',
        'app.members_phone',
//        'app.task',
//        'app.members_task'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Member = ClassRegistry::init('Member');
        
        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Member);

        parent::tearDown();
    }

    public function test()
    {
        //prevent test failure for not having a test
        $this->markTestSkipped('fake test to prevent failure for base class not having a test.');
    }    
}