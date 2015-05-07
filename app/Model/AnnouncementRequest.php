<?php

App::uses('AppModel', 'Model');
App::uses('AnnouncementRequestStatus', 'Model');

/**
 * AnnouncementRequest Model
 *
 * @property Congregation $Congregation
 * @property Member $Member
 */
class AnnouncementRequest extends AppModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'congregation_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'member_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'announcement' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'status' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'expiration' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Congregation' => array(
            'className' => 'Congregation',
            'foreignKey' => 'congregation_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid announcement request'));
        }

        $options = array('conditions' => array('AnnouncementRequest.' . $this->primaryKey => $id),
            'fields' => array('id', 'congregation_id', 'member_id', 'announcement', 'status', 'expiration'));

        return $this->find('first', $options);
    }

    public function getMembersAnnouncementRequests($memberId)
    {
        $options = array('conditions' => array('AnnouncementRequest.member_id' => $memberId,
            'status' => AnnouncementRequestStatus::PENDING),
            'fields' => array('id', 'congregation_id', 'member_id', 'announcement', 'expiration'));

        return $this->find('all', $options);
    }

    public function getCongregationsAnnouncementRequests($congregationId)
    {
        $options = array('conditions' => array('AnnouncementRequest.congregation_id' => $congregationId,
            'status' => AnnouncementRequestStatus::PENDING),
            'fields' => array('id', 'congregation_id', 'member_id', 'announcement', 'expiration'));

        return $this->find('all', $options);
    }
}
