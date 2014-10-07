<?php

/**
 * CongregationFollowFixture
 *
 */
class CongregationFollowFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
        'follower_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'the id of the congregation that is following another congregation'),
        'leader_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'the id of the congregation that is being followed by another congregation'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the congregation follow was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date the congregation follow was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'follower_id' => array('column' => 'follower_id', 'unique' => 0),
            'leader_id' => array('column' => 'leader_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
    );
//
//    /**
//     * Records
//     *
//     * @var array
//     */
//    public $records = array(
//        array(
//            'id' => 1,
//            'follower_id' => 1,
//            'leader_id' => 1,
//            'created' => '2014-10-02 20:33:48',
//            'modified' => '2014-10-02 20:33:48'
//        ),
//    );

}
