<?php

/**
 * PhoneFixture
 *
 */
class PhoneFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'phone identifier'),
        'number' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'comment' => 'formatted phone number', 'charset' => 'utf8'),
        'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => 'type of phone number such as home, cell, work', 'charset' => 'utf8'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date phone number was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date phone number was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
//            'number' => 'Lorem ipsum d',
//            'type' => 'Lorem ipsum dolor ',
//            'created' => '2014-05-13 17:37:23',
//            'modified' => '2014-05-13 17:37:23'
//        ),
//    );

}
