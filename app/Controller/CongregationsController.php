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
        $this->set('congregation', $this->Congregation->get($id));    
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
                
        $this->set('congregation', $this->Congregation->get($id));        
    }

    /**
     * Adds an email address to an existing congregation
     * @param string $id congregation identifier
     * @return void
     * @throws NotFoundException
     */    
    public function addEmailAddress($id)
    {
        if ($this->request->is('post'))
        {            
            if ($this->Congregation->addEmailAddress($this->request->data))
            {
                $this->Session->setFlash(__('The congregation\'s email address has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            }
            else
            {
                $this->Session->setFlash(__('The congregation\'s email address could not be saved. Please, try again.'));
            }
        }
                
        $this->set('congregation', $this->Congregation->get($id));          
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
            $this->request->data = $this->Congregation->get($id);
        }
        $addresses = $this->Congregation->Address->find('list');
        $emailAddresses = $this->Congregation->EmailAddress->find('list');
        $phones = $this->Congregation->Phone->find('list');
        $this->set(compact('addresses', 'emailAddresses', 'phones'));
    }

    /**
     * delete method
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

    /**
     * deletes the congregation's phone relationship and deletes
     * the phone if it's not in use by anything else
     * @param int $id identifier of the @Congregation the @Phone belongs to
     * @param int $phoneNumberId identifier of the @Phone to delete
     * @return void
     * @throws NotFoundException
     */
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
            $this->Session->setFlash(__('The phone number has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The phone number could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }
    
    /**
     * deletes the congregation's email address relationship and deletes
     * the email address if it's not in use by anything else
     * @param int $id identifier of the @Congregation the @EmailAddress belongs to
     * @param int $emailAddressId identifier of the @EmailAddress to delete
     * @return void
     * @throws NotFoundException
     */
    public function deleteEmailAddress($id, $emailAddressId)
    {
        $this->Congregation->id = $id;
        if (!$this->Congregation->exists())
        {
            throw new NotFoundException(__('Invalid congregation'));
        }    
        $this->request->onlyAllow('post', 'delete');
        if ($this->Congregation->deleteEmailAddress($emailAddressId))
        {
            $this->Session->setFlash(__('The email address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The email address could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());        
    }
    
    public function editPhone($id, $phoneId)
    {
        $this->editModel($id, $phoneId, 'Phone', 'phone');
    }
    
    public function editEmailAddress($id, $emailAddressId)
    {
        $this->editModel($id, $emailAddressId, 'EmailAddress', 'email address');
    }
    
    private function editModel($id, $modelId, $model, $modelLabel)
    {
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->Congregation->$model->save($this->request->data))
            {                
                $this->Session->setFlash(__('The ' . $modelLabel . ' has been saved.'));
                return $this->redirect(array('action' => 'view', $this->request->data['Congregation']['id']));
            }
            else
            {
                $this->Session->setFlash(__('The ' . $modelLabel . ' could not be saved. Please, try again.'));
            }
        }
        else
        {            
            $this->request->data = $this->Congregation->$model->get($modelId);
        }
    
        $this->set('congregationId', $id);        
    }
}
