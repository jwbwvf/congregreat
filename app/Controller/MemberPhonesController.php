<?php
App::uses('AppController', 'Controller');
/**
 * MemberPhones Controller
 *
 * @property MemberPhones $MemberPhones
 * @property SessionComponent $Session
 */
class MemberPhonesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session');

    /**
     * Adds a new phone to a member
     * The member will always be the one logged in
     * This should only be allowed to be called for the member logged in by the member logged in
     * @return void, redirect to the members view page
     */
    public function add()
    {
        if ($this->request->is('post'))
        {
            $memberId = $this->Auth->user('Member.id');
            $this->request->data['MemberPhone']['member_id'] = $memberId;
            if ($this->MemberPhone->save($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s phone has been saved.'));
                return $this->redirect(array('controller' => 'members', 'action' => 'view', $memberId));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s phone could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Edits an existing phone for a member
     * The member will always be the one logged in
     * This should only be allowed to be called by the member themselves
     * @throws NotFoundException
     * @param string $id of the MemberPhone to edit
     * @return void, redirect to the member view page
     */
    public function edit($id)
    {
        $memberPhone = $this->MemberPhone->get($id);
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->MemberPhone->save($this->request->data))
            {
                $this->Session->setFlash(__('The member\'s phone has been saved.'));
                return $this->redirect(array('controller' => 'members', 'action' => 'view', $memberPhone['MemberPhone']['member_id']));
            }
            else
            {
                $this->Session->setFlash(__('The member\'s phone could not be saved. Please, try again.'));
            }
        }
        else
        {
            $this->request->data = $memberPhone;
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
        $this->MemberPhone->id = $id;
        //todo verify this is the members member before allowing delete
        //todo verify the member has access control rights to delete
        if (!$this->MemberPhone->exists())
        {
            throw new NotFoundException(__('Invalid phone'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->MemberPhone->delete())
        {
            $this->Session->setFlash(__('The phone has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The phone could not be deleted. Please, try again.'));
        }

        $memberId = $this->Auth->user('Member.id');
        return $this->redirect(array('controller' => 'Members', 'action' => 'view', $memberId));
    }
}