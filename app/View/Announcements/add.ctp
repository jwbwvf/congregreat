<div class="announcements form">
<?php echo $this->Form->create('Announcement'); ?>
	<fieldset>
		<legend><?php echo __('Add Announcement'); ?></legend>
	<?php
		echo $this->Form->input('announcement', array('type' => 'textarea'));
		echo $this->Form->input('expiration');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Announcements'), array('action' => 'index')); ?></li>
	</ul>
</div>
