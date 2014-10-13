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
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'leader_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )        
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Follower' => array(
            'className' => 'Congregation',
            'foreignKey' => 'follower_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Leader' => array(
            'className' => 'Congregation',
            'foreignKey' => 'leader_id',
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
}
