<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->view('welcome');
        $this->load->model('timetable');
        $this->load->library('table');
        $this->load->library('parser');

        //var_dump($this->timetable->getBookings("BLAW3600", "none", "none"));
        
        $this->fill_courses_drop_down();
        $this->fill_days_drop_down();
        $this->fill_times_drop_down();
        
        $tabletemp = array(
            'table_open' => '<table class="schedule">'
        );
        $this->table->set_template($tabletemp);
        $this->table->set_heading('Day', 'Start', 'End', 'Code', 'Building'
                , 'Room', 'Type', 'Instructor');
        $schedule = array();
        $alldays = $this->timetable->getAllDays();
        foreach ($alldays as $key => $day) {
            $dayslot = $this->timetable->getDayBookings($day);
            foreach ($dayslot as $key => $booking)
                array_push($schedule, $booking);
        }
        var_dump($schedule);
        $this->data['schedule'] = $this->table->generate($schedule);
        
    }

    function fill_times_drop_down()
    {
        $allTimes = $this->timetable->getAllStartTimes();
        $times = '<li>none</li>';
        foreach($allTimes as $key=>$value)
        { 
             $times .= '<li>'.$key.'</li>';
        }
        $this->data['timedropdown'] = $times;
    }
    
    function fill_days_drop_down()
    {
        $allDays = $this->timetable->getAllDays();
        $days = '<li>none</li>';
        foreach($allDays as $key)
        { 
             $days .= '<li>'.$key.'</li>';
        }
        $this->data['daydropdown'] = $days;
    }
    
    function fill_courses_drop_down()
    {
        $allCourses = $this->timetable->getAllCourses();
        $courses = '<li>none</li>';
        foreach($allCourses as $key)
        { 
             $courses .= '<li>'.$key.'</li>';
        }
        $this->data['coursedropdown'] = $courses;
    }
        
    public function search()
    {

    }
}
