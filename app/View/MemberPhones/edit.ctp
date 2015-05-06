<div class="phones form">
    <?php echo $this->Form->create('MemberPhone'); ?>
    <fieldset>
        <legend><?php echo __('Edit Phone'); ?></legend>
        <?php
            echo $this->Form->input('id');
            echo $this->element('input_phone', array('belongsToModel' => 'Member'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
