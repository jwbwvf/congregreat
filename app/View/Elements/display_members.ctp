<h3><?php echo __('Members'); ?></h3>
<?php if (!empty($members)): ?>
    <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php echo __('First Name'); ?></th>
            <th><?php echo __('Last Name'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach ($members as $member): ?>
            <tr>
                <td><?php echo $member['first_name']; ?></td>
                <td><?php echo $member['last_name']; ?></td>
                <td class="actions">
                    <?php echo $this->Form->postLink(__('View'), array('controller' => 'members', 'action' => 'view', $member['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif;

