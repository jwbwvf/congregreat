<?php

App::uses('Member', 'Model');

/**
 * Member Test Case
 *
 */
class MemberTest extends CakeTestCase
{

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
        'app.user',
        'app.absence',
        'app.contribution',
        'app.member_task_assignment',
        'app.addresses_member',
        'app.email_addresses_member',
        'app.group',
        'app.groups_member',
        'app.members_phone',
        'app.task',
        'app.members_task'
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

}
