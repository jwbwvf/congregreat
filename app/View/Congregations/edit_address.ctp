<div class="email_addresses form">
    <?php echo $this->Form->create('Address'); ?>
    <fieldset>
        <legend><?php echo __('Edit Address'); ?></legend>
	<?php
            echo $this->Form->Hidden('Congregation.id', array('value' => $congregationId));
            echo $this->Form->input('id');
            echo $this->element('input_address');
	?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
