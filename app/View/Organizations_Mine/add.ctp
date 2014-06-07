<div class="organizations form">
<?php echo $this->Form->create('Organization'); ?>
    <fieldset>
        <legend><?php echo __('Add Organization'); ?></legend>
        <?php echo $this->Form->input('Organization.name'); ?>
        <?php echo $this->Form->input('Organization.website'); ?>
        
        <?php echo $this->Form->input('Organization.EmailAddress.email_address'); ?>
        
        <?php echo $this->Form->input('Phone.number', array('label' => 'Phone Number (555-555-5555)')); ?>
        <?php echo $this->Form->input('Phone.type'); ?>
        
        <?php echo $this->Form->input('Address.address'); ?>
        <?php echo $this->Form->input('Address.city'); ?>
        <?php echo $this->Form->input('Address.state', array(
            'options' => array(
                'Alabama' => 'Alabama',
                'Alaska' => 'Alaska',
                'Arizona' => 'Arizona',
                'Arkansas' => 'Arkansas',
                'California' => 'California',
                'Colorado' => 'Colorado',
                'Connecticut' => 'Connecticut',
                'Delaware' => 'Delaware',
                'Florida' => 'Florida',
                'Georgia' => 'Georgia',
                'Hawaii' => 'Hawaii',
                'Idaho' => 'Idaho',
                'Illinois' => 'Illinois',
                'Indiana' => 'Indiana',
                'Iowa' => 'Iowa',
                'Kansas' => 'Kansas',
                'Kentucky' => 'Kentucky',
                'Louisiana' => 'Louisiana',
                'Maine' => 'Maine',
                'Maryland' => 'Maryland',
                'Massachusetts' => 'Massachusetts',
                'Michigan' => 'Michigan',
                'Minnesota' => 'Minnesota',
                'Mississippi' => 'Mississippi',
                'Missouri' => 'Missouri',
                'Montana' => 'Montana',
                'Nebraska' => 'Nebraska',
                'Nevada' => 'Nevada',
                'NewHampshire' => 'NewHampshire',
                'NewJersey' => 'NewJersey',
                'NewMexico' => 'NewMexico',
                'NewYork' => 'NewYork',
                'NorthCarolina' => 'NorthCarolina',
                'NorthDakota' => 'NorthDakota',
                'Ohio' => 'Ohio',
                'Oklahoma' => 'Oklahoma',
                'Oregon' => 'Oregon',
                'Pennsylvania' => 'Pennsylvania',
                'RhodeIsland' => 'RhodeIsland',
                'SouthCarolina' => 'SouthCarolina',
                'SouthDakota' => 'SouthDakota',
                'Tennessee' => 'Tennessee',
                'Texas' => 'Texas',
                'Utah' => 'Utah',
                'Vermont' => 'Vermont',
                'Virginia' => 'Virginia',
                'Washington' => 'Washington',
                'WestVirginia' => 'WestVirginia',
                'Wisconsin' => 'Wisconsin',
                'Wyoming' => 'Wyoming'
            ))); ?>
        <?php echo $this->Form->input('Address.zipcode', array('type' => 'text', 
            'maxlength' => '5', 'size' => '5')); ?>
        <?php echo $this->Form->input('Address.country', array('disabled' => 'disabled',
            'value' => 'United States ')); ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Organizations'), array('action' => 'index')); ?></li>
    </ul>
</div>
