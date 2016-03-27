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
        $tempcode = $tempday = $temptime = null;
        
        $this->load->helper('url');
        $this->load->library('table');
        $search = $this->input->post();
        if ($search) {
            $tempcode = $search["Courses"];
            $tempday = $search["Days"];
            $temptime = $search["Times"];
        }
        
        if($tempcode == null)
            $tempcode = 'none';
        if($tempday == null)
            $tempday = 'none';
        if($temptime == null)
            $temptime = 'none';
        
        $this->load->library('parser');

        $this->load->model('timetable');

        $this->fill_courses_drop_down();
        $this->fill_days_drop_down();
        $this->fill_times_drop_down();
        
        
        // Handle any bingos here.
        $this->bingo($tempcode, $tempday, $temptime);
        
        $this->data['course_result_table'] = $this->search_code($tempcode);
        $this->data['day_result_table'] = $this->search_day($tempday);
        $this->data['time_result_table'] = $this->search_time($temptime);
        
        $this->parser->parse('welcome', $this->data);
    }
    
    public function search_code($code)
    {
        if($code !== "none")
            $bookings = $this->timetable->getCourseBookings($code);
        else
            return '';
        
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
    
    public function search_day($code)
    {
        if($code !== "none")
            $bookings = $this->timetable->getDayBookings($code);
        else
            return '';
        
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
    
    public function search_time($code)
    {
        if($code !== "none")
            $bookings = $this->timetable->getTimeBookings($code);
        else
            return '';
        
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
    
    public function bingo($code, $day, $time)
    {
        $this->data['bingo_results'] = 'Sorry, better luck next time.';
        $this->data['bingo_found'] = 'not found...';
        
        if($code === 'none' || $day === 'none' || $time === 'none')
            return false;
        
        $courseBookings = $this->timetable->getCourseBookings($code);
        $dayBookings = $this->timetable->getDayBookings($day);
        $timeBookings = $this->timetable->getTimeBookings($time);
        
        
        foreach($courseBookings as $cBook)
        {
            foreach($dayBookings as $dBook)
            {
                foreach($timeBookings as $tBook)
                {
                    if (($cBook->compare($dBook) === true) && ($cBook->compare($tBook) === true))
                    {
                        $this->data['bingo_results'] = 'Woo hoo! We have a winner!';
                        $this->data['bingo_found'] = 'found!';
                        return true;
                    }
                }
            }
        }
        return false;
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
