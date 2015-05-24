<div class="congregations follow requests">
    <h2><?php echo __('Follow Requests'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo __('Name'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach ($followRequests as $followRequest): ?>
            <tr>
                <td><?php echo h($followRequest['RequestingFollower']['name']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('controller' => 'congregations', 'action' => 'view', $followRequest['RequestingFollower']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Accept'), array('action' => 'accept', $followRequest['CongregationFollowRequest']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Reject'), array('action' => 'reject', $followRequest['CongregationFollowRequest']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>