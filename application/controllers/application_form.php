<?php

/**
 * This is the class which deals with controlling the main application .. might just get heavy here
 */
class Application_form extends CI_Controller {

    var $gallery_path;

    function __construct() {
        parent::__construct();
        $this -> is_logged_in();

        $this -> gallery_path = realpath(APPPATH . '../uploads');

    }

    function is_logged_in() {
        $is_logged_in = $this -> session -> userdata('is_logged_in');
        //if(isset($is_logged_in) || $is_logged_in != true)
        if (0) {
            echo 'You don\'t have permission to access this page. <a href="../home">Login</a>';
            die();
        }
    }
    
    function get_tab6_data(){
        //return the data for that application from data base
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_tab6_data();
        
        return $result;
        
    }
    
    function new_form() {
        /* 1. call the template page
         * 2. pass the tobe loaded page in serialised form
         * 3. the fields in the form will be populated from session,
         * 4. if the values were stored while hitting next
         */
       ChromePhp::log(' in the new_for contrroller');
        if ((isset($_POST['tab_name'])) && ($_POST['tab_name'] != null)) {
            //load template with the tab
            $data = '';
            $new_tabname = trim($_POST['tab_name']);
            ChromePhp::log('new tab name is '.$new_tabname);
            if($new_tabname == 'form_tab6'){
                // all the data from the data of the user must be available in the data as an array 
                $data = $this->get_tab6_data();
                ChromePhp::log('111111the tab data is '.print_r($data));
            }
            $page_data = $this -> load -> view('app_form_tabs/' . $new_tabname, $data, TRUE);
            echo $page_data;

        } else {
            ChromePhp::log('int he else');
            //use the tab name from the session .. the tab name to be specific
            if($this->session->userdata('tab_status'))
            {
                ChromePhp::log(' in the tabstatus if'.$this->session->userdata('tab_status'));
                if($this->session->userdata('tab_status') == 'form_tab6'){
                    ChromePhp::log('22222222new tab name is '.$this->session->userdata('tab_status'));
                // all the data from the data of the user must be available in the data as an array 
                $data = $this->get_tab6_data();
                ChromePhp::log('2222222222the tab data is '.print_r($data,true));
                }
                $data['new_tabname'] = $this->session->userdata('tab_status');
                
                $this -> load -> view('app_form_tabs/tab_template', $data);    
            }
            else{
                $data['new_tabname'] = 'form_tab1';
                $this -> load -> view('app_form_tabs/tab_template', $data);    
            }
            
        }

        /*  if((isset($_POST['app_tab'])) && ($this->input->post('app_tab') != 0)){
         // serialise the tab (other than the first one), and send the whole view tot he calling function
         }
         else {
         //load the first tab as a view on whole
         echo 'this is the first tab load';
         }*/
    }

    function get_states() {
        //FUNCTION DEC: load all the states on startup
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_states();
        echo $result;
    }

    function get_cities() {
        //FUNCTION DEC: load cities for selected state
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_cities($this -> input -> post('state_name'));
        echo $result;
    }

    function get_schools() {
        //FUNCTION DEC: load all the states on startup
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_schools($this -> input -> post('city_id'));
        echo $result;
    }

    function get_school_cities() {
        //FUNCTION DEC: load all the states on startup
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_school_cities();
        echo $result;
    }

    function get_person_categories() {
        //FUNCTION DEC: load all the categories of persons who can apply
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_person_categories();
        echo $result;
    }

    function get_ticker_news() {
        //FUNCTION DEC: load all the categories of persons who can apply
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_ticker_news($this -> input -> post('school_id'));
        echo $result;
    }

    function set_category() {
        $this -> session -> set_userdata('person_category', $this -> input -> post('category_id'));

    }

    function get_martial_statuses(){
         //FUNCTION DEC: load martial statuses
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_martial_statuses();
        echo $result;        
    }

    function get_genders(){
        //FUNCTION DEC: load genders db
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_genders();
        echo $result;        
    }

    function get_nationalities() {
        //FUNCTION DEC: load all nationalities from db
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_nationalities();
        echo $result;
    }

    function get_blood_groups() {
        //FUNCTION DEC: load all blood groups
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_blood_groups();
        echo $result;
    }

    function store_tab_in_session($current_tab) {
        //FUNCTION DESC: stores the data of the tab into the session as a string
        $data = serialize($_POST);
        
        
                //avaoiding for tab one .. as the person_application_id is not gerated yet
                if($current_tab != 'tab1'){
                    $this -> load -> model('db_handler');
                    $result = $this -> db_handler -> store_temp_session_tab($current_tab, $data);
                }
        
            $this -> session -> set_userdata($current_tab, $data);
        
        echo "stored data on session and db";
        
        
        
    }

    function store_tab_in_temp_db($current_tab) {
        //FUNCTION DESC: stores the data of the tab into the temp tables in database
       
        switch ($current_tab) {
            case 'tab1' :
                $this -> load -> model('db_handler');
                $result = $this -> db_handler -> store_temp_db_tab1($this -> input -> post());
                echo $result;
                break;

            case 'tab2' :
                $this -> load -> model('db_handler');
                $result = $this -> db_handler -> store_temp_db_tab2($this -> input -> post());
                echo $result;
                break;

            case 'tab3' :
                $this -> load -> model('db_handler');
                $result = $this -> db_handler -> store_temp_db_tab3($this -> input -> post());
                echo $result;
                break;

            case 'tab4' :
                $this -> load -> model('db_handler');
                $result = $this -> db_handler -> store_temp_db_tab4($this -> input -> post());
                echo $result;
                break;

            case 'tab4_2' :
                $this -> load -> model('db_handler');
                $result = $this -> db_handler -> store_temp_db_tab4_2($this -> input -> post());
               
                echo $result;
                break;
            case 'tab5' :
                //everything is already taken care of, hence .. just move
               
                echo 'true';
                break;
            default :
                break;
        }

    }

    function plupload_upload() {
         $person_application_id = $this -> session -> userdata('person_application_id');
         $targetDir = '.\uploads';
         if (!is_dir('.\uploads\\'.$person_application_id)) {
            mkdir('.\uploads\\'.$person_application_id, 0777);
             $targetDir = '.\uploads\\'.$person_application_id;
           }
        $targetDir = '.\uploads\\'.$person_application_id;

        $cleanupTargetDir = true;
        // Remove old files
        $maxFileAge = 5 * 3600;
        // Temp file age in seconds

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Uncomment this one to fake upload time
        // usleep(5000);

        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        // Create target dir
        if (!file_exists($targetDir))
            @mkdir($targetDir);

        // Remove old temp files
        if ($cleanupTargetDir) {
            if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                  
                    // Remove temp file if it is older than the max age and is not the current file
                    if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }
        }

        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = @fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    } else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    @fclose($in);
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            // Open temp file
            $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = @fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                @fclose($in);
                @fclose($out);
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }

        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

    }

    function insert_file_details_db() {
        //FUNCTION DEC: put file detials into the db also
       

        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> insert_file_details_db($_REQUEST['serializedData']);
        ChromePhp::warn(' the request data is '.print_r($_REQUEST['serializedData']));
        if ($result != 'true') {
            ChromePhp::log('File not uploaded ' . $files_data);
        } else {
            ChromePhp::log('successfull upload');
        }
    }

    function get_files_details() {
        //FUNCTION DEC: get the details of the customers files from the database
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_files_details();
        echo $result;
    }

    function get_document_types() {
        //FUNCTION DEC: get the details of the customers files from the database

        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> get_document_types();
        echo $result;
    }

    function delete_uploaded_files() {
        //FUNCTION DEC: get the details of the customers files from the database
        $result = '';
        //Code to delete files from the upload folder
       $person_application_id = $this -> session -> userdata('person_application_id');
        $uploadsDir = 'C:\wamp\www\CodeIgniter_Registration\uploads\\'.$person_application_id;
        $fp=$uploadsDir.'\\'.$this->input->post('file_name').'.'.$this->input->post('file_extn');
        
      
       
        if(unlink($fp)){
           
             // if success : delete from the database also
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> delete_uploaded_files($this->input->post('file_id_')); // dont know why the underscore here too
        }
        
       
        echo $result;
    }
    
    function set_file_category(){
        // DESC : this updates the categories in the database
       
        $this -> load -> model('db_handler');
        $result = $this -> db_handler -> set_file_category($this->input->post());
        echo $result;
    }

}
