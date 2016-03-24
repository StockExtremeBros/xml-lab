<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dayslot
 *
 * @author Gabriella
 */
class Dayslot extends Timetable{
    
    public $dayslots = array();
    //Create the Players model
    function __construct($filename = null) {
        parent::__construct();
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
                $this->dayslots[$day][] = $tempBooking;
            }
        }
    }
}
