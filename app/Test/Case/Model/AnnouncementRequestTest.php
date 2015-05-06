<?php
App::uses('AnnouncementRequest', 'Model');

/**
 * AnnouncementRequest Test Case
 *
 */
class AnnouncementRequestTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.announcement_request',
		'app.congregation',
		'app.member',
		'app.member_address',
		'app.member_email_address',
		'app.member_phone',
		'app.congregation_address',
		'app.congregation_email_address',
		'app.congregation_phone',
		'app.congregation_follow_request',
		'app.congregation_follow',
		'app.task'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementRequest = ClassRegistry::init('AnnouncementRequest');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementRequest);

		parent::tearDown();
	}

}
