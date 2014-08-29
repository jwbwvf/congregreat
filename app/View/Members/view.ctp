<div id="profile" class="members view">
    <h2><?php echo __('Member'); ?></h2>
    <div id="profile-picture">
        <?php echo $this->Html->image('members/' . $member['Member']['profile_picture'], array('width'=>'300px')); ?>    
    </div>
    <div id="profile-details">
    <dl>        
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
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Member'), array('action' => 'edit', $member['Member']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Member'), array('action' => 'delete', $member['Member']['id']), 
                null, __('Are you sure you want to delete %s?', $member['Member']['first_name'] . ' ' .
                        $member['Member']['last_name'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Members'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Member'), array('action' => 'add')); ?> </li>
    </ul>
</div>

<div class="related">
    <h3><?php echo __('Addresses'); ?></h3>
    <?php if (!empty($member['Address'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Street Address'); ?></th>
                <th><?php echo __('City'); ?></th>
                <th><?php echo __('State'); ?></th>
                <th><?php echo __('Zipcode'); ?></th>
                <th><?php echo __('Country'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($member['Address'] as $address): ?>
                <tr>                
                    <td><?php echo $address['street_address']; ?></td>
                    <td><?php echo $address['city']; ?></td>
                    <td><?php echo $address['state']; ?></td>
                    <td><?php echo $address['zipcode']; ?></td>
                    <td><?php echo $address['country']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'editAddress', $member['Member']['id'], $address['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'deleteAddress', $member['Member']['id'], $address['id']), null, __('Are you sure you want to delete %s?', $address['street_address'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Address'), array('action' => 'addAddress', $member['Member']['id'])); ?> </li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Email Addresses'); ?></h3>
    <?php if (!empty($member['EmailAddress'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Email Address'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($member['EmailAddress'] as $emailAddress): ?>
                <tr>                
                    <td><?php echo $emailAddress['email_address']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'editEmailAddress', $member['Member']['id'], $emailAddress['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'deleteEmailAddress', $member['Member']['id'], $emailAddress['id']), null, __('Are you sure you want to delete %s?', $emailAddress['email_address'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Email Address'), array('action' => 'addEmailAddress', $member['Member']['id'])); ?> </li>
        </ul>
    </div>
</div>

<div class="related">
    <h3><?php echo __('Phones'); ?></h3>
    <?php if (!empty($member['Phone'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Number'); ?></th>
                <th><?php echo __('Type'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($member['Phone'] as $phone): ?>
                <tr>
                    <td><?php echo $phone['number']; ?></td>
                    <td><?php echo $phone['type']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'editPhone', $member['Member']['id'], $phone['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'deletePhoneNumber', $member['Member']['id'], $phone['id']), null, __('Are you sure you want to delete # %s?', $phone['number'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Phone'), array('action' => 'addPhoneNumber', $member['Member']['id'])); ?> </li>
        </ul>
    </div>
</div>
