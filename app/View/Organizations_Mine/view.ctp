<div class="organizations view">
<h2><?php echo __('Organization'); ?></h2>
    <dl>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($organization['Organization']['name']); ?>&nbsp;
            <?php echo h($organization['Organization']['website']); ?>&nbsp;            
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Organization'), array('action' => 'edit', $organization['Organization']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Organization'), array('action' => 'delete', $organization['Organization']['id']), null, __('Are you sure you want to delete # %s?', $organization['Organization']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Organizations'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Organization'), array('action' => 'add')); ?> </li>
    </ul>
</div>
