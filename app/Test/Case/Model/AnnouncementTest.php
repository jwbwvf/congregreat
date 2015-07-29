<?php
App::uses('Announcement', 'Model');

/**
 * Announcement Test Case
 *
 */
class AnnouncementTest extends CakeTestCase {

    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    public $tests = array();

	public $fixtures = array(
		'app.announcement',
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
		$this->Announcement = ClassRegistry::init('Announcement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Announcement);

		parent::tearDown();
	}

    public function testGet()
    {

    }
}
