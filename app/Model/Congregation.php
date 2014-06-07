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
     * @param array $data form data submited from
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
        if ($this->saveAll($data, array('validate' => 'only')) === false) 
        {
            return false;            
        }
        if ($this->EmailAddress->saveAll($data, array('validate' => 'only')) === false) 
        {
            return false;        
        }
        if ($this->Phone->saveAll($data, array('validate' => 'only')) === false) 
        {
            return false;
        }
        if ($this->Address->saveAll($data, array('validate' => 'only')) ===  false) 
        {
            return false;        
        }
        
        return true;
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
}
