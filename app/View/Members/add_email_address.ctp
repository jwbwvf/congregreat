<div class="phone form">    
    <?php echo $this->Form->create('EmailAddress'); ?>
    <fieldset>
        <legend><?php echo __('Add Email Address'); ?></legend>
        <?php 
            echo $this->Form->hidden('Member.id', array('value' => $member['Member']['id']));
            echo $this->Form->input('EmailAddress.email_address', array('type' => 'email'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>