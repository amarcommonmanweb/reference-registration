<?php

/**
 * This is the class which deals with controlling the main application .. might just get heavy here
 */
class App_home extends CI_Controller {
    
	function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }
	
    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        //if(isset($is_logged_in) || $is_logged_in != true)
        if(0)
        {
            echo 'You don\'t have permission to access this page. <a href="../home">Login</a>';    
            die();            
        }  
    }
    
    function form()
    {
        $data['page_load'] = 'application_home';
        $this->load->view('includes/main_template', $data);
    }
}
