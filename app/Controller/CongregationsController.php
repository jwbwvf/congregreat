<?php
App::uses('AppController', 'Controller');

/**
 * Congregations Controller
 *
 * @property Congregation $Congregation
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CongregationsController extends AppController
{

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
    public function index()
    {
        $this->Congregation->recursive = 0;
        $this->set('congregations', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {       
        $this->set('congregation', $this->Congregation->getCongregation($id));    
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post'))
        {                                                
            if ($this->Congregation->add($this->request->data))
            {
                $this->Session->setFlash(__('The congregation has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The congregation could not be saved. Please, try again.'));
            }
        }
    }
    
    /**
     * Adds a phone number to an existing congregation
     * @param string $id congregation identifier
     * @return void
     * @throws NotFoundException
     */
    public function addPhoneNumber($id)
    {        
        if ($this->request->is('post'))
        {            
            if ($this->Congregation->addPhoneNumber($this->request->data))
            {
                $this->Session->setFlash(__('The congregation\'s phone number has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            }
            else
            {
                $this->Session->setFlash(__('The congregation\'s phone number could not be saved. Please, try again.'));
            }
        }
                
        $this->set('congregation', $this->Congregation->getCongregation($id));        
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Congregation->exists($id))
        {
            throw new NotFoundException(__('Invalid congregation'));
        }
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->Congregation->save($this->request->data))
            {
                $this->Session->setFlash(__('The congregation has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The congregation could not be saved. Please, try again.'));
            }
        }
        else
        {            
            $this->request->data = $this->Congregation->getCongregation($id);
        }
        $addresses = $this->Congregation->Address->find('list');
        $emailAddresses = $this->Congregation->EmailAddress->find('list');
        $phones = $this->Congregation->Phone->find('list');
        $this->set(compact('addresses', 'emailAddresses', 'phones'));
    }

    /**
     * delete method
     * this will remove any of the relationships between
     * the congregation and the other models
     * it does not remove the other models
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->Congregation->id = $id;
        if (!$this->Congregation->exists())
        {
            throw new NotFoundException(__('Invalid congregation'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Congregation->delete())
        {
            $this->Session->setFlash(__('The congregation has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The congregation could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function deletePhoneNumber($id, $phoneNumberId)
    {
        $this->Congregation->id = $id;
        if (!$this->Congregation->exists())
        {
            throw new NotFoundException(__('Invalid congregation'));
        }    
        $this->request->onlyAllow('post', 'delete');
        if ($this->Congregation->deletePhoneNumber($phoneNumberId))
        {
            $this->Session->setFlash(__('The phone has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The phone could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }
}
