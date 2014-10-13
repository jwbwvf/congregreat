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
    //TODO;;remove after login session implementation is added
    //this for now is to mimic the current congregation id being set
    //on the session
    public function __construct($request = null, $response = null)
    {
        parent::__construct($request, $response);
        
        //set to an existing congregation id in the dev database
        $this->Session = $this->Components->load('Session');
        $this->Session->write('Congregation.id', 1);
    }
    //END;;TODO
    
    
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
                
        $paginator = array('fields' => array('id', 'name', 'website'));

        $this->Paginator->settings = $paginator;
        $this->set('congregations', $this->Paginator->paginate());
        $this->set('congregationFollowMap', $this->Congregation->getCongregationFollowMap($this->Session->read('Congregation.id')));
        $this->set('congregationId', $this->Session->read('Congregation.id'));
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
        $this->set('congregationId', $this->Session->read('Congregation.id'));
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
     * Adds an address to an existing congregation
     * @param string $id congregation identifier
     * @return void
     * @throws NotFoundException
     */    
    public function addAddress($id)
    {
        if ($this->request->is('post'))
        {            
            if ($this->Congregation->addAddress($this->request->data))
            {
                $this->Session->setFlash(__('The congregation\'s address has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            }
            else
            {
                $this->Session->setFlash(__('The congregation\'s address could not be saved. Please, try again.'));
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
            $this->Congregation->recursive = -1;
            $options = array('conditions' => array('Congregation.' . $this->Congregation->primaryKey => $id),
                'fields' => array('id', 'name', 'website'));
            $this->request->data = $this->Congregation->find('first', $options);
        }
    }

    /**
     * delete method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->onlyAllow('post', 'delete');
        if ($this->Congregation->delete($id))
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
     * deletes the congregation's phone relationship and deletes the phone if it's not in use by anything else
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
    
    /**
     * deletes the congregation's address relationship and deletes the address if it's not in use by anything else
     * @param int $id identifier of the @Congregation the @Address belongs to
     * @param int $addressId identifier of the @Address to delete
     * @return void
     * @throws NotFoundException
     */
    public function deleteAddress($id, $addressId)
    {
        $this->Congregation->id = $id;
        if (!$this->Congregation->exists())
        {
            throw new NotFoundException(__('Invalid congregation'));
        }    
        $this->request->onlyAllow('post', 'delete');
        if ($this->Congregation->deleteAddress($addressId))
        {
            $this->Session->setFlash(__('The address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The address could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());        
    }        
    
    private function editModel($id, $modelId, $model, $modelLabel)
    {
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->Congregation->$model->save($this->request->data))
            {                
                $this->Session->setFlash(__('The ' . $modelLabel . ' has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            }
            else
            {
                $this->Session->setFlash(__('The ' . $modelLabel . ' could not be saved. Please, try again.'));
            }
        }
        else
        {            
            $this->Congregation->$model->recursive = -1;            
            $this->request->data = $this->Congregation->$model->get($modelId);
        }
    
        $this->set('congregationId', $id);        
    }
    
    /**
     * 
     * @param int $leaderId the id of the congregation to be followed
     * @return type
     */
    public function requestToFollow($leaderId)
    {   
        //TODO need ACL for this, check if privileged enough to request to follow another congregation 
        //i.e. elder, deacon, admin decides for the congregation what other congregations they want to follow
        
        $requestingFollowerId = $this->Session->read('Congregation.id');
        if ($this->Congregation->addFollowRequest($requestingFollowerId, $leaderId))
        {
            $this->Session->setFlash(__('A request to follow the congregation has been sent.'));
            return $this->redirect(array('action' => 'index'));
        }
        else
        {
            $this->Session->setFlash(__('Unable to send a request to follow the congregation. Please, try again.'));
        }     
    }        
    
    public function followRequests()
    {
        $congregationId = $this->Session->read('Congregation.id');
        $this->set('followRequests', $this->Congregation->getFollowRequests($congregationId));
    }    
    
    public function acceptFollowRequest($followRequestId)
    {
        if ($this->Congregation->acceptFollowRequest($followRequestId))
        {
            $this->Session->setFlash(__('The follow request has been accepted.'));
            return $this->redirect(array('action' => 'followRequests'));
        }
        else
        {
            $this->Session->setFlash(__('Unable to accept the follow request. Please, try again.'));
        }
    }
    
    public function rejectFollowRequest($followRequestId)
    {
        if ($this->Congregation->rejectFollowRequest($followRequestId))
        {
            $this->Session->setFlash(__('The follow request has been rejected.'));
            return $this->redirect(array('action' => 'followRequests'));
        }
        else
        {
            $this->Session->setFlash(__('Unable to reject the follow request. Please, try again.'));
        }
    }
    
    public function follows()
    {
        $congregationId = $this->Session->read('Congregation.id');
        $this->set('follows', $this->Congregation->getFollows($congregationId));
    }
    
    public function stopFollowing($followId)
    {
        $this->request->onlyAllow('post', 'delete');
        if ($this->Congregation->stopFollowing($followId))
        {
            $this->Session->setFlash(__('No longer following the congregation.'));
            return $this->redirect(array('action' => 'follows'));
        }
        else
        {
            $this->Session->setFlash(__('Unable to stop following the congregation. Please, try again.'));
        }
    }
}
