<?php

/**
 * This is the DB handler class with some core functions and some site specific ones
 */
class Db_handler extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function enter_registration_data($userdata) {

        $firstname = $userdata['firstname'];
        $lastname = $userdata['lastname'];
        $email = $userdata['email'];
        $phone = $userdata['phone'];
        $username = $userdata['username'];
        $password = $userdata['password'];
        $notifications = $userdata['notifications'];

        $random_hash = md5(rand(5, 10000) . $username);

        $query = 'insert into cr_registration_main values(null,"' . $firstname . '", "' . $lastname . '", "' . $email . '", ' . $phone . ',null,' . $notifications . ',"' . $random_hash . '")';
        $q = $this -> db -> query($query);

        $user_id = $this -> db -> insert_id();

        $data = array('activation_hash' => $random_hash, 'user_id' => $user_id, 'firstname' => $firstname, 'email' => $email);
        $this -> session -> set_userdata($data);

        $query1 = 'insert into cr_login_details values(' . $user_id . ', "' . $username . '", "' . $password . '","",null)';
        $q1 = $this -> db -> query($query1);

        if ($q && $q1) {
            return 1;
        } else {
            return 0;
        }
        return 0;
    }

    function resend_password($email_id) {
        //check if email exists .. and if yes .. send the email with new password generated
        $query = 'select email,user_id from cr_registration_main where email = "' . $email_id . '"';

        $q = $this -> db -> query($query);
        $ret_string = '';
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $ret_string = $row -> user_id;
            }
            ChromePhp::error('the user id in model is ' . $ret_string . ' querty is ' . $query);
            return 'exists_' . $ret_string;
        } else {
            return "Email Address does not exixst in the Records";
        }

    }

    function generate_new_password($user_id) {
        //update the temp password with the generated one .. and return use name and password
        ChromePhp::log('above the random password');
        $new_password = $this -> randomPassword();
        ChromePhp::log('in hte model with new password as ' . $new_password . ' and user id as ' . $user_id);
        $query = 'UPDATE cr_login_details SET temp_password = "' . md5(md5($new_password)) . '" WHERE user_id = ' . $user_id;
        $q = $this -> db -> query($query);

        $query = 'SELECT reg.firstname, ld.username FROM cr_login_details ld, cr_registration_main reg WHERE ld.user_id = reg.user_id AND ld.user_id = ' . $user_id;
        $q = $this -> db -> query($query);

        $username = '';
        $firstname = '';
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $username = $row -> username;
                $firstname = $row -> firstname;
            }
            return $new_password . '|' . $username . '|' . $firstname;
        }
    }

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1;
        //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
        //turn the array into a string
    }

    function get_activation_code($user_id) {
        $query = 'SELECT activated from cr_registration_main WHERE user_id = ' . $user_id;
        $q = $this -> db -> query($query);
        $ret_string = '';
        if ($q -> num_rows() > 0) {

            foreach ($q->result() as $row) {
                $ret_string = $row -> activated;
            }
        }
        return $ret_string;
    }

    function activate_email($activation_code) {
        $parts = explode('_', $activation_code);

        $query = 'SELECT activated from cr_registration_main WHERE user_id = ' . $parts[0];
        $q = $this -> db -> query($query);
        $ret_string = '';
        if ($q -> num_rows() > 0) {

            foreach ($q->result() as $row) {
                $ret_string = $row -> activated;
            }
        }
        if (($parts[1] == $ret_string) && ($ret_string != 'activated')) {
            $query1 = 'UPDATE cr_registration_main SET activated = "activated" WHERE user_id = ' . $parts[0];
            $q1 = $this -> db -> query($query1);
            if ($q1) {
                // go to the activation page
                header('Location: http://localhost/CodeIgniter_Registration/index.php/home/activation_sucess');
            } else {
                header('Location: http://localhost/CodeIgniter_Registration/index.php/home/activation_failed');
            }
        }
    }

    function login_validate() {

        $query = 'SELECT user_id, temp_password FROM cr_login_details WHERE username = "' . $this -> input -> post('login_username') . '"';
        $q = $this -> db -> query($query);
        $temp_password = '';
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $temp_password = $row -> temp_password;
            }
        }
        if (($temp_password != '') && ($temp_password == $this -> input -> post('login_password'))) {
            //the customer had requested for a temp password .. hence .. do the process
            $query = 'UPDATE cr_login_details SET password = "' . $temp_password . '", temp_password = "" WHERE username = "' . $this -> input -> post('login_username') . '"';
            $q = $this -> db -> query($query);

        }
        //End of resend password .. temp password checking ..

        $this -> db -> where('username', $this -> input -> post('login_username'));
        $this -> db -> where('password', $this -> input -> post('login_password'));
        $query = $this -> db -> get('cr_login_details');

        if ($query -> num_rows == 1) {
            $query2 = 'SELECT user_id from cr_login_details WHERE username="' . $this -> input -> post('login_username') . '"';
            $q = $this -> db -> query($query2);

            foreach ($q->result() as $row) {
                $user_id = $row -> user_id;
            }
            $this -> session -> set_userdata('logged_user_id', $user_id);
            $this -> session -> set_userdata('username', $this -> input -> post('login_username'));

            //user has entered the right password .. hence .. noneed to have the temp_password .. if any
            $query = 'UPDATE cr_login_details SET temp_password = "" WHERE username = "' . $this -> input -> post('login_username') . '"';
            $q = $this -> db -> query($query);
            return true;
        } else {
            return false;
        }
    }

    function is_user_existing($userdata) {

        if (array_key_exists('emailid', $userdata)) {

            $query = 'select email from cr_registration_main where email = "' . $userdata['emailid'] . '"';

            $q = $this -> db -> query($query);

            if ($q -> num_rows() > 0) {
                return "Email address already exist in database, please Sign In or Enter another email address";
            }
            $q -> free_result();
        }

        if (array_key_exists('username', $userdata)) {
            $query = 'select username from cr_login_details where username = "' . $userdata['username'] . '"';
            $q = $this -> db -> query($query);

            if ($q -> num_rows() > 0) {
                return "Username already exists, please Sign In or Choose another username";
            }
            $q -> free_result();
        }

        return 1;
    }

    function get_states() {
        //FUNCTION DESC : load all the states
        $req = 'SELECT DISTINCT state_name FROM cr_cities';
        $query = mysql_query($req);
        $results[] = 'Select State';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['state_name']] = $row['state_name'];
        }
        return json_encode($results);
    }

    function get_cities($state_name) {
        //FUNCTION DESC : load cities for selected state
        $req = 'SELECT DISTINCT city_id, city_name FROM cr_cities WHERE state_name = "' . $state_name . '"';
        $query = mysql_query($req);
        $results[] = 'Select City';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['city_id']] = $row['city_name'];
        }
        return json_encode($results);
    }

    function get_schools($city_id) {
        //FUNCTION DESC : load schools for the selected city
        $req = 'SELECT sd.school_id, sd.school_name
                        FROM cr_school_details sd, cr_addresses ad
                        WHERE sd.address_id = ad.address_id
                        AND ad.city_id = ' . $city_id;

        $query = mysql_query($req);
        $results[] = 'Select School';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['school_id']] = $row['school_name'];
        }
        return json_encode($results);
    }

    function get_school_cities() {
        //FUNCTION DESC : load all cities where the schools are registered
        $req = 'SELECT DISTINCT ct.city_id, ct.city_name
                        FROM cr_cities ct, cr_addresses ad, cr_school_details sd
                        WHERE ct.city_id = ad.city_id
                        AND ad.address_id = sd.address_id';
        $query = mysql_query($req);
        $results[] = 'Select City';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['city_id']] = $row['city_name'];
        }
        return json_encode($results);
    }

    function get_person_categories() {
        //FUNCTION DESC : load categories of persons who can register to the portal
        $req = 'SELECT DISTINCT category_id, category_name
                        FROM cr_person_category_lkup';
        $query = mysql_query($req);
        $results[] = 'Select Category';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['category_id']] = $row['category_name'];
        }
        return json_encode($results);
    }

    function get_ticker_news($school_id) {
        //FUNCTION DESC : disp[lay the news ticker items for the schools selected
        $req = 'SELECT sn.news_id, sn.news , sc.school_name
                        FROM cr_school_news sn, cr_school_details sc
                        WHERE sn.school_id = sc.school_id
                        AND sn.school_id = ' . $school_id;
        $query = mysql_query($req);

        while ($row = mysql_fetch_array($query)) {
            $results[$row['news_id']] = $row['school_name'] . ' - ' . $row['news'];
        }
        return json_encode($results);
    }

    function get_martial_statuses() {
        //FUNCTION DESC : load genders
        $req = 'SELECT martial_status_name
                        FROM cr_martial_status_lkup';
        $query = mysql_query($req);
        $results[] = 'Select Martial Status';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['martial_status_name']] = $row['martial_status_name'];
        }
        return json_encode($results);
    }

    function get_genders() {
        //FUNCTION DESC : load genders
        $req = 'SELECT gender_name
                        FROM cr_gender_lkup';
        $query = mysql_query($req);
        $results[] = 'Select Gender';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['gender_name']] = $row['gender_name'];
        }
        return json_encode($results);
    }

    function get_nationalities() {
        //FUNCTION DESC : load nationalities to select
        $req = 'SELECT nationality_id, nationality_name
                        FROM cr_nationality_lkup';
        $query = mysql_query($req);
        $results[] = 'Select Nationality';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['nationality_id']] = $row['nationality_name'];
        }
        return json_encode($results);
    }

    function get_blood_groups() {
        //FUNCTION DESC : load nationalities to select
        $req = 'SELECT blood_group_id, blood_group_name
                        FROM cr_blood_group_lkup';
        $query = mysql_query($req);
        $results[] = 'Select Blood Group';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['blood_group_id']] = $row['blood_group_name'];
        }
        return json_encode($results);
    }

    function store_temp_db_tab1($post_data) {

        if ($this -> session -> userdata('person_application_id')) {
            //an entry is already made .. hence just update

            $person_application_id = $this -> session -> userdata('person_application_id');
            $query = 'UPDATE temp_cr_persons set category_id = ' . $post_data['person_catagory'] . ' WHERE person_application_id = ' . $this -> session -> userdata('person_application_id');

            $q = $this -> db -> query($query);
        } else {

            $query = 'INSERT INTO temp_cr_persons (category_id) VALUES (' . $post_data['person_catagory'] . ')';
            $q = $this -> db -> query($query);
            $person_application_id = $this -> db -> insert_id();
            $this -> session -> set_userdata('person_application_id', $person_application_id);

            //Setting the Data recovery fall back values .. to handle session refresh ..
            $ip_addr = $this -> input -> ip_address();
            $user_id = $this -> session -> userdata('logged_user_id');
            $query = 'INSERT INTO temp_cr_ip_address_map VALUES (' . $person_application_id . ',"' . $ip_addr . '",' . $user_id . ')';
            $q = $this -> db -> query($query);
            //done

        }

        //delete the schools applied for if already presnet
        $query2 = 'DELETE FROM temp_cr_schools_applied WHERE person_application_id = ' . $person_application_id;
        $q2 = $this -> db -> query($query2);

        $query3 = 'INSERT INTO temp_cr_schools_applied VALUES ';
        $row_count = 0;
        foreach ($post_data as $key => $value) {

            if (strpos($key, 'school_') === 0) {

                $school_id = str_replace('school_', '', $key);
                if ($row_count != 0) {
                    $query3 .= ',';
                }
                $row_count++;
                $query3 .= '(' . $person_application_id . ',' . $school_id . ')';
            }
        }

        $q3 = $this -> db -> query($query3);

        return 'true';
    }

    //common function to be used to get the MySQL date format
    function datepicker_to_date($datepicker_val) {
        //Calculating the date input format
        date_default_timezone_set('Asia/Calcutta');
        // setting hte indian time zone
        //$datetime = date('Y-m-d H:i:s',time());  //if an error or mismatch in date .. try setting the timezone
        $date_of_birth = str_replace("/", "-", $datepicker_val);
        $todate = strtotime($date_of_birth);
        return date("Y-m-d", $todate);
    }

    function store_temp_db_tab2($post_data) {
        $person_application_id = $this -> session -> userdata('person_application_id');

        //$dob_date = datepicker_to_date($post_data['date_of_birth']);
        //Calculating the date input format
        date_default_timezone_set('Asia/Calcutta');
        // setting hte indian time zone
        //$datetime = date('Y-m-d H:i:s',time());  //if an error or mismatch in date .. try setting the timezone
        $date_of_birth = str_replace("/", "-", $post_data['date_of_birth']);
        $todate = strtotime($date_of_birth);
        $dob_date = date("Y-m-d", $todate);

        $query = 'UPDATE temp_cr_persons 
                    SET 
                    firstname = "' . $post_data['firstname'] . '",
                    middlename = "' . $post_data['middlename'] . '",
                    lastname = "' . $post_data['lastname'] . '",
                    gender = "' . $post_data['gender'] . '",
                    dob = "' . $dob_date . '",
                    nationality = ' . $post_data['nationality'] . ',
                    fathers_name = "' . $post_data['fathers_name'] . '",
                    mothers_name = "' . $post_data['mothers_name'] . '",
                    blood_group = ' . $post_data['blood_group'] . ' 
                    WHERE person_application_id = ' . $person_application_id;

        $q = $this -> db -> query($query);

        return 'true';

    }

    function store_temp_db_tab3($post_data) {
        $person_application_id = $this -> session -> userdata('person_application_id');

        /*
         * Check if the address is already existing for this application .. if yes .. UPDATE .. else INSERT
         */
        $query = 'SELECT address_id, category FROM temp_cr_person_address_map WHERE person_application_id = ' . $person_application_id;
        $q = $this -> db -> query($query);
        if ($q -> num_rows() > 0) {
            // already existing .. hence use update
            foreach ($q->result() as $row) {

                if ($row -> category == 1) {
                    $temp_address_id['residential'] = $row -> address_id;
                } else {
                    $temp_address_id['permanent'] = $row -> address_id;
                }
            }
            //if both addresses are same.. you need only one update .. else 2

            $query1 = 'UPDATE temp_cr_addresses 
                                SET 
                                line1 = "' . $post_data['res_address_line1'] . '",
                                line2 = "' . $post_data['res_address_line2'] . '",
                                city_id = ' . $post_data['res_city'] . ',
                                pincode = ' . $post_data['res_pin_code'] . ',
                                phone_1 = ' . $post_data['res_phone1'] . ',
                                phone_2 = ' . $post_data['res_phone2'] . ',
                                email = "' . $post_data['res_email'] . '" 
                                WHERE address_id = ' . $temp_address_id['residential'];
            $q = $this -> db -> query($query1);

            if ($temp_address_id['residential'] != $temp_address_id['permanent']) {
                //need to update permanent address also
                $query2 = 'UPDATE temp_cr_addresses 
                                SET 
                                line1 = "' . $post_data['permanent_address_line1'] . '",
                                line2 = "' . $post_data['permanent_address_line2'] . '",
                                city_id = ' . $post_data['permanent_city'] . ',
                                pincode = ' . $post_data['permanent_pin_code'] . ',
                                phone_1 = ' . $post_data['permanent_phone1'] . ',
                                phone_2 = ' . $post_data['permanent_phone2'] . ',
                                email = "' . $post_data['permanent_email'] . '" 
                                WHERE address_id = ' . $temp_address_id['permanent'];
                $q = $this -> db -> query($query2);
            }

        } else {
            // Need to insert data as it is not present

            $query = 'INSERT INTO temp_cr_addresses 
                            VALUES (null, 
                            "' . $post_data['res_address_line1'] . '",
                            "' . $post_data['res_address_line2'] . '",
                            ' . $post_data['res_city'] . ',
                            ' . $post_data['res_pin_code'] . ',
                            ' . $post_data['res_phone1'] . ',
                            ' . $post_data['res_phone2'] . ',
                            "' . $post_data['res_email'] . '")';
            $q = $this -> db -> query($query);
            $residential_address_id = $this -> db -> insert_id();

            $query1 = 'INSERT INTO temp_cr_person_address_map VALUES (' . $person_application_id . ',' . $residential_address_id . ',1)';
            $q1 = $this -> db -> query($query1);

            if (isset($post_data['same_permanent_address'])) {
                $query2 = 'INSERT INTO temp_cr_person_address_map VALUES (' . $person_application_id . ',' . $residential_address_id . ',2)';
                $q1 = $this -> db -> query($query2);
            } else {
                //PERMANENT ADDRESS
                $query3 = 'INSERT INTO temp_cr_addresses 
                            VALUES (null, 
                            "' . $post_data['permanent_address_line1'] . '",
                            "' . $post_data['permanent_address_line2'] . '",
                            ' . $post_data['permanent_city'] . ',
                            ' . $post_data['permanent_pin_code'] . ',
                            ' . $post_data['permanent_phone1'] . ',
                            ' . $post_data['permanent_phone2'] . ',
                            "' . $post_data['permanent_email'] . '")';
                $q = $this -> db -> query($query3);
                $permanent_address_id = $this -> db -> insert_id();

                $query4 = 'INSERT INTO temp_cr_person_address_map VALUES (' . $person_application_id . ',' . $permanent_address_id . ',2)';
                $q1 = $this -> db -> query($query4);
            }

        }
        return 'true';
    }

    function store_temp_db_tab4($post_data) {
        $person_application_id = $this -> session -> userdata('person_application_id');

        /*
         * in each case we check if the data exists already, and decide to UPDATE or INSERT
         */

        date_default_timezone_set('Asia/Calcutta');
        // setting hte indian time zone
        //$datetime = date('Y-m-d H:i:s',time());  //if an error or mismatch in date .. try setting the timezone
        $pre_edu_from = str_replace("/", "-", $post_data['pre_edu_from']);
        $todate = strtotime($pre_edu_from);
        $pre_edu_from = date("Y-m-d", $todate);

        $pre_edu_to = str_replace("/", "-", $post_data['pre_edu_to']);
        $todate = strtotime($pre_edu_to);
        $pre_edu_to = date("Y-m-d", $todate);

        $query = 'SELECT person_application_id FROM temp_cr_prev_edu WHERE person_application_id = ' . $person_application_id;
        $q = $this -> db -> query($query);

        if ($q -> num_rows() > 0) {
            // already present .. hence UPDATE
            $query2 = 'UPDATE temp_cr_prev_edu 
                                SET 
                                school_name = "' . $post_data['pre_edu_school_name'] . '",
                                city = ' . $post_data['pre_edu_city'] . ',
                                from_date = "' . $pre_edu_from . '",
                                to_date = "' . $pre_edu_to . '"
                                WHERE person_application_id = ' . $person_application_id;
            $q = $this -> db -> query($query2);

        } else {
            // not present hence insert
            $query2 = 'INSERT INTO temp_cr_prev_edu VALUES (
                        ' . $person_application_id . ',
                        "' . $post_data['pre_edu_school_name'] . '",
                        ' . $post_data['pre_edu_city'] . ',
                        "' . $pre_edu_from . '",
                        "' . $pre_edu_to . '")';
            $q = $this -> db -> query($query2);
        }

        //START the repeated insertion of Siblings data

        $query3 = 'DELETE FROM temp_cr_siblings WHERE person_application_id = ' . $person_application_id;
        $q3 = $this -> db -> query($query3);

        $sibl_name = $post_data['sibl_name'];
        $sibl_gender = $post_data['sibl_gender'];
        $sibl_dob = $post_data['sibl_dob'];
        $sibl_school = $post_data['sibl_school'];
        $sibl_class = $post_data['sibl_class'];

        $query4 = 'INSERT INTO temp_cr_siblings values ';

        foreach ($sibl_name as $key => $value) {
            $sibl_dob_temp = str_replace("/", "-", $sibl_dob[$key]);
            $todate = strtotime($sibl_dob_temp);
            $sibl_dob_temp = date("Y-m-d", $todate);

            if ($key != 0) {$query4 .= ',';
            }
            $query4 .= '(' . $person_application_id . ',"' . $sibl_name[$key] . '","' . $sibl_gender[$key] . '","' . $sibl_dob_temp . '","' . $sibl_school[$key] . '","' . $sibl_class[$key] . '")';

        }
        $q4 = $this -> db -> query($query4);

        //start to enter "Others" details now

        $query5 = 'SELECT person_application_id FROM temp_cr_misc_details WHERE person_application_id = ' . $person_application_id;
        $q5 = $this -> db -> query($query5);

        if ($q5 -> num_rows() > 0) {
            // already present .. hence UPDATE
            $query6 = 'UPDATE temp_cr_misc_details 
                                SET 
                                option_1 = "' . $post_data['day_or_hostel'] . '",
                                mother_tongue = "' . $post_data['mother_tongue'] . '",
                                birth_place = "' . $post_data['birth_place'] . '",
                                identification_marks = "' . $post_data['identification_marks'] . '",
                                hobbies = "' . $post_data['hobbies'] . '",
                                Allergies = "' . $post_data['allergies'] . '"
                                WHERE person_application_id = ' . $person_application_id;
            $q6 = $this -> db -> query($query6);

        } else {
            // not present hence insert
            $query7 = 'INSERT INTO temp_cr_misc_details VALUES (
                        ' . $person_application_id . ',
                        "' . $post_data['day_or_hostel'] . '",
                        "' . $post_data['mother_tongue'] . '",
                        "' . $post_data['birth_place'] . '",
                        "' . $post_data['identification_marks'] . '",
                         "' . $post_data['hobbies'] . '",
                        "' . $post_data['allergies'] . '")';
            $q7 = $this -> db -> query($query7);
        }

        //DONE with all details in tab4

        return 'true';
    }

    function store_temp_db_tab4_2($post_data) {
        $person_application_id = $this -> session -> userdata('person_application_id');

        /*
         * in each case we check if the data exists already, and decide to UPDATE or INSERT
         */
        date_default_timezone_set('Asia/Calcutta');

        //START the repeated insertion of Experience Details

        $query3 = 'DELETE FROM temp_cr_prev_exp WHERE person_application_id = ' . $person_application_id;
        $q3 = $this -> db -> query($query3);

        $experience_desc = $post_data['expr_desc'];
        $expr_city = $post_data['expr_city'];
        $expr_from = $post_data['expr_from'];
        $expr_to = $post_data['expr_to'];

        $query4 = 'INSERT INTO temp_cr_prev_exp values ';

        foreach ($experience_desc as $key => $value) {

            $expr_from = str_replace("/", "-", $expr_from[$key]);
            $todate = strtotime($expr_from);
            $expr_from = date("Y-m-d", $todate);

            $expr_to = str_replace("/", "-", $expr_to[$key]);
            $todate = strtotime($expr_to);
            $expr_to = date("Y-m-d", $todate);

            if ($key != 0) {
                $query4 .= ',';
            }
            $query4 .= '(' . $person_application_id . ',"' . $experience_desc[$key] . '",' . $expr_city[$key] . ',"' . $expr_from . '","' . $expr_to . '")';

        }
        $q4 = $this -> db -> query($query4);

        //Start with repeated insertion of qualification stuff

        $query3 = 'DELETE FROM temp_cr_qualifications WHERE person_application_id = ' . $person_application_id;
        $q3 = $this -> db -> query($query3);

        $course = $post_data['course'];
        $course_inst = $post_data['course_inst'];
        $course_from = $post_data['course_from'];
        $course_to = $post_data['course_to'];
        $final_percent = $post_data['course_final_percent'];

        $query4 = 'INSERT INTO temp_cr_qualifications values ';

        foreach ($course as $key => $value) {

            $course_from = str_replace("/", "-", $course_from[$key]);
            $todate = strtotime($course_from);
            $course_from = date("Y-m-d", $todate);

            $course_to = str_replace("/", "-", $course_to[$key]);
            $todate = strtotime($course_to);
            $course_to = date("Y-m-d", $todate);

            if ($key != 0) {
                $query4 .= ',';
            }
            $query4 .= '(' . $person_application_id . ',"' . $course[$key] . '","' . $course_inst[$key] . '","' . $course_from . '","' . $course_to . '",' . $final_percent[$key] . ')';

        }
        $q4 = $this -> db -> query($query4);

        //Start with repeated insertion of reference stuff

        $query3 = 'DELETE FROM temp_cr_references WHERE person_application_id = ' . $person_application_id;
        $q3 = $this -> db -> query($query3);

        $reference_name = $post_data['reference_name'];
        $reference_desc = $post_data['reference_desc'];
        $reference_phone = $post_data['reference_phone'];
        $reference_email = $post_data['reference_email'];

        $query4 = 'INSERT INTO temp_cr_references values ';

        foreach ($reference_name as $key => $value) {

            if ($key != 0) {
                $query4 .= ',';
            }
            $query4 .= '(' . $person_application_id . ',"' . $reference_name[$key] . '","' . $reference_desc[$key] . '",' . $reference_phone[$key] . ',"' . $reference_email[$key] . '")';

        }
        $q4 = $this -> db -> query($query4);

        //start to enter "Others" details now

        $query5 = 'SELECT person_application_id FROM temp_cr_misc_details WHERE person_application_id = ' . $person_application_id;
        $q5 = $this -> db -> query($query5);

        if ($q5 -> num_rows() > 0) {
            // already present .. hence UPDATE
            $query6 = 'UPDATE temp_cr_misc_details 
                                SET 
                                option_1 = "' . $post_data['maritial_status_2'] . '",
                                mother_tongue = "' . $post_data['mother_tongue_2'] . '",
                                birth_place = "' . $post_data['birth_place_2'] . '",
                                identification_marks = "' . $post_data['identification_marks_2'] . '",
                                hobbies = "' . $post_data['hobbies_2'] . '",
                                Allergies = "' . $post_data['allergies_2'] . '"
                                WHERE person_application_id = ' . $person_application_id;
            $q6 = $this -> db -> query($query6);

        } else {
            // not present hence insert
            $query7 = 'INSERT INTO temp_cr_misc_details VALUES (
                        ' . $person_application_id . ',
                        "' . $post_data['maritial_status_2'] . '",
                        "' . $post_data['mother_tongue_2'] . '",
                        "' . $post_data['birth_place_2'] . '",
                        "' . $post_data['identification_marks_2'] . '",
                         "' . $post_data['hobbies_2'] . '",
                        "' . $post_data['allergies_2'] . '")';
            $q7 = $this -> db -> query($query7);
        }

        return 'true';
    }

    function get_files_details() {

        $person_application_id = $this -> session -> userdata('person_application_id');
        //FUNCTION DESC : load nationalities to select
        $req = 'SELECT file_id, file_name, document_type_id
                        FROM temp_cr_fileuploads
                        WHERE person_application_id = ' . $person_application_id;
        $query = mysql_query($req);

        while ($row = mysql_fetch_array($query)) {
            $results[$row['file_id'] . '_' . $row['file_name']] = $row['document_type_id'];
        }
        return json_encode($results);
    }

    function get_document_types() {

        //FUNCTION DESC : load nationalities to select

        $req = 'SELECT document_type_id, document_type_name
                        FROM cr_reqd_documents_lkup
                        WHERE person_category_id = ' . $this -> session -> userdata('person_category');
        $query = mysql_query($req);
        $results[] = 'Select';
        while ($row = mysql_fetch_array($query)) {
            $results[$row['document_type_id']] = $row['document_type_name'];
        }

        return json_encode($results);
    }

    function insert_file_details_db($fileName) {

        $person_application_id = $this -> session -> userdata('person_application_id');

        $query = 'INSERT INTO temp_cr_fileuploads VALUES ';

        foreach ($fileName as $key => $value) {
            if ($key != 0) {
                $query .= ',';
            }
            $query .= '(' . $person_application_id . ',null,"' . $value . '",0,null)';
        }

        $q = $this -> db -> query($query);
        if ($q) {
            return 'true';
        }
    }

    function set_file_category($postdata) {
        //dont know why the extra '_' is .. but it works
        $query = 'UPDATE temp_cr_fileuploads SET document_type_id = ' . $postdata['category_val_'] . ' WHERE file_id = ' . $postdata['file_id_'];
        $q = $this -> db -> query($query);
    }

    function delete_uploaded_files($file_id) {
        $query = 'DELETE FROM temp_cr_fileuploads WHERE file_id = ' . $file_id;
        $q = $this -> db -> query($query);
        return $q;
    }

    function store_temp_session_tab($tab_name, $value) {
        $person_application_id = $this -> session -> userdata('person_application_id');
        $query = 'INSERT INTO temp_cr_session_vars VALUES (' . $person_application_id . ',"' . $tab_name . '",\'' . $value . '\')';
        $q = $this -> db -> query($query);
        return $q;
    }

    function get_tab6_data() {
        $person_application_id = $this -> session -> userdata('person_application_id');

        $result_set = array('tab1' => '', 'tab2' => '', 'tab3' => '', 'tab4' => '', 'tab4_2' => '');

        $temp_available = '';
        $query = 'SELECT person_application_id FROM temp_cr_persons WHERE person_application_id = ' . $person_application_id;
        $q = $this -> db -> query($query);

        if ($q -> num_rows() == 1) {
            $temp_available = 'temp_';
            // in case the application is still in the temp ..
        }

        $query = 'SELECT per.firstname, per.middlename, per.lastname, per.gender, per.dob, nat.nationality_name, 
                per.fathers_name, per.mothers_name, bld.blood_group_name, per.category_id 
                FROM ' . $temp_available . 'cr_persons per, cr_blood_group_lkup bld, cr_nationality_lkup nat   
                WHERE person_application_id = ' . $person_application_id . ' 
                AND per.nationality = nat.nationality_id
                AND per.blood_group = bld.blood_group_id';
        ChromePhp::error('the query is ' . $query);
        $q = $this -> db -> query($query);
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $result_set['tab2']['firstname'] = $row -> firstname;
                $result_set['tab2']['middlename'] = $row -> middlename;
                $result_set['tab2']['lastname'] = $row -> lastname;
                $result_set['tab2']['gender'] = $row -> gender;
                $result_set['tab2']['dob'] = $row -> dob;
                $result_set['tab2']['nationality'] = $row -> nationality_name;
                $result_set['tab2']['fathers_name'] = $row -> fathers_name;
                $result_set['tab2']['mothers_name'] = $row -> mothers_name;
                $result_set['tab2']['blood_group'] = $row -> blood_group_name;
                $result_set['tab2']['category_id'] = $row -> category_id;
            }
        }

        // get both the addresses
        $query = 'SELECT address_id, category FROM ' . $temp_available . 'cr_person_address_map WHERE person_application_id = ' . $person_application_id;
        $q = $this -> db -> query($query);
        $temp_address_id = '';
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                if ($row -> category == 1) {
                    $temp_address_id['residential'] = $row -> address_id;
                } else {
                    $temp_address_id['permanent'] = $row -> address_id;
                }

            }

        }

        //Fetch residential address

        $query = 'SELECT addr.line1, addr.line2, cty.city_name, cty.state_name, addr.pincode, addr.phone_1, addr.phone_2, addr.email 
                    FROM ' . $temp_available . 'cr_addresses addr, cr_cities cty 
                    WHERE cty.city_id = addr.city_id
                    AND addr.address_id = ' . $temp_address_id['residential'];
        $q = $this -> db -> query($query);
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $result_set['tab3']['res_line1'] = $row -> line1;
                $result_set['tab3']['res_line2'] = $row -> line2;
                $result_set['tab3']['res_city_name'] = $row -> city_name;
                $result_set['tab3']['res_state_name'] = $row -> state_name;
                $result_set['tab3']['res_pincode'] = $row -> pincode;
                $result_set['tab3']['res_phone_1'] = $row -> phone_1;
                $result_set['tab3']['res_phone_2'] = $row -> phone_2;
                $result_set['tab3']['res_email'] = $row -> email;

            }
        }

        $query = 'SELECT addr.line1, addr.line2, cty.city_name, cty.state_name, addr.pincode, addr.phone_1, addr.phone_2, addr.email 
                    FROM ' . $temp_available . 'cr_addresses addr, cr_cities cty 
                    WHERE cty.city_id = addr.city_id
                    AND addr.address_id = ' . $temp_address_id['permanent'];
        $q = $this -> db -> query($query);
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $result_set['tab3']['permn_line1'] = $row -> line1;
                $result_set['tab3']['permn_line2'] = $row -> line2;
                $result_set['tab3']['permn_city_name'] = $row -> city_name;
                $result_set['tab3']['permn_state_name'] = $row -> state_name;
                $result_set['tab3']['permn_pincode'] = $row -> pincode;
                $result_set['tab3']['permn_phone_1'] = $row -> phone_1;
                $result_set['tab3']['permn_phone_2'] = $row -> phone_2;
                $result_set['tab3']['permn_email'] = $row -> email;

            }
        }

        /*
         * Stat choosing based on category
         */
         
        if ($result_set['tab2']['category_id'] == 1) {

            //previous school
            $query = 'SELECT prsch.school_name, cty.city_name, cty.state_name, prsch.from_date, prsch.to_date 
                FROM ' . $temp_available . 'cr_prev_edu prsch, cr_cities cty 
                WHERE cty.city_id = prsch.city
                AND prsch.person_application_id = ' . $person_application_id;

            $q = $this -> db -> query($query);
            if ($q -> num_rows() > 0) {
                foreach ($q->result() as $row) {
                    $result_set['tab4']['school_name'] = $row -> school_name;
                    $result_set['tab4']['city_name'] = $row -> city_name;
                    $result_set['tab4']['state_name'] = $row -> state_name;
                    $result_set['tab4']['from_date'] = $row -> from_date;
                    $result_set['tab4']['to_date'] = $row -> to_date;
                }
            }

            //siblings information .. it is in arrays
            $query = 'SELECT full_name, Gender, dob, school_name, class 
                    FROM ' . $temp_available . 'cr_siblings 
                    WHERE person_application_id = ' . $person_application_id;

            ChromePhp::error('tsiblinmg he query is ' . $query);
            $q = $this -> db -> query($query);
            if ($q -> num_rows() > 0) {
                $key_counter = 0;
                foreach ($q->result() as $row) {
                    $result_set['tab4']['full_name'][$key_counter] = $row -> full_name;
                    $result_set['tab4']['gender'][$key_counter] = $row -> Gender;
                    $result_set['tab4']['dob'][$key_counter] = $row -> dob;
                    $result_set['tab4']['sibl_school_name'][$key_counter] = $row -> school_name;
                    $result_set['tab4']['class'][$key_counter] = $row -> class;
                    $key_counter++;
                }
            }

        } else {
           
           ChromePhp::log('the else cindition i shere ');
            $query = 'SELECT exp.exp_description, cty.city_name, cty.state_name, exp.exp_from, exp.exp_to 
                    FROM ' . $temp_available . 'cr_prev_exp exp, cr_cities cty 
                    WHERE cty.city_id = exp.exp_city_id 
                    AND exp.person_application_id = ' . $person_application_id;
            ChromePhp::log('the query is '.$query);

             $q = $this -> db -> query($query);
            if ($q -> num_rows() > 0) {
                $key_counter = 0;
                foreach ($q->result() as $row) {
                    $result_set['tab4']['exp_description'][$key_counter] = $row->exp_description;
                    $result_set['tab4']['city_name'][$key_counter] = $row->city_name;
                    $result_set['tab4']['state_name'][$key_counter] = $row->state_name;
                    $result_set['tab4']['exp_from'][$key_counter] = $row->exp_from;
                    $result_set['tab4']['exp_to'][$key_counter] = $row->exp_to;
                    $key_counter++;
                }
            }

            $query = 'SELECT course, institute, qual_from, qual_to, qual_percent 
                    FROM ' . $temp_available . 'cr_qualifications 
                    WHERE person_application_id = ' . $person_application_id;
                    
            $q = $this -> db -> query($query);
            if ($q -> num_rows() > 0) {
                $key_counter = 0;
                foreach ($q->result() as $row) {
                    $result_set['tab4']['course'][$key_counter] = $row -> course;
                    $result_set['tab4']['institute'][$key_counter] = $row -> institute;
                    $result_set['tab4']['qual_from'][$key_counter] = $row -> qual_from;
                    $result_set['tab4']['qual_to'][$key_counter] = $row -> qual_to;
                    $result_set['tab4']['qual_percent'][$key_counter] = $row -> qual_percent;
                    $key_counter++;
                }
            }
            
            $query = 'SELECT ref_name, ref_description, ref_phone, ref_email
                    FROM ' . $temp_available . 'cr_references 
                    WHERE person_application_id = ' . $person_application_id;
            
            $q = $this -> db -> query($query);
            if ($q -> num_rows() > 0) {
                $key_counter = 0;
                foreach ($q->result() as $row) {
                    $result_set['tab4']['ref_name'][$key_counter] = $row -> ref_name;
                    $result_set['tab4']['ref_description'][$key_counter] = $row -> ref_description;
                    $result_set['tab4']['ref_phone'][$key_counter] = $row -> ref_phone;
                    $result_set['tab4']['ref_email'][$key_counter] = $row -> ref_email;
                    $key_counter++;
                }
            }
            
        }
        /*
         * END of category distinctions
         */
         
        //extra details
        $query = 'SELECT option_1, mother_tongue, birth_place, identification_marks, hobbies, Allergies 
                   FROM ' . $temp_available . 'cr_misc_details 
                   WHERE person_application_id = ' . $person_application_id;
        $q = $this -> db -> query($query);
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                if ($result_set['tab2']['category_id'] == 1) {
                    $result_set['tab4']['day_or_hostel'] = $row -> option_1;
                } else {
                    $result_set['tab4']['marital_status'] = $row -> option_1;
                }

                $result_set['tab4']['mother_tongue'] = $row -> mother_tongue;
                $result_set['tab4']['birth_place'] = $row -> birth_place;
                $result_set['tab4']['identification_marks'] = $row -> identification_marks;
                $result_set['tab4']['hobbies'] = $row -> hobbies;
                $result_set['tab4']['allergies'] = $row -> Allergies;
            }
        }

        return $result_set;

    }

}
