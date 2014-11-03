<div class="congregations follow requests">
    <h2><?php echo __('My Pending Follow Requests'); ?></h2>
    <table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo __('Name'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($followRequests as $followRequest): ?>        
            <tr>
		<td><?php echo h($followRequest['RequestedLeader']['name']); ?>&nbsp;</td>
		<td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $followRequest['RequestedLeader']['id'])); ?>
		</td>
            </tr>        
        <?php endforeach; ?>
    </table>
</div>