<?php

App::uses('Congregation', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');

class CongregationEmailAddressTest extends CongregationBase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testAdd'                       => 1,
        'testAdd_InvalidEmailAddress'   => 1,
        'testDelete'                    => 1,
        'testDelete_IsInUse'            => 1,
    );

    /**
     * test adding an email address to an existing congregation
     * @covers Congregation::addEmailAddress
     * @covers Congregation::isRelatedModelValid
     */
    public function testAdd()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $emailAddressData = array(
            'Congregation' => array('id' => 1), //id from congregation fixture record
            'EmailAddress' => array('email_address' => 'emailAddress@emails.com')
        );

        $return = $this->Congregation->addEmailAddress($emailAddressData);

        $this->assertNotEqual(false, $return);

        $sql  = $this->buildCongregationsEmailAddressQuery($return['EmailAddress']['id']);

        $dbo = $this->Congregation->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($emailAddressData['EmailAddress']['email_address'], $row['email_addresses']['email_address']);
        $this->assertEqual($emailAddressData['Congregation']['id'], $row['congregations']['id']);
    }

    /**
     * tests adding an invalid email address to an existing congregation
     * @covers Congregation::addEmailAddress
     * @covers Congregation::isRelatedModelValid
     */
    public function testAdd_InvalidEmailAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $emailAddressData = array(
            'Congregation' => array('id' => 1),
            'EmailAddress' => array('email_address' => 'emailAddressemails.com')
        );

        $return = $this->Congregation->addEmailAddress($emailAddressData);

        $this->assertFalse($return);
    }

    public function testDelete()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->Congregation->id = 1; //id from congregation fixture record

        $sql = "SELECT congregations_email_addresses.email_address_id, email_addresses.id
                FROM congregations_email_addresses
                JOIN email_addresses ON congregations_email_addresses.email_address_id = email_addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";

        $dbo = $this->Congregation->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertNotNull($row['congregations_email_addresses']['email_address_id']);
        $emailAddressId = $row['email_addresses']['id'];
        $this->assertNotNull($emailAddressId);

        $this->Congregation->deleteEmailAddress($emailAddressId);

        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();

        $this->assertNull($rowAfter['congregations_email_addresses']['email_address_id']);
        $this->assertNull($rowAfter['email_addresses']['id']);

        $sqlEmailAddress = "SELECT id
                     FROM email_addresses where email_addresses.id= '" . $emailAddressId . "'";

        $dbo->rawQuery($sqlEmailAddress);
        $rowEmailAddress = $dbo->fetchRow();

        $this->assertNull($rowEmailAddress['email_addresses']['id']);
    }

    public function testDelete_IsInUse()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $emailAddressData = array(
            'Congregation' => array('id' => 2), //id from congregation fixture record
            'EmailAddress' => array('email_address' => 'emailAddress@emails.com')
        );

        $this->Congregation->addEmailAddress($emailAddressData);

        $this->Congregation->id = 1; //id from congregation fixture record

        $sql = "SELECT congregations_email_addresses.email_address_id, email_addresses.id
                FROM congregations_email_addresses
                JOIN email_addresses ON congregations_email_addresses.email_address_id = email_addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";

        $dbo = $this->Congregation->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertNotNull($row['congregations_email_addresses']['email_address_id']);
        $emailAddressId = $row['email_addresses']['id'];
        $this->assertNotNull($emailAddressId);

        $this->Congregation->deleteEmailAddress($emailAddressId);

        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();

        $this->assertNull($rowAfter['congregations_email_addresses']['email_address_id']);
        $this->assertNull($rowAfter['email_addresses']['id']);

        $sqlEmailAddress = "SELECT id
                     FROM email_addresses where email_addresses.id= '" . $emailAddressId . "'";

        $dbo->rawQuery($sqlEmailAddress);
        $rowEmailAddress = $dbo->fetchRow();

        $this->assertNotNull($rowEmailAddress['email_addresses']['id']);
    }

    /**
     * builds the query to retrieve the congregations
     * associated to the email address
     * @param int $emailAddressId
     * @return string
     */
    private function buildCongregationsEmailAddressQuery($emailAddressId)
    {
        return "SELECT
                congregations.id,
                email_addresses.email_address
                FROM email_addresses
                JOIN congregations_email_addresses cea ON email_addresses.id = cea.email_address_id
                JOIN congregations ON cea.congregation_id = congregations.id
                WHERE email_addresses.id = '" . $emailAddressId . "'";
    }

     /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.email_address',
        'app.congregations_email_address',
        //needed because the Phone.isInUse checks for member or congregation using the phone number
        'app.member',
        'app.email_addresses_member'
    );
}