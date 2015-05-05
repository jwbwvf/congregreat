<div class="email_addresses form">
    <?php echo $this->Form->create('CongregationEmailAddress'); ?>
    <fieldset>
        <legend><?php echo __('Edit Email Address'); ?></legend>
        <?php
            echo $this->Form->input('id');
            echo $this->Form->input('email_address', array('type' => 'email'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
