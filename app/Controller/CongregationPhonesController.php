<?php
App::uses('AppController', 'Controller');
/**
 * CongregationPhones Controller
 *
 * @property CongregationPhones $CongregationPhones
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CongregationPhonesController extends AppController {

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