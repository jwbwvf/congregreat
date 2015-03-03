<div id="profile" class="members view">
    <h2><?php echo __('Member'); ?></h2>
    <div id="profile-picture">
        <?php echo $this->Html->image('members/' . $member['profile_picture'], array('width'=>'300px')); ?>    
    </div>
    <div id="profile-details">
    <dl>        
        <dt><?php echo __('First Name'); ?></dt>
        <dd>
            <?php echo h($member['first_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Last Name'); ?></dt>
        <dd>
            <?php echo h($member['last_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Middle Name'); ?></dt>
        <dd>
            <?php echo h($member['middle_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Birth Date'); ?></dt>
        <dd>
            <?php echo h($member['birth_date']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Baptized'); ?></dt>
        <dd>
            <?php echo h($member['baptized']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Congregation'); ?></dt>
        <dd>
            <?php echo $this->Html->link($congregation['name'], array('controller' => 'congregations', 'action' => 'view', $congregation['id'])); ?>
            &nbsp;
        </dd>        
    </dl>
    </div>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php if($canModify) { echo $this->Html->link(__('Edit Member'), array('action' => 'edit', $member['id'])); } ?> </li>
        <li><?php if($canModify) { echo $this->Form->postLink(__('Delete Member'), array('action' => 'delete', $member['id']), 
                null, __('Are you sure you want to delete %s?', $member['first_name'] . ' ' .
                $member['last_name'])); } ?> </li>
        <li><?php echo $this->Html->link(__('List Members'), array('action' => 'index')); ?> </li>
        <li><?php if($canModify) { echo $this->Html->link(__('New Member'), array('action' => 'add')); } ?> </li>
    </ul>
</div>
