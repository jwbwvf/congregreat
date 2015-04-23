<?php

class TestHelper
{
    /**
     * Finds an id that will not exist in the database at the start of a test
     * @return int
     */
    public static function getNonFixtureId($records)
    {
        $ids = array();

        foreach($records as $record)
        {
            $ids[] = $record['id'];
        }

        for($count = 1; $count < count($ids); $count++)
        {
            if(!in_array($count, $ids)) {return $count;}
        }
    }
}

