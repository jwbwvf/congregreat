<?php

App::uses('AppModel', 'Model');

/**
 * CongregationFollow Model
 *
 * @property Follower $Follower
 * @property Leader $Leader
 */
class CongregationFollow extends AppModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'follower_id' => array(
            'numeric' => array(
                'rule' => array('numeric')
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'leader_id' => array(
            'numeric' => array(
                'rule' => array('numeric')
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Leader' => array(
            'className' => 'Congregation',
            'foreignKey' => 'leader_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Follower' => array(
            'className' => 'Congregation',
            'foreignKey' => 'follower_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function getFollows($followerId)
    {
        $options = array(
            'conditions' => array('CongregationFollow.follower_id' => $followerId),
            'fields' => array('id', 'Leader.id', 'Leader.name')
        );

        return $this->find('all', $options);
    }

    public function getFollowers($leaderId)
    {
        $options = array(
            'conditions' => array('CongregationFollow.leader_id' => $leaderId),
            'fields' => array('id', 'Follower.id', 'Follower.name')
        );

        return $this->find('all', $options);
    }

    public function getFollowId($followerId, $leaderId)
    {
        $options = array(
            'conditions' => array(
                'CongregationFollow.follower_id' => $followerId,
                'CongregationFollow.leader_id' => $leaderId
            ),
            'fields' => array('id')
        );

        $follow = $this->find('first', $options);
        return empty($follow) ? 0 : $follow['CongregationFollow']['id'];
    }

    /**
     * maps the leader(key) to the CongregationFollowId for a given follower id
     * @param type $followerId
     * @return type array
     */
    public function getCongregationFollowMap($followerId)
    {
        $congregationFollowMap = array();
        $follows = $this->getFollows($followerId);

        foreach ($follows as $follow)
        {
            $congregationFollowMap[$follow['Leader']['id']] = $follow['CongregationFollow']['id'];
        }

        return $congregationFollowMap;
    }
}
