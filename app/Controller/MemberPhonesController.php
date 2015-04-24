<?php
App::uses('AppController', 'Controller');
/**
 * MemberPhones Controller
 *
 * @property MemberPhones $MemberPhones
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MemberPhonesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

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