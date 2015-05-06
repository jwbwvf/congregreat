<?php

App::uses('AppModel', 'Model');
App::uses('PhoneType', 'Model');

/**
 * MemberPhone Model
 *
 * @property Member $Member
 */
class MemberPhone extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'number';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'number' => array(
            'rule' => array('phone', '/^[1-9]{3}[-]\d{3}[-]\d{4}$/', 'us'),
            'message' => 'Phone number is required in the format 555-555-5555',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations
        ),
        'type' => array(
            'rule' => array('inList', array(PhoneType::building, PhoneType::cell, PhoneType::home, PhoneType::work)),
            'message' => 'Phone type should be one of the following: building, cell, home, or work',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations
        )
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * finds a phone by the id
     * @param int $id
     * @return array
     * @throws NotFoundException
     */
    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid phone'));
        }
        $options = array('conditions' => array('MemberPhone.' . $this->primaryKey => $id),
            'fields' => array('id', 'member_id', 'number', 'type'));

        return $this->find('first', $options);
    }
}

