<?php

App::uses('CongregationFollowRequest', 'Model');

/**
 * CongregationFollowRequest Test Case
 *
 */
class CongregationFollowRequestTest extends CakeTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation_follow_request',
        'app.congregation',
        'app.member',
        'app.address',
        'app.addresses_congregation',
        'app.addresses_member',
        'app.email_address',
        'app.congregations_email_address',
        'app.email_addresses_member',
        'app.phone',
        'app.congregations_phone',
        'app.members_phone'//,
        //'app.requesting_congregation'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->CongregationFollowRequest = ClassRegistry::init('CongregationFollowRequest');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CongregationFollowRequest);

        parent::tearDown();
    }

    public function test()
    {
        //prevent test failure for not having a test
        $this->markTestSkipped('fake test to prevent failure for base class not having a test.');
    }    
}
