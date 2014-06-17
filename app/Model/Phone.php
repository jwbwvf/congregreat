<?php

App::uses('AppModel', 'Model');
App::uses('PhoneType', 'Model');

/**
 * Phone Model
 *
 * @property Congregation $Congregation
 */
class Phone extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'number';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'number' => array(
            'rule' => array('phone', '/^[1-9]{3}[-]\d{3}[-]\d{4}$/', 'us'),
            'message' => 'Phone number is required in the format 555-555-5555',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations
        ),
        'type' => array(
            'rule' => array('inList', array(PhoneType::building, PhoneType::cell, PhoneType::home, PhoneType::work)),
            'message' => 'Phone type should be one of the following: building, cell, home, or work',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations            
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Congregation' => array(
            'className' => 'Congregation',
            'joinTable' => 'congregations_phones',
            'foreignKey' => 'phone_id',
            'associationForeignKey' => 'congregation_id',
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
     * saves a phone
     * @param array $datal
     * @return On success Phone if its not empty or true, false on failure
     */
    public function add($data)
    {
        $this->create();
        return $this->save($data);
    }
    
    /**
     * finds a phone by the id
     * @param int $id
     * @return array
     * @throws NotFoundException
     */
    public function getPhone($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid phone'));
        }
        $options = array('conditions' => array('Phone.' . $this->primaryKey => $id));
        return $this->find('first', $options);
    }
    
    /**
     * finds a @Phone by the number and type
     * @param int $number
     * @param string $type
     * @return array
     */
    public function getPhoneByNumberAndType($number, $type)
    {        
        $options = array('conditions' => array('Phone.number' => $number, 'Phone.type' => $type));
        return $this->find('first', $options);        
    }
    
    /**
     * checks if the phone is being used by a congregation
     * @return boolean
     */
    public function isInUse()
    {
        return $this->CongregationsPhone->field('phone_id');
    }
}
