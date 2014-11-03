<?php

App::uses('Congregation', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');
App::uses('CongregationFollowRequestStatus', 'Model');

/**
 * Congregation Test Case
 *
 */
class CongregationTest extends CongregationBase
{    
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testAdd'                           => 0,        
        'testAdd_MissingName'               => 0,
        'testAdd_InvalidEmail'              => 0,
        'testAdd_InvalidAddress'            => 0,
        'testAdd_InvalidPhoneNumber'        => 0,                
        'testDelete'                        => 0,
        'testDelete_ExistingAssociations'   => 0,
        'testAddFollowRequest'              => 0,
        'testRejectFollowRequest'           => 0,
        'testAcceptFollowRequest'           => 0,
        'testGetFollowRequests'             => 0,
        'testGetFollows'                    => 0,
        'testGetFollowers'                  => 1,        
        'testStopFollowing'                 => 0,
    );
    
    /**
     * test adding a congregation with all of it's related data: phone, email, address
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     * @covers Congregation::saveModels
     * @covers Congregation::saveRelatedModel
     */
    public function testAdd()
    {                           
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $return = $this->Congregation->add($this->congregationAddData);
        $this->assertTrue($return);
        
        $dbo = $this->Congregation->getDataSource();
        $sql = $this->buildCongregationsAddDataQuery();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->assertEqual($this->congregationAddData['Congregation']['name'], $row['congregations']['name']);
        $this->assertEqual($this->congregationAddData['Congregation']['website'], $row['congregations']['website']);
        $this->assertEqual($this->congregationAddData['EmailAddress']['email_address'], $row['email_addresses']['email_address']);
        $this->assertEqual($this->congregationAddData['Phone']['number'], $row['phones']['number']);
        $this->assertEqual($this->congregationAddData['Phone']['type'], $row['phones']['type']);
        $this->assertEqual($this->congregationAddData['Address']['street_address'], $row['addresses']['street_address']);
        $this->assertEqual($this->congregationAddData['Address']['city'], $row['addresses']['city']);
        $this->assertEqual($this->congregationAddData['Address']['state'], $row['addresses']['state']);
        $this->assertEqual($this->congregationAddData['Address']['zipcode'], $row['addresses']['zipcode']);
        $this->assertEqual($this->congregationAddData['Address']['country'], $row['addresses']['country']);
    } 

    //todo add tests for multiple congregations
    //some sharing data others not sharing any 
    
    /**
     * test adding a congregation that is missing a name
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */
    public function testAdd_MissingName()
    {        
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('Congregation', 'name', '');
    }

    /**
     * test adding a congregation that has an invalid email address
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */
    public function testAdd_InvalidEmail()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('EmailAddress', 'email_address', 'invalidEmail@nowhere');      
    }    

    /**
     * test adding a congregation that has an invalid address
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */
    public function testAdd_InvalidAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('Address', 'zipcode', '6405A');
    }        
    
    /**
     * test adding a congregation that has an invalid phone number
     * @covers Congregation::add
     * @covers Congregation::createModels
     * @covers Congregation::areModelsValid
     */    
    public function testAdd_InvalidPhoneNumber()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->validate('Phone', 'number', '5555-555-5555');       
    }     
    
    /**
     * test deleting a congregation and all it's
     * associated models
     * @covers Congregation::delete
     * @covers Congregation::deleteAddress
     * @covers Congregation::deleteEmailAddress
     * @covers Congregation::deletePhoneNumber
     * @covers Congregation::deleteModel
     */
    public function testDelete()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);      
        
        $dbo = $this->Congregation->getDataSource();
        $sql = $this->buildCongregationsAddDataQuery();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->Congregation->delete($row['congregations']['id']);
        
        $sqlAfterDeleteCongregation = "SELECT * FROM congregations WHERE id='" . $row['congregations']['id'] . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM addresses WHERE id='" . $row['addresses']['id'] . "'";
        $sqlAfterDeletePhone = "SELECT * FROM phones WHERE id='" . $row['phones']['id'] . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM email_addresses WHERE id='" . $row['email_addresses']['id'] . "'";
        
        $dbo->rawQuery($sqlAfterDeleteCongregation);
        $rowAfterDeleteCongregation = $dbo->fetchRow();        
        $this->assertFalse($rowAfterDeleteCongregation);
        
        $dbo->rawQuery($sqlAfterDeleteAddress);
        $rowAfterDeleteAddress = $dbo->fetchRow();        
        $this->assertFalse($rowAfterDeleteAddress);
        
        $dbo->rawQuery($sqlAfterDeletePhone);
        $rowAfterDeletePhone = $dbo->fetchRow();        
        $this->assertFalse($rowAfterDeletePhone);
        
        $dbo->rawQuery($sqlAfterDeleteEmailAddress);
        $rowAfterDeleteEmailAddress = $dbo->fetchRow();        
        $this->assertFalse($rowAfterDeleteEmailAddress);        
    }
    
    /**
     * test deleting a congregation that has the same 
     * address, email address, phone number associated
     * to another congregation
     * @covers Congregation::delete
     * @covers Congregation::deleteAddress
     * @covers Congregation::deleteEmailAddress
     * @covers Congregation::deletePhoneNumber
     * @covers Congregation::deleteModel
     */
    public function testDelete_ExistingAssociations()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);        
        
        $secondCongregationData = $this->congregationAddData;
        $secondCongregationData['Congregation']['name'] = 'secondName';
        
        $this->Congregation->add($secondCongregationData);        
        
        $dbo = $this->Congregation->getDataSource();
        $sql = $this->buildCongregationsAddDataQuery();        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        
        $this->Congregation->delete($row['congregations']['id']);
        
        $sqlAfterDeleteCongregation = "SELECT * FROM congregations WHERE id='" . $row['congregations']['id'] . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM addresses WHERE id='" . $row['addresses']['id'] . "'";
        $sqlAfterDeletePhone = "SELECT * FROM phones WHERE id='" . $row['phones']['id'] . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM email_addresses WHERE id='" . $row['email_addresses']['id'] . "'";
        
        $dbo->rawQuery($sqlAfterDeleteCongregation);
        $rowAfterDeleteCongregation = $dbo->fetchRow();        
        $this->assertFalse($rowAfterDeleteCongregation);
        
        $dbo->rawQuery($sqlAfterDeleteAddress);
        $rowAfterDeleteAddress = $dbo->fetchRow();        
        $this->assertEquals($rowAfterDeleteAddress['addresses']['id'], $row['addresses']['id']);
        
        $dbo->rawQuery($sqlAfterDeletePhone);
        $rowAfterDeletePhone = $dbo->fetchRow();        
        $this->assertEquals($rowAfterDeletePhone['phones']['id'], $row['phones']['id']);
        
        $dbo->rawQuery($sqlAfterDeleteEmailAddress);
        $rowAfterDeleteEmailAddress = $dbo->fetchRow();        
        $this->assertEquals($rowAfterDeleteEmailAddress['email_addresses']['id'], $row['email_addresses']['id']);         
    }
    
    /**
     * 
     * @covers Congregation::addFollowRequest
     */
    public function testAddFollowRequest()            
    {       
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        $followerCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'secondCongregation';                

        $this->Congregation->add($congregationAddSecondData);
        $leadCongregationId = $this->Congregation->id;
        
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
       
        $dbo = $this->Congregation->getDataSource();
        $sql = "SELECT * FROM congregation_follow_requests WHERE leader_id='" . $leadCongregationId . "' AND "
                . "requesting_follower_id='" . $followerCongregationId . "'";
        $all = $dbo->fetchAll($sql);
        
        $this->assertEquals(1, count($all));
        $this->assertEquals(CongregationFollowRequestStatus::PENDING, $all[0]['congregation_follow_requests']['status']);
    }    
    
    public function testRejectFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        $followerCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'secondCongregation';                

        $this->Congregation->add($congregationAddSecondData);
        $leadCongregationId = $this->Congregation->id;
        
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
       
        $dbo = $this->Congregation->getDataSource();
        $sql = "SELECT id, status FROM congregation_follow_requests WHERE leader_id='" . $leadCongregationId . "' AND "
                . "requesting_follower_id='" . $followerCongregationId . "'";
        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        $congregationFollowRequestId = $row['congregation_follow_requests']['id'];
        $this->Congregation->rejectFollowRequest($congregationFollowRequestId);
        
        $dbo->rawQuery($sql);        
        $rowAfterReject = $dbo->fetchRow();
        
        //$this->assertEquals(1, count($allAfterReject));
        $this->assertEquals(CongregationFollowRequestStatus::REJECTED, 
                $rowAfterReject['congregation_follow_requests']['status']);        
    }
    
    public function testAcceptFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        $followerCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'secondCongregation';                

        $this->Congregation->add($congregationAddSecondData);
        $leadCongregationId = $this->Congregation->id;
        
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);
       
        $dbo = $this->Congregation->getDataSource();
        $sql = "SELECT id, status FROM congregation_follow_requests WHERE leader_id='" . $leadCongregationId . "' AND "
                . "requesting_follower_id='" . $followerCongregationId . "'";
        
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        $congregationFollowRequestId = $row['congregation_follow_requests']['id'];
        
        $this->Congregation->acceptFollowRequest($congregationFollowRequestId);
        
        $dbo->rawQuery($sql);        
        $rowAfterAccept = $dbo->fetchRow();
        
        $this->assertEquals(CongregationFollowRequestStatus::ACCEPTED, 
                $rowAfterAccept['congregation_follow_requests']['status']);      
        
        $sqlFollow = "SELECT id FROM congregation_follows WHERE leader_id='" . $leadCongregationId . "' AND "
                . "follower_id='" . $followerCongregationId . "'";
        
        $dbo->rawQuery($sqlFollow);
        $rowFollow = $dbo->fetchRow();
        
        $this->assertTrue(!empty($rowFollow));
    }    
    
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
    
    public function testStopFollowing()
    {
       $this->skipTestEvaluator->shouldSkip(__FUNCTION__);
        
        $this->Congregation->add($this->congregationAddData);
        $followerCongregationId = $this->Congregation->id;
        
        $congregationAddSecondData = $this->congregationAddData;
        $congregationAddSecondData['Congregation']['name'] = 'secondCongregation';                
                
        $this->Congregation->add($congregationAddSecondData);
        $leadCongregationId = $this->Congregation->id;
                
        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);                
        
        $followRequests  = $this->Congregation->getFollowRequests($leadCongregationId);        
        foreach ($followRequests as $followRequest)
        {
            $this->Congregation->acceptFollowRequest($followRequest['CongregationFollowRequest']['id']);
        }        
        
        $follows = $this->Congregation->getFollows($followerCongregationId);
        $this->assertEqual(1, count($follows));
        
        $this->Congregation->stopFollowing($follows[0]['CongregationFollow']['id']);
        
        $afterSopFollows = $this->Congregation->getFollows($followerCongregationId);
        $this->assertEqual(0, count($afterSopFollows));
    }
    
    /**
     * helper method to validate the key value pairs are invalid
     * @param string $key field to be saved
     * @param string $value value of the field to be saved
     */
    private function validate($model, $key, $value)
    {
        $data = $this->congregationAddData;
        $data[$model][$key] = $value;
        
        $result = $this->Congregation->add($data);
        $this->assertFalse($result); 
    }          

    /**
     * builds the query to retrieve the congregation
     * and all it's associated data from an add
     * @return string
     */
    private function buildCongregationsAddDataQuery()
    {
        return "SELECT
            congregations.name, congregations.website, congregations.id,
            addresses.street_address, addresses.city, addresses.state, addresses.zipcode, addresses.country, addresses.id,
            email_addresses.email_address, email_addresses.id,
            phones.number, phones.type, phones.id
            FROM congregations
            JOIN addresses_congregations ac ON congregations.id = ac.congregation_id
            JOIN congregations_phones cp ON congregations.id = cp.congregation_id
            JOIN congregations_email_addresses cea ON congregations.id = cea.congregation_id
            JOIN addresses ON ac.address_id = addresses.id
            JOIN email_addresses ON cea.email_address_id = email_addresses.id
            JOIN phones ON cp.phone_id = phones.id
            WHERE congregations.name = 'testCongregation'";        
    }    
}
