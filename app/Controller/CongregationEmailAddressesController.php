<?php
App::uses('AppController', 'Controller');
/**
 * CongregationEmailAddresses Controller
 *
 * @property CongregationEmailAddress $CongregationEmailAddress
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CongregationEmailAddressesController extends AppController {

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
    
    /**
     * adimin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null)
    {
        $this->delete($id);
    }    
}
