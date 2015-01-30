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
        $this->addAddress($data);
        $this->addEmailAddress($data);
        $this->addPhoneNumber($data);
        
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
    
    protected function isValid($data)
    {        
        return $this->saveAll($data[get_class($this)], array('validate' => 'only'));
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
