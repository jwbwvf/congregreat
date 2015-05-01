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
        'testAdd'                           => 1,
        'testAdd_MissingName'               => 1,
        'testAdd_InvalidEmail'              => 1,
        'testAdd_InvalidAddress'            => 1,
        'testAdd_InvalidPhoneNumber'        => 1,
        'testDelete'                        => 1,
        'testAddFollowRequest'              => 1,
        'testRejectFollowRequest'           => 1,
        'testAcceptFollowRequest'           => 1,
        'testCancelFollowRequest'           => 1,
        'testStopFollowing'                 => 1,
        'testGetFollowAction'               => 1,
        'testGetFollowAction_SameCongregationId'                    => 1,
        'testGetFollowAction_Following'                             => 1,
        'testGetFollowAction_PendingFollowRequest'                  => 1,
        'testGetFollowAction_NotFollowing_NoPendingFollowRequest'   => 1,
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.congregation_address',
        'app.congregation_email_address',
        'app.congregation_phone',
        'app.congregation_follow_request',
        'app.congregation_follow',
        'app.task'
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
        $this->assertEqual($this->congregationAddData['CongregationEmailAddress']['email_address'], $row['congregation_email_addresses']['email_address']);
        $this->assertEqual($this->congregationAddData['CongregationPhone']['number'], $row['congregation_phones']['number']);
        $this->assertEqual($this->congregationAddData['CongregationPhone']['type'], $row['congregation_phones']['type']);
        $this->assertEqual($this->congregationAddData['CongregationAddress']['street_address'], $row['congregation_addresses']['street_address']);
        $this->assertEqual($this->congregationAddData['CongregationAddress']['city'], $row['congregation_addresses']['city']);
        $this->assertEqual($this->congregationAddData['CongregationAddress']['state'], $row['congregation_addresses']['state']);
        $this->assertEqual($this->congregationAddData['CongregationAddress']['zipcode'], $row['congregation_addresses']['zipcode']);
        $this->assertEqual($this->congregationAddData['CongregationAddress']['country'], $row['congregation_addresses']['country']);
    }

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

        $this->validate('CongregationEmailAddress', 'email_address', 'invalidEmail@nowhere');
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

        $this->validate('CongregationAddress', 'zipcode', '6405A');
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

        $this->validate('CongregationPhone', 'number', '5555-555-5555');
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

        $congregationId = 1;
        $this->Congregation->id = $congregationId; //id from congregation record in fixture

        $this->Congregation->delete($congregationId);

        $sqlAfterDeleteCongregation = "SELECT * FROM congregations WHERE id='" . $congregationId . "'";
        $sqlAfterDeleteAddress = "SELECT * FROM congregation_addresses WHERE congregation_id='" . $congregationId . "'";
        $sqlAfterDeletePhone = "SELECT * FROM congregation_phones WHERE id='" . $congregationId . "'";
        $sqlAfterDeleteEmailAddress = "SELECT * FROM congregation_email_addresses WHERE id='" . $congregationId . "'";

        $dbo = $this->Congregation->getDataSource();

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
     *
     * @covers Congregation::addFollowRequest
     */
    public function testAddFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

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

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

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

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

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

    public function testCancelFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);

        $dbo = $this->Congregation->getDataSource();
        $sql = "SELECT id, status FROM congregation_follow_requests WHERE leader_id='" . $leadCongregationId . "' AND "
                . "requesting_follower_id='" . $followerCongregationId . "'";

        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();
        $congregationFollowRequestId = $row['congregation_follow_requests']['id'];

        $this->Congregation->cancelFollowRequest($congregationFollowRequestId);

        $dbo->rawQuery($sql);
        $rowAfterAccept = $dbo->fetchRow();

        $this->assertEquals(CongregationFollowRequestStatus::CANCELLED,
                $rowAfterAccept['congregation_follow_requests']['status']);
    }

    public function testStopFollowing()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

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

    public function testGetFollowAction_SameCongregationId()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationId = 1; //first id from congregation fixture record

        $followAction = $this->Congregation->getFollowAction($congregationId, $congregationId);

        $this->assertEmpty($followAction);
    }

    public function testGetFollowAction_Following()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);

        $followRequests  = $this->Congregation->getFollowRequests($leadCongregationId);
        foreach ($followRequests as $followRequest)
        {
            $this->Congregation->acceptFollowRequest($followRequest['CongregationFollowRequest']['id']);
        }

        $followAction = $this->Congregation->getFollowAction($followerCongregationId, $leadCongregationId);
        $followId = $this->Congregation->CongregationFollow->getFollowId($followerCongregationId, $leadCongregationId);

        $this->assertEquals($followAction['action'], CongregationFollowActions::STOP);
        $this->assertEquals($followAction['label'], CongregationFollowActionLabels::STOP);
        $this->assertEquals($followAction['param'], $followId);
        $this->assertEquals($followAction['viewId'], $leadCongregationId);
    }

    public function testGetFollowAction_PendingFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

        $this->Congregation->addFollowRequest($followerCongregationId, $leadCongregationId);

        $followAction = $this->Congregation->getFollowAction($followerCongregationId, $leadCongregationId);
        $pendingFollowRequestId = $this->Congregation->CongregationFollowRequest->getPendingFollowRequestId($leadCongregationId, $followerCongregationId);

        $this->assertEquals($followAction['action'], CongregationFollowActions::CANCEL);
        $this->assertEquals($followAction['label'], CongregationFollowActionLabels::CANCEL);
        $this->assertEquals($followAction['param'], $pendingFollowRequestId);
        $this->assertEquals($followAction['viewId'], $leadCongregationId);
    }

    public function testGetFollowAction_NotFollowing_NoPendingFollowRequest()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $followerCongregationId = 1; //first id from congregation fixture record
        $leadCongregationId = 2; //second id from congregation fixture record

        $followAction = $this->Congregation->getFollowAction($followerCongregationId, $leadCongregationId);

        $this->assertEquals($followAction['action'], CongregationFollowActions::REQUEST);
        $this->assertEquals($followAction['label'], CongregationFollowActionLabels::REQUEST);
        $this->assertEquals($followAction['param'], $leadCongregationId);
        $this->assertEquals($followAction['viewId'], $leadCongregationId);
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

        if ($this->Congregation->add($data))
        {
            //returns the validation rule data
            $validationMessage = $this->Congregation->$model->validate[$key]['message'];
            //returns any validation errors that occurred on save
            $validationErrors = $this->Congregation->$model->validationErrors;
        }
        else
        {
            //returns the validation rule data
            $validationMessage = $this->Congregation->validate[$key]['message'];
            //returns any validation errors that occurred on save
            $validationErrors = $this->Congregation->validationErrors;
        }
        $this->assertEquals($validationErrors[$key][0], $validationMessage);
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
            congregation_addresses.street_address,
            congregation_addresses.city, congregation_addresses.state,
            congregation_addresses.zipcode, congregation_addresses.country, congregation_addresses.id,
            congregation_email_addresses.email_address, congregation_email_addresses.id,
            congregation_phones.number, congregation_phones.type, congregation_phones.id
            FROM congregations
            JOIN congregation_addresses ON congregations.id = congregation_addresses.congregation_id
            JOIN congregation_phones ON congregations.id = congregation_phones.congregation_id
            JOIN congregation_email_addresses ON congregations.id = congregation_email_addresses.congregation_id
            WHERE congregations.name = 'testCongregation'";
    }

    public $congregationAddData = array(
        'Congregation' => array(
            'name' => 'testCongregation',
            'website' => 'testCongregation.org'
        ),
        'CongregationEmailAddress' => array(
            'email_address' => 'test@test.com'
        ),
        'CongregationPhone' => array(
            'number' => '555-555-5555',
            'type' => 'home'
        ),
        'CongregationAddress' => array(
            'street_address' => '123 elm st.',
            'city' => 'kc',
            'state' => 'Missouri',
            'zipcode' => '66066',
            'country' => 'United States'
        )
    );
}
