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

    public function delete($followId, $viewId)
    {
        $this->CongregationFollow->id = $followId;
        if (!$this->CongregationFollow->exists())
        {
            throw new NotFoundException(__('Invalid congregation follow'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->CongregationFollow->delete())
        {
            $this->Session->setFlash(__('No longer following the congregation.'));
            return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $viewId));
        }
        else
        {
            $this->Session->setFlash(__('Unable to stop following the congregation. Please, try again.'));
        }
    }
}
