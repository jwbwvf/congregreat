<div class="phone form">    
    <?php echo $this->Form->create('MemberPhone'); ?>
    <fieldset>
        <legend><?php echo __('Add Phone'); ?></legend>
        <?php 
            echo $this->Form->hidden('member_id', array('value' => $member['Member']['id']));
            echo $this->element('input_phone', array('belongsToModel' => 'Member'));
            ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>