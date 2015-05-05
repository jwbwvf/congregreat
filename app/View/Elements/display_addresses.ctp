<h3><?php echo __('Addresses'); ?></h3>
<?php if (!empty($addresses)): ?>
    <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php echo __('Address'); ?></th>
            <th><?php echo __('City'); ?></th>
            <th><?php echo __('State'); ?></th>
            <th><?php echo __('Zipcode'); ?></th>
            <th><?php echo __('Country'); ?></th>
            <?php if($canModify) { ?>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <?php }//end can modify ?>
        </tr>
        <?php foreach ($addresses as $address): ?>
            <tr>
                <td><?php echo $address['street_address']; ?></td>
                <td><?php echo $address['city']; ?></td>
                <td><?php echo $address['state']; ?></td>
                <td><?php echo $address['zipcode']; ?></td>
                <td><?php echo $address['country']; ?></td>
                <?php if($canModify) { ?>
                <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('controller' => $belongsToModel . 'Addresses', 'action' => 'edit', $address['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('controller' => $belongsToModel . 'Addresses', 'action' => 'delete', $address['id']), null, __('Are you sure you want to delete %s?', $address['street_address'])); ?>
                </td>
                <?php }//end can modify ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php if($canModify) { ?>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('New Address'), array('controller' => $belongsToModel . 'Addresses', 'action' => 'add')); ?> </li>
    </ul>
</div>
<?php }//end can modify
