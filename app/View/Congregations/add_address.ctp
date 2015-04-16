<div class="phone form">
    <?php echo $this->Form->create('CongregationAddress'); ?>
    <fieldset>
        <legend><?php echo __('Add Address'); ?></legend>
        <?php
            echo $this->element('input_address', array('belongsToModel' => 'Congregation'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>