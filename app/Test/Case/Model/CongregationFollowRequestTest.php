<?php

App::uses('CongregationFollowRequest', 'Model');
App::uses('TestHelper', 'Test/Lib');
App::uses('SkipTestEvaluator', 'Test/Lib');

/**
 * @covers CongregationFollowRequest
 */
class CongregationFollowRequestTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'                       => 1,
        'testGet_NotFound'              => 1,
        'testGetFollowRequests'         => 1,
        'testGetMyPendingRequests'      => 1,
        'testGetPendingFollowRequestId' => 1,
        'testAddFollowRequest'          => 1,
        'testRejectFollowRequest'       => 1,
        'testAcceptFollowRequest'       => 1,
        'testCancelFollowRequest'       => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_follow_request',
        'app.congregation_follow'
    );

    public function setup()
    {
        parent::setUp();

        $this->CongregationFollowRequest = ClassRegistry::init('CongregationFollowRequest');

        $congregationFollowRequestFixture = new CongregationFollowRequestFixture();
        $this->congregationFollowRequestRecords = $congregationFollowRequestFixture->records;

        $congregationFixture = new CongregationFixture();
        $this->congregationRecords = $congregationFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    public function tearDown() {
        unset($this->CongregationFollowRequest);

        parent::tearDown();
    }

    /**
     * @covers CongregationFollowRequest::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationFollowRequestRecord = $this->congregationFollowRequestRecords[0];
        $congregationFollowRequest = $this->CongregationFollowRequest->get($congregationFollowRequestRecord['id']);

        $this->assertEquals($congregationFollowRequestRecord['id'], $congregationFollowRequest['CongregationFollowRequest']['id']);
        $this->assertEquals($congregationFollowRequestRecord['leader_id'], $congregationFollowRequest['CongregationFollowRequest']['leader_id']);
        $this->assertEquals($congregationFollowRequestRecord['requesting_follower_id'], $congregationFollowRequest['CongregationFollowRequest']['requesting_follower_id']);
        $this->assertEquals($congregationFollowRequestRecord['status'], $congregationFollowRequest['CongregationFollowRequest']['status']);
    }

    /**
     * @covers CongregationFollowRequest::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationFollowRequestId = TestHelper::getNonFixtureId($this->congregationFollowRequestRecords);
        $this->CongregationFollowRequest->get($congregationFollowRequestId);
    }

    /**
     * @covers CongregationFollowRequest::getFollowRequests
     */
    public function testGetFollowRequests()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $leadCongregationId = 1; //leader id from CongregationFollowRequest fixture record
        $followerCongregationId = 2; //first requesting follower id from CongregationFollowRequest fixture record
        $followerCongregationName = $this->congregationRecords[$followerCongregationId - 1]['name'];
        $followerCongregationSecondId = 3; //second requesting follower id from CongregationFollow fixture record
        $followerCongregationSecondName = $this->congregationRecords[$followerCongregationSecondId - 1]['name'];

        $followRequests  = $this->CongregationFollowRequest->getFollowRequests($leadCongregationId);

        $this->assertEquals(count($followRequests), 2);
        $this->assertEquals($followRequests[0]['RequestingFollower']['id'], $followerCongregationId);
        $this->assertEquals($followRequests[0]['RequestingFollower']['name'], $followerCongregationName);
        $this->assertEquals($followRequests[1]['RequestingFollower']['id'], $followerCongregationSecondId);
        $this->assertEquals($followRequests[1]['RequestingFollower']['name'], $followerCongregationSecondName);

    }

    /**
     * @covers CongregationFollowRequest::getMyPendingRequests
     */
    public function testGetMyPendingRequests()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 2; //reqeusting follower id from CongregationFollowRequest fixture record
        $leadCongregationId = 1; //first leader id from CongregationFollowRequest fixture record
        $leadCongregationName = $this->congregationRecords[$leadCongregationId - 1]['name'];
        $leadCongregationSecondId = 3; //second leader id from CongregationFollowRequest fixture record
        $leadCongregationSecondName = $this->congregationRecords[$leadCongregationSecondId - 1]['name'];

        $followRequests  = $this->CongregationFollowRequest->getMyPendingRequests($followerCongregationId);

        $this->assertEquals(count($followRequests), 2);
        $this->assertEquals($followRequests[0]['RequestedLeader']['id'], $leadCongregationId);
        $this->assertEquals($followRequests[0]['RequestedLeader']['name'], $leadCongregationName);
        $this->assertEquals($followRequests[1]['RequestedLeader']['id'], $leadCongregationSecondId);
        $this->assertEquals($followRequests[1]['RequestedLeader']['name'], $leadCongregationSecondName);
    }

    /**
     * @covers CongregationFollowRequest::getPendingFollowRequestId
     */
    public function testGetPendingFollowRequestId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $leadCongregationId = 1; //leader id from CongregationFollowRequest fixture record
        $followerCongregationId = 2; //requesting follower id from CongregationFollowRequest fixture record

        $followRequestId = $this->CongregationFollowRequest->getPendingFollowRequestId($leadCongregationId, $followerCongregationId);
        $this->assertEquals($followRequestId, 1);
    }

    /**
     * @covers CongregationFollowRequest::addFollowRequest
     */
    public function testAddFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //id from congregation fixture record
        $leadCongregationId = 2; //id from congregation fixture record

        $this->CongregationFollowRequest->addFollowRequest($followerCongregationId, $leadCongregationId);

        $dbo = $this->CongregationFollowRequest->getDataSource();
        $sql = "SELECT * FROM congregation_follow_requests WHERE leader_id='" . $leadCongregationId . "' AND "
                . "requesting_follower_id='" . $followerCongregationId . "'";

        $all = $dbo->fetchAll($sql);

        $this->assertEquals(1, count($all));
        $this->assertEquals(CongregationFollowRequestStatus::PENDING, $all[0]['congregation_follow_requests']['status']);
    }

    /**
     * @covers CongregationFollowRequest::rejectFollowRequest
     */
    public function testRejectFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationFollowRequestId = 1; //id from CongregationFollowRequest, 1 leader, 2 follower status PENDING
        $this->CongregationFollowRequest->rejectFollowRequest($congregationFollowRequestId);

        $sql = "SELECT id, status FROM congregation_follow_requests WHERE id='" . $congregationFollowRequestId . "'";

        $dbo = $this->CongregationFollowRequest->getDataSource();
        $dbo->rawQuery($sql);
        $rowAfterReject = $dbo->fetchRow();

        $this->assertEquals(1, count($rowAfterReject));
        $this->assertEquals(CongregationFollowRequestStatus::REJECTED,
                $rowAfterReject['congregation_follow_requests']['status']);
    }

    /**
     * @covers CongregationFollowRequest::acceptFollowRequest
     */
    public function testAcceptFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationFollowRequestId = 1; //id from CongregationFollowRequest, 1 leader, 2 follower status PENDING
        $leadCongregationId   = 1; //id from CongregationFollowRequest
        $followerCongregationId = 2; //id from CongregationFollowRequest

        $this->CongregationFollowRequest->acceptFollowRequest($congregationFollowRequestId);

        $sql = "SELECT id, status FROM congregation_follow_requests WHERE id='" . $congregationFollowRequestId . "'";

        $dbo = $this->CongregationFollowRequest->getDataSource();
        $dbo->rawQuery($sql);
        $rowAfterAccept = $dbo->fetchRow();

        $this->assertEquals(CongregationFollowRequestStatus::ACCEPTED,
                $rowAfterAccept['congregation_follow_requests']['status']);

        //ensure a new row was added to the follows table
        $sqlFollow = "SELECT id FROM congregation_follows WHERE leader_id='" . $leadCongregationId . "' AND "
                . "follower_id='" . $followerCongregationId . "'";

        $dbo->rawQuery($sqlFollow);
        $rowFollow = $dbo->fetchRow();

        $this->assertTrue(!empty($rowFollow));
    }

    /**
     * @covers CongregationFollowRequest::cancelFollowRequest
     */
    public function testCancelFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationFollowRequestId = 1; //id from CongregationFollowRequest, 1 leader, 2 follower status PENDING
        $this->CongregationFollowRequest->cancelFollowRequest($congregationFollowRequestId);

        $sql = "SELECT id, status FROM congregation_follow_requests WHERE id='" . $congregationFollowRequestId . "'";

        $dbo = $this->CongregationFollowRequest->getDataSource();
        $dbo->rawQuery($sql);
        $rowAfterAccept = $dbo->fetchRow();

        $this->assertEquals(CongregationFollowRequestStatus::CANCELLED,
                $rowAfterAccept['congregation_follow_requests']['status']);
    }
}
