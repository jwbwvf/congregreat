<?php

App::uses('CongregationFollowRequest', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');
App::uses('TestHelper', 'Test/Lib');

/**
 * @covers CongregationFollowRequest
 *
 */
class CongregationFollowRequestTest extends CongregationBase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'                       => 0,
        'testGet_NotFound'              => 1,
        'testGetFollowRequests'         => 0,
        'testGetMyPendingRequests'      => 0,
        'testGetPendingFollowRequestId' => 0,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_follow_request'
    );

    public function setup()
    {
        parent::setUp();

        $congregationFollowRequestFixture = new CongregationFollowRequestFixture();
        $this->congregationFollowRequestRecords = $congregationFollowRequestFixture->records;
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
     * @covers CongregationFollowRequest::get
     */
    public function testGetFollowRequests()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record
        $followerCongregationSecondId = 3; //third id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
        $this->Congregation->addFollowRequest($followerCongregationSecondId, $leadCongregationId);

        $followRequests  = $this->Congregation->getFollowRequests($leadCongregationId);
        $this->assertEqual(2, count($followRequests));
    }

    /**
     * @covers CongregationFollowRequest::getMyPendingRequests
     */
    public function testGetMyPendingRequests()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record
        $leadCongregationSecondId = 3; //third id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationSecondId);

        $followRequests  = $this->Congregation->getMyPendingRequests($followerCongregationId);
        $this->assertEqual(2, count($followRequests));
    }

    /**
     * @covers CongregationFollowRequest::getPendingFollowRequestId
     */
    public function testGetPendingFollowRequestId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);

        $followRequestId = $this->Congregation->CongregationFollowRequest->getPendingFollowRequestId($leadCongregationId, $followerCongregationId);
        $this->assertTrue($followRequestId != 0);
    }
}
