<div class="members index">
	<h2><?php echo __('Members'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort('first_name'); ?></th>
            <th><?php echo $this->Paginator->sort('last_name'); ?></th>
            <th><?php echo $this->Paginator->sort('baptized'); ?></th>
            <th><?php echo $this->Paginator->sort('congregation_id'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach ($members as $member): ?>
            <tr>
                <td><?php echo h($member['Member']['first_name']); ?>&nbsp;</td>
                <td><?php echo h($member['Member']['last_name']); ?>&nbsp;</td>                
                <td><?php echo h($member['Member']['baptized']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($member['Congregation']['name'], array('controller' => 'congregations', 'action' => 'view', $member['Congregation']['id'])); ?>
                </td>                
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $member['Member']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $member['Member']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $member['Member']['id']), null, __('Are you sure you want to delete # %s?', $member['Member']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
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
        <li><?php echo $this->Html->link(__('New Member'), array('action' => 'add')); ?></li>
    </ul>
</div>
