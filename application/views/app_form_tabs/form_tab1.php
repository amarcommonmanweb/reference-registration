<?php

 $this->session->set_userdata('tab_status','form_tab1');

?>
<div id="tab1">
	<center>
		<br/>
		<div id="news_ticker">
			<strong>Information on selected schools</strong>
			<hr/>
			<div id="news_ticker_scroll">
				<table id="news_ticker_table">

				</table>
			</div>
		</div>
		<div id="tab1_container">
			<div id="tab1_form_main">
				<p>
					<label for="select_city">Select City</label>

					<!-- the city id and name must match the db/ or you can change it later to be automated from db itself -->
					<div id="presence_cities">
						<select id="select_city" name="select_city" tabindex="1" onchange="get_schools(this.value,'select_school')" style="width:250px;">
							<option value="0">Select City</option>

						</select>
					</div>
					<script>
						load_school_cities('select_city');
					</script>
				</p>
				<p>

					<label for="select_school">Select School</label>
					<select id="select_school" name="select_school" tabindex="2" style="width:250px;" onchange="populate_select_school('selec_school_list','0_0')">   
						<option value="0">Select School</option>
					</select>
				</p>

				<p>
					<label for="catagory">Apply As</label>

					<div id="catagory_fill">
						<select id="person_catagory" name="person_catagory" tabindex="2" style="width:250px;" onchange="adjust_catagory(this.value)">
							<option value="">Select Catagory</option>

						</select>
					</div>
					<script>
						load_person_categories('person_catagory');						
					</script>
				</p>
				<br/>
			</div>
			<div id="selected_schools_list">
				<strong>Schools you selected</strong>
				<hr style="color:#ddddd;"/>
				<div id="selected_schools_list_scroll">
					<table id="selec_school_list" width="100%">

					</table>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</center>
	<div style="clear: both;"></div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
		    <!-- have defined these custom tabs in the DOCTYPE html in the header .. hence able to use it here -->
			<a class="more-link next_tab" current_tab="tab1" next_tab="tab2" >&nbsp; Next &nbsp;</a>
		</p>
	</div>
	<div style="clear: both;"></div>
     <div class="tab_error_msg">
        &nbsp;&nbsp;Please correct the highlighted fields to proceed&nbsp;&nbsp;
    </div>
	<div style="clear: both;"></div>
	<script>

        on_tab_load('tab1');
    </script>
    
    <?php
   $sess_data = array();
     $person_application_id = $this -> session -> userdata('person_application_id');
     
        if(print_r($this->session->userdata('tab1'),true)){
            $sess_data = unserialize($this->session->userdata('tab1'));
            ChromePhp::warn('choosing the if 1');
        }   
        else{
            ChromePhp::warn('choosing the else db 1');
            $req = 'SELECT session_var FROM temp_cr_session_vars WHERE person_application_id = '.$person_application_id.' AND tab_name = "tab1"';
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
    
    populate_tab_vals();

function populate_tab_vals(){
        var arrayFromPHP = <?php echo json_encode($sess_data); ?>;
        $.each(arrayFromPHP, function(i, elem) {
            if(i.indexOf('school_') == 0){
                 //this is a value to be populated in the box 
                 console.log('the raw school dta is '+elem)
                school_data = elem.split('_')[1]+'_'+elem.split('_')[2];
               populate_select_school('selec_school_list',school_data)
            }
          
          console.log(' the value of i is '+i);
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
        console.log(' key is tab 1 '+form_memory_array[key]);
    }    
    </script>
    
    
    <?php
    }
    ?>
</div>
