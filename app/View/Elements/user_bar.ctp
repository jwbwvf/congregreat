<div class="user">
    <?php
        echo 'Welcome ';
        if (AuthComponent::user('id')) {
            echo $this->Html->link(AuthComponent::user('username'), array('controller' => 'users', 'action' => 'view',
                AuthComponent::user('id')));
            echo ' | ';
            echo $this->Html->link('logout', array('controller' => 'users', 'action' => 'logout'));
        } else { //not logged in
            echo 'stranger';
            echo ' | ';
            echo $this->Html->link('login', array('controller' => 'users', 'action' => 'login'));
        }
    ?>
</div>



