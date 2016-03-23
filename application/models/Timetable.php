<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Timetable extends CI_Model{
    
    protected $xml = null;
    protected $timeslots = array();
    protected $days = array();
    protected $courses = array();
    

    //Create the Players model
    function __construct() {
        parent::__construct();
    }
    
}

class Booking {
    public $day;
    public $start;
    public $end;
    public $code;
    public $building;
    public $room;
    public $type;
    public $instructor;
}
