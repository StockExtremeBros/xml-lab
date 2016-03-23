<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Courseslot extends CI_Model {
    public $code;
    public $courseslots = array();
    //Create the Players model
    function __construct($filename = null) {
        parent::__construct();
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
                $this->courseslots[$this->code] = new Booking($booking);
            }
           
        }
    }
}
