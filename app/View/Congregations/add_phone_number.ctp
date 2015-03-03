<div class="phone form">    
    <?php echo $this->Form->create('Phone'); ?>
    <fieldset>
        <legend><?php echo __('Add Phone'); ?></legend>
        <?php 
            echo $this->Form->hidden('Congregation.id', array('value' => $congregation['Congregation']['id']));
            echo $this->element('input_phone');
            ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>