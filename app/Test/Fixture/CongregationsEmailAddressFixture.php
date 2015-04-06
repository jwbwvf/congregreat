<?php

/**
 * CongregationsEmailAddressFixture
 *
 */
class CongregationsEmailAddressFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'email identifier'),
        'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'congregation identifier'),
        'email_address_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the congregation email address was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date the congregation email address was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'organization_id' => array('column' => 'congregation_id', 'unique' => 0),
            'email_id' => array('column' => 'email_address_id', 'unique' => 0)
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
            'congregation_id' => 1,
            'email_address_id' => 1,
            'created' => '2014-05-22 20:50:47',
            'modified' => '2014-05-22 20:50:47'
        ),
    );

}
