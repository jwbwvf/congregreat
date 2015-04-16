<div class="congregations form">
    <?php echo $this->Form->create('Congregation'); ?>
    <fieldset>
        <legend><?php echo __('Add Congregation'); ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('website');

            echo $this->Form->input('EmailAddress.email_address', array('type' => 'email', 'maxlength' => 254));

            echo $this->element('input_phone');

            echo $this->element('input_address', array('belongsToModel' => 'Congregation'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Congregations'), array('action' => 'index')); ?></li>
    </ul>
</div>
