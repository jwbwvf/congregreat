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
        'Member' => array(
            'className' => 'Member',
            'joinTable' => 'email_addresses_members',
            'foreignKey' => 'email_address_id',
            'associationForeignKey' => 'member_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Congregation' => array(
            'className' => 'Organization',
            'joinTable' => 'congregations_email_addresses',
            'foreignKey' => 'email_address_id',
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
     * saves an email address
     * @param array $data
     * @return On success EmailAddress if its not empty or true, false on failure
     */
    public function add($data)
    {
        $this->create();
        return $this->save($data);
    }
}
