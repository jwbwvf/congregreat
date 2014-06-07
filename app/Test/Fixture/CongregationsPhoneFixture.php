<?php

/**
 * CongregationsPhoneFixture
 *
 */
class CongregationsPhoneFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'phone identifier'),
        'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'congregation identifier'),
        'phone_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date phone number was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date phone number was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'organization_id' => array('column' => 'congregation_id', 'unique' => 0),
            'phone_id' => array('column' => 'phone_id', 'unique' => 0)
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
//            'congregation_id' => 1,
//            'phone_id' => 1,
//            'created' => '2014-05-22 20:50:59',
//            'modified' => '2014-05-22 20:50:59'
//        ),
//    );

}
