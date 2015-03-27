<?php

/**
 * MemberFixture
 *
 */
class MemberFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'the id of the congregation the member is a part of'),
        'first_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => 'users first name', 'charset' => 'utf8'),
        'last_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => 'users last name', 'charset' => 'utf8'),
        'middle_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => 'members middle name', 'charset' => 'utf8'),
        'gender' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'comment' => 'members gender', 'charset' => 'utf8'),
        'birth_date' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => 'members birthdate'),
        'baptized' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'has the member been baptized 1 - yes, 0 - no'),
        'profile_picture' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => 'name of the profile picutre for the member', 'charset' => 'utf8'),
        'anniversary_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'the foreign key to the anniversary table that indicates when they were married and to whom'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date profile was created'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last day the profile was modified'),
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
    public $records = array(
        array(
            'id' => 1,
            'congregation_id' => 1,
            'first_name' => 'first name 1',
            'last_name' => 'last name 1',
            'middle_name' => 'middle name 1',
            'gender' => 'Lore',
            'birth_date' => '2014-08-06',
            'baptized' => 1,
            'profile_picture' => 'Lorem ipsum dolor sit amet',
            'anniversary_id' => 1,
            'created' => '2014-08-06 13:08:07',
            'modified' => '2014-08-06 13:08:07'
        ),
        array(
            'id' => 2,
            'congregation_id' => 1,
            'first_name' => 'first name 2',
            'last_name' => 'last name 2',
            'middle_name' => 'last name 2',
            'gender' => 'Lore',
            'birth_date' => '2014-08-06',
            'baptized' => 1,
            'profile_picture' => 'Lorem ipsum dolor sit amet',
            'anniversary_id' => 1,
            'created' => '2014-08-06 13:08:07',
            'modified' => '2014-08-06 13:08:07'
        ),
    );

}
