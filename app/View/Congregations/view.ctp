<div class="congregations view">
    <h2><?php echo __('Congregation'); ?></h2>
    <dl>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($congregation['Congregation']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Website'); ?></dt>
        <dd>
            <?php echo $this->Html->link($congregation['Congregation']['website'], $congregation['Congregation']['website']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Congregation'), array('action' => 'edit', $congregation['Congregation']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Congregations'), array('action' => 'index')); ?> </li>
        <?php if ($congregation['Congregation']['id'] != $congregationId) { ?>
            <li><?php echo $this->Html->link(__('Follow Congregation'), array('action' => 'requestToFollow', $congregation['Congregation']['id'])); ?> </li>
        <?php } //end if not the congregation that the user(member) belongs to ?>
        
    </ul>
</div>
<div class="related">
    <h3><?php echo __('Addresses'); ?></h3>
    <?php if (!empty($congregation['Address'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Address'); ?></th>
                <th><?php echo __('City'); ?></th>
                <th><?php echo __('State'); ?></th>
                <th><?php echo __('Zipcode'); ?></th>
                <th><?php echo __('Country'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($congregation['Address'] as $address): ?>
                <tr>
                    <td><?php echo $address['street_address']; ?></td>
                    <td><?php echo $address['city']; ?></td>
                    <td><?php echo $address['state']; ?></td>
                    <td><?php echo $address['zipcode']; ?></td>
                    <td><?php echo $address['country']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'editAddress', $congregation['Congregation']['id'], $address['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'deleteAddress', $congregation['Congregation']['id'], $address['id']), null, __('Are you sure you want to delete %s?', $address['street_address'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Address'), array('action' => 'addAddress', $congregation['Congregation']['id'])); ?> </li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Email Addresses'); ?></h3>
    <?php if (!empty($congregation['EmailAddress'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Email Address'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($congregation['EmailAddress'] as $emailAddress): ?>
                <tr>
                    <td><?php echo $emailAddress['email_address']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'editEmailAddress', $congregation['Congregation']['id'], $emailAddress['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'deleteEmailAddress', $congregation['Congregation']['id'], $emailAddress['id']), null, __('Are you sure you want to delete %s?', $emailAddress['email_address'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Email Address'), array('action' => 'addEmailAddress', $congregation['Congregation']['id'])); ?> </li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Phones'); ?></h3>
    <?php if (!empty($congregation['Phone'])): ?>
	<table cellpadding = "0" cellspacing = "0">
            <tr>
		<th><?php echo __('Number'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($congregation['Phone'] as $phone): ?>
		<tr>
                    <td><?php echo $phone['number']; ?></td>
                    <td><?php echo $phone['type']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'editPhone', $congregation['Congregation']['id'], $phone['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'deletePhoneNumber', $congregation['Congregation']['id'], $phone['id']), null, __('Are you sure you want to delete # %s?', $phone['number'])); ?>
                    </td>
		</tr>
            <?php endforeach; ?>
	</table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Phone'), array('action' => 'addPhoneNumber', $congregation['Congregation']['id'])); ?> </li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Members'); ?></h3>
    <?php if (!empty($congregation['Member'])): ?>
	<table cellpadding = "0" cellspacing = "0">
            <tr>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($congregation['Member'] as $member): ?>
		<tr>
                    <td><?php echo $member['first_name']; ?></td>
                    <td><?php echo $member['last_name']; ?></td>
                    <td class="actions">
                        <?php echo $this->Form->postLink(__('View'), array('controller' => 'members', 'action' => 'view', $member['id'])); ?>
                    </td>
		</tr>
            <?php endforeach; ?>
	</table>
    <?php endif; ?>
</div>
