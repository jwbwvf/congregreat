<?php

App::uses('AppModel', 'Model');

/**
 * Task Model
 *
 * @property Congregation $Congregation
 */
class Task extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

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
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'description' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

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

    /**
     * hasMany associations
     *
     * @var array
     */
//    public $hasMany = array(
//        'MemberTaskAssignment' => array(
//            'className' => 'MemberTaskAssignment',
//            'foreignKey' => 'task_id',
//            'dependent' => false,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        )
//    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
//    public $hasAndBelongsToMany = array(
//        'Group' => array(
//            'className' => 'Group',
//            'joinTable' => 'groups_tasks',
//            'foreignKey' => 'task_id',
//            'associationForeignKey' => 'group_id',
//            'unique' => 'keepExisting',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'finderQuery' => '',
//        ),
//        'Member' => array(
//            'className' => 'Member',
//            'joinTable' => 'members_tasks',
//            'foreignKey' => 'task_id',
//            'associationForeignKey' => 'member_id',
//            'unique' => 'keepExisting',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'finderQuery' => '',
//        )
//    );

    public function getAllForCongregation($congregationId)
    {
        $options = array(
            'conditions' => array('Task.congregation_id' => $congregationId),
            'fields' => array('id', 'name', 'description')
        ); 
        
        return $this->find('all', $options);          
    }
}
