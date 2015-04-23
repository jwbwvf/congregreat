<?php

App::uses('ContactableModel', 'Model');

/**
 * Member Model
 *
 * @property Congregation $Congregation
 * @property Address $Address
 * @property EmailAddress $EmailAddress
 * @property Phone $Phone
 */
class Member extends ContactableModel
{
    public $virtualFields = array('full_name' => "CONCAT(Member.first_name, ' ', Member.last_name)");

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'full_name';


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'numeric' => array(
                'rule' => array('numeric')
            )
        ),
        'congregation_id' => array(
            'rule' => array('numeric'),
            'message' => 'A congregation is required',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
        'first_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Member first name is required',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Member last name is required',
            'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            'on' => 'create' // Limit validation to 'create' or 'update' operations
        ),
        'birth_date' => array(
            'date' => array(
                'rule' => array('date'),
                'message' => 'Invalid date of birth',
            )
        ),
        'baptized' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'anniversary_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'created' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'modified' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasOne associations
     *
     * @var array
     */
    public $hasOne = array(
        'MemberAddress' => array(
            'className' => 'MemberAddress',
            'foreignKey' => '',
            'dependent' => false,
            'conditions' => '',
            'fields' => array('id', 'street_address', 'city', 'state', 'zipcode', 'country'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Congregation' => array(
            'className' => 'Congregation',
            'foreignKey' => 'congregation_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
//        'Anniversary' => array(
//            'className' => 'Anniversary',
//            'foreignKey' => 'anniversary_id',
//            'conditions' => '',
//            'fields' => '',
//            'order' => ''
//        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'MemberAddress' => array(
            'className' => 'MemberAddress',
            'foreignKey' => 'member_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => array('id', 'street_address', 'city', 'state', 'zipcode', 'country'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'MemberEmailAddress' => array(
            'className' => 'MemberEmailAddress',
            'foreignKey' => 'member_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => array('id', 'email_address'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'MemberPhone' => array(
            'className' => 'MemberPhone',
            'foreignKey' => 'member_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => array('id', 'number', 'type'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
//        'Absence' => array(
//            'className' => 'Absence',
//            'foreignKey' => 'member_id',
//            'dependent' => false,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        ),
//        'Contribution' => array(
//            'className' => 'Contribution',
//            'foreignKey' => 'member_id',
//            'dependent' => false,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        ),
//        'MemberTaskAssignment' => array(
//            'className' => 'MemberTaskAssignment',
//            'foreignKey' => 'member_id',
//            'dependent' => false,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
//    public $hasAndBelongsToMany = array(
//        'Group' => array(
//            'className' => 'Group',
//            'joinTable' => 'groups_members',
//            'foreignKey' => 'member_id',
//            'associationForeignKey' => 'group_id',
//            'unique' => 'keepExisting',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'finderQuery' => '',
//        ),
//        'Task' => array(
//            'className' => 'Task',
//            'joinTable' => 'members_tasks',
//            'foreignKey' => 'member_id',
//            'associationForeignKey' => 'task_id',
//            'unique' => 'keepExisting',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'finderQuery' => '',
//        )
//    );

    /**
     * retrievs the @Member for the given id
     * @param int $id @Member identifier
     * @return @Member
     * @throws NotFoundException
     */
    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid member'));
        }

        $options = array(
            'conditions' => array('Member.' . $this->primaryKey => $id),
            'fields' => array('id', 'first_name', 'last_name', 'middle_name', 'birth_date',
                'profile_picture', 'baptized',
                'Congregation.id', 'Congregation.name')
            );
        return $this->find('first', $options);
    }

    public function add($data)
    {
        $this->create();
        if ($this->isValid($data) === false)
        {
            return false;
        }
        $this->save($data['Member']);

        $data['Member'] = array('id' => $this->id);

        return parent::add($data);
    }

    public function storeProfilePicture($data)
    {
        if (is_uploaded_file($data['Member']['profile_picture']['tmp_name']))
        {
            move_uploaded_file($data['Member']['profile_picture']['tmp_name'],
                    '../webroot/img/members/' . $data['Member']['profile_picture']['name']);

            return $data['Member']['profile_picture']['name'];
        }

        return "";
    }
}
