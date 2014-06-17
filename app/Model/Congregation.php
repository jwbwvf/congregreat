<?php

App::uses('AppModel', 'Model');


/**
 * Congregation Model
 *
 * @property Address $Address
 * @property EmailAddress $EmailAddress
 * @property Phone $Phone
 */
class Congregation extends AppModel
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
            'message' => 'Congregation website is required',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Address' => array(
            'className' => 'Address',
            'joinTable' => 'addresses_congregations',
            'foreignKey' => 'congregation_id',
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
            'joinTable' => 'congregations_email_addresses',
            'foreignKey' => 'congregation_id',
            'associationForeignKey' => 'email_address_id',
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
            'joinTable' => 'congregations_phones',
            'foreignKey' => 'congregation_id',
            'associationForeignKey' => 'phone_id',
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
     * saves a congregation and it's related data
     * phone, email, address
     * @param array $data form data submitted from
     * View/Congregations/add.ctp
     * @return bool returns saveAll 
     */
    public function add($data) 
    {                
        $this->createModels();                
        if ($this->areModelsValid($data)) 
        {
            return $this->saveModels($data);
        }
        
        return false;
    }
    
    /**
     * creates all models including this
     */
    private function createModels()
    {
        $this->create();
        $this->EmailAddress->create();
        $this->Phone->create();
        $this->Address->create();        
    }
    
    /**
     * validates every model
     * @param array $data containing each models data
     * @return boolean true if every model is valid otherwise false
     */
    private function areModelsValid($data)
    {        
        if ($this->saveAll($data['Congregation'], array('validate' => 'only')) === false) 
        {
            return false;            
        }
        if ($this->isRelatedModelValid('EmailAddress', $data) === false)
        {
            return false;        
        }
        if ($this->isRelatedModelValid('Phone', $data) === false)        
        {
            return false;
        }
        if ($this->isRelatedModelValid('Address', $data) ===  false) 
        {
            return false;        
        }
        
        return true;
    }    
    
    /**
     * checks if a related model is valid
     * @param type $model related model to the Congregation
     * @param array $data contents of the model to verify
     * @return boolean
     */
    private function isRelatedModelValid($model, $data)
    {
        return $this->$model->saveAll($data[$model], array('validate' => 'only'));
    }
    
    /**
     * saves all models
     * @param array $data
     * @return boolean returns saveAll on this
     */
    private function saveModels($data)
    {
        $this->saveRelatedModel('EmailAddress', $data);
        $this->saveRelatedModel('Phone', $data);
        $this->saveRelatedModel('Address', $data);
        
        //This model must be saved last because it's dependent on the 
        //related models having ids to populate the join tables
        return $this->saveAll($data, array('validate' => false));
    }
    
    /**
     * convience method to save the related models
     * resets the model array to only contain the newly 
     * created id, so that join tables can be filled out
     * @param type $model
     * @param array $data
     */
    private function saveRelatedModel($model, &$data)
    {        
        $updatedModel = $this->$model->save($data[$model], false);
        unset($data[$model]);
        $data[$model]['id'] = $updatedModel[$model]['id'];        
    }
    
    /**
     * adds a new @Phone to the @Congregation
     * @param array $data form data submitted from
     * View/Congregations/view/add_phone_number.ctp
     * @return mixed boolean false if save fails
     * array of @Phone added if successful
     */
    public function addPhoneNumber($data)
    {
        $this->id = $data['Congregation']['id'];
        
        //check if this phone already exists and use it if it does
        $phone = $this->Phone->getPhoneByNumberAndType($data['Phone']['number'], $data['Phone']['type']);
        
        if (empty($phone))
        {
            $this->Phone->create();
            if ($this->isRelatedModelValid('Phone', $data) === false) 
            {
                return false;
            }
            
            return $this->Phone->save($data, false);            
        }   
        else
        {
            $association = array('congregation_id' => $this->id, 'phone_id' => $phone['Phone']['id']);
            return $this->CongregationsPhone->save($association, false);
        }
    }
    
    /**
     * retrievs the @Congregation for the given id
     * @param int $id @Congregation identifier
     * @return @Congregation
     * @throws NotFoundException
     */
    public function getCongregation($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid congregation'));
        }
        $options = array('conditions' => array('Congregation.' . $this->primaryKey => $id)); 
        return $this->find('first', $options);
    }
    
    /**
     * removes the relationship with the @Phone
     * if there are no other relationships with the @Phone
     * the @Phone is deleted.
     * @param int $phoneId
     * @return bool
     */
    public function deletePhoneNumber($phoneId)
    {
        $this->CongregationsPhone->deleteAll(array('CongregationsPhone.phone_id' => $phoneId, 
            'CongregationsPhone.congregation_id' => $this->id), false);
        
        //check if any one has this phone and if not delete the phone
        $this->Phone->id = $phoneId;
        if ($this->Phone->isInUse() === false)
        {
            $this->Phone->delete();
        }
        
        return true;
    }
    
    /**
     * adds a new @EmailAddress to the @Congregation
     * @param array $data form data submitted from
     * View/Congregations/view/add_email_address.ctp
     * @return mixed boolean false if save fails
     * array of @EmailAddress added if successful
     */    
    public function addEmailAddress($data)
    {
        $this->id = $data['Congregation']['id'];
        
        //check if this email address already exists and use it if it does
        $emailAddress = $this->EmailAddress->getEmailAddressByEmailAddress($data['EmailAddress']['email_address']);
        
        if (empty($emailAddress))
        {
            $this->EmailAddress->create();
            if ($this->isRelatedModelValid('EmailAddress', $data) === false) 
            {
                return false;
            }
            
            return $this->EmailAddress->save($data, false);            
        }   
        else
        {
            $association = array('congregation_id' => $this->id, 'email_address_id' => $emailAddress['EmailAddress']['id']);
            return $this->CongregationsEmailAddress->save($association, false);
        }        
    }
}
