<div class="members view">
    <h2><?php echo __('Member'); ?></h2>
    <dl>
        <?php echo $this->Html->image('members/' . $member['Member']['profile_picture'], array('width'=>'300px')); ?>
        <dt><?php echo __('First Name'); ?></dt>
        <dd>
            <?php echo h($member['Member']['first_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Last Name'); ?></dt>
        <dd>
            <?php echo h($member['Member']['last_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Middle Name'); ?></dt>
        <dd>
            <?php echo h($member['Member']['middle_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Birth Date'); ?></dt>
        <dd>
            <?php echo h($member['Member']['birth_date']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Baptized'); ?></dt>
        <dd>
            <?php echo h($member['Member']['baptized']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Congregation'); ?></dt>
        <dd>
            <?php echo $this->Html->link($member['Congregation']['name'], array('controller' => 'congregations', 'action' => 'view', $member['Congregation']['id'])); ?>
            &nbsp;
        </dd>        
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Member'), array('action' => 'edit', $member['Member']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Member'), array('action' => 'delete', $member['Member']['id']), null, __('Are you sure you want to delete # %s?', $member['Member']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Members'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Member'), array('action' => 'add')); ?> </li>
    </ul>
</div>

<div class="related">
    <h3><?php echo __('Addresses'); ?></h3>
    <?php if (!empty($member['Address'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('Street Address'); ?></th>
                <th><?php echo __('City'); ?></th>
                <th><?php echo __('State'); ?></th>
                <th><?php echo __('Zipcode'); ?></th>
                <th><?php echo __('Country'); ?></th>
                <th><?php echo __('Created'); ?></th>
                <th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($member['Address'] as $address): ?>
                <tr>
                    <td><?php echo $address['id']; ?></td>
                    <td><?php echo $address['street_address']; ?></td>
                    <td><?php echo $address['city']; ?></td>
                    <td><?php echo $address['state']; ?></td>
                    <td><?php echo $address['zipcode']; ?></td>
                    <td><?php echo $address['country']; ?></td>
                    <td><?php echo $address['created']; ?></td>
                    <td><?php echo $address['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'addresses', 'action' => 'edit', $address['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'addresses', 'action' => 'delete', $address['id']), null, __('Are you sure you want to delete # %s?', $address['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Email Addresses'); ?></h3>
    <?php if (!empty($member['EmailAddress'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('Email Address'); ?></th>
                <th><?php echo __('Created'); ?></th>
                <th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($member['EmailAddress'] as $emailAddress): ?>
                <tr>
                    <td><?php echo $emailAddress['id']; ?></td>
                    <td><?php echo $emailAddress['email_address']; ?></td>
                    <td><?php echo $emailAddress['created']; ?></td>
                    <td><?php echo $emailAddress['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'email_addresses', 'action' => 'edit', $emailAddress['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'email_addresses', 'action' => 'delete', $emailAddress['id']), null, __('Are you sure you want to delete # %s?', $emailAddress['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Email Address'), array('controller' => 'email_addresses', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>

<div class="related">
    <h3><?php echo __('Phones'); ?></h3>
    <?php if (!empty($member['Phone'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('Number'); ?></th>
                <th><?php echo __('Type'); ?></th>
                <th><?php echo __('Created'); ?></th>
                <th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($member['Phone'] as $phone): ?>
                <tr>
                    <td><?php echo $phone['id']; ?></td>
                    <td><?php echo $phone['number']; ?></td>
                    <td><?php echo $phone['type']; ?></td>
                    <td><?php echo $phone['created']; ?></td>
                    <td><?php echo $phone['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'phones', 'action' => 'edit', $phone['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'phones', 'action' => 'delete', $phone['id']), null, __('Are you sure you want to delete # %s?', $phone['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Phone'), array('controller' => 'phones', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>
