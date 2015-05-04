<div class="tasks index">
<h2><?php echo __('Tasks'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?php echo __('name'); ?></th>
                <th><?php echo __('description'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
	</thead>
	<tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo h($task['Task']['name']); ?>&nbsp;</td>
                <td><?php echo h($task['Task']['description']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $task['Task']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $task['Task']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $task['Task']['id']), __('Are you sure you want to delete %s?', $task['Task']['name'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
	</tbody>
    </table>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Task'), array('action' => 'add')); ?></li>
    </ul>
</div>
