<div class="congregations index">
    <h2><?php echo __('Congregations'); ?></h2>
    <table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('website'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($congregations as $congregation): ?>        
            <tr>
		<td><?php echo h($congregation['Congregation']['name']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($congregation['Congregation']['website'], $congregation['Congregation']['website']); ?>&nbsp;</td>
		<td class="actions">
                    <?php 
                        echo $this->Html->link(__('View'), array('action' => 'view', $congregation['Congregation']['id']));
                        echo $this->Html->link(__('Edit'), array('action' => 'edit', $congregation['Congregation']['id']));
                        echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $congregation['Congregation']['id']), null, __('Are you sure you want to delete %s?', $congregation['Congregation']['name']));
                        if ($congregation['Congregation']['id'] != $congregationId) {
                            if (array_key_exists($congregation['Congregation']['id'], $congregationFollowMap)) {
                                echo $this->Form->postLink(__('Stop Following'), array('action' => 'stopFollowing', $congregationFollowMap[$congregation['Congregation']['id']]));
                            } else {
                                echo $this->Html->link(__('Follow'), array('action' => 'requestToFollow', $congregation['Congregation']['id']));
                            }
                        } //end if not the congregation that the user(member) belongs to 
                    ?>
		</td>
            </tr>        
        <?php endforeach; ?>
    </table>
    <p>
        <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
        ?>
    </p>
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
        <li><?php echo $this->Html->link(__('New Congregation'), array('action' => 'add')); ?></li>
    </ul>
</div>
