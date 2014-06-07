<?php

App::uses('AppModel', 'Model');

/**
 * Address Model
 *
 * @property Congregation $Congregation
 */
class Address extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'street_address';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'street_address' => array(
            'rule' => 'notEmpty',
            'message' => 'Enter the street address.',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
        'city' => array(
            'rule' => 'notEmpty',
            'message' => 'Enter a city.',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations
        ),
        'state' => array(            
            'rule' => array('inList', array(
                'Alabama',
                'Alaska',
                'Arizona',
                'Arkansas',
                'California',
                'Colorado',
                'Connecticut',
                'Delaware',
                'Florida',
                'Georgia',
                'Hawaii',
                'Idaho',
                'Illinois',
                'Indiana',
                'Iowa',
                'Kansas',
                'Kentucky',
                'Louisiana',
                'Maine',
                'Maryland',
                'Massachusetts',
                'Michigan',
                'Minnesota',
                'Mississippi',
                'Missouri',
                'Montana',
                'Nebraska',
                'Nevada',
                'NewHampshire',
                'NewJersey',
                'NewMexico',
                'NewYork',
                'NorthCarolina',
                'NorthDakota',
                'Ohio',
                'Oklahoma',
                'Oregon',
                'Pennsylvania',
                'RhodeIsland',
                'SouthCarolina',
                'SouthDakota',
                'Tennessee',
                'Texas',
                'Utah',
                'Vermont',
                'Virginia',
                'Washington',
                'WestVirginia',
                'Wisconsin',
                'Wyoming'
            )),
            'message' => 'Enter a valid state.',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
        'zipcode' => array(            
            'rule' => array('postal', '/^(\d{5})$/', 'us'),
            'message' => 'Enter a valid zipcode.',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
        'country' => array(
            'rule' => array('inList', array('United States')),
            'message' => 'Enter a valid country.',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations            
        ),
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
            'joinTable' => 'addresses_congregations',
            'foreignKey' => 'address_id',
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

    public function add($data)
    {
        $this->create();
        return $this->save($data);
    }
}
