<div class="congregations form">
<?php echo $this->Form->create('Congregation'); ?>
	<fieldset>
		<legend><?php echo __('Edit Congregation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('website');
		echo $this->Form->input('Address');
		echo $this->Form->input('EmailAddress');
		echo $this->Form->input('Phone');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Congregation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Congregation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Congregations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('controller' => 'addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Email Addresses'), array('controller' => 'email_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Email Address'), array('controller' => 'email_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phones'), array('controller' => 'phones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phone'), array('controller' => 'phones', 'action' => 'add')); ?> </li>
	</ul>
</div>
