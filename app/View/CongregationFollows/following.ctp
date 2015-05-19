<div class="congregations follow requests">
    <h2><?php echo __('Following'); ?></h2>
    <table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo __('Name'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($follows as $follow): ?>
            <tr>
		<td><?php echo h($follow['Leader']['name']); ?>&nbsp;</td>
		<td class="actions">
                    <?php echo $this->Html->link(__('View'), array('controller' => 'congregations', 'action' => 'view', $follow['Leader']['id'])); ?>
		</td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>