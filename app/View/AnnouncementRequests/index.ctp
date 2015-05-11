<div class="announcementRequests index">
	<h2><?php echo __('Announcement Requests'); ?></h2>
	<table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?php echo __('announcement'); ?></th>
                <th><?php echo __('expiration'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($announcementRequests as $announcementRequest): ?>
            <tr>
                <td><?php echo $this->Text->truncate(h($announcementRequest['AnnouncementRequest']['announcement']), 60, array('elipsis' => '...', 'exact' => false)); ?>&nbsp;</td>
                <td><?php echo h($announcementRequest['AnnouncementRequest']['expiration']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $announcementRequest['AnnouncementRequest']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $announcementRequest['AnnouncementRequest']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'cancel', $announcementRequest['AnnouncementRequest']['id']), array(), __('Are you sure you want to cancel the announcement request')); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
	</table>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Announcement Request'), array('action' => 'add')); ?></li>
	</ul>
</div>
