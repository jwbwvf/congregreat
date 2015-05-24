<?php
App::uses('AppController', 'Controller');

class CongregationFollowRequestsController extends AppController
{
    public $components = array('Session');

    /**
     *
     * @param int $leaderId the id of the congregation to be followed
     * @return type
     */
    public function add($leaderId, $viewId)
    {
        //TODO need ACL for this, check if privileged enough to request to follow another congregation
        //i.e. elder, deacon, admin decides for the congregation what other congregations they want to follow
        $this->request->allowMethod('post');
        $requestingFollowerId = $this->Auth->user('Member.congregation_id');
        if ($this->CongregationFollowRequest->add($requestingFollowerId, $leaderId))
        {
            $this->Session->setFlash(__('A request to follow the congregation has been sent.'));
            return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $viewId));
        }
        else
        {
            $this->Session->setFlash(__('Unable to send a request to follow the congregation. Please, try again.'));
        }
    }

    public function index()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('followRequests', $this->CongregationFollowRequest->getAll($congregationId));
    }

    public function pending()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('followRequests', $this->CongregationFollowRequest->getPending($congregationId));
    }

    public function accept($followRequestId)
    {
        $this->request->allowMethod('post');
        if ($this->CongregationFollowRequest->accept($followRequestId))
        {
            $this->Session->setFlash(__('The follow request has been accepted.'));
            return $this->redirect(array('action' => 'index'));
        }
        else
        {
            $this->Session->setFlash(__('Unable to accept the follow request. Please, try again.'));
        }
    }

    public function reject($followRequestId)
    {
        $this->request->allowMethod('post');
        if ($this->CongregationFollowRequest->reject($followRequestId))
        {
            $this->Session->setFlash(__('The follow request has been rejected.'));
            return $this->redirect(array('action' => 'index'));
        }
        else
        {
            $this->Session->setFlash(__('Unable to reject the follow request. Please, try again.'));
        }
    }

    public function cancel($followRequestId, $viewId)
    {
        $this->request->allowMethod('post');
        if ($this->CongregationFollowRequest->cancelFollowRequest($followRequestId))
        {
            $this->Session->setFlash(__('The follow request has been cancelled.'));
            return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $viewId));
        }
        else
        {
            $this->Session->setFlash(__('Unable to cancel the follow request. Please, try again.'));
        }
    }
}
