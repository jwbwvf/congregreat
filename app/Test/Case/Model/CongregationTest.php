<?php

App::uses('Congregation', 'Model');
App::uses('SkipTestEvaluator', 'Test/Lib');
App::uses('TestHelper', 'Test/Lib');

/**
 * @covers Congregation
 */
class CongregationTest extends CakeTestCase
{
    //Add the line below at the beginning of each test
    //$this->skipTestEvaluator->shouldSkip(__FUNCTION__);
    //add test name to the array with
    //1 - run, 0 - do not run
    public $tests = array(
        'testGet'                           => 1,
        'testGet_NotFound'                  => 1,
        'testAdd'                           => 1,
        'testAdd_MissingName'               => 1,
        'testAdd_InvalidEmail'              => 1,
        'testAdd_InvalidAddress'            => 1,
        'testAdd_InvalidPhoneNumber'        => 1,
        'testDelete'                        => 1,
        'testGetTasks'                      => 1,
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
        'app.task',
        'app.announcement_request',
        'app.announcement',
        'app.member'
    );

    public function setUp()
    {
        parent::setUp();

        $this->Congregation = ClassRegistry::init('Congregation');

        if (in_array(1, $this->tests, true))
        {
            $congregationFixture = new CongregationFixture();
            $this->congregationRecords = $congregationFixture->records;
        }

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    public function tearDown()
    {
        unset($this->Congregation);

        parent::tearDown();
    }

    /**
     * @covers Congregation::get
     */
    public function testGet()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationRecord = $this->congregationRecords[0];
        $congregation = $this->Congregation->get($congregationRecord['id']);

        $this->assertEquals($congregationRecord['id'], $congregation['Congregation']['id']);
        $this->assertEquals($congregationRecord['name'], $congregation['Congregation']['name']);
        $this->assertEquals($congregationRecord['website'], $congregation['Congregation']['website']);
    }

    /**
     * @covers Congregation::get
     * @expectedException NotFoundException
     */
    public function testGet_NotFound()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationId = TestHelper::getNonFixtureId($this->congregationRecords);

        $this->Congregation->get($congregationId);
    }

    /**
     * test adding a congregation with all of it's related data: phone, email, address
     * @covers Congregation::add
     * @covers Congregation::save
     * @covers Congregation::isValid
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

        $this->assertEquals($this->congregationAddData['Congregation']['name'], $row['congregations']['name']);
        $this->assertEquals($this->congregationAddData['Congregation']['website'], $row['congregations']['website']);
        $this->assertEquals($this->congregationAddData['CongregationEmailAddress']['email_address'], $row['congregation_email_addresses']['email_address']);
        $this->assertEquals($this->congregationAddData['CongregationPhone']['number'], $row['congregation_phones']['number']);
        $this->assertEquals($this->congregationAddData['CongregationPhone']['type'], $row['congregation_phones']['type']);
        $this->assertEquals($this->congregationAddData['CongregationAddress']['street_address'], $row['congregation_addresses']['street_address']);
        $this->assertEquals($this->congregationAddData['CongregationAddress']['city'], $row['congregation_addresses']['city']);
        $this->assertEquals($this->congregationAddData['CongregationAddress']['state'], $row['congregation_addresses']['state']);
        $this->assertEquals($this->congregationAddData['CongregationAddress']['zipcode'], $row['congregation_addresses']['zipcode']);
        $this->assertEquals($this->congregationAddData['CongregationAddress']['country'], $row['congregation_addresses']['country']);
    }

    /**
     * test adding a congregation that is missing a name
     * @covers Congregation::add
     * @covers Congregation::isValid
     */
    public function testAdd_MissingName()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('Congregation', 'name', '');
    }

    /**
     * test adding a congregation that has an invalid email address
     * @covers Congregation::add
     * @covers Congregation::isValid
     */
    public function testAdd_InvalidEmail()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('CongregationEmailAddress', 'email_address', 'invalidEmail@nowhere');
    }

    /**
     * test adding a congregation that has an invalid address
     * @covers Congregation::add
     * @covers Congregation::isValid
     */
    public function testAdd_InvalidAddress()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $this->validate('CongregationAddress', 'zipcode', '6405A');
    }

    /**
     * test adding a congregation that has an invalid phone number
     * @covers Congregation::add
     * @covers Congregation::isValid
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
     * @covers Congregation::getTasks
     */
    public function testGetTasks()
    {
        $this->skipTestEvaluator->shouldSkip(__FUNCTION__);

        $congregationId = 1;//congregation id from task fixture, 2 tasks

        $tasks = $this->Congregation->getTasks($congregationId);

        $this->assertEquals(2, count($tasks));
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
