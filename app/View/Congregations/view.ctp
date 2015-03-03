<?php echo $this->element('display_congregation', array(
        'congregation' => $congregation['Congregation'],
        'followAction' => $followAction,
        'canModify' => $canModify));
?>

<div class="related">
    <?php echo $this->element('display_addresses', array(
            'addresses' => $congregation['Address'], 
            'ownerId' => $congregation['Congregation']['id'],
            'canModify' => $canModify)); 
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_email_addresses', array(
            'emailAddresses' => $congregation['EmailAddress'], 
            'ownerId' => $congregation['Congregation']['id'],
            'canModify' => $canModify)); 
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_phones', array(
            'phones' => $congregation['Phone'], 
            'ownerId' => $congregation['Congregation']['id'],
            'canModify' => $canModify)); 
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_members', array('members' => $congregation['Member'])); ?>
</div>
