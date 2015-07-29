<?php

App::uses('CakeFixtureManager', 'TestSuite/Fixture');

/**
 * AppFixtureManager
 *
 * Prevents fixtures from being loaded for tests that are being skipped
 */
class AppFixtureManager extends CakeFixtureManager
{
    public function load(CakeTestCase $test)
    {
        $testName = $test->getName();
        if (array_key_exists($testName, $test->tests) && $test->tests[$testName] === 1) {parent::load($test);}
    }
}