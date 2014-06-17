<div class="phones form">
    <?php echo $this->Form->create('Phone'); ?>
    <fieldset>
        <legend><?php echo __('Edit Phone'); ?></legend>
	<?php
            echo $this->Form->Hidden('Referer.controller', array('value' => $controller));
            echo $this->Form->Hidden('Referer.action', array('value' => $action));
            echo $this->Form->Hidden('Referer.Id', array('value' => $ownerId));
            echo $this->Form->input('id');
            echo $this->Form->input('number');
            echo $this->Form->input('type', array(
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
