<?php

App::uses('AppModel', 'Model');

/**
 * Member model
 */
class Member extends AppModel {
    
    public $virtualFields = array('name' => "CONCAT(first_name, ' ', last_name)");
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    
//    
//    public $hasMany = array('MemberEmailAddress');
    
//    public function add($data)
//    {
//        $date = new DateTime();
//        
//        $birthdateYear = $data['Member']['birthdate']['year'];        
//        $birthdateMonth = $data['Member']['birthdate']['month'];
//        $birthdateDay = $data['Member']['birthdate']['day'];                        
//        $date->setDate($birthdateYear, $birthdateMonth, $birthdateDay);                
//        $data['Member']['birthdate'] = $date->format('Y-m-d');
//        
//        $anniversaryYear = $data['Member']['anniversary']['year'];
//        $anniversaryMonth = $data['Member']['anniversary']['month'];
//        $anniversaryDay = $data['Member']['anniversary']['day'];        
//        $date->setDate($anniversaryYear, $anniversaryMonth, $anniversaryDay);                
//        $data['Member']['anniversary'] = $date->format('Y-m-d');
//        
//        parent::add($data);
//    }
}