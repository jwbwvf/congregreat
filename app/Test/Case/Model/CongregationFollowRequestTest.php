<?php

App::uses('CongregationFollowRequest', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');

/**
 * CongregationFollowRequest Test Case
 *
 */
class CongregationFollowRequestTest extends CongregationBase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGetFollowRequests'             => 1,
        'testGetMyPendingRequests'          => 1,
        'testGetPendingFollowRequestId'     => 1,
    );

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

    public function testGetPendingFollowRequestId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);

        $followRequestId = $this->Congregation->CongregationFollowRequest->getPendingFollowRequestId($leadCongregationId, $followerCongregationId);
        $this->assertTrue($followRequestId != 0);
    }

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_follow_request'
    );
}
