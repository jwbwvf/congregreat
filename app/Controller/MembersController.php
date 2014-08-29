<?php

App::uses('AppController', 'Controller');

/**
 * Members Controller
 *
 * @property Member $Member
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MembersController extends AppController
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
        $this->Member->recursive = 0;
        $this->set('members', $this->Paginator->paginate());
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
        $this->set('member', $this->Member->get($id));
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
            //store the picture on the file system, set the name of the picture to be stored in the database on Members
            $this->request->data['Member']['profile_picture'] = $this->Member->storeProfilePicture($this->request->data);
            
            if ($this->Member->add($this->request->data))
            {
                $this->Session->setFlash(__('The member has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The member could not be saved. Please, try again.'));
            }
        }
        
        $congregations = $this->Member->Congregation->find('list');
        $this->set(compact('congregations'));        
    }
    
    /**
     * Adds a phone number to an existing member
     * @param string $id member identifier
     * @return void
     * @throws NotFoundException
     */
    public function addPhoneNumber($id)
    {        
        if ($this->request->is('post'))
        {            
            if ($this->Member->addPhoneNumber($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s phone number has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s phone number could not be saved. Please, try again.'));
            }
        }
                
        $this->set('member', $this->Member->get($id));        
    }    
    
    /**
     * Adds an email address to an existing member
     * @param string $id member identifier
     * @return void
     * @throws NotFoundException
     */    
    public function addEmailAddress($id)
    {
        if ($this->request->is('post'))
        {            
            if ($this->Member->addEmailAddress($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s email address has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s email address could not be saved. Please, try again.'));
            }
        }
                
        $this->set('member', $this->Member->get($id));          
    }    

    /**
     * Adds an address to an existing member
     * @param string $id member identifier
     * @return void
     * @throws NotFoundException
     */    
    public function addAddress($id)
    {
        if ($this->request->is('post'))
        {            
            if ($this->Member->addAddress($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s address has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s address could not be saved. Please, try again.'));
            }
        }
                
        $this->set('member', $this->Member->get($id));          
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
        if (!$this->Member->exists($id))
        {
            throw new NotFoundException(__('Invalid member'));
        }
        if ($this->request->is(array('post', 'put')))
        {
            //store the picture on the file system, set the name of the picture to be stored in the database on Members
            $this->request->data['Member']['profile_picture'] = $this->Member->storeProfilePicture($this->request->data);
            
            if ($this->Member->save($this->request->data))
            {
                $this->Session->setFlash(__('The member has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The member could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
            $this->request->data = $this->Member->find('first', $options);
        }
        $congregations = $this->Member->Congregation->find('list');
        $this->set(compact('congregations'));
    }
    
    public function editPhone($id, $phoneId)
    {
        $this->editModel($id, $phoneId, 'Phone', 'phone');
    }
    
    public function editEmailAddress($id, $emailAddressId)
    {
        $this->editModel($id, $emailAddressId, 'EmailAddress', 'email address');
    }
    
    public function editAddress($id, $addressId)
    {
        $this->editModel($id, $addressId, 'Address', 'address');
    }
    
    private function editModel($id, $modelId, $model, $modelLabel)
    {
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->Member->$model->save($this->request->data))
            {                
                $this->Session->setFlash(__('The ' . $modelLabel . ' has been saved.'));
                return $this->redirect(array('action' => 'view', $this->request->data['Member']['id']));
            }
            else
            {
                $this->Session->setFlash(__('The ' . $modelLabel . ' could not be saved. Please, try again.'));
            }
        }
        else
        {            
            $this->request->data = $this->Member->$model->get($modelId);
        }
    
        $this->set('memberId', $id);        
    }   
        
    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->onlyAllow('post', 'delete');
        if ($this->Member->delete($id))
        {
            $this->Session->setFlash(__('The member has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The member could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * deletes the member's phone relationship and deletes the phone if it's not in use by anything else
     * @param int $id identifier of the @Member the @Phone belongs to
     * @param int $phoneNumberId identifier of the @Phone to delete
     * @return void
     * @throws NotFoundException
     */
    public function deletePhoneNumber($id, $phoneNumberId)
    {
        $this->Member->id = $id;
        if (!$this->Member->exists())
        {
            throw new NotFoundException(__('Invalid member'));
        }    
        $this->request->onlyAllow('post', 'delete');
        if ($this->Member->deletePhoneNumber($phoneNumberId))
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
     * deletes the member's email address relationship and deletes
     * the email address if it's not in use by anything else
     * @param int $id identifier of the @Member the @EmailAddress belongs to
     * @param int $emailAddressId identifier of the @EmailAddress to delete
     * @return void
     * @throws NotFoundException
     */
    public function deleteEmailAddress($id, $emailAddressId)
    {
        $this->Member->id = $id;
        if (!$this->Member->exists())
        {
            throw new NotFoundException(__('Invalid member'));
        }    
        $this->request->onlyAllow('post', 'delete');
        if ($this->Member->deleteEmailAddress($emailAddressId))
        {
            $this->Session->setFlash(__('The email address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The email address could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());        
    }
    
    /**
     * deletes the member's address relationship and deletes the address if it's not in use by anything else
     * @param int $id identifier of the @Member the @Address belongs to
     * @param int $addressId identifier of the @Address to delete
     * @return void
     * @throws NotFoundException
     */
    public function deleteAddress($id, $addressId)
    {
        $this->Member->id = $id;
        if (!$this->Member->exists())
        {
            throw new NotFoundException(__('Invalid member'));
        }    
        $this->request->onlyAllow('post', 'delete');
        if ($this->Member->deleteAddress($addressId))
        {
            $this->Session->setFlash(__('The address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The address could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());        
    }    
    
    public function addImage()
    {
        if ($this->request->is('post'))
        {            
            $this->request->data['Member']['profile_picture'] = $this->Member->storeProfilePicture($this->request->data);
            $this->Member->save();
        }        
    }    
}
