<div class="phone form">    
    <?php echo $this->Form->create('Address'); ?>
    <fieldset>
        <legend><?php echo __('Add Address'); ?></legend>
        <?php 
            echo $this->Form->hidden('Congregation.id', array('value' => $congregation['Congregation']['id']));        
            echo $this->Form->input('Address.street_address');
            echo $this->Form->input('Address.city');
            echo $this->Form->input('Address.state', array(
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
                )
            ));                        
            echo $this->Form->input('Address.zipcode', array('type' => 'text', 'maxlength' => '5', 'size' => '5'));
            echo $this->Form->input('Address.country', array('options' => array('United States' => 'United States')));            
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>