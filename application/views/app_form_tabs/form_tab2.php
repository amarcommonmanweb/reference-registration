<?php $this -> session -> set_userdata('tab_status', 'form_tab2'); ?>
<div id="tab2">
	<div>
		<br/>
		<table style="margin-left:10px; width:100%;">

			<tr>
				<td><label for="firstname">First Name</label>
				<br />
				<input id="firstname" name="firstname" type="text" tabindex="1"  style="width:250px;" maxlength="50"/>
				</td>
				<td><label for="middlename">Middle Name</label>
				<br />
				<input id="middlename" name="middlename" type="text" tabindex="2"  style="width:250px;" maxlength="50"/>
				</td>
				<td><label for="lastname">Last Name</label>
				<br />
				<input id="lastname" name="lastname" type="text" tabindex="3"  style="width:250px;" maxlength="50"/>
				</td>
			</tr>

			<tr>
				<td><label for="gender">Gender</label>
				<br />
				<select id="gender" name="gender" type="text" tabindex="3" onchange="javascript:void(0)" style="width:250px;">
					<option value="0">Select Gender</option>
					
				</select>
				<script>
				    get_genders('gender');
				</script>
				</td>
				<td><label for="date_of_birth">Date of Birth</label>
				<br />
				<input id="date_of_birth" class="datefield" name="date_of_birth" type="text" tabindex="3"  style="width:250px;" maxlength="10"/>
				</td>
				<td><label for="nationality">Nationality</label>
				<br />
				<select id="nationality" name="nationality" type="text" tabindex="3" onchange="javascript:void(0)" style="width:250px;">
					<option value="0">Select Nationality</option>
				</select></td>
				<script>
					get_nationalities('nationality');
				</script>
			</tr>
			<tr>
				<td><label for="fathers_name">Father's Name</label>
				<br />
				<input id="fathers_name" name="fathers_name" type="text" tabindex="3"  style="width:250px;" maxlength="70"/>
				</td>
				<td><label for="mothers_name">Mother's Name</label>
				<br />
				<input id="mothers_name" name="mothers_name" type="text" tabindex="3"  style="width:250px;" maxlength="70"/>
				</td>
				<td><label for="blood_group">Blood Group</label>
				<br />
				<select id="blood_group" name="blood_group" type="text" onchange="javascript:void(0)" tabindex="3"  style="width:250px;">
					<option value="0">Select Blood Group</option>
				</select></td>
				<script>
					get_blood_groups('blood_group');
				</script>
				</td>
			</tr>
		</table >
	</div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link next_tab" current_tab="tab2" next_tab="tab3">&nbsp; Next &nbsp;</a>
		</p>
	</div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link prev_tab" current_tab="tab2" next_tab="tab1">&nbsp; Back &nbsp;</a>
		</p>
	</div>
	<div style="clear: both;"></div>
	<div class="tab_error_msg">
		&nbsp;&nbsp;Please correct the highlighted fields to proceed&nbsp;&nbsp;
	</div>
	<div style="clear: both;"></div>
	<script>

		on_tab_load('tab2');

	</script>
	<?php
	$sess_data = array();
     $person_application_id = $this -> session -> userdata('person_application_id');
     
        if(print_r($this->session->userdata('tab2'),true)){
            $sess_data = unserialize($this->session->userdata('tab2'));
            ChromePhp::warn('choosing the if 2');
        }   
        else{
            ChromePhp::warn('choosing the else db 2');
            $req = 'SELECT session_var FROM temp_cr_session_vars WHERE person_application_id = '.$person_application_id.' AND tab_name = "tab2"';
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

	$.each(arrayFromPHP, function(i, elem) {
		//console.log('key = ' + i + ' value = ' + elem);
		$('#' + i).each(function(){
		    console.log('key = ' + i + ' value = ' + elem+' tag type is '+$(this).prop('tagName'));
           if('SELECT' == $(this).prop('tagName')){
               console.log(i+' is a select type');
               form_memory_array[i] = elem;
           }
           else{
               $('#' + i).val(elem);
           } 
        });
	});
	}
    
    for (var key in form_memory_array){
        console.log(' key is '+form_memory_array[key]);
    }
    
	</script>

	<?php
    }
	?>

</div>
