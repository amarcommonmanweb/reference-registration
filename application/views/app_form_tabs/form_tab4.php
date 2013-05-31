<?php $this -> session -> set_userdata('tab_status', 'form_tab4'); ?>

<?php
    $sess_data1 = array();
    if(print_r($this->session->userdata('tab4'),true)){
    $sess_data1 = unserialize($this->session->userdata('tab4'));
    print_r($sess_data1);
    }
    
    
    ?>
        
<div id="tab4">
	<div style="margin:0px 10px;">
		<br/>
		<div class="form_sub_title">
			<strong>Previous School Details</strong>
			<hr/>
		</div>
		<table id = "add_prev_school_row" style="width:100%;">

			<tr>
				<td><label for="pre_edu_school_name1">School Name</label>
				<br />
				<input id="pre_edu_school_name" name="pre_edu_school_name" type="text" tabindex="7" style="width:230px;" maxlength="80"/>
				</td>
				<td><label for="pre_edu_state">State</label>
				<br />
				<select id="pre_edu_state" name="pre_edu_state" type="text" tabindex="7" style="width:180px;" onchange="get_cities(this.value, 'pre_edu_city')">
					<option value=0>Select State</option>

				</select>
				<script>
					load_states('pre_edu_state');
				</script></td>
				</td>
				<td><label for="pre_edu_city">City</label>
				<br />
				<select id="pre_edu_city" name="pre_edu_city" type="text" onchange="javascript:void(0)" tabindex="7" style="width:180px;">
					<option value="0">Select City</option>
				</select></td>
				<td><label for="pre_edu_from">From</label>
				<br />
				<input class="datefield" id="pre_edu_from" name="pre_edu_from" type="text" tabindex="7" style="width:110px;"/>
				</td>
				<td><label for="pre_edu_to1">To</label>
				<br />
				<input class="datefield" id="pre_edu_to" name="pre_edu_to" type="text" tabindex="7" style="width:110px;"/>
				</td>

			</tr>

		</table>

		<div style="clear: both;">
			&nbsp;
		</div>

		<div class="form_sub_title">
			<strong>Siblings Information</strong>
			<div style="margin-right:20px;float:right;">
				<a id="add_siblings" href="javascript:add_sibling_row('siblings_info')"><strong>Add more siblings<strong></a>
			</div>
			<hr/>
		</div>
		<table id = "siblings_info" style="width:100%;">
			<tr>
				<td><label for="sibl_name1">Full Name</label>
				<br />
				<input id="sibl_name1" name="sibl_name[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>
				</td>
				<td><label for="sibl_gender1">Gender</label>
				<br />
				<select id="sibl_gender1" name="sibl_gender[]" type="text" onchange="javascript:void(0)" tabindex="7"  style="width:90px;">
					<option value="0">Select Gender</option>
					
				</select>
				<script>
                    get_genders('sibl_gender1');
                </script>
                </td>
				<td><label for="sibl_dob1">Date of Birth</label>
				<br />
				<input class="datefield" id="sibl_dob1" name="sibl_dob[]" type="text" tabindex="7" style="width:120px;"/>
				</td>
				<td><label for="sibl_school1">School</label>
				<br />
				<input id="sibl_school1" name="sibl_school[]" type="text" tabindex="7" style="width:220px;" maxlength="80"/>
				</td>
				<td><label for="sibl_class1">Class</label>
				<br />
				<input id="sibl_class1" title="sibling class onetoo" name="sibl_class[]" type="text" tabindex="7" style="width:90px;" maxlength="30"/>
				</td>
			</tr>

		</table>

		<div style="clear: both;">
			&nbsp;
		</div>

		<div class="form_sub_title">
			<strong>Others</strong>
			<hr/>
		</div>
		<table id="catagory_other" style="width:100%;">
			<tr>

				<td><label for="day_or_hostel">Day Scholar/ Hostelier</label>
				<br />
				<input id="Day" name="day_or_hostel" type="radio" checked="checked" value="Day">
				Day Scholor</input>&nbsp; &nbsp;&nbsp; &nbsp;
				<input id="Hostel" name="day_or_hostel" type="radio" value="Hostel">
				Hostelier</input> </td>
				<td><label for="mother_tongue">Mother Tongue</label>
				<br />
				<input id="mother_tongue" name="mother_tongue" type="text" tabindex="7" style="width:220px;" />
				</td>
				<td><label for="birth_place">Birth Place</label>
				<br />
				<input id="birth_place" name="birth_place" type="text" tabindex="7" style="width:220px;" />
				</td>
			</tr>
			<tr>
				<td><label for="identification_marks">Identification Marks</label>
				<br />
				<textarea class="class_height" id="identification_marks" name="identification_marks" tabindex="7" rows="11" cols="27"></textarea>				</td>
				<td><label for="hobbies">Hobbies</label>
				<br />
				<textarea class="class_height" id="hobbies" name="hobbies" tabindex="7" rows="11" cols="27"></textarea>				</td>
				<td><label for="allergies">Allergies</label>
				<br />
				<textarea class="class_height" id="allergies" name="allergies" tabindex="7" rows="11" cols="27"></textarea>				</td>

			</tr>
		</table>
	</div>

	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link next_tab" current_tab="tab4" next_tab="tab5">&nbsp; Next &nbsp;</a>
		</p>
	</div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link prev_tab" current_tab="tab4" next_tab="tab3">&nbsp; Back &nbsp;</a>
		</p>
	</div>
	<div style="clear: both;"></div>
	<div class="tab_error_msg">
		&nbsp;&nbsp;Please correct the highlighted fields to proceed&nbsp;&nbsp;
	</div>
	<div style="clear: both;"></div>
	<script>

    
	num_of_siblings = 1;
	
		on_tab_load('tab4');
	</script>
	<?php
       $sess_data = array();
     $person_application_id = $this -> session -> userdata('person_application_id');
     
        if(print_r($this->session->userdata('tab4'),true)){
            $sess_data = unserialize($this->session->userdata('tab4'));
            ChromePhp::warn('choosing the if 4');
        }   
        else{
            ChromePhp::warn('choosing the else db 4');
            $req = 'SELECT session_var FROM temp_cr_session_vars WHERE person_application_id = '.$person_application_id.' AND tab_name = "tab4"';
            $query = mysql_query($req);
            $results = '';
           if($query){
                while ($row = mysql_fetch_array($query)) {
                    $results = $row['session_var'];
                }    
            } 
            $sess_data = unserialize($results);
  
        }
    
    if(!empty($sess_data)){    
	?>
	<script>

			//simply populate the fileds based on the keys of the array..
	// i think there is no need to specify the tab .. as the fields are unique in themselves

	populate_tab_vals();

	function populate_tab_vals(){
	var arrayFromPHP = <?php echo json_encode($sess_data); ?>;
        
        for (var keyy in arrayFromPHP['sibl_name']){
            if(keyy != 0){
                add_sibling_row('siblings_info');     // running it for one less time, coz one row is already there 
            }            
            console.log(' the input her e is ssssssssssssss'+arrayFromPHP['sibl_name'][keyy]);
        }
        // ODne with generating hte extra rows
        
         for (var sibl_arrays in arrayFromPHP){
             if(sibl_arrays.indexOf('sibl_') == 0){
                // looping through the sibl arrays
                $.each(arrayFromPHP[sibl_arrays], function(key, value){
                    
                    if ('SELECT' == $('#'+sibl_arrays+(key+1)).prop('tagName')) {
                    
                    form_memory_array[sibl_arrays+(key+1)] = value;
                } else {
                   $('#'+sibl_arrays+(key+1)).val(value);
                   } 
                });            
             }
             
             //setting the radio button
             else if(sibl_arrays == 'day_or_hostel'){
                 $('#'+arrayFromPHP[sibl_arrays]).prop('checked',true);
             }
              else{
                if ('SELECT' == $('#'+sibl_arrays).prop('tagName')) {
                    
                    form_memory_array[sibl_arrays] = arrayFromPHP[sibl_arrays];
                } else {
                    $('#' + sibl_arrays).val(arrayFromPHP[sibl_arrays]);
                }
            }
         }
         
         
         //del from here

		}

		for (var key in form_memory_array) {
			console.log(' key is ' + form_memory_array[key]);
		}

	</script>

	<?php
    }
	?>
</div>