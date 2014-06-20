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
        $options = array('conditions' => array('Congregation.' . $this->primaryKey => $id)); 
        return $this->find('first', $options);
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
        return $this->addModel($data, 'Phone');
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
        return $this->addModel($data, 'EmailAddress');
    }
    
    public function addModel($data, $model)
    {
        $this->id = $data['Congregation']['id'];
        
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
            
            $joinModel = 'Congregations' . $model;
            return $this->$joinModel->save($association, false);
        }           
    }
    
    /**
     * removes the relationship with the @Phone
     * if there are no other relationships with the @Phone
     * the @Phone is deleted.
     * @param int $phoneId
     * @return boolean
     */
    public function deletePhoneNumber($phoneId)
    {
        return $this->deleteModel($phoneId, 'Phone');
    }    
    
    /**
     * removes the relationship with the @EmailAddress
     * if there are no other relationshiops with the @EmailAddress
     * the @EmailAddress is deleted
     * @param int $emailAddressId
     * @return boolean
     */
    public function deleteEmailAddress($emailAddressId)
    {   
        return $this->deleteModel($emailAddressId, 'EmailAddress');
    }
    
    /**
     * removes the relationship with the model
     * if there are no other relationshiops with the model
     * the model is deleted
     * @param int $modelId 
     * @param string $model name of the model
     * @return boolean
     */
    public function deleteModel($modelId, $model)
    {   
        $foreignKey = $this->hasAndBelongsToMany[$model]['foreignKey'];
        $associatedForeignKey = $this->hasAndBelongsToMany[$model]['associationForeignKey'];
        
        $joinModel = 'Congregations' . $model;

        $this->$joinModel->deleteAll(array($joinModel . '.' . $associatedForeignKey => $modelId, 
            $joinModel . '.' . $foreignKey => $this->id), false);
        
        //check if any one has this email address and if not delete the email address
        $this->$model->id = $modelId;
        if ($this->$model->isInUse() === false)
        {
            $this->$model->delete();
        }
        
        return true;          
    }

}
