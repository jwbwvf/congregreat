<?php echo $this->element('display_member', array(
    'member' => $member['Member'],
    'congregation' => $member['Congregation'],
    'canModify' => $canModify));
?>

<div class="related">
    <?php echo $this->element('display_addresses', array(
            'addresses' => $member['Address'], 
            'ownerId' => $member['Member']['id'],
            'canModify' => $canModify)); 
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_email_addresses', array(
            'emailAddresses' => $member['EmailAddress'], 
            'ownerId' => $member['Member']['id'],
            'canModify' => $canModify)); 
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_phones', array(
            'phones' => $member['Phone'], 
            'ownerId' => $member['Member']['id'],
            'canModify' => $canModify)); 
    ?>
</div>
