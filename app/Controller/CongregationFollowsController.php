<?php
App::uses('AppController', 'Controller');

class CongregationFollowsController extends AppController
{
    public $components = array('Session');

    public function following()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('follows', $this->CongregationFollow->getFollows($congregationId));
    }

    public function followers()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('followers', $this->CongregationFollow->getFollowers($congregationId));
    }

    public function stopFollowing($followId, $viewId)
    {
        $this->request->allowMethod('post');
        if ($this->CongregationFollow->stopFollowing($followId))
        {
            $this->Session->setFlash(__('No longer following the congregation.'));
            return $this->redirect(array('action' => 'view', $viewId));
        }
        else
        {
            $this->Session->setFlash(__('Unable to stop following the congregation. Please, try again.'));
        }
    }
}
