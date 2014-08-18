<?php

App::uses('ContactableModel', 'Model');

/**
 * Member Model
 *
 * @property User $User
 * @property Congregation $Congregation
 * @property Anniversary $Anniversary
 * @property Absence $Absence
 * @property Contribution $Contribution
 * @property MemberTaskAssignment $MemberTaskAssignment
 * @property Address $Address
 * @property EmailAddress $EmailAddress
 * @property Group $Group
 * @property Phone $Phone
 * @property Task $Task
 */
class Member extends ContactableModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
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
        'birth_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'baptized' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'anniversary_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'created' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'modified' => array(
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

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasOne associations
     *
     * @var array
     */
    public $hasOne = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'member_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
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
        ),
        'Anniversary' => array(
            'className' => 'Anniversary',
            'foreignKey' => 'anniversary_id',
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
    public $hasMany = array(
        'Absence' => array(
            'className' => 'Absence',
            'foreignKey' => 'member_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Contribution' => array(
            'className' => 'Contribution',
            'foreignKey' => 'member_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'MemberTaskAssignment' => array(
            'className' => 'MemberTaskAssignment',
            'foreignKey' => 'member_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Address' => array(
            'className' => 'Address',
            'joinTable' => 'addresses_members',
            'foreignKey' => 'member_id',
            'associationForeignKey' => 'address_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'EmailAddress' => array(
            'className' => 'EmailAddress',
            'joinTable' => 'email_addresses_members',
            'foreignKey' => 'member_id',
            'associationForeignKey' => 'email_address_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Group' => array(
            'className' => 'Group',
            'joinTable' => 'groups_members',
            'foreignKey' => 'member_id',
            'associationForeignKey' => 'group_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Phone' => array(
            'className' => 'Phone',
            'joinTable' => 'members_phones',
            'foreignKey' => 'member_id',
            'associationForeignKey' => 'phone_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Task' => array(
            'className' => 'Task',
            'joinTable' => 'members_tasks',
            'foreignKey' => 'member_id',
            'associationForeignKey' => 'task_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );  

    /**
     * validates every model
     * @param array $data containing each models data
     * @return boolean true if every model is valid otherwise false
     */
    protected function areModelsValid($data)
    {        
        if ($this->saveAll($data['Member'], array('validate' => 'only')) === false) 
        {
            return false;            
        }

        return parent::areModelsValid($data);
    }    
    
    /**
     * retrievs the @Member for the given id
     * @param int $id @Member identifier
     * @return @Member
     * @throws NotFoundException
     */
    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid member'));
        }
        $options = array('conditions' => array('Member.' . $this->primaryKey => $id)); 
        return $this->find('first', $options);
    }      
    
    public function addModel($data, $model)
    {
        $this->id = $data['Member']['id'];
        
        //check if this the model already exists and use it if it does
        $existingModel = $this->$model->getByData($data[$model]);
        
        if (empty($existingModel))
        {
            $this->$model->create();
            if (parent::isRelatedModelValid($model, $data) === false) 
            {
                return false;
            }
            
            return $this->$model->save($data, false);            
        }   
        else
        {            
            $foreignKey = $this->hasAndBelongsToMany[$model]['foreignKey'];
            $associatedForeignKey = $this->hasAndBelongsToMany[$model]['associationForeignKey'];
            $association = array($foreignKey => $this->id, $associatedForeignKey => $existingModel[$model]['id']);
            
            $joinModel = 'Member' . $model;
            return $this->$joinModel->save($association, false);
        }           
    }              
}
