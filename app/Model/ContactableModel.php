<?php

class ContactableModel extends AppModel
{
    /**
     * saves a ContactableModel and it's related data phone, email, address
     * @param array $data form data submitted from View/[Model]/add.ctp
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
    protected function areModelsValid($data)
    {                
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
     * @param type $model related model to the ContactableModel
     * @param array $data contents of the model to verify
     * @return boolean
     */    
    protected function isRelatedModelValid($model, $data)
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
     * convience method to save the related models, resets the model array to only contain the newly created id, 
     * so that join tables can be filled out
     * @param type $model
     * @param array $data
     */    
    private function saveRelatedModel($model, &$data)
    {        
        //check if model already exists
        //if it does use it's id instead of creating a new one
        $existingModel = $this->$model->getByData($data[$model]);
        if (empty($existingModel))
        {
            $updatedModel = $this->$model->save($data[$model], false);
            $modelId = $updatedModel[$model]['id'];        
        }
        else
        {            
            $modelId = $existingModel[$model]['id'];
        }
        
        unset($data[$model]);
        $data[$model]['id'] = $modelId;
    }     
    
    /**
     * adds a new @Phone to the ContactableModel
     * @param array $data form data submitted from View/[Model]/view/add_phone_number.ctp
     * @return mixed boolean false if save fails
     * array of @Phone added if successful
     */
    public function addPhoneNumber($data)
    {
        return $this->addModel($data, 'Phone');
    }
    
    /**
     * adds a new @EmailAddress to the ContactableModel
     * @param array $data form data submitted from View/[Model]/view/add_email_address.ctp
     * @return mixed boolean false if save fails
     * array of @EmailAddress added if successful
     */    
    public function addEmailAddress($data)
    {
        return $this->addModel($data, 'EmailAddress');
    }
    
    /**
     * adds a new @Address to the ContactableModel
     * @param array $data form data submitted from View/[Model]/view/add_address.ctp
     * @return mixed boolean false if save fails
     * array of @Address added if successful
     */       
    public function addAddress($data)
    {
        return $this->addModel($data, 'Address');
    }  
    
    /**
     * removes the relationship with the @Phone if there are no other relationships with the @Phone 
     * the @Phone is deleted.
     * @param int $phoneId
     * @return boolean
     */
    public function deletePhoneNumber($phoneId)
    {
        return $this->deleteModel($phoneId, 'Phone');
    }       
    
    /**
     * removes the relationship with the @EmailAddress if there are no other relationshiops with the @EmailAddress
     * the @EmailAddress is deleted
     * @param int $emailAddressId
     * @return boolean
     */
    public function deleteEmailAddress($emailAddressId)
    {   
        return $this->deleteModel($emailAddressId, 'EmailAddress');
    }
    
    /**
     * removes the relationship with the @Address if there are no other relationshiops with the @Address
     * the @Address is deleted
     * @param int $addressId
     * @return boolean
     */    
    public function deleteAddress($addressId)
    {
        return $this->deleteModel($addressId, 'Address');
    }   
    
    /**
     * removes the relationship with the model if there are no other relationshiops with the model the model is deleted.
     * @param int $modelId 
     * @param string $model name of the model
     * @return boolean
     */
    public function deleteModel($modelId, $model)
    {   
        $foreignKey = $this->hasAndBelongsToMany[$model]['foreignKey'];
        $associatedForeignKey = $this->hasAndBelongsToMany[$model]['associationForeignKey'];        
        $joinModel = $this->hasAndBelongsToMany[$model]['joinModel'];

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
    
    public function delete($id = NULL, $cascade = true)
    {        
        $this->id = $id;//todo rework so that id is passed into deletes
        $contactableModel = $this->get($id);

        //foreach address
        foreach ($contactableModel['Address'] as $address)
        {
            $this->deleteAddress($address['id']);            
        }
                
        //foreach email address
        foreach ($contactableModel['EmailAddress'] as $emailAddress)
        {
            $this->deleteEmailAddress($emailAddress['id']);
        }
        
        //foreach phone number
        foreach ($contactableModel['Phone'] as $phone)
        {
            $this->deletePhoneNumber($phone['id']);
        }
        
        //foreach related model
        
        //delete self
        return parent::delete($id, $cascade);
    }    
}
