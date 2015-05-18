<?php

App::uses('AnnouncementRequest', 'Model');
App::uses('AnnouncementRequestStatus', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

/**
 * @covers AnnouncementRequest
 */
class AnnouncementRequestTest extends CakeTestCase
{

    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'                                   => 1,
        'testGet_NotFound'                          => 1,
        'testGetMembersAnnouncementRequests'        => 1,
        'testGetCongregationsAnnouncementRequests'  => 1,
        'testCancel'                                => 1,
        'testReject'                                => 1,
        'testAccept'                                => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.announcement_request',
        'app.announcement',
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

        $announcementRequestFixture = new AnnouncementRequestFixture();
        $this->announcementRequestRecords = $announcementRequestFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
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

    /**
     * @covers AnnouncementRequest::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $announcementRequestRecord = $this->announcementRequestRecords[0];
        $announcementRequest = $this->AnnouncementRequest->get($announcementRequestRecord['id']);

        $this->assertEquals($announcementRequestRecord['id'], $announcementRequest['AnnouncementRequest']['id']);
        $this->assertEquals($announcementRequestRecord['member_id'], $announcementRequest['AnnouncementRequest']['member_id']);
        $this->assertEquals($announcementRequestRecord['congregation_id'], $announcementRequest['AnnouncementRequest']['congregation_id']);
        $this->assertEquals($announcementRequestRecord['announcement'], $announcementRequest['AnnouncementRequest']['announcement']);
        $this->assertEquals($announcementRequestRecord['status'], $announcementRequest['AnnouncementRequest']['status']);
        $this->assertEquals($announcementRequestRecord['expiration'], $announcementRequest['AnnouncementRequest']['expiration']);
    }

    /**
     * @covers AnnouncementRequest::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $announcementRequestId = TestHelper::getNonFixtureId($this->announcementRequestRecords);

        $this->AnnouncementRequest->get($announcementRequestId);
    }

    /**
     * @covers AnnouncementRequest::getMembersAnnouncementRequests
     */
    public function testGetMembersAnnouncementRequests()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $memberId = 1; //member_id from AnnouncementRequest fixture
        $announcementRequestId = 1; //id from AnnouncementRequest fixture
        $congregationId = 1; //congregation_id from AnnouncementRequest fixture
        $announcement = 'test announcement request 1'; //announcement from AnnouncementRequest fixture
        $expiration = '2015-05-06 13:47:46'; //expiration from AnnouncementRequest fixture

        $announcementRequest = $this->AnnouncementRequest->getMembersAnnouncementRequests($memberId);

        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['member_id'], $memberId);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['id'], $announcementRequestId);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['congregation_id'], $congregationId);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['announcement'], $announcement);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['expiration'], $expiration);
    }

    /**
     * @covers AnnouncementRequest::getCongregationsAnnouncementRequests
     */
    public function testGetCongregationsAnnouncementRequests()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationId = 1; //congregation_id from AnnouncementRequest fixture
        $announcementRequestId = 1; //id from AnnouncementRequest fixture
        $memberId = 1; //member_id from AnnouncementRequest fixture
        $announcement = 'test announcement request 1'; //announcement from AnnouncementRequest fixture
        $expiration = '2015-05-06 13:47:46'; //expiration from AnnouncementRequest fixture

        $announcementRequest = $this->AnnouncementRequest->getCongregationsAnnouncementRequests($congregationId);

        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['congregation_id'], $congregationId);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['id'], $announcementRequestId);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['member_id'], $memberId);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['announcement'], $announcement);
        $this->assertEquals($announcementRequest[0]['AnnouncementRequest']['expiration'], $expiration);
    }

    /**
     * @covers AnnouncementRequest::cancel
     */
    public function testCancel()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $announcementRequestId = 1; //id from AnnouncementRequest fixture

        $announcementRequest = $this->AnnouncementRequest->get($announcementRequestId);

        $this->assertEquals($announcementRequest['AnnouncementRequest']['status'], AnnouncementRequestStatus::PENDING);

        $this->AnnouncementRequest->cancel($announcementRequestId);

        $announcementRequestCancelled = $this->AnnouncementRequest->get($announcementRequestId);

        $this->assertEquals($announcementRequestCancelled['AnnouncementRequest']['status'], AnnouncementRequestStatus::CANCELLED);
    }

    /**
     * @covers AnnouncementRequest::reject
     */
    public function testReject()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $announcementRequestId = 1; //id from AnnouncementRequest fixture

        $announcementRequest = $this->AnnouncementRequest->get($announcementRequestId);

        $this->assertEquals($announcementRequest['AnnouncementRequest']['status'], AnnouncementRequestStatus::PENDING);

        $this->AnnouncementRequest->reject($announcementRequestId);

        $announcementRequestCancelled = $this->AnnouncementRequest->get($announcementRequestId);

        $this->assertEquals($announcementRequestCancelled['AnnouncementRequest']['status'], AnnouncementRequestStatus::REJECTED);
    }

    /**
     * @covers AnnouncementRequest::accept
     */
    public function testAccept()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $announcementRequestId = 1; //id from AnnouncementRequest fixture

        $announcementRequest = $this->AnnouncementRequest->get($announcementRequestId);

        $this->assertEquals($announcementRequest['AnnouncementRequest']['status'], AnnouncementRequestStatus::PENDING);

        $announcement = $this->AnnouncementRequest->accept($announcementRequestId);

        $announcementRequestAccepted = $this->AnnouncementRequest->get($announcementRequestId);

        $this->assertEquals($announcementRequestAccepted['AnnouncementRequest']['status'], AnnouncementRequestStatus::ACCEPTED);

        $this->assertEquals($announcement['Announcement']['congregation_id'], $announcementRequestAccepted['AnnouncementRequest']['congregation_id']);
        $this->assertEquals($announcement['Announcement']['announcement'], $announcementRequestAccepted['AnnouncementRequest']['announcement']);
        $this->assertEquals($announcement['Announcement']['expiration'], $announcementRequestAccepted['AnnouncementRequest']['expiration']);

        $sql = "SELECT congregation_id, announcement, expiration FROM announcements WHERE announcement = '" . $announcementRequestAccepted['AnnouncementRequest']['announcement'] . "'";

        $dbo = $this->AnnouncementRequest->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEquals($row['announcements']['congregation_id'], $announcementRequestAccepted['AnnouncementRequest']['congregation_id']);
        $this->assertEquals($row['announcements']['announcement'], $announcementRequestAccepted['AnnouncementRequest']['announcement']);
        $this->assertEquals($row['announcements']['expiration'], $announcementRequestAccepted['AnnouncementRequest']['expiration']);
    }

}
