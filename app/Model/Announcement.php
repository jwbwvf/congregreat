<?php

App::uses('AppModel', 'Model');

/**
 * Announcement Model
 *
 * @property Congregation $Congregation
 */
class Announcement extends AppModel
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
        )
    );

}
