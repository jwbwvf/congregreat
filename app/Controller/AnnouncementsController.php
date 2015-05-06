<?php
App::uses('AppController', 'Controller');
/**
 * Announcements Controller
 *
 * @property Announcement $Announcement
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AnnouncementsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Announcement->recursive = 0;
		$this->set('announcements', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Announcement->exists($id)) {
			throw new NotFoundException(__('Invalid announcement'));
		}
		$options = array('conditions' => array('Announcement.' . $this->Announcement->primaryKey => $id));
		$this->set('announcement', $this->Announcement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Announcement->create();
			if ($this->Announcement->save($this->request->data)) {
				$this->Session->setFlash(__('The announcement has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The announcement could not be saved. Please, try again.'));
			}
		}
		$congregations = $this->Announcement->Congregation->find('list');
		$this->set(compact('congregations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Announcement->exists($id)) {
			throw new NotFoundException(__('Invalid announcement'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Announcement->save($this->request->data)) {
				$this->Session->setFlash(__('The announcement has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The announcement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Announcement.' . $this->Announcement->primaryKey => $id));
			$this->request->data = $this->Announcement->find('first', $options);
		}
		$congregations = $this->Announcement->Congregation->find('list');
		$this->set(compact('congregations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Announcement->id = $id;
		if (!$this->Announcement->exists()) {
			throw new NotFoundException(__('Invalid announcement'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Announcement->delete()) {
			$this->Session->setFlash(__('The announcement has been deleted.'));
		} else {
			$this->Session->setFlash(__('The announcement could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
