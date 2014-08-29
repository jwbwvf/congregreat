<div class="phone form">    
    <?php echo $this->Form->create('Address'); ?>
    <fieldset>
        <legend><?php echo __('Add Address'); ?></legend>
        <?php 
            echo $this->Form->hidden('Congregation.id', array('value' => $congregation['Congregation']['id']));        
            echo $this->element('address');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>