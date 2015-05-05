<div class="phone form">    
    <?php echo $this->Form->create('CongregationPhone'); ?>
    <fieldset>
        <legend><?php echo __('Add Phone'); ?></legend>
        <?php
            echo $this->element('input_phone', array('belongsToModel' => 'Congregation'));
            ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>