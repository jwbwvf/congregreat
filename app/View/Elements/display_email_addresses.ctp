<h3><?php echo __('Email Addresses'); ?></h3>
<?php if (!empty($emailAddresses)): ?>
    <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php echo __('Email Address'); ?></th>
            <?php if($canModify) { ?>
                <th class="actions"><?php echo __('Actions'); ?></th>
            <?php }//end can modify ?>
        </tr>
        <?php foreach ($emailAddresses as $emailAddress): ?>
            <tr>
                <td><?php echo $emailAddress['email_address']; ?></td>
                <?php if($canModify) { ?>
                <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'editEmailAddress', $ownerId, $emailAddress['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('controller' => $belongsToModel . 'EmailAddresses', 'action' => 'delete', $emailAddress['id']), null, __('Are you sure you want to delete %s?', $emailAddress['email_address'])); ?>
                </td>
                <?php }//end can modify ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php if($canModify) { ?>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('New Email Address'), array('action' => 'addEmailAddress', $ownerId)); ?> </li>
    </ul>
</div>
<?php }//end can modify
