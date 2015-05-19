<div class="congregations view">
    <h2><?php echo __('Congregation'); ?></h2>
    <dl>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($congregation['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Website'); ?></dt>
        <dd>
            <?php echo $this->Html->link($congregation['website'], $congregation['website']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php if ($canModify) {echo $this->Html->link(__('Edit Congregation'), array('action' => 'edit', $congregation['id']));} ?> </li>
        <li><?php echo $this->Html->link(__('List Congregations'), array('action' => 'index')); ?> </li>
        <?php if (!empty($followAction)) { ?>
            <li><?php echo $this->Form->postLink(__($followAction['label']),
                array('controller' => $followAction['controller'], 'action' => $followAction['action'],
                    $followAction['param'], $followAction['viewId'])); ?> </li>
        <?php } //end if ?>

    </ul>
</div>