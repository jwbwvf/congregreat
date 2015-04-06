<?php

App::uses('CongregationFollow', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');

/**
 * CongregationFollow Test Case
 *
 */
class CongregationFollowTest extends CongregationBase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGetFollows'                    => 1,
        'testGetFollowers'                  => 1,
        'testGetFollowId'                   => 1,
    );

    public function testGetFollows()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record
        $leadCongregationSecondId = 3; //third id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationSecondId);

        $followRequests  = $this->Congregation->getFollowRequests($leadCongregationId);
        foreach ($followRequests as $followRequest)
        {
            $this->Congregation->acceptFollowRequest($followRequest['CongregationFollowRequest']['id']);
        }

        $followRequestsSecond = $this->Congregation->getFollowRequests($leadCongregationSecondId);
        foreach ($followRequestsSecond as $followRequest)
        {
            $this->Congregation->acceptFollowRequest($followRequest['CongregationFollowRequest']['id']);
        }

        $follows = $this->Congregation->getFollows($followerCongregationId);
        $this->assertEqual(2, count($follows));
    }

    public function testGetFollowers()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $leaderCongregationId = 1; //first id from congregation fixture record
        $followingCongregationIdOne = 2; //second id from congregation fixture record
        $followingCongregationIdTwo = 3; //third id from congregation fixture record

        $this->Congregation->addFollowRequest($followingCongregationIdOne, $leaderCongregationId);
        $this->Congregation->addFollowRequest($followingCongregationIdTwo, $leaderCongregationId);

        $followRequests  = $this->Congregation->getFollowRequests($leaderCongregationId);
        foreach ($followRequests as $followRequest)
        {
            $this->Congregation->acceptFollowRequest($followRequest['CongregationFollowRequest']['id']);
        }

        $followers = $this->Congregation->getFollowers($leaderCongregationId);
        $this->assertEqual(2, count($followers));
    }

    public function testGetFollowId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $leaderCongregationId = 1; //first id from congregation fixture record
        $followingCongregationIdOne = 2; //second id from congregation fixture record

        $this->Congregation->addFollowRequest($followingCongregationIdOne, $leaderCongregationId);

        $followIdBeforeFollowing = $this->Congregation->CongregationFollow->getFollowId($followingCongregationIdOne,
                $leaderCongregationId);

        $this->assertEqual(0, $followIdBeforeFollowing);

        $followRequests  = $this->Congregation->getFollowRequests($leaderCongregationId);
        foreach ($followRequests as $followRequest)
        {
            $this->Congregation->acceptFollowRequest($followRequest['CongregationFollowRequest']['id']);
        }

        $followIdFollowing = $this->Congregation->CongregationFollow->getFollowId($followingCongregationIdOne,
                $leaderCongregationId);

        $this->assertTrue($followIdFollowing != 0);
    }

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
}
