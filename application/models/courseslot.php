<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CourseSlot extends CI_Model{
    
    //Create the Players model
    function __construct($filename = null) {
        parent::__construct();
        if($filename == null)
            return;
    
        $this->xml = simplexml_load_file(DATAPATH . $filename . XMLSUFFIX);
        
        // extracts basics
        $this->code = (string) $this->xml->code;
        $this->day = (string) $this->xml->day;
        $this->start = (string) $this->xml->start;
        $this->end = (string) $this->xml->end;
        $this->building = (string) $this->xml->building;
        $this->room = (string) $this->xml->room;
        $this->type = (string) $this->xml->type;
        $this->instructor = (string) $this->xml->instructor;
    }
    
    
    
}
