<div class="email_addresses form">
    <?php echo $this->Form->create('CongregationAddress'); ?>
    <fieldset>
        <legend><?php echo __('Edit Address'); ?></legend>
        <?php
            echo $this->Form->input('id');
            echo $this->element('input_address', array('belongsToModel' => 'Congregation'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
