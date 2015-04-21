<?php

class ContactableModel extends AppModel
{
    /**
     * saves a ContactableModel and it's related data phone, email, address
     * @param array $data form data submitted from View/[Model]/add.ctp
     * @return bool returns saveAll
     */
    public function add($data)
    {
        $this->addAddress($data);
        $this->addEmailAddress($data);
        $this->addPhoneNumber($data);

        return true;
    }

    /**
     * checks if a related model is valid
     * @param type $model related model to the ContactableModel
     * @param array $data contents of the model to verify
     * @return boolean
     */
    protected function isRelatedModelValid($model, $data)
    {
        return $this->$model->saveAll($data[$model], array('validate' => 'only'));
    }

    protected function isValid($data)
    {
        return $this->saveAll($data[get_class($this)], array('validate' => 'only'));
    }

    /**
     * adds a new @Phone to the ContactableModel
     * @param array $data form data submitted from View/[Model]/view/add_phone_number.ctp
     * @return mixed boolean false if save fails
     * array of @Phone added if successful
     */
    public function addPhoneNumber($data)
    {
        return $this->addModel($data, get_called_class() . 'Phone');
    }

    /**
     * adds a new @EmailAddress to the ContactableModel
     * @param array $data form data submitted from View/[Model]/view/add_email_address.ctp
     * @return mixed boolean false if save fails
     * array of @EmailAddress added if successful
     */
    public function addEmailAddress($data)
    {
        return $this->addModel($data, get_called_class() . 'EmailAddress');
    }

    /**
     * adds a new @Address to the ContactableModel
     * @param array $data form data submitted from View/[Model]/view/add_address.ctp
     * @return mixed boolean false if save fails
     * array of @Address added if successful
     */
    public function addAddress($data)
    {
        return $this->addModel($data, get_called_class() . 'Address');
    }

    public function addModel($data, $model)
    {
        $this->$model->create();
        if ($this->isRelatedModelValid($model, $data) === false)
        {
            return false;
        }

        return $this->$model->save($data, false);
    }
}
