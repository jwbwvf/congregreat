<div class="announcements view">
<h2><?php echo __('Announcement'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Congregation'); ?></dt>
		<dd>
			<?php echo $this->Html->link($announcement['Congregation']['name'], array('controller' => 'congregations', 'action' => 'view', $announcement['Congregation']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Announcement'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['announcement']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expiration'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['expiration']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcement'), array('action' => 'edit', $announcement['Announcement']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Announcement'), array('action' => 'delete', $announcement['Announcement']['id']), array(), __('Are you sure you want to delete # %s?', $announcement['Announcement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('action' => 'add')); ?> </li>
	</ul>
</div>
