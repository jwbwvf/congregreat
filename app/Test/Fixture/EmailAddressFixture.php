<?php

/**
 * EmailAddressFixture
 *
 */
class EmailAddressFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'email identifier'),
        'email_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'comment' => 'members email address', 'charset' => 'utf8'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the users email address was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date the users email address was modified'),
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
//            'email_address' => 'Lorem ipsum dolor sit amet',
//            'created' => '2014-05-13 17:36:50',
//            'modified' => '2014-05-13 17:36:50'
//        ),
//    );

}
