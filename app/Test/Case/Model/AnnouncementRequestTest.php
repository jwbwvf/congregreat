<?php

App::uses('AnnouncementRequest', 'Model');

/**
 * AnnouncementRequest Test Case
 *
 */
class AnnouncementRequestTest extends CakeTestCase
{

    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet' => 1,
        'testGet_NotFound' => 1,
        'testGetMembersAnnouncementRequests' => 1,
        'testGetCongregationsAnnouncementRequests' => 1,
        'testCancel' => 1,
        'testReject' => 1,
        'testAccept' => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.announcement_request',
        'app.congregation',
        'app.member'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->AnnouncementRequest = ClassRegistry::init('AnnouncementRequest');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnnouncementRequest);

        parent::tearDown();
    }

    public function testGet()
    {

    }

    public function testGet_NotFound()
    {

    }

    public function testGetMembersAnnouncementRequests()
    {

    }

    public function testGetCongregationsAnnouncementRequests()
    {

    }

    public function testCancel()
    {

    }

    public function testReject()
    {

    }

    public function testAccept()
    {

    }

}
