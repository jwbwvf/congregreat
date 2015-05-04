<?php

class SkipTestEvaluator
{
    private $tests;

    public function __construct($tests)
    {
        $this->tests = $tests;
    }

    public function shouldSkip($test)
    {
        try {
            $run = $this->tests[$test];
        } catch (Exception $ex) {
            //nothing to do but run the test
            $run = 0;
        }

        if (!$run) { PHPUnit_Framework_Assert::markTestSkipped('Skipping on purpose.'); }
    }
}

