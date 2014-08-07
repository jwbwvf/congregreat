<?php
    echo $this->Html->image('members/Jason Brady.jpg');
    echo $this->Form->create('Member', array('type' => 'file'));
    echo $this->Form->input('image', array('type' => 'file'));
    echo $this->Form->end(__('Submit'));
