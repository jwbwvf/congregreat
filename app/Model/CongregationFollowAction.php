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
     * no action, follow, stop following, cancel pending follow request
     * @param int $currentCongregationId - the id of the congregation the logged in user is a member of
     * @param int $viewCongregationId - the id of the congregation that is being viewed
     * @return array empty if there are no actions to take
     * else the array will contain the views label, the controllers action, and the parameter for the action
     */
    public static function get($currentCongregationId, $viewCongregationId)
    {
        $followAction = array();

        if ($currentCongregationId === $viewCongregationId)
        {
            return $followAction;//no action return empty array
        }

        $congregationFollow = ClassRegistry::init('CongregationFollow');
        $congregationFollow->create();

        $followId = $congregationFollow->getFollowId($currentCongregationId, $viewCongregationId);
        if ($followId > 0)
        {
            $followAction['action'] = CongregationFollowActions::STOP;
            $followAction['label'] = CongregationFollowActionLabels::STOP;
            $followAction['param'] = $followId;
            $followAction['viewId'] = $viewCongregationId;

            return $followAction;
        }

        $congregationFollowRequest = ClassRegistry::init('CongregationFollowRequest');
        $congregationFollowRequest->create();

        $followRequestId = $congregationFollowRequest->getPendingFollowRequestId($viewCongregationId, $currentCongregationId);
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
}

