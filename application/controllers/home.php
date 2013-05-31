<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index()
	{	
		$data['page_load'] = 'home_page';
        $this->load->view('includes/main_template', $data);
	}    
    
    function view_test(){  //delete this one
            $this->load->view('emails/activation_email');
    }
    
    function validate_credentials()
    {       
        $this->load->model('db_handler');
        $query = $this->db_handler->login_validate();
        
        if($query) // if the user's credentials validated...
        {
            $data = array(                
                'is_logged_in' => true
            );
            $this->session->set_userdata($data);
            echo 'true';
        }
        else // incorrect username or password
        {
            echo "Invalid Username or Password, please try again...";
        }
    }
    
    function store_registration(){
        
        $userdata['firstname'] = $this->input->post('firstname');
         $userdata['lastname'] = $this->input->post('lastname');
         $userdata['email'] = $this->input->post('emailid');
         $userdata['phone'] = $this->input->post('phone');
         $userdata['username'] = $this->input->post('username');
         $userdata['password'] = md5($this->input->post('password'));
         if(isset($_POST['info_send'])){
                $userdata['notifications'] = 1;
         }
         else{
                $userdata['notifications'] = 0;
         } 
         
       $this->load->model('db_handler');
       $result = $this->db_handler->enter_registration_data($userdata);
       
       
       if($result == 1)
       {
          
           echo 'true';
       }
       else
           {
               echo 'Registration Failed, PLease try again!!';
           }
    }
    
    
    //generic function to send emails
    function send_email_to($to, $subject, $data_array,$email_view,$attachment){
        ChromePhp::log('coming to email with '.$to.$subject.$data_array.$email_view.$attachment);
        $this->load->library('email');
        $this->email->set_newline("\r\n");        
    
        $this->email->from('amar.insane@gmail.com', 'Amar');
        $this->email->to($to);     
        $this->email->subject($subject);     
        //$message_body = '<h1>HI this is a HTML test</h1>';
        
        //$this->email->message($this->load->view('emails/activation_email', $data, true));
        //$this->email->message($message_body);
        
        //use this  "$this->email->message($this->load->view('emails/signup', $data, true));"  .. to send awesome flexible mails 
        
       
        $this->email->message($this->load->view('emails/'.$email_view, $data_array, true));
        
        if(($attachment != 0)||($attachment != '')){
            $path = $this->config->item('server_root');
            $file = $path . '/CodeIgniter_Registration/attachments/'.$attachment;
        
            $this->email->attach($file);    
        }        
        
        if($this->email->send())
        {
            return 'true';
        }        
        else
        {
            //show_error($this->email->print_debugger());
            return 'error_email';
        }        
    }
    function resend_activationemail(){
        
        //leter merge this with the activation email
         $this->load->library('email');
        $this->email->set_newline("\r\n");        
    
        $this->email->from('amar.insane@gmail.com', 'Amar');
        $this->email->to($this->session->userdata('email'));     
        $this->email->subject('This is an email test');     
        //$message_body = '<h1>HI this is a HTML test</h1>';
        
        //$this->email->message($this->load->view('emails/activation_email', $data, true));
        //$this->email->message($message_body);
        
        //use this  "$this->email->message($this->load->view('emails/signup', $data, true));"  .. to send awesome flexible mails 
        $this->load->model('db_handler');
        $activation_hash = $this->db_handler->get_activation_code($this->session->userdata('user_id'));
                
        $data['firstname'] = $this->session->userdata('firstname');
        $data['url_string'] = 'http://localhost/CodeIgniter_Registration/index.php/home/email_activation/'.$this->session->userdata('user_id').'_'.$activation_hash;
        
        $this->email->message($this->load->view('emails/activation_email', $data, true));
        
        if($this->email->send())
        {
            echo 'true';
        }        
        else
        {
            //show_error($this->email->print_debugger());
            echo 'email was not sent! Please contact admin for assistance';
        }        
    }
    
    function activation_email(){
        
        $this->load->library('email');
        $this->email->set_newline("\r\n");        
    
        $this->email->from('amar.insane@gmail.com', 'Amar');
        $this->email->to($this->session->userdata('email'));     
        $this->email->subject('This is an email test');     
        //$message_body = '<h1>HI this is a HTML test</h1>';
        
        //$this->email->message($this->load->view('emails/activation_email', $data, true));
        //$this->email->message($message_body);
        
        //use this  "$this->email->message($this->load->view('emails/signup', $data, true));"  .. to send awesome flexible mails 
        
        $data['firstname'] = $this->session->userdata('firstname');
        $data['url_string'] = 'http://localhost/CodeIgniter_Registration/index.php/home/email_activation/'.$this->session->userdata('user_id').'_'.$this->session->userdata('activation_hash');
        
        $this->email->message($this->load->view('emails/activation_email', $data, true));
        
        $path = $this->config->item('server_root');
        $file = $path . '/CodeIgniter_Registration/attachments/yourInfo.txt';
        
        $this->email->attach($file);
        
        if($this->email->send())
        {
            echo 'true';
        }        
        else
        {
            //show_error($this->email->print_debugger());
            echo 'email was not sent! Please contact admin for assistance';
        }        
    }    
    
    function email_activation($activation_code){
        // the activation code is format  <user id>_<random hash>
        
        $this->load->model('db_handler');
       $result = $this->db_handler->activate_email($activation_code);
        
    }    
    
    function activation_sucess(){
        // or rather go to the home page of the form itself ... with some extra dat .. and no activaion
        
        //clearing session for some data not be used anymore
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('activation_hash');
       $data = array(
                'is_logged_in' => true
            );
       $this->session->set_userdata($data);
       $data['page_load'] = 'application_home';
       $this->session->set_userdata('just_activated','true');
        $this->load->view('includes/main_template', $data);
   }
   
  
    
    function is_user_existing(){
        $this->load->model('db_handler');
         $result = $this->db_handler->is_user_existing($_POST);
         
         if($result == 1){
            echo "true";
        }        
        else{
            echo $result;
                        
        }
    }
    
    function resend_password(){
        ChromePhp::warn('in the resend controller');        
        
        $email_to = $this->input->post('resend_password_email');
         ChromePhp::warn('in the resend controller'.$email_to);        
        $this->load->model('db_handler');
         $result = $this->db_handler->resend_password($email_to);
         
         $result_parts = explode('_', $result);
         $user_id = str_replace($result_parts[0].'_', '', $result);
         
         if($result_parts[0] == 'exists'){
             ChromePhp::log('user id in controller is '.$user_id.' and is existing if ');
                 //get username and the new password
                 $this->load->model('db_handler');
                 $new_pass = $this->db_handler->generate_new_password($user_id);
                  $new_parts = explode('|', $new_pass);
                  ChromePhp::log('got back string '.$new_pass);
             $email_to = $this->input->post('resend_password_email');
             $subject = 'Login credentials - Crossbow Systems';
             $data_array = array('username' => $new_parts[1],
                                'firstname' => $new_parts[2],
                                        'password' => $new_parts[0]);
             $email_view = 'resend_password';
             $attachment = 0;   
             if($this->send_email_to($email_to, $subject, $data_array,$email_view,$attachment)){
                echo "true";   
             }
             
         }
         else{
            echo $result;    
         }
         
    }
}

