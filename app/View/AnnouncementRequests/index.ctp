<div class="announcementRequests index">
	<h2><?php echo __('Announcement Requests'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('congregation_id'); ?></th>
			<th><?php echo $this->Paginator->sort('member_id'); ?></th>
			<th><?php echo $this->Paginator->sort('announcement'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('expiration'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($announcementRequests as $announcementRequest): ?>
	<tr>
		<td><?php echo h($announcementRequest['AnnouncementRequest']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($announcementRequest['Congregation']['name'], array('controller' => 'congregations', 'action' => 'view', $announcementRequest['Congregation']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($announcementRequest['Member']['full_name'], array('controller' => 'members', 'action' => 'view', $announcementRequest['Member']['id'])); ?>
		</td>
		<td><?php echo h($announcementRequest['AnnouncementRequest']['announcement']); ?>&nbsp;</td>
		<td><?php echo h($announcementRequest['AnnouncementRequest']['status']); ?>&nbsp;</td>
		<td><?php echo h($announcementRequest['AnnouncementRequest']['expiration']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $announcementRequest['AnnouncementRequest']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $announcementRequest['AnnouncementRequest']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $announcementRequest['AnnouncementRequest']['id']), array(), __('Are you sure you want to delete # %s?', $announcementRequest['AnnouncementRequest']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Announcement Request'), array('action' => 'add')); ?></li>
	</ul>
</div>
