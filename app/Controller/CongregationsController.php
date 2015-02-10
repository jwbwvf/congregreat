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
    private $ADMIN_DIRECTORY = 'Admin/';
    private $TASK_DIRECTORY = 'Task/';       
    
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
        $membersCongregationId = $this->Auth->user('Member.congregation_id');
        $this->set('congregation', $this->Congregation->get($id));
        $this->set('followAction', $this->Congregation->getFollowAction($membersCongregationId, $id));
        $this->set('canModify', $id === $membersCongregationId);
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
    public function requestToFollow($leaderId, $viewId)
    {   
        //TODO need ACL for this, check if privileged enough to request to follow another congregation 
        //i.e. elder, deacon, admin decides for the congregation what other congregations they want to follow
        $this->request->onlyAllow('post');
        $requestingFollowerId = $this->Auth->user('Member.congregation_id');
        if ($this->Congregation->addFollowRequest($requestingFollowerId, $leaderId))
        {
            $this->Session->setFlash(__('A request to follow the congregation has been sent.'));
            return $this->redirect(array('action' => 'view', $viewId));
        }
        else
        {
            $this->Session->setFlash(__('Unable to send a request to follow the congregation. Please, try again.'));
        }     
    }        
    
    public function followRequests()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('followRequests', $this->Congregation->getFollowRequests($congregationId));
    }    
    
    public function myPendingRequests()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('followRequests', $this->Congregation->getMyPendingRequests($congregationId));        
    }
    
    public function acceptFollowRequest($followRequestId)
    {
        $this->request->onlyAllow('post');
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
        $this->request->onlyAllow('post');
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
    
    public function cancelFollowRequest($followRequestId, $viewId)
    {
        $this->request->onlyAllow('post');
        if ($this->Congregation->cancelFollowRequest($followRequestId))
        {
            $this->Session->setFlash(__('The follow request has been cancelled.'));
            return $this->redirect(array('action' => 'view', $viewId));
        }
        else
        {
            $this->Session->setFlash(__('Unable to cancel the follow request. Please, try again.'));
        }        
    }
    
    public function following()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('follows', $this->Congregation->getFollows($congregationId));
    }
    
    public function followers()
    {
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('followers', $this->Congregation->getFollowers($congregationId));        
    }
    
    public function stopFollowing($followId, $viewId)
    {
        $this->request->onlyAllow('post');
        if ($this->Congregation->stopFollowing($followId))
        {
            $this->Session->setFlash(__('No longer following the congregation.'));
            return $this->redirect(array('action' => 'view', $viewId));
        }
        else
        {
            $this->Session->setFlash(__('Unable to stop following the congregation. Please, try again.'));
        }
    }

//Task methods//////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    public function task_index() 
    {        
        $congregationId = $this->Auth->user('Member.congregation_id');
        $this->set('tasks', $this->Congregation->getTasks($congregationId));
        
        $this->render($this->TASK_DIRECTORY . __FUNCTION__);
    }
    
    public function task_add()
    {
        if ($this->request->is('post'))
        {            
            $congregationId = $this->Auth->user('Member.congregation_id');
            $this->request->data['Task']['congregation_id'] = $congregationId;
            if ($this->Congregation->Task->save($this->request->data))
            {
                $this->Session->setFlash(__('The task has been saved for the congregation.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The task could not be saved. Please, try again.'));
            }
        }
        
        $this->render($this->TASK_DIRECTORY . __FUNCTION__);
    }
    
    public function task_view($id = null)
    {
        $this->set('task', $this->Congregation->Task->get($id));
        
        $this->render($this->TASK_DIRECTORY . __FUNCTION__);
    }
    
    
//END Task methods using Prefix Routing/////////////////////////////////////////////////////////////////////////////////
    
//Admin methods using Prefix Routing////////////////////////////////////////////////////////////////////////////////////
//Using subfolder for the admin views so use $this->render($this->ADMIN_DIRECTORY . __FUNCTION__); at the end of 
//every admin method for rendering the correct view
//These are the actions that only the superest of users can take ie me, this excludes users that can edit their own
//congregations info
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function admin_index()
    {
        $this->Congregation->recursive = 0;
                
        $paginator = array('fields' => array('id', 'name', 'website'));

        $this->Paginator->settings = $paginator;
        $this->set('congregations', $this->Paginator->paginate());
        $membersCongregationId = $this->Auth->user('Member.congregation_id');
        $this->set('congregationFollowMap', $this->Congregation->getCongregationFollowMap($membersCongregationId));
        $this->set('congregationId', $membersCongregationId);   
        
        $this->render($this->ADMIN_DIRECTORY . __FUNCTION__);
    }
    
    /**
     * add method
     *
     * @return void
     */
    public function admin_add()
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
        
        $this->render($this->ADMIN_DIRECTORY . __FUNCTION__);
    }
    
    public function admin_view($id = null)    
    {       
        $this->set('congregation', $this->Congregation->get($id));   
        $this->set('followAction', $this->Congregation->getFollowAction($this->Auth->user('Member.congregation_id'), $id));
        
        $this->render($this->ADMIN_DIRECTORY . __FUNCTION__);
    }
    
    /**
     * delete method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null)
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
//END Admin methods using Prefix Routing////////////////////////////////////////////////////////////////////////////////
}
