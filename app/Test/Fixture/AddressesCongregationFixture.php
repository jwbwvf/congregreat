<?php

/**
 * AddressesCongregationFixture
 *
 */
class AddressesCongregationFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'address identifier'),
        'address_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
        'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'congregation identifier'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date address was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date address was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'organization_id' => array('column' => 'congregation_id', 'unique' => 0),
            'address_id' => array('column' => 'address_id', 'unique' => 0)
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
//            'address_id' => 1,
//            'congregation_id' => 1,
//            'created' => '2014-05-22 20:50:35',
//            'modified' => '2014-05-22 20:50:35'
//        ),
//    );

}
