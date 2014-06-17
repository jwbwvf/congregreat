<div class="phone form">    
    <?php echo $this->Form->create('Phone'); ?>
    <fieldset>
        <legend><?php echo __('Add Phone'); ?></legend>
        <?php 
            echo $this->Form->hidden('Congregation.id', array('value' => $congregation['Congregation']['id']));
            echo $this->Form->input('Phone.number', array('label' => 'Phone Number (555-555-5555)'));
            echo $this->Form->input('Phone.type', array(
                'options' => array(
                    'building' => 'building', 
                    'cell' => 'cell', 
                    'home' => 'home', 
                    'work' => 'work'
                )   
            ));
            ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>