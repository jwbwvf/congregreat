<div class="phone form">    
    <?php echo $this->Form->create('Phone'); ?>
    <fieldset>
        <legend><?php echo __('Add Phone'); ?></legend>
        <?php 
            echo $this->Form->hidden('Member.id', array('value' => $member['Member']['id']));
            echo $this->element('add_phone')
            ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>