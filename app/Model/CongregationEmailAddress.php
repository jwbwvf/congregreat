<?php

App::uses('AppModel', 'Model');

/**
 * CongregationEmailAddress Model
 *
 * @property Congregation $Congregation
 */
class CongregationEmailAddress extends AppModel
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
        'Congregation' => array(
            'className' => 'Congregation',
            'foreignKey' => 'congregation_id',
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
        $options = array('conditions' => array('CongregationEmailAddress.' . $this->primaryKey => $id),
            'fields' => array('id', 'congregation_id', 'email_address'));

        return $this->find('first', $options);
    }
}

