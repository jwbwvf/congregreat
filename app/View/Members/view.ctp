<?php echo $member['Member']['name']; ?>
<?php echo $member['Member']['birthdate']; ?>
<?php echo $member['Member']['anniversary']; ?>

<h2><?php echo __('Email Addresses'); ?></h2>
<table cellpadding="0" cellspacing="0">    
<?php foreach($member['Member']['member_email_address'] as $email_address): ?>
    <tr><td><?php echo $email_address['Member']['member_email_address']; ?></td></tr>
<?php endforeach; ?>


