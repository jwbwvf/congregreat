<?php

App::uses('AppModel', 'Model');

/**
 * MemberAddress Model
 *
 * @property Member $Member
 */
class MemberAddress extends AppModel
{
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

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid address'));
        }
        $options = array('conditions' => array('MemberAddress.' . $this->primaryKey => $id),
            'fields' => array('id', 'street_address', 'city', 'state', 'zipcode', 'country'));

        return $this->find('first', $options);
    }

}
