<?php

App::uses('CongregationFollow', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');

/**
 * @covers CongregationFollow
 */
class CongregationFollowTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testGetFollows'    => 1,
        'testGetFollowers'  => 1,
        'testGetFollowId'   => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_follow'
    );

    public function setup()
    {
        parent::setUp();

        $this->CongregationFollow = ClassRegistry::init('CongregationFollow');

        $congregationFixture = new CongregationFixture();
        $this->congregationRecords = $congregationFixture->records;

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    public function tearDown() {
        unset($this->CongregationFollow);

        parent::tearDown();
    }

    /**
     * @covers CongregationFollow::getFollows
     */
    public function testGetFollows()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //follower id from congregationFollow fixture record
        $leadCongregationId = 2; //first congregation id being followed from congregationFollow fixture record
        $leadCongregationName = $this->congregationRecords[$leadCongregationId - 1]['name'];
        $leadCongregationSecondId = 3; //second congregation id being followed from congregationFollow fixture record
        $leadCongregationSecondName = $this->congregationRecords[$leadCongregationSecondId - 1]['name'];

        $follows = $this->CongregationFollow->getFollows($followerCongregationId);

        $this->assertEquals(count($follows), 2);
        $this->assertEquals($follows[0]['Leader']['id'], $leadCongregationId);
        $this->assertEquals($follows[0]['Leader']['name'], $leadCongregationName);
        $this->assertEquals($follows[1]['Leader']['id'], $leadCongregationSecondId);
        $this->assertEquals($follows[1]['Leader']['name'], $leadCongregationSecondName);
    }

    /**
     * @covers CongregationFollow::getFollowers
     */
    public function testGetFollowers()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $leaderCongregationId = 3; //lead id with two followers in CongregationFollow fixture
        $followingCongregationId = 1; //first congregation id following from CongregationFollow fixture record
        $followingCongregationName = $this->congregationRecords[$followingCongregationId - 1]['name'];
        $followingCongregationSecondId = 2; //second congregation id following from CongregationFollow fixture record
        $followingCongregationSecondName = $this->congregationRecords[$followingCongregationSecondId - 1]['name'];


        $followers = $this->CongregationFollow->getFollowers($leaderCongregationId);

        $this->assertEquals(count($followers), 2);
        $this->assertEquals($followers[0]['Follower']['id'], $followingCongregationId);
        $this->assertEquals($followers[0]['Follower']['name'], $followingCongregationName);
        $this->assertEquals($followers[1]['Follower']['id'], $followingCongregationSecondId);
        $this->assertEquals($followers[1]['Follower']['name'], $followingCongregationSecondName);
    }

    /**
     * @covers CongregationFollow::getFollowId
     */
    public function testGetFollowId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $leaderCongregationId = 2; //lead congregation id from CongregationFollow fixture
        $followingCongregationId = 1; //follower congregation id from CongregationFollow fixture
        $congregationFollowRecordId = 1; //id from CongregationFollow fixture

        $followId = $this->CongregationFollow->getFollowId($followingCongregationId, $leaderCongregationId);

        $this->assertEquals($congregationFollowRecordId, $followId);
    }
}
