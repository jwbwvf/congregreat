<?php

App::uses('SkipTestEvaluator', 'Test/Lib');

class CongregationBase extends CakeTestCase
{
    protected $skipTestEvaluator;


    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Congregation = ClassRegistry::init('Congregation');

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
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

    public function test()
    {
        //prevent test failure for not having a test
        $this->markTestSkipped('fake test to prevent failure for base class not having a test.');
    }
}
