<div class="phone form">    
    <?php echo $this->Form->create('CongregationEmailAddress'); ?>
    <fieldset>
        <legend><?php echo __('Add Email Address'); ?></legend>
        <?php 
            echo $this->Form->input('CongregationEmailAddress.email_address', array('type' => 'email'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>