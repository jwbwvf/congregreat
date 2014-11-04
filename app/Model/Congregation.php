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
        'CongregationFollowRequest' => array(
            'className' => 'CongregationFollowRequest',
            'foreignKey' => '',
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
//        'CongregationFollowLeader' => array(
//            'className' => 'CongregationFollow',
//            'foreignKey' => 'leader_id',
//            'dependent' => false,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        ),             
//        'CongregationFollowFollower' => array(
//            'className' => 'CongregationFollow',
//            'foreignKey' => 'follower_id',
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
        'CongregationFollow' => array(
            'className' => 'CongregationFollow',
            'foreignKey' => '',
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
        $this->CongregationFollowRequest->create();
        return $this->CongregationFollowRequest->save(array('requesting_follower_id' => $followerId,
            'leader_id' => $leaderId, 'status' => CongregationFollowRequestStatus::PENDING));       
    }

    /**
     * 
     * @param int $followRequestId the id of the followRequest that is pending acceptance
     */
    public function acceptFollowRequest($followRequestId)
    {
        $this->CongregationFollowRequest->id = $followRequestId;        
        if ($this->CongregationFollowRequest->saveField('status', CongregationFollowRequestStatus::ACCEPTED))
        {
            $congregationFollowRequest = $this->CongregationFollowRequest->get($followRequestId);
            $this->CongregationFollow->create();
            return $this->CongregationFollow->save(array(
                'follower_id' => $congregationFollowRequest['CongregationFollowRequest']['requesting_follower_id'], 
                'leader_id' => $congregationFollowRequest['CongregationFollowRequest']['leader_id']));
        }
        
        return false;
    }
    
    /**
     * 
     * @param int $followRequestId the id of the followRequest that is pending rejection
     */
    public function rejectFollowRequest($followRequestId)
    {
        $this->CongregationFollowRequest->id = $followRequestId;
        return $this->CongregationFollowRequest->saveField('status', 
                CongregationFollowRequestStatus::REJECTED);
    }
    
    public function cancelFollowRequest($followRequestId)
    {
        $this->CongregationFollowRequest->id = $followRequestId;
        return $this->CongregationFollowRequest->saveField('status', 
                CongregationFollowRequestStatus::CANCELLED);        
    }
    
    public function getFollowRequests($leaderId)
    {                       
        return $this->CongregationFollowRequest->getFollowRequests($leaderId);
    }
    
    public function getMyPendingRequests($requesting_follower_id)
    {
        return $this->CongregationFollowRequest->getMyPendingRequests($requesting_follower_id);
    }
    
    public function getFollows($followerId)
    {
        return $this->CongregationFollow->getFollows($followerId);
    }
    
    public function getFollowers($leaderId)
    {
        return $this->CongregationFollow->getFollowers($leaderId);
    }
    
    public function getCongregationFollowMap($followerId)
    {
        $congregationFollowMap = array();
        $follows = $this->CongregationFollow->getFollows($followerId);
        foreach ($follows as $follow)
        {
            $congregationFollowMap[$follow['Leader']['id']] = $follow['CongregationFollow']['id'];
        }
        
        return $congregationFollowMap;        
    }
    
    public function stopFollowing($followId)
    {
        $this->CongregationFollow->id = $followId;
        return $this->CongregationFollow->delete();
    }
    
    /**
     * Finds what action can be taken given a current congregation(logged in as member of) viewing congregation
     * no action, follow, stop following, cancel pending follow request
     * @param int $currentCongregationId - the id of the congregation the logged in user is a member of
     * @param int $viewCongregationId - the id of the congregation that is being viewed
     * @return array empty if there are no actions to take
     * else the array will contain the views label, the controllers action, and the parameter for the action
     */
    public function getFollowAction($currentCongregationId, $viewCongregationId)
    {        
        $followAction = array();
        
        if ($currentCongregationId === $viewCongregationId)
        {
            return $followAction;//no action return empty array
        }
        
        $followId = $this->CongregationFollow->getFollowId($currentCongregationId, $viewCongregationId);
        if ($followId > 0)
        {
            $followAction['action'] = 'stopFollowing';
            $followAction['label'] = 'Stop Following';
            $followAction['param'] = $followId;
            $followAction['viewId'] = $viewCongregationId;
            
            return $followAction;
        }
        
        $followRequestId = $this->CongregationFollowRequest->getPendingFollowRequestId($viewCongregationId, $currentCongregationId);
        if ($followRequestId > 0)
        {
            $followAction['action'] = 'cancelFollowRequest';
            $followAction['label'] = 'Cancel Follow Request';
            $followAction['param'] = $followRequestId;
            $followAction['viewId'] = $viewCongregationId;
            
            return $followAction;
        }
        
        $followAction['action'] = 'requestToFollow';
        $followAction['label'] = 'Follow Congregation';
        $followAction['param'] = $viewCongregationId;
        $followAction['viewId'] = $viewCongregationId;
        
        return $followAction;
    }
}
