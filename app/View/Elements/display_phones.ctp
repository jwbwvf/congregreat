<h3><?php echo __('Phones'); ?></h3>
<?php if (!empty($phones)): ?>
    <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php echo __('Number'); ?></th>
            <th><?php echo __('Type'); ?></th>
            <?php if($canModify) { ?>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <?php }//end can modify ?>
        </tr>
        <?php foreach ($phones as $phone): ?>
            <tr>
                <td><?php echo $phone['number']; ?></td>
                <td><?php echo $phone['type']; ?></td>
                <?php if($canModify) { ?>
                <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'editPhone', $ownerId, $phone['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('controller' => $belongsToModel . 'Phones', 'action' => 'delete', $phone['id']), null, __('Are you sure you want to delete # %s?', $phone['number'])); ?>
                </td>
                <?php }//end can modify ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php if($canModify) { ?>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('New Phone'), array('action' => 'addPhoneNumber', $ownerId)); ?> </li>
    </ul>
</div>
<?php }//end can modify

