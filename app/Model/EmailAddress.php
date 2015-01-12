<?php

App::uses('AppModel', 'Model');

/**
 * EmailAddress Model
 *
 * @property Member $Member
 * @property Congregation $Congregation
 */
class EmailAddress extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'email_address';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'email_address' => array(
        'rule' => 'email',
        'message' => 'Enter a valid email address.',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
            'joinTable' => 'congregations_email_addresses',
            'foreignKey' => 'email_address_id',
            'associationForeignKey' => 'congregation_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => 'id',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Member' => array(
            'className' => 'Member',
            'joinTable' => 'email_addresses_members',
            'foreignKey' => 'email_address_id',
            'associationForeignKey' => 'member_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => 'id',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',        
        )
    );
    
    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid email address'));
        }
        $options = array('conditions' => array('EmailAddress.' . $this->primaryKey => $id),
            'fields' => array('id', 'email_address'));
        return $this->find('first', $options);        
    }
    
    /**
     * finds an email address by the given email address
     * @param string @EmailAddress
     * @return array
     */
    public function getByData($data)
    {
        $options = array('conditions' => array('EmailAddress.email_address' => $data['email_address']));
        return $this->find('first', $options);      
    }
    
    /**
     * checks if the email address is being used by a member or congregation
     * @return boolean
     */
    public function isInUse()
    {
        $memberOptions = array('conditions' => array('EmailAddressesMember.email_address_id' => $this->id));                        
        $emailAddressMembers = $this->EmailAddressesMember->find('first', $memberOptions);        
        
        if (!empty($emailAddressMembers))
        {
            return true;
        }
        
        $congregationOptions = array('conditions' => array('CongregationsEmailAddress.email_address_id' => $this->id));                        
        $congregationsEmailAddress = $this->CongregationsEmailAddress->find('first', $congregationOptions);
        return !empty($congregationsEmailAddress);
    }
}
