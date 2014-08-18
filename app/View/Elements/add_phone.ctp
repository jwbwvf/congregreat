<?php

echo $this->Form->input('Phone.number', array('label' => 'Phone Number (555-555-5555)', 'type' => 'text', 
    'maxlength' => '12', 'style' => 'width:150px'));//todo move to class for phone number
echo $this->Form->input('Phone.type', array(
    'options' => array(
        'building' => 'building',
        'cell' => 'cell',
        'home' => 'home',
        'work' => 'work'
    )
));
