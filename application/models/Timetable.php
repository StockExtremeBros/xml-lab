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
        $this->xml = null;
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
    
    function getDayBookings($day)
    {
        if (isset($this->days[$day]))
        {
            return $this->days[$day];
        }
        else
        {
            return null;
        }
    }
    
    function getCourseBookings($code)
    {
        if (isset($this->courses[$code]))
        {
            return $this->courses[$code];
        }
        else
        {
            return null;
        }
    }
    
    function getTimeBookings($start)
    {
        if (isset($this->timeslots[$start]))
        {
            return $this->timeslots[$start];
        }
        else
        {
            return $this->timeslots;
        }
    }
    
    function getAllDays()
    {
        return array_keys($this->days);
    }
    
    function getAllStartTimes()
    {
        return array_keys($this->timeslots);
    }
    
    function getAllCourses()
    {
        return array_keys($this->courses);
    }
    
    function getBookings($user_code = "none", $user_day = "none", $user_time = "none")
    {
        $tempBookings = array();
        $finalBookings = array();
        
        if ($user_code !== "none")
        {
            $tempBookings = $this->getCourseBookings($user_code);
            
        } else if ($user_day !== "none")
        {
            $tempBookings = $this->getDayBookings($user_day);
        } else if ($user_time !== "none")
        {
            $tempBookings = $this->getTimeBookings($user_time);
        }
        
        if (empty($tempBookings))
        {
            foreach($this->courses as $group)
            {
                foreach ($group as $booking)
                {
                    array_push($finalBookings, $booking);
                }
            }
            return $finalBookings;
        } else {
            foreach($tempBookings as $booking)
            {
                if (($booking->code === $user_code || $user_code === "none")
                        && ($booking->day === $user_day || $user_day === "none")
                        && ($booking->start === $user_time || $user_time === "none"))
                {
                    array_push($finalBookings, $booking);
                }
            }
            return $finalBookings;
        }
    }
    
    public function getCourseBookingsUsingDayAndTime($day, $time)
    {
        foreach($this->courses as $bookingsByCourse)
        {
            foreach($bookingsByCourse as $booking)
            {
                if (($booking->day === $day) 
                    && ($booking->start === $time))
                {
                    return $booking;
                }
            }
            
        }
    }

    public function getDayBookingsUsingDayAndTime($day, $time)
    {
        foreach($this->days as $bookingsByDay)
        {
            foreach($bookingsByDay as $booking)
            {
                if (($booking->day === $day) 
                    && ($booking->start === $time))
                {
                    return $booking;
                }
            }
        }
    }
    
    public function getTimeBookingsUsingDayAndTime($day, $time)
    {
        foreach($this->timeslots as $bookingsByTime)
        {
            foreach($bookingsByTime as $booking)
            {
                if (($booking->day === $day) 
                    && ($booking->start === $time))
                {
                    return $booking;
                }
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
    
    /*
     * Returns a string array of this Booking object
     */
    function toArray() {
        return array(
          'day' => $this->day,
          'start' => $this->start,
          'end' => $this->end,
          'code' => $this->code,
          'building' => $this->building,
          'room' => $this->room,
          'type' => $this->type,
          'instructor' => $this->instructor
        );
    }
    
    /*
     * Compares the passed in Booking entry with the entry associated with this
     * object
     * 
     * return: returns true if their members are all are equal, otherwise false
     */
    function compare($compareTo) {
        if (   $this->day        == $compareTo->day
            && $this->start      == $compareTo->start
            && $this->end        == $compareTo->end
            && $this->code       == $compareTo->code
            && $this->building   == $compareTo->building
            && $this->room       == $compareTo->room
            && $this->type       == $compareTo->type
            && $this->instructor == $compareTo->instructor)
        {
            return true;
        }
            
        return false;
    }
}
