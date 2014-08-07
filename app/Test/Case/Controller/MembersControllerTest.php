<?php
App::uses('MembersController', 'Controller');

/**
 * MembersController Test Case
 *
 */
class MembersControllerTest extends ControllerTestCase {

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
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}

}
