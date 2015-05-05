<?php
App::uses('AppController', 'Controller');
/**
 * MemberAddresses Controller
 *
 * @property MemberAddress $MemberAddress
 * @property SessionComponent $Session
 */
class MemberAddressesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Session');

    /**
     * Adds a new address to a member
     * The member will always be the one logged in
     * This should only be allowed to be called for the member logged in by the member logged in
     * @return void, redirect to the members view page
     */
    public function add()
    {
        if ($this->request->is('post'))
        {
            $memberId = $this->Auth->user('Member.id');
            $this->request->data['MemberAddress']['member_id'] = $memberId;
            if ($this->MemberAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s address has been saved.'));
                return $this->redirect(array('controller' => 'members', 'action' => 'view', $memberId));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s address could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Edits an existing address for a member
     * The member will always be the one logged in
     * This should only be allowed to be called by the member themselves
     * @throws NotFoundException
     * @param string $id of the CongregationAddress to edit
     * @return void, redirect to the congregations view page
     */
    public function edit($id)
    {
        $memberAddress = $this->MemberAddress->get($id);
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->MemberAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The address has been saved.'));
                return $this->redirect(array('controller' => 'members', 'action' => 'view', $memberAddress['MemberAddress']['member_id']));
            }
            else
            {
                $this->Session->setFlash(__('The address could not be saved. Please, try again.'));
            }
        }
        else
        {
            $this->request->data = $memberAddress;
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
        $this->MemberAddress->id = $id;
        //todo verify this is the members congregation before allowing delete
        //todo verify the member has access control rights to delete
        if (!$this->MemberAddress->exists())
        {
            throw new NotFoundException(__('Invalid address'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->MemberAddress->delete())
        {
            $this->Session->setFlash(__('The address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The address could not be deleted. Please, try again.'));
        }

        $memberId = $this->Auth->user('Member.id');
        return $this->redirect(array('controller' => 'Members', 'action' => 'view', $memberId));
    }
}