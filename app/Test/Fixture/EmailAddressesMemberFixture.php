<?php

/**
 * EmailAddressesMemberFixture
 *
 */
class EmailAddressesMemberFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'member_id' => array('type' => 'integer', 'null' => false, 'default' => null),
        'email_address_id' => array('type' => 'integer', 'null' => false, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
//            'member_id' => 1,
//            'email_address_id' => 1,
//            'created' => '2014-08-19 19:29:40',
//            'modified' => '2014-08-19 19:29:40'
//        ),
//    );

}
