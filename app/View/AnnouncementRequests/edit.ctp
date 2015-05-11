<div class="announcementRequests form">
<?php echo $this->Form->create('AnnouncementRequest'); ?>
	<fieldset>
		<legend><?php echo __('Edit Announcement Request'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('announcement', array('type' => 'textarea'));
		echo $this->Form->input('expiration');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AnnouncementRequest.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('AnnouncementRequest.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Announcement Requests'), array('action' => 'index')); ?></li>
	</ul>
</div>
