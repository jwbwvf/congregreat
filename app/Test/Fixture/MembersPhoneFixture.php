<?php

/**
 * MembersPhoneFixture
 *
 */
class MembersPhoneFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'member phone relation primary identifier'),
        'member_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'member identifier'),
        'number' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'comment' => 'formatted phone number', 'charset' => 'utf8'),
        'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => 'type of phone number such as home, cell, work', 'charset' => 'utf8'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the member phone relation was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date the member phone relation was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'member_id' => array('column' => array('member_id', 'phone_id'), 'unique' => 0)
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
            'number' => '555-555-5555',
            'type' => 'test',
            'created' => '2014-08-19 19:29:52',
            'modified' => '2014-08-19 19:29:52'
        ),
    );

}
