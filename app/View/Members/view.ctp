<?php echo $this->element('display_member', array(
    'member' => $member['Member'],
    'congregation' => $member['Congregation'],
    'canModify' => $canModify));
?>

<div class="related">
    <?php echo $this->element('display_addresses', array(
            'addresses' => $member['MemberAddress'],
            'belongsToModel' => 'Member',
            'canModify' => $canModify));
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_email_addresses', array(
            'emailAddresses' => $member['MemberEmailAddress'],
            'belongsToModel' => 'Member',
            'canModify' => $canModify));
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_phones', array(
            'phones' => $member['MemberPhone'],
            'belongsToModel' => 'Member',
            'canModify' => $canModify));
    ?>
</div>
