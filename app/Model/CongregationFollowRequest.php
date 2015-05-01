<?php

App::uses('AppModel', 'Model');
App::uses('CongregationFollowRequestStatus', 'Model');

/**
 * CongregationFollowRequest Model
 *
 * @property Leader $Leader
 * @property RequestingFollower $RequestingFollower
 */
class CongregationFollowRequest extends AppModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'leader_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'requesting_follower_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'status' => array(
            'numeric' => array(
                'rule' => array('numeric'),
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
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'RequestedLeader' => array(
            'className' => 'Congregation',
            'foreignKey' => 'leader_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'RequestingFollower' => array(
            'className' => 'Congregation',
            'foreignKey' => 'requesting_follower_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function get($id)
    {
        if (!$this->exists($id))
        {
            throw new NotFoundException(__('Invalid congregation follow request'));
        }
        $options = array('conditions' => array('CongregationFollowRequest.' . $this->primaryKey => $id),
            'fields' => array('id', 'leader_id', 'requesting_follower_id', 'status')
        );

        return $this->find('first', $options);
    }

    public function getFollowRequests($leaderId)
    {
        $options = array(
            'conditions' => array('CongregationFollowRequest.leader_id' => $leaderId,
                'status' => CongregationFollowRequestStatus::PENDING
            ),
            'fields' => array('id', 'RequestingFollower.id', 'RequestingFollower.name')
        );

        return $this->find('all', $options);
    }

    public function getMyPendingRequests($requesting_follower_id)
    {
        $options = array(
            'conditions' => array('CongregationFollowRequest.requesting_follower_id' => $requesting_follower_id,
                'status' => CongregationFollowRequestStatus::PENDING
            ),
            'fields' => array('id', 'RequestedLeader.id', 'RequestedLeader.name')
        );

        return $this->find('all', $options);
    }

    public function getPendingFollowRequestId($leaderId, $requestingFollowerId)
    {
        $options = array(
            'conditions' => array(
                'CongregationFollowRequest.leader_id'=> $leaderId,
                'CongregationFollowRequest.requesting_follower_id' => $requestingFollowerId,
                'status' => CongregationFollowRequestStatus::PENDING
            ),
            'fields' => array('id')
        );

        $followRequest = $this->find('first', $options);
        return empty($followRequest) ? 0 : $followRequest['CongregationFollowRequest']['id'];
    }
}
