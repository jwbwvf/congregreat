<?php
/**
 * TaskFixture
 *
 */
class TaskFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary', 'comment' => 'task identifier'),
		'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'congregation that owns the task'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'name of the task', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => 'description of the task', 'charset' => 'utf8'),
		'due' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the task is due'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date the task was created'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'last date task was modified'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'organization_id' => array('column' => 'congregation_id', 'unique' => 0)
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
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'due' => '2014-11-18 21:11:57',
			'created' => '2014-11-18 21:11:57',
			'modified' => '2014-11-18 21:11:57'
		),
	);

}
