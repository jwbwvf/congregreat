<?php

App::uses('ContactableModel', 'Model');
App::uses('CongregationFollowRequestStatus', 'Model');

/**
 * Congregation Model
 *
 * @property Address $Address
 * @property EmailAddress $EmailAddress
 * @property Phone $Phone
 */
class Congregation extends ContactableModel
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
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Congregation name is required',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
        'website' => array(
            'rule' => 'notEmpty',
            //'message' => 'Congregation website is required',
            'allowEmpty' => true,
            'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'congregation_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => array('id', 'first_name', 'last_name'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CongregationFollowRequestLeader' => array(
            'className' => 'CongregationFollowRequest',
            'foreignKey' => 'leader_id',
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
        'CongregationFollowRequestRequestingFollower' => array(
            'className' => 'CongregationFollowRequest',
            'foreignKey' => 'requesting_follower_id',
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
            'joinTable' => 'addresses_congregations',
            'joinModel' => 'AddressesCongregation',
            'foreignKey' => 'congregation_id',
            'associationForeignKey' => 'address_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => array('id', 'street_address', 'city', 'state', 'zipcode', 'country'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'EmailAddress' => array(
            'className' => 'EmailAddress',
            'joinTable' => 'congregations_email_addresses',
            'joinModel' => 'CongregationsEmailAddress',
            'foreignKey' => 'congregation_id',
            'associationForeignKey' => 'email_address_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => array('id', 'email_address'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Phone' => array(
            'className' => 'Phone',
            'joinTable' => 'congregations_phones',
            'joinModel' => 'CongregationsPhone',
            'foreignKey' => 'congregation_id',
            'associationForeignKey' => 'phone_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => array('id', 'number', 'type'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',            
        )
    );   
    
    protected function isValid($data)
    {
        return $this->saveAll($data['Congregation'], array('validate' => 'only'));
    }
    
    /**
     * retrievs the @Congregation for the given id
     * @param int $id @Congregation identifier
     * @return @Congregation
     * @throws NotFoundException
     */
    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid congregation'));
        }
        $options = array(
            'conditions' => array('Congregation.' . $this->primaryKey => $id),
            'fields' => array('id', 'name', 'website')
            ); 
        return $this->find('first', $options);
    }   
    
    public function add($data)
    {
        $this->create();     
        if ($this->isValid($data) === false)
        {
            return false;
        }
        $this->save($data['Congregation']);        
        $data['Congregation']['id'] = $this->id;
        return parent::add($data);
    }
    
    public function addModel($data, $model)
    {        
        //check if this the model already exists and use it if it does
        $existingModel = $this->$model->getByData($data[$model]);
        
        if (empty($existingModel))
        {
            $this->$model->create();
            if ($this->isRelatedModelValid($model, $data) === false) 
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
            
            $joinModel = $this->hasAndBelongsToMany[$model]['joinModel'];
            return $this->$joinModel->save($association, false);
        }           
    }
    
    /**
     * 
     * @param int $followerId the id of the congregation requesting to follow another congregation
     * @param int $leaderId the id of the congregation to be followed
     * @return type
     */
    public function addFollowRequest($followerId, $leaderId)
    {
        $this->CongregationFollowRequestRequestingFollower->create();
        return $this->CongregationFollowRequestRequestingFollower->save(array('requesting_follower_id' => $followerId,
            'leader_id' => $leaderId, 'status' => CongregationFollowRequestStatus::PENDING));       
    }
//
//    /**
//     * 
//     * @param int $followRequestId the id of the followRequest that is pending acceptance
//     */
//    public function acceptFollowRequest($followRequestId)
//    {
//        
//    }
    
    /**
     * 
     * @param int $followRequestId the id of the followRequest that is pending rejection
     */
    public function rejectFollowRequest($followRequestId)
    {
        $this->CongregationFollowRequestRequestingFollower->id = $followRequestId;
        $this->CongregationFollowRequestRequestingFollower->saveField('status', 
                CongregationFollowRequestStatus::REJECTED);
    }
}
