<div class="email_addresses form">
    <?php echo $this->Form->create('MemberEmailAddress'); ?>
    <fieldset>
        <legend><?php echo __('Edit Email Address'); ?></legend>
	<?php
            echo $this->Form->Hidden('member_id', array('value' => $memberId));
            echo $this->Form->input('id');
            echo $this->Form->input('email_address');
	?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
