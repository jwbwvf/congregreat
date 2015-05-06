<div class="announcementRequests view">
<h2><?php echo __('Announcement Request'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($announcementRequest['AnnouncementRequest']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Congregation'); ?></dt>
		<dd>
			<?php echo $this->Html->link($announcementRequest['Congregation']['name'], array('controller' => 'congregations', 'action' => 'view', $announcementRequest['Congregation']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Member'); ?></dt>
		<dd>
			<?php echo $this->Html->link($announcementRequest['Member']['full_name'], array('controller' => 'members', 'action' => 'view', $announcementRequest['Member']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Announcement'); ?></dt>
		<dd>
			<?php echo h($announcementRequest['AnnouncementRequest']['announcement']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expiration'); ?></dt>
		<dd>
			<?php echo h($announcementRequest['AnnouncementRequest']['expiration']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcement Request'), array('action' => 'edit', $announcementRequest['AnnouncementRequest']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Announcement Request'), array('action' => 'delete', $announcementRequest['AnnouncementRequest']['id']), array(), __('Are you sure you want to delete # %s?', $announcementRequest['AnnouncementRequest']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcement Requests'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement Request'), array('action' => 'add')); ?> </li>
	</ul>
</div>
