<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
    
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    // Filters allowed views
    public function beforeFilter() {
        parent::beforeFilter();
        //this sets the allowed without login
        $this->Auth->allow('login', 'logout');
        
        $this->Auth->authenticate = array('Form' => array(
                'userFields' => array('id', 'Member.id', 'Member.congregation_id')
            )
        );
    }
    
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
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
        if (!$this->User->exists($id))
        {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post'))
        {
            $this->User->create();
            if ($this->User->save($this->request->data))
            {
                $this->Session->setFlash(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $members = $this->User->Member->find('list');
        $this->set(compact('members'));
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
        if (!$this->User->exists($id))
        {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->User->save($this->request->data))
            {
                $this->Session->setFlash(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $members = $this->User->Member->find('list');
        $this->set(compact('members'));
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
        $this->User->id = $id;
        if (!$this->User->exists())
        {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete())
        {
            $this->Session->setFlash(__('The user has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    /**
     * login method
     *
     * @return void
     */
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password.'));
            }
        }
    }

    /**
     * logout method
     *
     * @return void
     */
    public function logout() {        
        $this->redirect($this->Auth->logout());        
    }    

    /**
     * isAuthorized method
     *
     * @param type $user
     * @return boolean true if user is authorized for the controller action
     */
    //todo implement
    public function isAuthorized($user) {
        return true;
        // Any new user can register
        // //todo update will all allowed actions when user is NOT logged in
//        if (in_array($this->action, array('index', 'add', 'view', 'dash'))) {
//            return true;
//        }
        //todo update will all allowed actions when user is logged in
//        if (in_array($this->action, array('edit', 'view'))) {
//            $userId = $this->request->params['pass'][0];
//            if ($this->Auth->user('id') === $userId) {
//                return true;
//            }
//        }

        return parent::isAuthorized($user);
    }    
}
