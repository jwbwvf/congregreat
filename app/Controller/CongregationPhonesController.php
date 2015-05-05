<?php
App::uses('AppController', 'Controller');
/**
 * CongregationPhones Controller
 *
 * @property CongregationPhones $CongregationPhones
 * @property SessionComponent $Session
 */
class CongregationPhonesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Session');

    /**
     * Adds a new phone to a congregation
     * The congregation will always be the one the user is a member of
     * This should only be allowed to be called by congregation admins
     * @return void, redirect to the congregations view page
     */
    public function add()
    {
        if ($this->request->is('post'))
        {
            $congregationId = $this->Auth->user('Member.congregation_id');
            $this->request->data['CongregationPhone']['congregation_id'] = $congregationId;
            if ($this->CongregationPhone->save($this->request->data))
            {
                $this->Session->setFlash(__('The phone has been saved for the congregation.'));
                return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $congregationId));
            }
            else
            {
                $this->Session->setFlash(__('The phone could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Edits an existing phone for a congregation
     * The congregation will always be the one the user is a member of
     * This should only be allowed to be called by congregation admins
     * @throws NotFoundException
     * @param string $id of the CongregationPhone to edit
     * @return void, redirect to the congregations view page
     */
    public function edit($id)
    {
        $congregationPhone = $this->CongregationPhone->get($id);
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->CongregationPhone->save($this->request->data))
            {
                $this->Session->setFlash(__('The phone has been saved.'));
                return $this->redirect(array('controller' => 'congregations', 'action' => 'view', $congregationPhone['CongregationPhone']['congregation_id']));
            }
            else
            {
                $this->Session->setFlash(__('The phone could not be saved. Please, try again.'));
            }
        }
        else
        {
            $this->request->data = $congregationPhone;
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
        $this->CongregationPhone->id = $id;
        //todo verify this is the members congregation before allowing delete
        //todo verify the member has access control rights to delete
        if (!$this->CongregationPhone->exists())
        {
            throw new NotFoundException(__('Invalid phone'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->CongregationPhone->delete())
        {
            $this->Session->setFlash(__('The phone has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The phone could not be deleted. Please, try again.'));
        }
        $congregationId = $this->Auth->user('Member.congregation_id');
        return $this->redirect(array('controller' => 'Congregations', 'action' => 'view', $congregationId));
    }
}