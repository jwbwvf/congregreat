<?php
App::uses('CongregationFollowActions', 'Model');
App::uses('CongregationFollowActionLabels', 'Model');

class CongregationFollowAction
{
    private function __construct()
    {
        //empty private constructor to prevent instance
    }

    /**
     * Finds what action can be taken given a current congregation(logged in as member of) viewing congregation
     * no action, request to follow, stop following, cancel pending follow request
     * @param int $followerId - the id of the congregation will take the action
     * @param int $leaderId - the id of the congregation that is being followed, pending requested to follow, or
     *                          requesting to follow
     * @return array empty if there are no actions to take
     * else the array will contain the views label, the controllers action, and the parameter for the action
     */
    public static function get($followerId, $leaderId)
    {
        if ($followerId === $leaderId)
        {
            return array();//no action return empty array
        }

        $congregationFollow = ClassRegistry::init('CongregationFollow');
        $congregationFollow->create();

        $followId = $congregationFollow->getFollowId($followerId, $leaderId);
        if ($followId > 0)
        {
            return CongregationFollowAction::getStopFollowing($followId, $leaderId);
        }

        $congregationFollowRequest = ClassRegistry::init('CongregationFollowRequest');
        $congregationFollowRequest->create();

        $followRequestId = $congregationFollowRequest->getIdByLeaderFollower($leaderId, $followerId);
        if ($followRequestId > 0)
        {
            return CongregationFollowAction::getCancelRequest($followRequestId, $leaderId);
        }

        return CongregationFollowAction::getAddRequest($leaderId);
    }

    private static function getStopFollowing($followId, $leaderId)
    {
        return array(
            'controller' => 'congregationFollows',
            'action' => CongregationFollowActions::STOP_FOLLOWING,
            'label' => CongregationFollowActionLabels::STOP_FOLLOWING,
            'param' => $followId,
            'viewId' => $leaderId
        );
    }

    private static function getCancelRequest($followRequestId, $leaderId)
    {
        return array(
            'controller' => 'congregationFollowRequests',
            'action' => CongregationFollowActions::CANCEL_REQUEST,
            'label' => CongregationFollowActionLabels::CANCEL_REQUEST,
            'param' => $followRequestId,
            'viewId' => $leaderId
        );
    }

    private static function getAddRequest($leaderId)
    {
        return array(
            'controller' => 'congregationFollowRequests',
            'action' => CongregationFollowActions::ADD_REQUEST,
            'label' => CongregationFollowActionLabels::ADD_REQUEST,
            'param' => $leaderId,
            'viewId' => $leaderId
        );
    }
}

