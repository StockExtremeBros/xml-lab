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
        $this->load->view('welcome_message');

        $this->load->model('timetable');

        var_dump($this->timetable);
        //var_dump($this->courseslot);
        //var_dump($this->dayslot);
        //var_dump($this->timeslot);
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
}
