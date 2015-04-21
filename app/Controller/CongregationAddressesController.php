<?php
App::uses('AppController', 'Controller');
/**
 * CongregationAddresses Controller
 *
 * @property CongregationAddress $CongregationAddress
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CongregationAddressesController extends AppController {

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
