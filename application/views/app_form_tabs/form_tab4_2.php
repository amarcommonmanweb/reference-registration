<?php $this -> session -> set_userdata('tab_status', 'form_tab4_2'); ?>



<div id="tab4_2">
	<div style="margin:0px 10px;">
		<br/>
		<div class="form_sub_title">
			<strong>Experience Details</strong>
			<div style="margin-right:20px;float:right;">
				<a id="add_siblings" href="javascript:add_prev_exp_row('prev_exp_table')"><strong>Add more experience details<strong></a>
			</div>
			<hr/>
		</div>
		<table id = "prev_exp_table" style="width:100%;">
			<!-- Previous edu mapps to the experience of the teachers -->
			<tr>
				<td><label for="expr_desc1">Description</label>
				<br />
				<input id="expr_desc1" name="expr_desc[]" type="text" tabindex="7" style="width:230px;" maxlength="80"/>
				</td>
				<td><label for="expr_state1">State</label>
				<br />
				<select id="expr_state1" name="expr_state[]" type="text" tabindex="7" style="width:180px;" onchange="get_cities(this.value,'expr_city1')">
					<option value=0>Select State</option>

				</select>
				<script>
					load_states('expr_state1');
				</script></td>
				<td><label for="expr_city1">City</label>
				<br />
				<select id="expr_city1" name="expr_city[]" onchange="javascript:void(0)" type="text" tabindex="7" style="width:180px;">
					<option value="0">Select City</option>
				</select></td>
				<td><label for="expr_from1">From</label>
				<br />
				<input class="datefield" id="expr_from1" name="expr_from[]" type="text" tabindex="7" style="width:110px;"/>
				</td>
				<td><label for="expr_to1">To</label>
				<br />
				<input class="datefield" id="expr_to1" name="expr_to[]" type="text" tabindex="7" style="width:110px;"/>
				</td>

			</tr>

		</table>

		<div style="clear: both;">
			&nbsp;
		</div>

		<div class="form_sub_title">
			<strong>Qualification Details</strong>
			<div style="margin-right:20px;float:right;">
				<a id="add_qualifications" href="javascript:add_qualifications_info_row('qualifications_info')"><strong>Add more qualification details<strong></a>
			</div>
			<hr/>
		</div>
		<table id = "qualifications_info" style="width:100%;">
			<tr>
				<td><label for="course1">Degree / Course</label>
				<br />
				<input id="course1" name="course[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>
				</td>
				<td><label for="course_inst1">Institute Name</label>
				<br />
				<input id="course_inst1" name="course_inst[]" type="text" tabindex="7" style="width:230px;" maxlength="80"/>
				</td>
				<td><label for="course_from1">From</label>
				<br />
				<input class="datefield" id="course_from1" name="course_from[]" type="text" tabindex="7" style="width:110px;"/>
				</td>
				<td><label for="course_to1">To</label>
				<br />
				<input class="datefield" id="course_to1" name="course_to[]" type="text" tabindex="7" style="width:110px;"/>
				</td>
				<td><label for="final_percent1">Final Percentage</label>
				<br />
				<input id="course_final_percent1" name="course_final_percent[]" type="text" tabindex="7" style="width:110px;"/>
				</td>
			</tr>

		</table>

		<div style="clear: both;">
			&nbsp;
		</div>

		<div class="form_sub_title">
			<strong>References Details (2)</strong>
			<hr/>
		</div>
		<table id = "references_info" style="width:100%;">
			<tr>
				<td><label for="reference_name1">Person's Name</label>
				<br />
				<input id="reference_name1" name="reference_name[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>
				</td>
				<td><label for="reference_desc1">Description</label>
				<br />
				<input id="reference_desc1" name="reference_desc[]" type="text" tabindex="7" style="width:210px;" maxlength="180"/>
				</td>
				<td><label for="reference_phone1">Phone Number</label>
				<br />
				<input id="reference_phone1" name="reference_phone[]" type="text" tabindex="7" style="width:210px;" maxlength="20"/>
				</td>
				<td><label for="reference_email1">Email Id</label>
				<br />
				<input id="reference_email1" name="reference_email[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>
				</td>

			</tr>
			<tr class="even_row">
				<td>
				<input id="reference_name2" name="reference_name[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>
				</td>
				<td>
				<input id="reference_desc2" name="reference_desc[]" type="text" tabindex="7" style="width:210px;" maxlength="180"/>
				</td>
				<td>
				<input id="reference_phone2" name="reference_phone[]" type="text" tabindex="7" style="width:210px;" maxlength="20"/>
				</td>
				<td>
				<input id="reference_email2" name="reference_email[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>
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
		<table id="catagory_other_2" style="width:100%;">
			<tr>

				<td><label for="mother_tongue_2">Mother Tongue</label>
				<br />
				<input id="mother_tongue_2" name="mother_tongue_2" type="text" tabindex="7" style="width:220px;" />
				</td>
				<td><label for="birth_place_2">Birth Place</label>
				<br />
				<input id="birth_place_2" name="birth_place_2" type="text" tabindex="7" style="width:220px;" />
				</td>
				<td><label for="maritial_status_2">Maritial Status</label>
				<br />
				<select id="maritial_status_2" name="maritial_status_2" type="text" onchange="javascript:void(0)" tabindex="7" style="width:220px;">
					<option value="0">Select Status</option>
					
				</select>
				<script>
				    get_martial_statuses('maritial_status_2');    
				</script>
				
				</td>
			</tr>
			<tr>
				<td><label for="identification_marks_2">Identification Marks</label>
				<br />
				<textarea class="class_height" id="identification_marks_2" name="identification_marks_2" tabindex="7" rows="11" cols="27"></textarea>				</td>
				<td><label for="hobbies_2">Hobbies</label>
				<br />
				<textarea class="class_height" id="hobbies_2" name="hobbies_2" tabindex="7" rows="11" cols="27"></textarea>				</td>
				<td><label for="allergies_2">Allergies</label>
				<br />
				<textarea class="class_height" id="allergies_2" name="allergies_2" tabindex="7" rows="11" cols="27"></textarea>				</td>

			</tr>
		</table>
	</div>

	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link next_tab" current_tab="tab4_2" next_tab="tab5">&nbsp; Next &nbsp;</a>
		</p>
	</div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link prev_tab" current_tab="tab4_2" next_tab="tab3">&nbsp; Back &nbsp;</a>
		</p>
	</div>
	<div style="clear: both;"></div>
	<div class="tab_error_msg">
		&nbsp;&nbsp;Please correct the highlighted fields to proceed&nbsp;&nbsp;
	</div>
	<div style="clear: both;"></div>
	<script>
	
    
	num_of_exp = 1;
	num_of_qual = 1;
		on_tab_load('tab4_2');
	</script>
	<?php
	
    //Check if tab_>number> is present in the session .. if it is not present  .. load the tab_<name>_db from the database stored stirng
    // either way .. just populate the $sess_data . so that you can work with it
    
     $sess_data = array();
     $person_application_id = $this -> session -> userdata('person_application_id');
     
        if(print_r($this->session->userdata('tab4_2'),true)){
            $sess_data = unserialize($this->session->userdata('tab4_2'));
            ChromePhp::warn('choosing the if ');
        }	
        else{
            ChromePhp::warn('choosing the else db ');
            $req = 'SELECT session_var FROM temp_cr_session_vars WHERE person_application_id = '.$person_application_id.' AND tab_name = "tab4_2"';
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
       
		for (var keyy in arrayFromPHP['expr_desc']) {
		    
			if (keyy != 0) {
				add_prev_exp_row('prev_exp_table');
				// running it for one less time, coz one row is already there
			}
			
		}
		
		for (var keyy in arrayFromPHP['course']) {
            
            if (keyy != 0) {
                add_qualifications_info_row('qualifications_info');
                // running it for one less time, coz one row is already there
            }
            
        }
        
		// ODne with generating hte extra rows

        


		for (var exp_arrays in arrayFromPHP) {
			if (exp_arrays.indexOf('expr_') == 0) {
				// looping through the expr arrays
				
				$.each(arrayFromPHP[exp_arrays], function(key, value) {
				   // console.log(' the key value pair is key = '+key+' and value '+value+ 'and the tag type = '+$('#' + exp_arrays + (key + 1)).prop('tagName'));
					if ('SELECT' == $('#' + exp_arrays + (key + 1)).prop('tagName')) {
						
						form_memory_array[exp_arrays + (key + 1)] = value;						
					} else {
						$('#' + exp_arrays + (key + 1)).val(value);
					}
				});
			}
			
			else if (exp_arrays.indexOf('course') == 0) {
                // looping through the sibl arrays
                $.each(arrayFromPHP[exp_arrays], function(key, value) {
                    if ('SELECT' == $('#' + exp_arrays + (key + 1)).prop('tagName')) {
                       
                        form_memory_array[exp_arrays + (key + 1)] = value;
                    } else {
                        $('#' + exp_arrays + (key + 1)).val(value);
                    }
                });
            }
            
            else if (exp_arrays.indexOf('reference_') == 0) {
                // looping through the sibl arrays
                $.each(arrayFromPHP[exp_arrays], function(key, value) {
                    if ('SELECT' == $('#' + exp_arrays + (key + 1)).prop('tagName')) {
                       
                        form_memory_array[exp_arrays + (key + 1)] = value;
                    } else {
                        $('#' + exp_arrays + (key + 1)).val(value);
                    }
                });
            }
            
            else{
                if ('SELECT' == $('#'+exp_arrays).prop('tagName')) {
                    
                    form_memory_array[exp_arrays] = arrayFromPHP[exp_arrays];
                } else {
                    $('#' + exp_arrays).val(arrayFromPHP[exp_arrays]);
                }
            }
			
		}

		}

for (var key in form_memory_array) {
          //  console.log(' key in memory is ' + key +' with value '+form_memory_array[key]);
        }
		

	</script>

	<?php
    }
	?>
</div>