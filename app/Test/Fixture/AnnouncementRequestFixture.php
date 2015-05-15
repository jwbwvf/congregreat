<?php

App::uses('AnnouncementRequestStatus', 'Model');

/**
 * AnnouncementRequestFixture
 *
 */
class AnnouncementRequestFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary', 'comment' => 'primary identifier for an announcement request'),
		'congregation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'identifier of the congregation the announcement belongs to'),
		'member_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'comment' => 'identifier of the member who submitted the announcement'),
		'announcement' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => 'announcement text', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => true, 'comment' => 'status of the announcement request, PENDING - 0, ACCEPTED - 1, REJECTED - 2, CANCELLED - 3'),
		'expiration' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the announcement will expire and no longer be relevant'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the announcement request was created'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the announcement request was last modified'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'congregation_id' => array('column' => array('congregation_id', 'member_id'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB', 'comment' => 'this table holds all announcements submitted by members of a congregation')
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
			'member_id' => 1,
			'announcement' => 'test announcement 1',
			'status' => AnnouncementRequestStatus::PENDING,
			'expiration' => '2015-05-06 13:47:46',
			'created' => '2015-05-06 13:47:46',
			'modified' => '2015-05-06 13:47:46'
		),
	);

}
