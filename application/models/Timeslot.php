<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of timeslot
 *
 * @author Gabriella
 */
class Timeslot extends Timetable{
    
    public $timeslots = array();
    //Create the Players model
    function __construct($filename = null) {
        parent::__construct();
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
}
