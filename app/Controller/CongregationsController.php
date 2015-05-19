<?php
App::uses('AppController', 'Controller');
App::uses('CongregationFollowAction', 'Model');
/**
 * Congregations Controller
 *
 * @property Congregation $Congregation
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CongregationsController extends AppController
{
    private $ADMIN_DIRECTORY = 'Admin/';

    public $components = array('Paginator', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Congregation->recursive = 0;

        $paginator = array('fields' => array('id', 'name', 'website'));

        $this->Paginator->settings = $paginator;
        $this->set('congregations', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $membersCongregationId = $this->Auth->user('Member.congregation_id');
        $this->set('congregation', $this->Congregation->get($id));
        $this->set('followAction', CongregationFollowAction::get($membersCongregationId, $id));
        //todo this should be checking if they are an authorized user to make changes ie admin
        $this->set('canModify', $id === $membersCongregationId);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Congregation->exists($id))
        {
            throw new NotFoundException(__('Invalid congregation'));
        }
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->Congregation->save($this->request->data))
            {
                $this->Session->setFlash(__('The congregation has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The congregation could not be saved. Please, try again.'));
            }
        }
        else
        {
            $this->Congregation->recursive = -1;
            $options = array('conditions' => array('Congregation.' . $this->Congregation->primaryKey => $id),
                'fields' => array('id', 'name', 'website'));
            $this->request->data = $this->Congregation->find('first', $options);
        }
    }

//END Task methods using Prefix Routing/////////////////////////////////////////////////////////////////////////////////

//Admin methods using Prefix Routing////////////////////////////////////////////////////////////////////////////////////
//Using subfolder for the admin views so use $this->render($this->ADMIN_DIRECTORY . __FUNCTION__); at the end of
//every admin method for rendering the correct view
//These are the actions that only the superest of users can take ie me, this excludes users that can edit their own
//congregations info
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function admin_index()
    {
        $this->Congregation->recursive = 0;

        $paginator = array('fields' => array('id', 'name', 'website'));

        $this->Paginator->settings = $paginator;
        $this->set('congregations', $this->Paginator->paginate());
        $membersCongregationId = $this->Auth->user('Member.congregation_id');
        $this->set('congregationFollowMap', $this->Congregation->CongregationFollow->getCongregationFollowMap($membersCongregationId));
        $this->set('congregationId', $membersCongregationId);

        $this->render($this->ADMIN_DIRECTORY . __FUNCTION__);
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add()
    {
        if ($this->request->is('post'))
        {
            if ($this->Congregation->add($this->request->data))
            {
                $this->Session->setFlash(__('The congregation has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The congregation could not be saved. Please, try again.'));
            }
        }

        $this->render($this->ADMIN_DIRECTORY . __FUNCTION__);
    }

    public function admin_view($id = null)
    {
        $this->set('congregation', $this->Congregation->get($id));
        $this->set('followAction', CongregationFollowAction::get($this->Auth->user('Member.congregation_id'), $id));

        $this->render($this->ADMIN_DIRECTORY . __FUNCTION__);
    }

    /**
     * delete method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null)
    {
        $this->request->allowMethod('post', 'delete');
        if ($this->Congregation->delete($id))
        {
            $this->Session->setFlash(__('The congregation has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The congregation could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
//END Admin methods using Prefix Routing////////////////////////////////////////////////////////////////////////////////
}
