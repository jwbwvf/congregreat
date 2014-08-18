<div class="members form">
<?php echo $this->Form->create('Member'); ?>
	<fieldset>
		<legend><?php echo __('Edit Member'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('congregation_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('middle_name');
		echo $this->Form->input('gender');
		echo $this->Form->input('birth_date');
		echo $this->Form->input('baptized');
		echo $this->Form->input('profile_picture');
		echo $this->Form->input('anniversary_id');
		echo $this->Form->input('Address');
		echo $this->Form->input('EmailAddress');
		echo $this->Form->input('Group');
		echo $this->Form->input('Phone');
		echo $this->Form->input('Task');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Member.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Member.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Members'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Congregations'), array('controller' => 'congregations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Congregation'), array('controller' => 'congregations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Anniversaries'), array('controller' => 'anniversaries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Anniversary'), array('controller' => 'anniversaries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Absences'), array('controller' => 'absences', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Absence'), array('controller' => 'absences', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contributions'), array('controller' => 'contributions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contribution'), array('controller' => 'contributions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Member Task Assignments'), array('controller' => 'member_task_assignments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Member Task Assignment'), array('controller' => 'member_task_assignments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('controller' => 'addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Email Addresses'), array('controller' => 'email_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Email Address'), array('controller' => 'email_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phones'), array('controller' => 'phones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phone'), array('controller' => 'phones', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tasks'), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Task'), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>
