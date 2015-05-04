<div class="tasks view">
<h2><?php echo __('Task'); ?></h2>
    <dl>
        <dt><?php echo __('Name'); ?></dt>
        <dd><?php echo h($task['Task']['name']); ?>&nbsp;</dd>
        <dt><?php echo __('Description'); ?></dt>
        <dd><?php echo h($task['Task']['description']); ?>&nbsp;</dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
        <ul>
            <li><?php echo $this->Html->link(__('Edit Task'), array('action' => 'edit', $task['Task']['id'])); ?> </li>
            <li><?php echo $this->Form->postLink(__('Delete Task'), array('action' => 'delete', $task['Task']['id']), __('Are you sure you want to delete %s?', $task['Task']['name'])); ?> </li>
            <li><?php echo $this->Html->link(__('List Tasks'), array('action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New Task'), array('action' => 'add')); ?> </li>
	</ul>
</div>