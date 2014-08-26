<div class="members form">
    <?php echo $this->Form->create('Member', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php echo __('Edit Member'); ?></legend>
        <?php
        echo $this->Form->input('id');
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
        echo $this->Html->image('members/' . $this->request->data['Member']['profile_picture']);
        echo $this->Form->input('profile_picture', array('type' => 'file'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>