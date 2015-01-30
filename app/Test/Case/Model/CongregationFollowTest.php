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
        
        $this->Congregation->add($this->congregationAddData);
        $followerCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'secondCongregation';                
                
        $this->Congregation->add($congregationAddSecondData);
        $leadCongregationId = $this->Congregation->id;
                
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
        
        $congregationAddThirdData = $this->congregationAddData;
        $congregationAddThirdData['Congregation']['name'] = 'thirdCongregation';                
                
        $this->Congregation->add($congregationAddThirdData);
        $leadCongregationSecondId = $this->Congregation->id;
        
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
        
        $this->Congregation->add($this->congregationAddData);
        $leaderCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'followCongregationOne';                
                
        $this->Congregation->add($congregationAddSecondData);
        $followingCongregationIdOne = $this->Congregation->id;
                
        $this->Congregation->addFollowRequest($followingCongregationIdOne, $leaderCongregationId);
        
        $congregationAddThirdData = $this->congregationAddData;
        $congregationAddThirdData['Congregation']['name'] = 'followCongregationTwo';                
                
        $this->Congregation->add($congregationAddThirdData);
        $followingCongregationIdTwo = $this->Congregation->id;
        
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
        
        $this->Congregation->add($this->congregationAddData);
        $leaderCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'followCongregationOne';                
                
        $this->Congregation->add($congregationAddSecondData);
        $followingCongregationIdOne = $this->Congregation->id;
                
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
}
