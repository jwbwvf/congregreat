<?php

/**
 * CongregationFollowRequestFixture
 *
 */
class CongregationFollowRequestFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
        'leader_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'the id of the congregation that is being asked to be followed by another congregation'),
        'requesting_follower_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'the id of the congregation that is requesting to follow another congregation'),
        'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => true, 'comment' => 'the status of the request - pending, accepted, denied'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the request was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the last time the request was updated'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'leader_id' => array('column' => 'leader_id', 'unique' => 0),
            'requesting_follower_id' => array('column' => 'requesting_follower_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
    );

//    /**
//     * Records
//     *
//     * @var array
//     */
//    public $records = array(
//        array(
//            'id' => 1,
//            'leader_id' => 1,
//            'requesting_follower_id' => 1,
//            'status' => 1,
//            'created' => '2014-09-23 18:23:49',
//            'modified' => '2014-09-23 18:23:49'
//        ),
//    );

}
