<?php

App::uses('SkipTestEvaluator', 'Test/Lib');

class MemberBase extends CakeTestCase
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
        $this->Member = ClassRegistry::init('Member');

        $this->skipTestEvaluator = new SkipTestEvaluator($this->tests);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Member);

        parent::tearDown();
    }

    public function test()
    {
        //prevent test failure for not having a test
        $this->markTestSkipped('fake test to prevent failure for base class not having a test.');
    }
}