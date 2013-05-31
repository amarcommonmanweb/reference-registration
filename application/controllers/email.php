<?php

/**
* SENDS EMAIL WITH GMAIL
*/
class Email extends Controller
{
    function __construct()
    {
        parent::Controller();
    }
    
    function index() 
    {   
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        
        $this->email->from('amar.insane@gmail.com', 'Amar');
        $this->email->to('amarnath.cmr2010@gmail.com');     
        $this->email->subject('This is an email test');     
        $this->email->message('It is working. Great!');
        
        $path = $this->config->item('server_root');
        $file = $path . '/CodeIgniter_Registration/attachments/yourInfo.txt';
        ChromePhp::log('the file is '.$file);
        $this->email->attach($file);
        
        if($this->email->send())
        {
            echo 'Your email was sent, Amar.';
        }
        
        else
        {
            show_error($this->email->print_debugger());
        }
    }
}


      