<?php
App::uses('AppController', 'Controller');

/**
 * CongregationEmailAddresses Controller
 *
 * @property CongregationEmailAddress $CongregationEmailAddress
 * @property SessionComponent $Session
 */
class CongregationEmailAddressesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session');

    /**
     * Adds a new email address to a congregation
     * The congregation will always be the one the user is a member of
     * This should only be allowed to be called by congregation admins
     * @return void, redirect to the congregations view page
     */
    public function add()
    {
        if ($this->request->is('post'))
        {
            $congregationId = $this->Auth->user('Member.congregation_id');
            $this->request->data['CongregationEmailAddress']['congregation_id'] = $congregationId;
            if ($this->CongregationEmailAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The email address has been saved for the congregation.'));
                return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $congregationId));
            }
            else
            {
                $this->Session->setFlash(__('The email address could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Edits an existing email address for a congregation
     * The congregation will always be the one the user is a member of
     * This should only be allowed to be called by congregation admins
     * @throws NotFoundException
     * @param string $id of the CongregationEmailAddress to edit
     * @return void, redirect to the congregations view page
     */
    public function edit($id)
    {
        $congregationEmailAddress = $this->CongregationEmailAddress->get($id);
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->CongregationEmailAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The email address has been saved.'));
                return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $congregationEmailAddress['CongregationEmailAddress']['congregation_id']));
            }
            else
            {
                $this->Session->setFlash(__('The email address could not be saved. Please, try again.'));
            }
        }
        else
        {
            $this->request->data = $congregationEmailAddress;
        }
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
        $this->CongregationEmailAddress->id = $id;
        //todo verify this is the members congregation before allowing delete
        //todo verify the member has access control rights to delete
        if (!$this->CongregationEmailAddress->exists())
        {
            throw new NotFoundException(__('Invalid email address'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->CongregationEmailAddress->delete())
        {
            $this->Session->setFlash(__('The email address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The email address could not be deleted. Please, try again.'));
        }

        $congregationId = $this->Auth->user('Member.congregation_id');
        return $this->redirect(array('controller' => 'Congregations', 'action' => 'view', $congregationId));
    }
}
