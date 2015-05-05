<?php echo $this->element('display_congregation', array(
    'congregation' => $congregation['Congregation'],
    'followAction' => $followAction,
    'canModify' => $canModify));
?>

<div class="related">
    <?php echo $this->element('display_addresses', array(
        'addresses' => $congregation['CongregationAddress'],
        'ownerId' => $congregation['Congregation']['id'],
        'belongsToModel' => 'Congregation',
        'canModify' => $canModify));
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_email_addresses', array(
        'emailAddresses' => $congregation['CongregationEmailAddress'],
        'belongsToModel' => 'Congregation',
        'canModify' => $canModify));
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_phones', array(
        'phones' => $congregation['CongregationPhone'],
        'belongsToModel' => 'Congregation',
        'canModify' => $canModify));
    ?>
</div>
<div class="related">
    <?php echo $this->element('display_members', array('members' => $congregation['Member'])); ?>
</div>
