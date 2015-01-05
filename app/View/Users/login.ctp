<div class="users form">
    <?php
        $this->set('title_for_layout', 'User Login');

        echo $this->Session->flash('auth');
        echo $this->Form->create('User');
    ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your username and password'); ?>
        </legend>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('password');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Login')); ?>
</div>