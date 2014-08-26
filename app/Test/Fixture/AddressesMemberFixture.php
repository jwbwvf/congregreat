<?php

/**
 * AddressesMemberFixture
 *
 */
class AddressesMemberFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'address member relation primary identifier'),
        'address_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'address identifier'),
        'member_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'member identifier'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date address member relationship was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date address member relationship was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'address_id' => array('column' => array('address_id', 'member_id'), 'unique' => 0)
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
//            'address_id' => 1,
//            'member_id' => 1,
//            'created' => '2014-08-19 19:29:25',
//            'modified' => '2014-08-19 19:29:25'
//        ),
//    );

}
