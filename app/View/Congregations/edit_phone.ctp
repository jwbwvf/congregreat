<div class="phones form">
    <?php echo $this->Form->create('Phone'); ?>
    <fieldset>
        <legend><?php echo __('Edit Phone'); ?></legend>
	<?php
            echo $this->Form->Hidden('Congregation.id', array('value' => $congregationId));
            echo $this->Form->input('id');
            echo $this->element('input_phone');
	?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
