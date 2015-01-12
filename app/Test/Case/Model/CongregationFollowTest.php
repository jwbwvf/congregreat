<?php

App::uses('CongregationFollow', 'Model');

/**
 * CongregationFollow Test Case
 *
 */
class CongregationFollowTest extends CakeTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        //'app.congregation_follow',
        //'app.follower',
        //'app.leader'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->CongregationFollow = ClassRegistry::init('CongregationFollow');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CongregationFollow);

        parent::tearDown();
    }

    public function test()
    {
        //prevent test failure for not having a test
        $this->markTestSkipped('fake test to prevent failure for base class not having a test.');
    }

}
