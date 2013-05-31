<?php $this -> session -> set_userdata('tab_status', 'form_tab3'); ?>
<div id="tab3">
	<div style="margin:0px 10px;">
		<br/>
		<div class="form_sub_title">
			<strong>Residential Address</strong>
			<hr/>
		</div>
		<table style="width:100%;">

			<tr>
				<td><label for="res_address_line1">Address Line 1</label>
				<br />
				<input id="res_address_line1" name="res_address_line1" type="text" tabindex="7" style="width:190px;"  maxlength="80"/>
				</td>
				<td><label for="res_address_line2">Address Line 2</label>
				<br />
				<input id="res_address_line2" name="res_address_line2" type="text" tabindex="7" style="width:190px;" maxlength="80"/>
				</td>
				<td><label for="res_state">State</label>
				<br />
				<select id="res_state" name="res_state" type="text" tabindex="7" style="width:190px;" onchange="get_cities(this.value, 'res_city','res_city','190')">

					<option value=0>Select State</option>

				</select>
				<script>
					load_states('res_state');
				</script></td>
				<td><label for="res_city">City</label>
				<br />
				<select id="res_city" name="res_city" onchange="javascript:void(0)" type="text" tabindex="7" style="width:190px;">
					<option value="0">Select City</option>
				</select></td>
			</tr>
			<tr>
				<td><label for="res_pin_code">Pin Code</label>
				<br />
				<input id="res_pin_code" name="res_pin_code" type="text" tabindex="7" style="width:190px;" maxlength="10"/>
				</td>
				<td><label for="res_phone1">Phone 1</label>
				<br />
				<input id="res_phone1" name="res_phone1" type="text" tabindex="7" style="width:190px;" maxlength="15"/>
				</td>
				<td><label for="res_phone2">Phone 2</label>
				<br />
				<input id="res_phone2" name="res_phone2" type="text" tabindex="7" style="width:190px;" maxlength="15"/>
				</td>
				<td><label for="res_email">Email</label>
				<br />
				<input id="res_email" name="res_email" type="text" tabindex="7" style="width:190px;" maxlength="70"/>
				</td>
			</tr>
		</table>

		<div style="clear: both;">
			&nbsp;
		</div>
		<div class="form_sub_title">
			<strong>Permanent Address</strong>
			<div style="margin-right:20px;float:right;height:5px;vertical-align:-14px;">
				<input type="checkbox" id="same_permanent_address" name="same_permanent_address">
				<strong> Same as Residential Address </strong></input>
			</div>
			<hr/>
		</div>
		<div id="permanent_is_residential">
			Same as Residential Address
		</div>
		<div id="permant_addr_table">
			<table style="width:100%;">

				<tr>
					<td><label for="permanent_address_line1">Address Line 1</label>
					<br />
					<input id="permanent_address_line1" name="permanent_address_line1" type="text" tabindex="7" style="width:190px;" maxlength="80"/>
					</td>
					<td><label for="permanent_address_line2">Address Line 2</label>
					<br />
					<input id="permanent_address_line2" name="permanent_address_line2" type="text" tabindex="7" style="width:190px;" maxlength="80"/>
					</td>
					<td><label for="permanent_state">State</label>
					<br />
					<select id="permanent_state" name="permanent_state" type="text" tabindex="7" style="width:190px;" onchange="get_cities(this.value, 'permanent_city','permanent_city','190')">
						<option value="0">Select State</option>

					</select>
					<script>
						load_states('permanent_state');
					</script></td>

					<td><label for="permanent_city">City</label>
					<br />
					<select id="permanent_city" name="permanent_city" onchange="javascript:void(0)" type="text" tabindex="7" style="width:190px;">
						<option value="0">Select City</option>
					</select></td>
				</tr>
				<tr>
					<td><label for="permanent_pin_code">Pin Code</label>
					<br />
					<input id="permanent_pin_code" name="permanent_pin_code" type="text" tabindex="7" style="width:190px;" maxlength="10"/>
					</td>
					<td><label for="permanent_phone1">Phone 1</label>
					<br />
					<input id="permanent_phone1" name="permanent_phone1" type="text" tabindex="7" style="width:190px;" maxlength="12"/>
					</td>
					<td><label for="permanent_phone2">Phone 2</label>
					<br />
					<input id="permanent_phone2" name="permanent_phone2" type="text" tabindex="7" style="width:190px;" maxlength="12"/>
					</td>
					<td><label for="permanent_email">Email</label>
					<br />
					<input id="permanent_email" name="permanent_email" type="text" tabindex="7" style="width:190px;" maxlength="80"/>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<?php
if($this->session->userdata('person_category') == 1)
{
			?>
			<a class="more-link next_tab" current_tab="tab3" next_tab="tab4">&nbsp; Next &nbsp;</a>
			<?php } else { ?>
			<a class="more-link next_tab" current_tab="tab3" next_tab="tab4_2">&nbsp; Next &nbsp;</a>

			<?php } ?>
		</p>
	</div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link prev_tab" current_tab="tab3" next_tab="tab2">&nbsp; Back &nbsp;</a>
		</p>
	</div>
	<div style="clear: both;"></div>
	<div class="tab_error_msg">
		&nbsp;&nbsp;Please correct the highlighted fields to proceed&nbsp;&nbsp;
	</div>
	<div style="clear: both;"></div>
	<script>
		on_tab_load('tab3');
	</script>
	<?php
$sess_data = array();
$person_application_id = $this -> session -> userdata('person_application_id');

if(print_r($this->session->userdata('tab3'),true)){
$sess_data = unserialize($this->session->userdata('tab3'));
ChromePhp::warn('choosing the if 3');
}
else{
ChromePhp::warn('choosing the else db 3');
$req = 'SELECT session_var FROM temp_cr_session_vars WHERE person_application_id = '.$person_application_id.' AND tab_name = "tab3"';
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

			$('#' + i).each(function() {
				if ('SELECT' == $(this).prop('tagName')) {
					console.log(i + ' is a select type');
					form_memory_array[i] = elem;
				} else {
					$('#' + i).val(elem);
				}
			});
		});

		var checkbox_val = 0;
		$.each(arrayFromPHP, function(i, elem) {

			if (i == 'same_permanent_address') {
				checkbox_val = 1;
			}
		});

		if (checkbox_val == 1) {

			$('#permant_addr_table').css("display", "none");
			$('#same_permanent_address').attr('checked', 'checked');
			$('#permanent_is_residential').show(50);

		} else {
			$('#permant_addr_table').css("display", "inline");
			//$('#same_permanent_address').attr('checked','checked');
			$('#permanent_is_residential').hide(50);
		}

		}

	</script>

	<?php
    }
	?>
</div>