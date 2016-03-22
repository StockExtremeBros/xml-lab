<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TimeTable extends CI_Model{
    
    protected $xml = null;
    protected $timeslots = array();
    protected $dayslots = array();
    protected $courseslots = array();
    

    //Create the Players model
    function __construct() {
        parent::__construct();
    }
    
}

class Booking{
    public $day;
    public $start;
    public $end;
    public $code;
    public $building;
    public $room;
    public $type;
    public $instructor;
    
    function __construct($entry) {
        $this->day = (String) $entry['day'];
        $this->start = (String) $entry['start'];
        $this->end = (String) $entry['end'];
        $this->code = (String) $entry['code'];
        $this->code = (String) $entry['building'];
        $this->room = (String) $entry['room'];
        $this->type = (String) $entry['type'];
        $this->instructor = (String) $entry['instructor'];        
    }
}
