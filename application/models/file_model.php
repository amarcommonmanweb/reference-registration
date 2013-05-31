<?php

/**
 * This is the File_model class with functionalities involving file handling
 */
class File_model extends CI_Model {

    var $gallery_path;
    var $gallery_path_url;
    var $person_application_id;
    
    function __construct() {
        parent::__construct();
        
        $this->$person_application_id = $this -> session -> userdata('person_application_id');
        $this->gallery_path = realpath(APPPATH . '../uploads');
        $this->gallery_path_url = base_url().'uploads/';
    }
    
    function do_upload(){
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';
        
        $doc_id = $this->input->post('document_name');
        
        $filename = $_FILES['userfile']['name'];
        $filename = $person_application_id.'_'.$doc_id.'_'.$filename;
        
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png|doc|docx|pdf',
            'upload_path' => $this->gallery_path,
            'max_size' => 2000,
            'file_name' => $filename
        );
        
        $upload_status = $this->load->library('upload', $config);
        
        if (!$this -> upload -> do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this -> upload -> display_errors('', '');
        }
        else{
            $file_data = $this->upload->data();
               // $file_id = $this -> files_model -> insert_file($data['file_name'], $_POST['title']);
                if (1) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
        }
        @unlink($_FILES[$file_element_name]);
        
         echo json_encode(array('status' => $status, 'msg' => $msg));
    }
    
}