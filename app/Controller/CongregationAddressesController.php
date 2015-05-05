<?php
App::uses('AppController', 'Controller');
/**
 * CongregationAddresses Controller
 *
 * @property CongregationAddress $CongregationAddress
 * @property SessionComponent $Session
 */
class CongregationAddressesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Session');

    /**
     * Adds a new address to a congregation
     * The congregation will always be the one the user is a member of
     * This should only be allowed to be called by congregation admins
     * @return void, redirect to the congregations view page
     */
    public function add()
    {
        if ($this->request->is('post'))
        {
            $congregationId = $this->Auth->user('Member.congregation_id');
            $this->request->data['CongregationAddress']['congregation_id'] = $congregationId;
            if ($this->CongregationAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The address has been saved for the congregation.'));
                return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $congregationId));
            }
            else
            {
                $this->Session->setFlash(__('The address could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Edits an existing address for a congregation
     * The congregation will always be the one the user is a member of
     * This should only be allowed to be called by congregation admins
     * @throws NotFoundException
     * @param string $id of the CongregationAddress to edit
     * @return void, redirect to the congregations view page
     */
    public function edit($id)
    {
        $congregationAddress = $this->CongregationAddress->get($id);
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->CongregationAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The address has been saved.'));
                return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $congregationAddress['CongregationAddress']['congregation_id']));
            }
            else
            {
                $this->Session->setFlash(__('The address could not be saved. Please, try again.'));
            }
        }
        else
        {
            $this->request->data = $congregationAddress;
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
        $this->CongregationAddress->id = $id;
        //todo verify this is the members congregation before allowing delete
        //todo verify the member has access control rights to delete
        if (!$this->CongregationAddress->exists())
        {
            throw new NotFoundException(__('Invalid address'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->CongregationAddress->delete())
        {
            $this->Session->setFlash(__('The address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The address could not be deleted. Please, try again.'));
        }
        $congregationId = $this->Auth->user('Member.congregation_id');
        return $this->redirect(array('controller' => 'Congregations', 'action' => 'view', $congregationId));
    }
}
