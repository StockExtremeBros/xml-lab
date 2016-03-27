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
        $this->load->helper('url');
        $search = $this->input->post();
        if ($search) {
            $tempcode = $search["Courses"];
            $tempday = $search["Days"];
            $temptime = $search["Times"];
        }
        
        $this->load->library('parser');

        $this->load->model('timetable');

        $this->fill_courses_drop_down();
        $this->fill_days_drop_down();
        $this->fill_times_drop_down();
        
        if ($this->input->server('REQUEST_METHOD') == 'POST')
            $this->data['result_table'] = $this->search($tempcode, $tempday, $temptime);
        else
            $this->data['result_table'] = $this->search('','','');
        
        $this->parser->parse('welcome', $this->data);
        
    }

    public function search($code, $day, $time)
    {
        $this->load->library('table');
        $bookings = $this->timetable->getBookings($code, $day, $time);
        foreach ($bookings as $key => $booking) {
            $bookings[$key] = $booking->toArray();
        }
        $template = array('table_open' => '<table id="tableResults"'
            . ' class="table table-striped table-hover text-center">');
        $this->table->set_template($template);
        $this->table->set_heading('Day', 'Start', 'End', 'Code', 'Building',
                'Room', 'Type', 'Instructor');
        return $this->table->generate($bookings);
    }

    function fill_times_drop_down()
    {
        $allTimes = $this->timetable->getAllStartTimes();
        $times = '<option>none</option>';
        foreach($allTimes as $key)
        { 
             $times .= '<option>'.$key.'</option>';
        }
        $this->data['timedropdown'] = $times;
    }
    
    function fill_days_drop_down()
    {
        $allDays = $this->timetable->getAllDays();
        $days = '<option>none</option>';
        foreach($allDays as $key)
        { 
             $days .= '<option>'.$key.'</option>';
        }
        $this->data['daydropdown'] = $days;
    }
    
    function fill_courses_drop_down()
    {
        $allCourses = $this->timetable->getAllCourses();
        $courses = '<option>none</option>';
        foreach($allCourses as $key)
        { 
             $courses .= '<option>'.$key.'</option>';
        }
        $this->data['coursedropdown'] = $courses;
    }
}
