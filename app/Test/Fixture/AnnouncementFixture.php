<?php
/**
 * AnnouncementFixture
 *
 */
class AnnouncementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary', 'comment' => 'primary identifier for an announcement'),
		'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'identifier of the congregation the announcement belongs to'),
		'announcement' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => 'announcement text', 'charset' => 'utf8'),
		'expiration' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the announcement is no longer relevant'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the announcement was created'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the last time the announcement was modified'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'congregation_id' => array('column' => 'congregation_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB', 'comment' => 'this table holds all announcements for a congregation')
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
			'announcement' => 'Lorem ipsum dolor sit amet',
			'expiration' => '2015-05-06 13:53:45',
			'created' => '2015-05-06 13:53:45',
			'modified' => '2015-05-06 13:53:45'
		),
	);

}
