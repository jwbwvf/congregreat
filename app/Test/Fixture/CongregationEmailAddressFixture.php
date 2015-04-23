<?php

/**
 * CongregationEmailAddressFixture
 *
 */
class CongregationEmailAddressFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'email identifier'),
        'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'congregation identifier'),
        'email_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'comment' => 'members email address', 'charset' => 'utf8'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the congregation email address was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date the congregation email address was modified'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'congregation_id' => array('column' => 'congregation_id', 'unique' => 0)
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
            'email_address' => 'testEmailAddress1@test.com',
            'created' => '2014-05-22 20:50:47',
            'modified' => '2014-05-22 20:50:47'
        ),
    );

}
