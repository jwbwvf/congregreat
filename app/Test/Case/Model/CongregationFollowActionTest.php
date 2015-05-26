<?php

App::uses('CongregationFollowAction', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');

class CongregationFollowActionTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGet'                                       => 1,
        'testGet_SameCongregationId'                    => 1,
        'testGet_Following'                             => 1,
        'testGet_PendingFollowRequest'                  => 1,
        'testGet_NotFollowing_NoPendingFollowRequest'   => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_follow_request',
        'app.congregation_follow',
    );

    public function setUp()
    {
        parent::setUp();

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @covers CongregationFollowAction::get
     */
    public function testGet_SameCongregationId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationId = 1; //first id from congregation fixture record

        $followAction = CongregationFollowAction::get($congregationId, $congregationId);

        $this->assertEmpty($followAction);
    }

    /**
     * @covers CongregationFollowAction::get
     */
    public function testGet_Following()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationFollowId = 1; //id from CongregationFollow, follower_id 1, leader_id 2
        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

        $followAction = CongregationFollowAction::get($followerCongregationId, $leadCongregationId);

        $this->assertEquals($followAction['action'], CongregationFollowActions::STOP_FOLLOWING);
        $this->assertEquals($followAction['label'], CongregationFollowActionLabels::STOP_FOLLOWING);
        $this->assertEquals($followAction['param'], $congregationFollowId);
        $this->assertEquals($followAction['viewId'], $leadCongregationId);
    }

    /**
     * @covers CongregationFollowAction::get
     */
    public function testGet_PendingFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationFollowRequestId = 1; //id from CongregationFollowRequest fixutre, leader_id 1, requesting_follower_id 2
        $followerCongregationId = 2; //first id from congregation fixture record
        $leadCongregationId = 1; //second id from congregation fixture record

        $followAction = CongregationFollowAction::get($followerCongregationId, $leadCongregationId);

        $this->assertEquals($followAction['action'], CongregationFollowActions::CANCEL_REQUEST);
        $this->assertEquals($followAction['label'], CongregationFollowActionLabels::CANCEL_REQUEST);
        $this->assertEquals($followAction['param'], $congregationFollowRequestId);
        $this->assertEquals($followAction['viewId'], $leadCongregationId);
    }

    /**
     * @covers CongregationFollowAction::get
     */
    public function testGet_NotFollowing_NoPendingFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 4; //congregation id not following or requesting to follow congregation id 5
        $leadCongregationId = 5; //congregation id not being followed or any pending follow requests from congregation id 4

        $followAction = CongregationFollowAction::get($followerCongregationId, $leadCongregationId);

        $this->assertEquals($followAction['action'], CongregationFollowActions::ADD_REQUEST);
        $this->assertEquals($followAction['label'], CongregationFollowActionLabels::ADD_REQUEST);
        $this->assertEquals($followAction['param'], $leadCongregationId);
        $this->assertEquals($followAction['viewId'], $leadCongregationId);
    }
}
