<?php
App::uses('AppController', 'Controller');
/**
 * MemberEmailAddresses Controller
 *
 * @property MemberEmailAddress $MemberEmailAddress
 * @property SessionComponent $Session
 */
class MemberEmailAddressesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Session');

    /**
     * Adds a new email address to a member
     * The member will always be the one logged in
     * This should only be allowed to be called by the current member logged in
     * @return void, redirect to the member view page
     */
    public function add()
    {
        if ($this->request->is('post'))
        {
            $memberId = $this->Auth->user('Member.id');
            $this->request->data['MemberEmailAddress']['member_id'] = $memberId;
            if ($this->MemberEmailAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s email address has been saved.'));
                return $this->redirect(array('controller' => 'members', 'action' => 'view', $memberId));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s email address could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Edits an existing email address for a member
     * The member will always be the one logged in
     * This should only be allowed to be called by the member themselves
     * @throws NotFoundException
     * @param string $id of the CongregationEmailAddress to edit
     * @return void, redirect to the member view page
     */
    public function edit($id)
    {
        $memberEmailAddress = $this->MemberEmailAddress->get($id);
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->MemberEmailAddress->save($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s email address has been saved.'));
                return $this->redirect(array('controller' => 'members', 'action' => 'view', $memberEmailAddress['MemberEmailAddress']['member_id']));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s email address could not be saved. Please, try again.'));
            }
        }
        else
        {
            $this->request->data = $memberEmailAddress;
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
        $this->MemberEmailAddress->id = $id;
        //todo verify this is the members congregation before allowing delete
        //todo verify the member has access control rights to delete
        if (!$this->MemberEmailAddress->exists())
        {
            throw new NotFoundException(__('Invalid address'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->MemberEmailAddress->delete())
        {
            $this->Session->setFlash(__('The email address has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The email address could not be deleted. Please, try again.'));
        }

        $memberId = $this->Auth->user('Member.id');
        return $this->redirect(array('controller' => 'Members', 'action' => 'view', $memberId));
    }
}