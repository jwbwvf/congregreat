<?php
App::uses('AppController', 'Controller');
/**
 * MemberAddresses Controller
 *
 * @property MemberAddress $MemberAddress
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MemberAddressesController extends AppController {

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