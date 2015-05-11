<?php

App::uses('AppController', 'Controller');
App::uses('AnnouncementRequestStatus', 'Model');

/**
 * AnnouncementRequests Controller
 *
 * @property AnnouncementRequest $AnnouncementRequest
 * @property SessionComponent $Session
 */
class AnnouncementRequestsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $memberId = $this->Auth->user('Member.id');
        //$congregationId = $this->Auth->user('Member.congregation_id');
        //if congregation admin $this->AnnouncementRequest->getCongregationAnnouncementRequests($congregationId);
        $this->set('announcementRequests', $this->AnnouncementRequest->getMembersAnnouncementRequests($memberId));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->AnnouncementRequest->exists($id)) {
            throw new NotFoundException(__('Invalid announcement request'));
        }
        $options = array('conditions' => array('AnnouncementRequest.' . $this->AnnouncementRequest->primaryKey => $id));
        $this->set('announcementRequest', $this->AnnouncementRequest->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {

            $congregationId = $this->Auth->user('Member.congregation_id');
            $memberId = $this->Auth->user('Member.id');

            $this->request->data['AnnouncementRequest']['member_id'] = $memberId;
            $this->request->data['AnnouncementRequest']['congregation_id'] = $congregationId;
            $this->request->data['AnnouncementRequest']['status'] = AnnouncementRequestStatus::PENDING;

            $this->AnnouncementRequest->create();
            if ($this->AnnouncementRequest->save($this->request->data)) {
                $this->Session->setFlash(__('The announcement request has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The announcement request could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->AnnouncementRequest->exists($id)) {
            throw new NotFoundException(__('Invalid announcement request'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->AnnouncementRequest->save($this->request->data)) {
                $this->Session->setFlash(__('The announcement request has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The announcement request could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('AnnouncementRequest.' . $this->AnnouncementRequest->primaryKey => $id));
            $this->request->data = $this->AnnouncementRequest->find('first', $options);
        }
        $congregations = $this->AnnouncementRequest->Congregation->find('list');
        $members = $this->AnnouncementRequest->Member->find('list');
        $this->set(compact('congregations', 'members'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->AnnouncementRequest->id = $id;
        if (!$this->AnnouncementRequest->exists()) {
            throw new NotFoundException(__('Invalid announcement request'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->AnnouncementRequest->delete()) {
            $this->Session->setFlash(__('The announcement request has been deleted.'));
        } else {
            $this->Session->setFlash(__('The announcement request could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
