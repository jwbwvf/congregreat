<?php

class CongregationBase extends CakeTestCase
{

public $congregationAddData = array(
        'Congregation' => array(
            'name' => 'testCongregation',
            'website' => 'testCongregation.org'
        ),
        'EmailAddress' => array(
            'email_address' => 'test@test.com'
        ),
        'Phone' => array(
            'number' => '555-555-5555',
            'type' => 'home'
        ),
        'Address' => array(
            'street_address' => '123 elm st.',
            'city' => 'kc',
            'state' => 'Missouri',
            'zipcode' => '66066',
            'country' => 'United States'
        )
    );

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.congregation',
        'app.address',
        'app.addresses_congregation',
        'app.email_address',
        'app.congregations_email_address',
        'app.phone',
        'app.congregations_phone'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Congregation = ClassRegistry::init('Congregation');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Congregation);

        parent::tearDown();
    }
}
