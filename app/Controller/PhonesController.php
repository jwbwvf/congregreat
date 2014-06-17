<?php

App::uses('AppController', 'Controller');

/**
 * Phones Controller
 *
 * @property Phone $Phone
 * @property SessionComponent $Session
 */
class PhonesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session');

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id, $controller, $action, $ownerId)
    {
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->Phone->save($this->request->data))
            {                
                $refererController = $this->request->data['Referer']['controller'];
                $refererAction = $this->request->data['Referer']['action'];                     
                $refererId = $this->request->data['Referer']['Id'];
                
                $this->Session->setFlash(__('The phone has been saved.'));
                return $this->redirect(array('controller' => $refererController, 'action' => $refererAction, $refererId));
            }
            else
            {
                $this->Session->setFlash(__('The phone could not be saved. Please, try again.'));
            }
        }
        else
        {            
            $this->request->data = $this->Phone->getPhone($id);
        }
        $this->set('controller', $controller);
        $this->set('action', $action);
        $this->set('ownerId', $ownerId);
    }

}
