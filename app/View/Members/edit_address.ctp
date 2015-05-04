<div class="email_addresses form">
    <?php echo $this->Form->create('MemberAddress'); ?>
    <fieldset>
        <legend><?php echo __('Edit Address'); ?></legend>
        <?php
            echo $this->Form->Hidden('member_id', array('value' => $memberId));
            echo $this->Form->input('id');
            echo $this->element('input_address', array('belongsToModel' => 'Member'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
