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
        $followerCongregationSecondId = $this->Congregation->id;
        
        $this->Congregation->addFollowRequest($followerCongregationSecondId, $leadCongregationId);
        
        $followRequests  = $this->Congregation->getFollowRequests($leadCongregationId);        
        $this->assertEqual(2, count($followRequests));        
    }
    
    public function testGetMyPendingRequests()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
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
        
        $followRequests  = $this->Congregation->getMyPendingRequests($followerCongregationId);        
        $this->assertEqual(2, count($followRequests));           
    }
    
    public function testGetPendingFollowRequestId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        $followerCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'secondCongregation';                
                
        $this->Congregation->add($congregationAddSecondData);
        $leadCongregationId = $this->Congregation->id;
                
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
        
        $followRequestId = $this->Congregation->CongregationFollowRequest->getPendingFollowRequestId($leadCongregationId, $followerCongregationId);
        $this->assertTrue($followRequestId != 0);
    }    
}
