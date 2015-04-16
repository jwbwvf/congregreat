<?php

/**
 * MemberAddressFixture
 *
 */
class MemberAddressFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'address member relation primary identifier'),
        'member_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'member identifier'),
        'street_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'utf8_unicode_ci', 'comment' => 'street address', 'charset' => 'utf8'),
        'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'comment' => 'city', 'charset' => 'utf8'),
        'state' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 12, 'collate' => 'utf8_unicode_ci', 'comment' => 'state', 'charset' => 'utf8'),
        'zipcode' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'comment' => 'zipcode', 'charset' => 'utf8'),
        'country' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'comment' => 'country', 'charset' => 'utf8'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date address member relationship was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date address member relationship was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'member_id' => array('column' => 'member_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
    );

    /**
     * Records
     *
     * @var array
     */
    public $records = array(
        array(
            'id' => 1,
            'member_id' => 1,
            'street_address' => 'test street address',
            'city' => 'test city',
            'state' => 'test state',
            'zipcode' => '66066',
            'country' => 'test country',
            'created' => '2014-05-13 17:35:55',
            'modified' => '2014-05-13 17:35:55'
        ),
    );

}
