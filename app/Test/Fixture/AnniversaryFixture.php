<?php
/**
 * AnniversaryFixture
 *
 */
class AnniversaryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'anniversary primary identifier'),
		'member_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'member identifier'),
		'spouse_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'members spouse identifier 0 if they are not in the system'),
		'anniversary' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => 'date of the couples anniversary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the anniversary was created'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the last time the anniversary was modified'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'member_id' => array('column' => array('member_id', 'spouse_id'), 'unique' => 0)
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
			'spouse_id' => 1,
			'anniversary' => '2014-08-22',
			'created' => '2014-08-22 14:20:44',
			'modified' => '2014-08-22 14:20:44'
		),
	);

}
