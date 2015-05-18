<?php

App::uses('ContactableModel', 'Model');
App::uses('CongregationFollowActions', 'Model');
App::uses('CongregationFollowActionLabels', 'Model');

/**
 * Congregation Model
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

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'congregation_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => array('id', 'first_name', 'last_name'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CongregationAddress' => array(
            'className' => 'CongregationAddress',
            'foreignKey' => 'congregation_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => array('id', 'street_address', 'city', 'state', 'zipcode', 'country'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CongregationEmailAddress' => array(
            'className' => 'CongregationEmailAddress',
            'foreignKey' => 'congregation_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => array('id', 'email_address'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CongregationPhone' => array(
            'className' => 'CongregationPhone',
            'foreignKey' => 'congregation_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => array('id', 'number', 'type'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CongregationFollowRequest' => array(
            'className' => 'CongregationFollowRequest',
            'foreignKey' => '',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CongregationFollow' => array(
            'className' => 'CongregationFollow',
            'foreignKey' => '',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'AnnouncementRequest' => array(
            'className' => 'AnnouncementRequest',
            'foreignKey' => 'congregation_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => array('id', 'member_id', 'announcement', 'status', 'expiration'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Announcement' => array(
            'className' => 'Announcement',
            'foreignKey' => 'congregation_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => array('id', 'announcement', 'expiration'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Task' => array(
            'className' => 'Task',
            'foreignKey' => 'congregation_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

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
        $options = array(
            'conditions' => array('Congregation.' . $this->primaryKey => $id),
            'fields' => array('id', 'name', 'website')
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

        $this->save($data['Congregation']);

        $data['Congregation'] = array('id' => $this->id);
        $data['CongregationAddress']['congregation_id'] = $this->id;
        $data['CongregationEmailAddress']['congregation_id'] = $this->id;
        $data['CongregationPhone']['congregation_id'] = $this->id;
        return parent::add($data);
    }

    /**
     * Finds what action can be taken given a current congregation(logged in as member of) viewing congregation
     * no action, follow, stop following, cancel pending follow request
     * @param int $currentCongregationId - the id of the congregation the logged in user is a member of
     * @param int $viewCongregationId - the id of the congregation that is being viewed
     * @return array empty if there are no actions to take
     * else the array will contain the views label, the controllers action, and the parameter for the action
     */
    public function getFollowAction($currentCongregationId, $viewCongregationId)
    {
        $followAction = array();

        if ($currentCongregationId === $viewCongregationId)
        {
            return $followAction;//no action return empty array
        }

        $followId = $this->CongregationFollow->getFollowId($currentCongregationId, $viewCongregationId);
        if ($followId > 0)
        {
            $followAction['action'] = CongregationFollowActions::STOP;
            $followAction['label'] = CongregationFollowActionLabels::STOP;
            $followAction['param'] = $followId;
            $followAction['viewId'] = $viewCongregationId;

            return $followAction;
        }

        $followRequestId = $this->CongregationFollowRequest->getPendingFollowRequestId($viewCongregationId, $currentCongregationId);
        if ($followRequestId > 0)
        {
            $followAction['action'] = CongregationFollowActions::CANCEL;
            $followAction['label'] = CongregationFollowActionLabels::CANCEL;
            $followAction['param'] = $followRequestId;
            $followAction['viewId'] = $viewCongregationId;

            return $followAction;
        }

        $followAction['action'] = CongregationFollowActions::REQUEST;
        $followAction['label'] = CongregationFollowActionLabels::REQUEST;
        $followAction['param'] = $viewCongregationId;
        $followAction['viewId'] = $viewCongregationId;

        return $followAction;
    }

    public function getTasks($id)
    {
        return $this->Task->getAllForCongregation($id);
    }
}
