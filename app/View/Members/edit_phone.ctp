<div class="phones form">
    <?php echo $this->Form->create('Phone'); ?>
    <fieldset>
        <legend><?php echo __('Edit Phone'); ?></legend>
	<?php
            echo $this->Form->Hidden('Member.id', array('value' => $memberId));
            echo $this->Form->input('id');
            echo $this->element('phone');
	?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
