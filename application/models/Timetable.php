<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Timetable extends CI_Model {
    
    protected $xml;
    private $code;
    protected $timeslots = array();
    protected $days = array();
    protected $courses = array();
    

    //Create the Players model
    function __construct() {
        parent::__construct();
        
        $this->makeCourses("courses");
        $this->makeDays("days");
        $this->makeTimeslots("timeslots");
        var_dump($this->courses);
    }
    
    function makeTimeslots($filename)
    {
        if($filename == null)
        {
            $filename = "timeslots";
        }
    
        $this->xml = simplexml_load_file(DATAPATH . $filename . XMLSUFFIX);
        
        foreach($this->xml->timeslot as $timeslot)
        {
            $time = (string) $timeslot['start'];
            foreach($timeslot->booking as $booking)
            {
                $tempBooking = new Booking($booking);
                $tempBooking->start = (string) $timeslot['start'];
                $tempBooking->end = (string) $timeslot['end'];
                $this->timeslots[$time][] = $tempBooking;
            }
        }
    }
    
    function makeDays($filename)
    {
        if($filename == null)
        {
            $filename = "days";
        }
    
        $this->xml = simplexml_load_file(DATAPATH . $filename . XMLSUFFIX);
        
        foreach($this->xml->dayslot as $dayslot)
        {
            $day = (string) $dayslot['day'];
            foreach($dayslot->booking as $booking)
            {
                $tempBooking = new Booking($booking);
                $tempBooking->day = (string) $dayslot['day'];
                $this->days[$day][] = $tempBooking;
            }
        }
    }
    
    function makeCourses($filename)
    {
        if($filename == null)
        {
            $filename = 'courses';
        }
        $this->xml = simplexml_load_file(DATAPATH . $filename . XMLSUFFIX);
        
        // extracts basics
        foreach ($this->xml->courseslot as $courseslot) 
        { 
            $this->code = (string) $courseslot['code'];
            foreach($courseslot->booking as $booking)
            {
                $tempBooking = new Booking($booking);
                $tempBooking->code = $this->code;
                $this->courses[$this->code][] = $tempBooking;
            }
           
        }
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
    
    function __construct($entry) {
        $this->day = (String) $entry->day;
        $this->start = (String) $entry->start;
        $this->end = (String) $entry->end;
        $this->code = (String) $entry->code;
        $this->building = (String) $entry->building;
        $this->room = (String) $entry->room;
        $this->type = (String) $entry->type;
        $this->instructor = (String) $entry->instructor;        
    }
}
