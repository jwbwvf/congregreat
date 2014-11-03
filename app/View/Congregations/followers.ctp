<div class="congregations follow requests">
    <h2><?php echo __('Followers'); ?></h2>
    <table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo __('Name'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($followers as $follower): ?>        
            <tr>
		<td><?php echo h($follower['Follower']['name']); ?>&nbsp;</td>
		<td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $follower['Follower']['id'])); ?>                                        
		</td>
            </tr>        
        <?php endforeach; ?>
    </table>
</div>