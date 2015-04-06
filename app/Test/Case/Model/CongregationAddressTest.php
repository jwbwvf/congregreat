<?php

App::uses('Congregation', 'Model');
App::uses('CongregationBase', 'Test/Case/Model');

class CongregationAddressTest extends CongregationBase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    protected $tests = array(
        'testAdd'                => 1,
        'testAdd_InvalidState'   => 1,
        'testAdd_InvalidZipcode' => 1,
        'testDelete'             => 1,
        'testDelete_IsInUse'     => 1,
    );

    public function testAdd()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $addressData = array(
            'Congregation' => array('id' => 1), //id from congregation fixture record
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'Florida',
                'zipcode' => '66000',
                'country' => 'United States'
            )
        );

        $return = $this->Congregation->addAddress($addressData);
        $this->assertNotEqual(false, $return);

        $sql  = $this->buildCongregationsAddressQuery($return['Address']['id']);

        $dbo = $this->Congregation->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertEqual($addressData['Address']['street_address'], $row['addresses']['street_address']);
        $this->assertEqual($addressData['Address']['city'], $row['addresses']['city']);
        $this->assertEqual($addressData['Address']['state'], $row['addresses']['state']);
        $this->assertEqual($addressData['Address']['zipcode'], $row['addresses']['zipcode']);
        $this->assertEqual($addressData['Address']['country'], $row['addresses']['country']);
        $this->assertEqual($addressData['Congregation']['id'], $row['congregations']['id']);
    }

    public function testAdd_InvalidState()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $addressData = array(
            'Congregation' => array('id' => 1), //id from congregation fixture record
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'invalid',
                'zipcode' => '66000',
                'country' => 'United States'
            )
        );

        $return = $this->Congregation->addAddress($addressData);

        $this->assertEqual(false, $return);
    }

    public function testAdd_InvalidZipcode()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $addressData = array(
            'Congregation' => array('id' => 1), //id from congregation fixture record
            'Address' => array(
                'street_address' => '555 elm grove',
                'city' => 'stl',
                'state' => 'Florida',
                'zipcode' => '6600A',
                'country' => 'United States'
            )
        );

        $return = $this->Congregation->addAddress($addressData);

        $this->assertEqual(false, $return);
    }

    public function testDelete()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->Congregation->id = 1; //id from congregation fixture record

        $sql = "SELECT addresses_congregations.address_id, addresses.id
                FROM addresses_congregations
                JOIN addresses ON addresses_congregations.address_id = addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";

        $dbo = $this->Congregation->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertNotNull($row['addresses_congregations']['address_id']);
        $addressId = $row['addresses']['id'];
        $this->assertNotNull($addressId);

        $this->Congregation->deleteAddress($addressId);

        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();

        $this->assertNull($rowAfter['addresses_congregations']['address_id']);
        $this->assertNull($rowAfter['addresses']['id']);

        $sqlAddress = "SELECT id
                     FROM addresses where addresses.id= '" . $addressId . "'";

        $dbo->rawQuery($sqlAddress);
        $rowAddress = $dbo->fetchRow();

        $this->assertNull($rowAddress['addresses']['id']);
    }

    public function testDelete_IsInUse()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $addressData = array(
            'COngregation' => array('id' => 2), //id from congregation fixture record
            'Address' => array(
                'street_address' => 'test street address',
                'city' => 'test city',
                'state' => 'test state',
                'zipcode' => '66066',
                'country' => 'test country',
            )
        );

        $return = $this->Congregation->addAddress($addressData);

        $this->assertNotEqual(false, $return);

        $this->Congregation->id = 1; //id from congregation fixture record

        $sql = "SELECT addresses_congregations.address_id, addresses.id
                FROM addresses_congregations
                JOIN addresses ON addresses_congregations.address_id = addresses.id
                WHERE congregation_id= '" . $this->Congregation->id . "'";

        $dbo = $this->Congregation->getDataSource();
        $dbo->rawQuery($sql);
        $row = $dbo->fetchRow();

        $this->assertNotNull($row['addresses_congregations']['address_id']);
        $addressId = $row['addresses']['id'];
        $this->assertNotNull($addressId);

        $this->Congregation->deleteAddress($addressId);

        $dbo->rawQuery($sql);
        $rowAfter = $dbo->fetchRow();

        $this->assertNull($rowAfter['addresses_congregations']['address_id']);
        $this->assertNull($rowAfter['addresses']['id']);

        $sqlAddress = "SELECT id
                     FROM addresses where addresses.id= '" . $addressId . "'";

        $dbo->rawQuery($sqlAddress);
        $rowAddress = $dbo->fetchRow();

        $this->assertNotNull($rowAddress['addresses']['id']);
    }

    private function buildCongregationsAddressQuery($addressId)
    {
        return "SELECT
                congregations.id,
                addresses.street_address, addresses.city, addresses.state, addresses.zipcode, addresses.country
                FROM addresses
                JOIN addresses_congregations ac ON addresses.id = ac.address_id
                JOIN congregations ON ac.congregation_id = congregations.id
                WHERE addresses.id = '" . $addressId . "'";
    }

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.address',
        'app.addresses_congregation',
        //needed because the Address.isInUse checks for member or congregation using the address
        'app.member',
        'app.addresses_member',
    );
}
