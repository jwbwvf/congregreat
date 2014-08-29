<?php

App::uses('ContactableModel', 'Model');

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
            'fields' => '',
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
            'fields' => '',
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
            'fields' => '',
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
        $options = array('conditions' => array('Congregation.' . $this->primaryKey => $id)); 
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
            
            $joinModel = $this->hasAndBelongsToMany[$model]['joinModel'];
            return $this->$joinModel->save($association, false);
        }           
    }

}
