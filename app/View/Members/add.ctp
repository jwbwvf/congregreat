<div class="members form">
    <?php echo $this->Form->create('Member'); ?>
    <fieldset>
        <legend><?php echo __('Add Member'); ?></legend>
        <?php
        echo $this->Form->input('congregation_id');
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('middle_name');
        echo $this->Form->input('gender', array('options' => array('Male' => 'Male', 'Female' => 'Female')));
        echo $this->Form->input('birth_date', array(
            'label' => 'Date of Birth',
            'dateFormat' => 'MDY',
            'minYear' => date('Y') - 100,
            'maxYear' => date('Y')
        ));
        echo $this->Form->input('baptized', array('type' => 'checkbox'));                
        echo $this->Form->input('EmailAddress.email_address', array('type' => 'email', 'maxlength' => 254));        
        echo $this->element('add_phone');        
        echo $this->element('add_address');        
        echo $this->Form->input('profile_picture', array('type' => 'file'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Members'), array('action' => 'index')); ?></li>
    </ul>
</div>
