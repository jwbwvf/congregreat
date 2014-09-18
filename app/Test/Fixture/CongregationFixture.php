<?php

/**
 * CongregationFixture
 *
 */
class CongregationFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'unsigned' => true, 'comment' => 'congregation identifier'),
        'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => 'name of the congregation', 'charset' => 'utf8'),
        'website' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 256, 'collate' => 'armscii8_general_ci', 'comment' => 'congregations website address', 'charset' => 'armscii8'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the congregation was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date the congregation was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'name' => array('column' => 'name', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
    );

    /**
     * Records
     *
     * @var array
     */
//    public $records = array(
//        array(
//            'id' => 1,
//            'name' => 'Lorem ipsum dolor sit amet',
//            'website' => 'Lorem ipsum dolor sit amet',
//            'created' => '2014-05-13 16:41:14',
//            'modified' => '2014-05-13 16:41:14'
//        ),
//    );

}
