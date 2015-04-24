<?php

App::uses('AppModel', 'Model');

/**
 * MemberEmailAddress Model
 *
 * @property Member $Member
 */
class MemberEmailAddress extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'email_address';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'email_address' => array(
        'rule' => 'email',
        'message' => 'Enter a valid email address.',
        'allowEmpty' => false,
        'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
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

    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid email address'));
        }
        $options = array('conditions' => array('MemberEmailAddress.' . $this->primaryKey => $id),
            'fields' => array('id', 'email_address'));

        return $this->find('first', $options);
    }
}

