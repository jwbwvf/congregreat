<?php echo $this->Form->create('Member'); ?>
<fieldset>
    <legend><?php echo __('Add Member'); ?></legend>
    <?php
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
//        echo $this->Form->input('birthdate');
//        echo $this->Form->input('anniversary');
    ?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>