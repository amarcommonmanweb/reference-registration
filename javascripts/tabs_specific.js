//file containig general functions .. which may apply to more than one tab

var cache_state_vals = '';
var current_blur_tab = 'tab1';
var document_types_object = '';
var form_memory_array = new Array();
/* Tip :
*
*  /^$|\s+/ matches empty and whitespace
*  and (?! pattern ) is used to negate the regex
*
*  like /(.{0,4})  <remove the unneeded parantheses .. then it becomes /.{0,4}
*  can be negated by using  (?!/.{0,4}$).*   or even better  ^(?!/.{0,4}$).*$
*
*  Therefore, this can be used for the drop downs, if their first value is made as ''
*/

// am using (?!/^$|\s+/).* for all the date pickers and drop downs
var not_empty_pattern = '(?!\s*$).+';
// The working one
var names_pattern = '[a-zA-Z\s]{1,50}';
var address_line_names = '[a-zA-Z0-9\.\#\,\s\_\-]{1,80}';
var phone = '[0-9]{10,12}';
var pincode = '[0-9]{6,6}';
var percentage = '[0-9]{1,3}';
var textarea_text = '[a-zA-Z0-9\.\#\,\s\_\-]{1,150}';
var email = '[a-zA-Z0-9\.\+\_\-]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}';
var drop_downs = '[1-9][0-9]*';

var validation_array = new Array();

validation_array['tab1'] = new Array();
validation_array['tab1']['person_catagory'] = drop_downs;
validation_array['tab1']['selec_school_list'] = 'valfunc_selec_school_list()';

validation_array['tab2'] = new Array();
validation_array['tab2']['firstname'] = names_pattern;
validation_array['tab2']['middlename'] = names_pattern;
validation_array['tab2']['lastname'] = names_pattern;
validation_array['tab2']['gender'] = names_pattern;
validation_array['tab2']['date_of_birth'] = not_empty_pattern;
validation_array['tab2']['nationality'] = drop_downs;
validation_array['tab2']['fathers_name'] = names_pattern;
validation_array['tab2']['mothers_name'] = names_pattern;
validation_array['tab2']['blood_group'] = drop_downs;

validation_array['tab3'] = new Array();
validation_array['tab3']['res_address_line1'] = address_line_names;
validation_array['tab3']['res_address_line2'] = address_line_names;
validation_array['tab3']['res_state'] = '';
validation_array['tab3']['res_city'] = drop_downs;
validation_array['tab3']['res_pin_code'] = pincode;
validation_array['tab3']['res_phone1'] = phone;
validation_array['tab3']['res_phone2'] = phone;
validation_array['tab3']['res_email'] = email;
validation_array['tab3']['permanent_address_line1'] = address_line_names;
validation_array['tab3']['permanent_address_line2'] = address_line_names;
validation_array['tab3']['permanent_state'] = '';
validation_array['tab3']['permanent_city'] = drop_downs;
validation_array['tab3']['permanent_pin_code'] = pincode;
validation_array['tab3']['permanent_phone1'] = phone;
validation_array['tab3']['permanent_phone2'] = phone;
validation_array['tab3']['permanent_email'] = email;

validation_array['tab4'] = new Array();
validation_array['tab4']['pre_edu_school_name'] = address_line_names;
validation_array['tab4']['pre_edu_state'] = '';
validation_array['tab4']['pre_edu_city'] = drop_downs;
validation_array['tab4']['pre_edu_from'] = not_empty_pattern;
validation_array['tab4']['pre_edu_to'] = not_empty_pattern;
validation_array['tab4']['sibl_name'] = names_pattern;
validation_array['tab4']['sibl_gender'] = names_pattern;
validation_array['tab4']['sibl_dob'] = not_empty_pattern;
validation_array['tab4']['sibl_school'] = address_line_names;
validation_array['tab4']['sibl_class'] = address_line_names;
validation_array['tab4']['day_or_hostel'] = '';
validation_array['tab4']['mother_tongue'] = names_pattern;
validation_array['tab4']['birth_place'] = address_line_names;
validation_array['tab4']['identification_marks'] = textarea_text;
validation_array['tab4']['hobbies'] = textarea_text;
validation_array['tab4']['allergies'] = textarea_text;

validation_array['tab4_2'] = new Array();
validation_array['tab4_2']['experience_desc'] = textarea_text;
validation_array['tab4_2']['expr_state'] = '';
validation_array['tab4_2']['expr_city'] = drop_downs;
validation_array['tab4_2']['expr_from'] = not_empty_pattern;
validation_array['tab4_2']['expr_to'] = not_empty_pattern;
validation_array['tab4_2']['course'] = address_line_names;
validation_array['tab4_2']['course_inst'] = address_line_names;
validation_array['tab4_2']['course_from'] = not_empty_pattern;
validation_array['tab4_2']['course_to'] = not_empty_pattern;
validation_array['tab4_2']['final_percent'] = percentage;
validation_array['tab4_2']['reference_name'] = names_pattern;
validation_array['tab4_2']['reference_desc'] = textarea_text;
validation_array['tab4_2']['reference_phone'] = phone;
validation_array['tab4_2']['reference_email'] = email;
validation_array['tab4_2']['mother_tongue_2'] = names_pattern;
validation_array['tab4_2']['birth_place_2'] = address_line_names;
validation_array['tab4_2']['maritial_status_2'] = names_pattern;
validation_array['tab4_2']['identification_marks_2'] = textarea_text;
validation_array['tab4_2']['hobbies_2'] = textarea_text;
validation_array['tab4_2']['allergies_2'] = textarea_text;

// The error messages for each field
var validation_error = new Array();

validation_error['tab1'] = new Array();
validation_error['tab1']['person_catagory'] = 'error here ';
validation_error['tab1']['selec_school_list'] = 'error here ';

validation_error['tab2'] = new Array();
validation_error['tab2']['firstname'] = 'error here ';
validation_error['tab2']['middlename'] = 'error here ';
validation_error['tab2']['lastname'] = 'error here ';
validation_error['tab2']['gender'] = 'error here ';
validation_error['tab2']['date_of_birth'] = 'error here ';
validation_error['tab2']['nationality'] = 'error here ';
validation_error['tab2']['fathers_name'] = 'error here ';
validation_error['tab2']['mothers_name'] = 'error here ';
validation_error['tab2']['blood_group'] = 'error here ';

validation_error['tab3'] = new Array();
validation_error['tab3']['res_address_line1'] = 'error here ';
validation_error['tab3']['res_address_line2'] = 'error here ';
validation_error['tab3']['res_state'] = '';
validation_error['tab3']['res_city'] = 'error here ';
validation_error['tab3']['res_pin_code'] = 'error here ';
validation_error['tab3']['res_phone1'] = 'error here ';
validation_error['tab3']['res_phone2'] = 'error here ';
validation_error['tab3']['res_email'] = 'error here ';
validation_error['tab3']['permanent_address_line1'] = 'error here ';
validation_error['tab3']['permanent_address_line2'] = 'error here ';
validation_error['tab3']['permanent_state'] = '';
validation_error['tab3']['permanent_city'] = 'error here ';
validation_error['tab3']['permanent_pin_code'] = 'error here ';
validation_error['tab3']['permanent_phone1'] = 'error here ';
validation_error['tab3']['permanent_phone2'] = 'error here ';
validation_error['tab3']['permanent_email'] = 'error here ';

validation_error['tab4'] = new Array();
validation_error['tab4']['pre_edu_school_name'] = 'error here ';
validation_error['tab4']['pre_edu_state'] = '';
validation_error['tab4']['pre_edu_city'] = 'error here ';
validation_error['tab4']['pre_edu_from'] = 'error here ';
validation_error['tab4']['pre_edu_to'] = 'error here ';
validation_error['tab4']['sibl_name'] = 'error here ';
validation_error['tab4']['sibl_gender'] = 'error here ';
validation_error['tab4']['sibl_dob'] = 'error here ';
validation_error['tab4']['sibl_school'] = 'error here ';
validation_error['tab4']['sibl_class'] = 'error here ';
validation_error['tab4']['day_or_hostel'] = '';
validation_error['tab4']['mother_tongue'] = 'error here ';
validation_error['tab4']['birth_place'] = 'error here ';
validation_error['tab4']['identification_marks'] = 'error here ';
validation_error['tab4']['hobbies'] = 'error here ';
validation_error['tab4']['allergies'] = 'error here ';

validation_error['tab4_2'] = new Array();
validation_error['tab4_2']['experience_desc'] = 'error here ';
validation_error['tab4_2']['expr_state'] = '';
validation_error['tab4_2']['expr_city'] = 'error here ';
validation_error['tab4_2']['expr_from'] = 'error here ';
validation_error['tab4_2']['expr_to'] = 'error here ';
validation_error['tab4_2']['course'] = 'error here ';
validation_error['tab4_2']['course_inst'] = 'error here ';
validation_error['tab4_2']['course_from'] = 'error here ';
validation_error['tab4_2']['course_to'] = 'error here ';
validation_error['tab4_2']['final_percent'] = 'error here ';
validation_error['tab4_2']['reference_name'] = 'error here ';
validation_error['tab4_2']['reference_desc'] = 'error here ';
validation_error['tab4_2']['reference_phone'] = 'error here ';
validation_error['tab4_2']['reference_email'] = 'error here ';
validation_error['tab4_2']['mother_tongue_2'] = 'error here ';
validation_error['tab4_2']['birth_place_2'] = 'error here ';
validation_error['tab4_2']['maritial_status_2'] = 'error here ';
validation_error['tab4_2']['identification_marks_2'] = 'error here ';
validation_error['tab4_2']['hobbies_2'] = 'error here ';
validation_error['tab4_2']['allergies_2'] = 'error here ';

$(document).ready(function() {

	$('.tab_error_msg').hide();
	$('#permanent_is_residential').hide();
	
	$('#same_permanent_address').live("change",function(){
		if($(this).prop('checked')){
			
				$('#permant_addr_table').css("display", "none");
				$('#permanent_is_residential').show(50);
			
		}
		else{
			
				$('#permanent_is_residential').hide(50);
				$('#permant_addr_table').css("display", "inline");	
				}			
			
	});

	$('.datefield').live('click', function() {

		$(this).datepicker('destroy').datepicker({
			changeMonth : true,
			changeYear : true,
			yearRange : "-30:+0",
			dateFormat : 'dd/mm/yy'
		}).focus();
	});

	$('.file_document_type').live('change',function(){
			
			serializedData = 'file_id = '+$(this).attr('id').replace('file_id_','');
			serializedData += '&category_val = '+$(this).val();
			
			$.ajax({
				url : "http://localhost/CodeIgniter_Registration/index.php/application_form/set_file_category",
				type : "post",
				data : serializedData,
				success : function(response, textStatus, jqXHR) {
					console.log('response is ' + response);
				}
			});
	});

	$('.prev_tab').live("click", function(){
		var next_tab = $(this).attr('next_tab');
		load_tab(next_tab);
		
	});

	$('.next_tab').live("click", function() {

		/*
		 * Things to do
		 *
		 * 1. run validation on all elements.
		 * 2. Calclulate the errors in this by the error counter
		 * 3. Highlight and assign title tag for the error elements and display the error bar, increment error counter for each run
		 * 4. If error counter = 0,
		 * 		4.1. serialise the values of the tab and post them to controlleer metod, to store it as a string in session
		 *  	4.2. strore the values i nthe temp tables in db
		 * 		4.3. If all ok .. navigate to the next tab
		 * 5. If error counter is not zero, stay in the step 3.
		 *
		 */

		var current_tab = $(this).attr('current_tab');
		var next_tab = $(this).attr('next_tab');
		

		//Step 1, 2, 3
		form_error_counter = 0;
		$('#' + current_tab + ' :input').each(function() {

			for (var key in validation_array[current_tab]) {
				//alert('key is '+key+' and id is '+$(this).attr('id'));
				if (($(this).attr('id')) && ($(this).attr('id').indexOf(key) == 0)) {
					//now we have locked on to the id we need to operate on .. also have the key for he regex... hence
					r = new RegExp(validation_array[current_tab][key]);

					if (r.test($(this).val()) == true) {
						// has passed the validation
						$(this).removeClass('field_error');
						$(this).attr('title', '');
					} else {
						form_error_counter++;
						$(this).addClass('field_error');
						$(this).attr('title', validation_error[current_tab][key]);
						//has failed the validation
					}
				}
			}

		});

		//alert('number of errors are '+form_error_counter);

		if (form_error_counter == 0) {
			$('.tab_error_msg').fadeOut(200);

			//Step 4.1
			serializedData = $('#' + current_tab + ' :input').serialize();

			//add the school ids of the school list table also
			$('#selec_school_list tr').each(function() {
				serializedData += '&' + $(this).attr('id') + '=' + $(this).attr('id')+'_'+$(this).find("td:first").text();
			});


			$.ajax({
				url : "http://localhost/CodeIgniter_Registration/index.php/application_form/store_tab_in_session/" + current_tab,
				type : "post",
				data : serializedData,
				success : function(response, textStatus, jqXHR) {
					console.log('responseee is ' + response);
					
					//Store the tab details into the database
			$.ajax({
				url : "http://localhost/CodeIgniter_Registration/index.php/application_form/store_tab_in_temp_db/" + current_tab,
				type : "post",
				data : serializedData,
				success : function(response, textStatus, jqXHR) {
					console.log('the response here is ' + response);
					if (response == 'true') {
						load_tab(next_tab);
					} else {
						alert('Error in proceeding with request, PLease contact Admin');
					}
				}
			});
					
				}
			});

			
		} else {
			$('.tab_error_msg').fadeIn(200);
		}

		//alert('next tab is pressed next is'+$(this).attr('next_tab')+' and the current is '+$(this).attr('current_tab'));

	});
	// the next tab button click closing
});



function select_memoryfill(select_id){
	
	for (var key in form_memory_array){
		if(key == select_id){
			
			$('#'+select_id).val(form_memory_array[key]);	
			if(document.getElementById(select_id).onchange()){};		
		}  
	}	
}

function on_tab_load(tab_name) {
	// any initial things that have to be done when a tab is loaded in generally... if have to lock to a particular tab, use if condition
	$('.tab_error_msg').hide();
	
	
	change_tab_header_position(tab_name);
	
	if (tab_name == 'tab5') {
		get_documents_types('selec_files_list');

		//included this in the success callback in the above function
		//populate_select_files('selec_files_list');
	}
}

function load_states(select_id) {

	if (cache_state_vals == '') {

		serializedData = '';

		$.ajax({
			url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_states",
			type : "post",
			dataType : 'json',
			data : serializedData,
			// callback handler that will be called on success
			success : function(response, textStatus, jqXHR) {

				$('#' + select_id).empty();
				//clear anything that may exist
				var mySelect = $('#' + select_id);
				$.each(response, function(key, val) {
					$('<option/>', {
						value : key
					}).text(val).appendTo(mySelect);
				});
				select_memoryfill(select_id);
			},
			// callback handler that will be called on error
			error : function(jqXHR, textStatus, errorThrown) {
				// log the error to the console
				console.log("The following error occured: " + textStatus, errorThrown);
			},
			// callback handler that will be called on completion
			// which means, either on success or error
			complete : function() {

			}
		});
	} else {
		//values are cached .. hence just do this ..
		
		$('#' + select_id).empty();
		//clear anything that may exist

		var mySelect = $('#' + select_id)
		$.each(cache_state_vals, function(key, val) {
			$('<option/>', {
				value : key
			}).text(val).appendTo(mySelect);
		});
		select_memoryfill(select_id);
	}
}

function get_cities(state_name, select_id) {
	serializedData = 'state_name=' + state_name;

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_cities",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id);
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
			select_memoryfill(select_id);
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function del_table_row(del_id) {

	$(del_id).remove();

	// for the news ticker box
	var row_id_string = $(del_id).attr('id');
	$('tr[id^=' + row_id_string + '_ticker]').remove();
}

function load_tab(next_tab) {
	//load the tab given as next tab

	next_tab = 'form_' + next_tab;
	//correction, because only tab name is used till now

	serializedData = 'tab_name=' + next_tab;

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/new_form",
		type : "post",
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {
			// load the core form
			$('#load_next_tab').html(response);

			//change_tab_header_position(next_tab);

		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {

		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function change_tab_header_position(next_tab){
// change the current header tab position
			//var parts = next_tab.split('_');
			
			if(next_tab == 'tab4_2'){
				next_tab = 'tab4';
			}
			console.log('=========Header posisiotn is ============'+next_tab);
			var current_tab_pos = next_tab + '_step';
			$('#tab_steps tr td').each(function() {
				$(this).removeClass('current');
			});

			$('#' + current_tab_pos).addClass('current');
		}	


var num_of_siblings = 1;

function add_sibling_row(tableID) {
	num_of_siblings++;
	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	var row = table.insertRow(rowCount);
	var row_id = 'sibl_row_id' + num_of_siblings;
	row.id = row_id;
	//adding this row id only so that it can be deleted ... used below .. at X

	if ((num_of_siblings % 2) == 0) {
		row.style.background = '#F9F9F9';
	}

	var cell1 = row.insertCell(0);
	cell1.innerHTML = '<input id="sibl_name' + num_of_siblings + '" name="sibl_name[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>';

	var cell2 = row.insertCell(1);
	var sib_gend_str = '<select id="sibl_gender' + num_of_siblings + '" name="sibl_gender[]" onchange="javascript:void(0)" type="text" tabindex="7"  style="width:90px;">';
	sib_gend_str += '<option value="0">Select Gender</option>';
	sib_gend_str += '</select>';
	
	cell2.innerHTML = sib_gend_str;

	var cell3 = row.insertCell(2);
	cell3.innerHTML = '<input class="datefield" id="sibl_dob' + num_of_siblings + '" name="sibl_dob[]" type="text" tabindex="7" style="width:120px;"/>';

	var cell4 = row.insertCell(3);
	cell4.innerHTML = '<input id="sibl_school' + num_of_siblings + '" name="sibl_school[]" type="text" tabindex="7" style="width:220px;" maxlength="80"/>';

	var cell5 = row.insertCell(4);
	cell5.innerHTML = '<input id="sibl_class' + num_of_siblings + '" name="sibl_class[]" type="text" tabindex="7" style="width:90px;" maxlength="30"/>';

	var cell6 = row.insertCell(5);

	cell6.innerHTML = '<a href="javascript:del_table_row(' + row_id + ')"> <span style="color:#ff0000"><strong> X </strong></span></a>';
	get_genders('sibl_gender'+num_of_siblings);
}

var num_of_exp = 1;
function add_prev_exp_row(tableID) {
	num_of_exp++;
	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	var row = table.insertRow(rowCount);
	var row_id = 'exp_row_id' + num_of_exp;
	row.id = row_id;
	//adding this row id only so that it can be deleted ... used below .. at X

	if ((num_of_exp % 2) == 0) {
		row.style.background = '#F9F9F9';
	}

	var cell1 = row.insertCell(0);
	cell1.innerHTML = '<input id="expr_desc' + num_of_exp + '" name="expr_desc[]" type="text" tabindex="7" style="width:230px;" maxlength="80"/>';

	var cell2 = row.insertCell(1);
	var expr_state = '<select id="expr_state' + num_of_exp + '" name="expr_state[]" type="text" tabindex="7" style="width:180px;" onchange="get_cities(this.value,\'expr_city' + num_of_exp + '\')">';
	expr_state += '<option value=0>Select State</option>';
	expr_state += '</select>';
	cell2.innerHTML = expr_state;

	var cell3 = row.insertCell(2);
	var expr_city = '<select id="expr_city' + num_of_exp + '" name="expr_city[]" onchange="javascript:void(0)" type="text" tabindex="7" style="width:180px;">';
	expr_city += '<option value="0">Select City</option>';
	expr_city += '</select>';
	cell3.innerHTML = expr_city;

	var cell4 = row.insertCell(3);
	cell4.innerHTML = '<input class="datefield" id="expr_from' + num_of_exp + '" name="expr_from[]" type="text" tabindex="7" style="width:110px;"/>';

	var cell5 = row.insertCell(4);
	cell5.innerHTML = '<input class="datefield" id="expr_to' + num_of_exp + '" name="expr_to[]" type="text" tabindex="7" style="width:110px;"/>';

	var cell6 = row.insertCell(5);
	cell6.innerHTML = '<a href="javascript:del_table_row(' + row_id + ')"> <span style="color:#ff0000"><strong> X </strong></span></a>';

	//because this row contains a state field .. so populate it
	load_states('expr_state' + num_of_exp);

}

var num_of_qual = 1;
function add_qualifications_info_row(tableID) {
	num_of_qual++;
	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	var row = table.insertRow(rowCount);
	var row_id = 'qualf_row_id' + num_of_qual;
	row.id = row_id;
	//adding this row id only so that it can be deleted ... used below .. at X

	if ((num_of_qual % 2) == 0) {
		row.style.background = '#F9F9F9';
	}

	var cell1 = row.insertCell(0);
	cell1.innerHTML = '<input id="course' + num_of_qual + '" name="course[]" type="text" tabindex="7" style="width:210px;" maxlength="80"/>';

	var cell2 = row.insertCell(1);
	cell2.innerHTML = '<input id="course_inst' + num_of_qual + '" name="course_inst[]" type="text" tabindex="7" style="width:230px;" maxlength="80"/>';

	var cell3 = row.insertCell(2);
	cell3.innerHTML = '<input class="datefield" id="course_from' + num_of_qual + '" name="course_from[]" type="text" tabindex="7" style="width:110px;"/>';

	var cell4 = row.insertCell(3);
	cell4.innerHTML = '<input class="datefield" id="course_to' + num_of_qual + '" name="course_to[]" type="text" tabindex="7" style="width:110px;"/>';

	var cell5 = row.insertCell(4);
	cell5.innerHTML = '<input id="course_final_percent' + num_of_qual + '" name="course_final_percent[]" type="text" tabindex="7" style="width:110px;"/>';

	var cell6 = row.insertCell(5);

	cell6.innerHTML = '<a href="javascript:del_table_row(' + row_id + ')"> <span style="color:#ff0000"><strong> X </strong></span></a>';

}

function load_school_cities(select_id) {
	serializedData = '';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_school_cities",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id)
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
			select_memoryfill(select_id);
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});

}

function get_schools(city_id, select_id) {
	serializedData = 'city_id=' + city_id;

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_schools",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id)
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
			select_memoryfill(select_id);
			// select_memoryfill(select_id);  may be not that appropriate .. this is on second
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function populate_select_school(tableID,school_data) {
	//Just include this as it is .. and check if the names and ids are ok ... it will work

	
	school_id = school_data.split('_')[0];
	school_fullname = school_data.split('_')[1];
	
	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	
	temp_school_id = school_id; // to be tested and used in the populate below
	//IF THE TAB POPULATE HAS CALLED THIS FUNCTION .. IT WILL NOT BE ZERO
	if(school_id == 0){
		var school_id = $('#select_school').val();	
	}
		
	var row_id = 'school_' + school_id;

	var no_repeat_flag = 0;
	$('#' + tableID + ' tr').each(function() {

		if ((rowCount != 0) && (row_id == $(this).attr('id'))) {
			no_repeat_flag = 1;
		}
	});

	if ((no_repeat_flag == 0)&&(school_id != 0)) {
		row.id = row_id;

		var cell1 = row.insertCell(0);
		
		if(temp_school_id == 0)
		{
			var school_name = $("#select_school option:selected").text();
			var school_city = $("#select_city option:selected").text();
			cell1.innerHTML = school_name + ', ' + school_city;
		}
		else
		{
			cell1.innerHTML = school_fullname;
		}
		var cell2 = row.insertCell(1);
		cell2.innerHTML = '<a id="del_sch" href="javascript:del_table_row(' + row_id + ')">&nbsp;&nbsp;X&nbsp;&nbsp;</a>';

		//also need to fill the new ticker when this is filled.. or delete when this is deleted
		//NEWS ticker begins here
		add_news_ticker_item(row_id + '_ticker');
		//sending a row id prefix as parameter
		//an addition to the del_row function is made due to this line to remove the ticker also.. when school is removed
	}
}

function load_person_categories(select_id) {
	serializedData = '';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_person_categories",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id)
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
			select_memoryfill(select_id);
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function add_news_ticker_item(row_id_prefix) {
	//the parameter fromat is 'school_'<school_id>'_ticker .. so we have the school_id as the second value [1]

	var parts = row_id_prefix.split("_");
	serializedData = 'school_id=' + parts[1];

	var tableID = 'news_ticker_table';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_ticker_news",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

			$.each(response, function(key, val) {// rows
				var row = '<tr id="' + row_id_prefix + key + '"><td>' + val + '</td></tr>';
				$('#' + tableID).append(row);
			});

		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function adjust_catagory(category_id) {
	serializedData = 'category_id=' + category_id;
	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/set_category",
		type : "post",
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

		}
	});

}
function get_martial_statuses(select_id){
	serializedData = '';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_martial_statuses",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {
			
			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id)
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
			select_memoryfill(select_id);
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}
function get_genders(select_id){
	serializedData = '';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_genders",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {
			
			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id)
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
			select_memoryfill(select_id);
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function get_nationalities(select_id) {
	serializedData = '';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_nationalities",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {
			
			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id)
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
			select_memoryfill(select_id);
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function get_blood_groups(select_id) {
	serializedData = '';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_blood_groups",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

			$('#' + select_id).empty();
			//clear anything that may exist
			var mySelect = $('#' + select_id)
			$.each(response, function(key, val) {
				$('<option/>', {
					value : key
				}).text(val).appendTo(mySelect);
			});
		select_memoryfill(select_id);
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function get_documents_types(tableID) {
	serializedData = '';

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_document_types",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {
			
			document_types_object = response;
			
			/*
			 * START OF THE FILES UPLOADED POPULATION
			 */

			/*
			 * flowchart on paper : documentation
			 */
			$.ajax({
				url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_files_details",
				type : "post",
				dataType : 'json',
				data : serializedData,
				// callback handler that will be called on success
				success : function(response, textStatus, jqXHR) {
					
					
						// do the row creation and addition repeatedly for each input
						var table = document.getElementById(tableID);
						$(table).empty();

						$.each(response, function(key, val) {
							
							var rowCount = table.rows.length;
							var row = table.insertRow(rowCount);
							var file_parts = key.split('_');
							var row_id = 'file_' + file_parts[0];
							// the file_id
							row.id = row_id;

							var cell1 = row.insertCell(0);
							cell1.innerHTML = '<div id="' + file_parts[0] + '" class="row_file_name">' + key.replace(file_parts[0]+'_','') + '</div>';

							// document_types_object contains all the types of documents required by the person of this category
							var cell2 = row.insertCell(1);
							var expr_city = '<select id="file_id_' + file_parts[0] + '" class="file_document_type" name="document_type[]" type="text" tabindex="7" style="width:120px;">';
							expr_city += '<option value="0">Select</option>';
							expr_city += '</select>';
							cell2.innerHTML = expr_city;

							// populate this select now
							var mySelect = $('#file_id_' + file_parts[0]);
							$(mySelect).empty();
							$.each(document_types_object, function(key, val) {
								$('<option/>', {
									value : key
								}).text(val).appendTo(mySelect);
							});
							
							// select the value also .. if it was specified in the database
								
								if (val != 0) {
									$(mySelect).val(val);
								}

								var cell3 = row.insertCell(2);
								//var file_name_22 = '<a id="del_sch" href="javascript:del_file_table_row(' + row_id + ",'"+key.replace(file_parts[0]+'_','').split('.')[0]+"','"+key.replace(file_parts[0]+'_','').split('.')[1]+"')\">&nbsp;&nbsp;X&nbsp;&nbsp;</a>';
								//console.log(' the href link is '+file_name_22)
								//cell3.innerHTML = '<a id="del_sch" href="javascript:del_file_table_row(' + row_id + ','"+key.replace(file_parts[0]+'_','').split('.')[0]+"','"+key.replace(file_parts[0]+'_','').split('.')[1]+"')\">&nbsp;&nbsp;X&nbsp;&nbsp;</a>';
								var val1=key.replace(file_parts[0]+"_","").split(".")[0];
								var val2=key.replace(file_parts[0]+"_","").split(".")[1];
								
								cell3.innerHTML = "<a id='del_sch' href=\"javascript:del_file_table_row(" + row_id + ",'" + val1 + "','" + val2 + "')\">&nbsp;&nbsp;X&nbsp;&nbsp;</a>";

						});
					
				}
			});

			/*
			 * END OF FILES UPLOADED POPULATION
			 */
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}

function insert_file_details_db(file_object){
	
	
	//serializedData = file_object;
	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/insert_file_details_db",
		type : "post",
		data : { serializedData : file_object },
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {
				get_documents_types('selec_files_list');				
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			console.log("The following error occured: " + textStatus, errorThrown);
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
	
}
function del_file_table_row(row_id, file_name, file_extn){
	var file_id = $(row_id).attr('id').split('_')[1];
	
	
		serializedData = 'file_id = '+file_id;
		
		//filename_parts = filename.split('.');
		
		file_name = file_name.replace(/-/gi,'_'); 
		
		
		/*
		 * For some reason (i m yet to find out), the file names in the actual folders are all having '-' replaced with '_'
		 * Hence the above line is a minor adjustment to compensate for that
		 */
		serializedData += '&file_name='+file_name+'&file_extn='+file_extn;
		
	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/delete_uploaded_files",
		type : "post",
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {
			
					get_documents_types('selec_files_list');							
		},
		// callback handler that will be called on error
		error : function(jqXHR, textStatus, errorThrown) {
			// log the error to the console
			
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete : function() {

		}
	});
}


/*
function populate_select_files(tableID) {
	/*
	 * flowchart on paper : documentation

	$.ajax({
		url : "http://localhost/CodeIgniter_Registration/index.php/application_form/get_files_details",
		type : "post",
		dataType : 'json',
		data : serializedData,
		// callback handler that will be called on success
		success : function(response, textStatus, jqXHR) {

			if (jQuery.isEmptyObject(response)) {
				alert('empry object in the json');
				var table = document.getElementById(tableID);
				$(table).empty();
				var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);

				var row_id = 'row_0';
				row.id = row_id;
				var cell1 = row.insertCell(0);
				cell1.innerHTML = 'NoUploaded Documents Yet';

			} else {
				// do the row creation and addition repeatedly for each input
				var table = document.getElementById(tableID);
				$(table).empty();

				$.each(response, function(key, val) {

					var rowCount = table.rows.length;
					var row = table.insertRow(rowCount);
					var file_parts = key.split('_');
					var row_id = 'file_' + file_parts[0];
					// the file_id
					row.id = row_id;

					var cell1 = row.insertCell(0);
					cell1.innerHTML = '<div id="' + file_parts[0] + '" class="row_file_name">' + file_parts[1] + '</div>';

					// document_types_object contains all the types of documents required by the person of this category
					var cell2 = row.insertCell(1);
					var expr_city = '<select id="file_id_' + file_parts[0] + '" class="file_document_type" name="document_type[]" type="text" tabindex="7" style="width:120px;">';
					expr_city += '<option value="0">Select</option>';
					expr_city += '</select>';
					cell2.innerHTML = expr_city;

					// populate this select now
					var mySelect = $('#file_id_' + file_parts[0])
					$.each(document_types_object, function(key, val) {
						$('<option/>', {
							value : key
						}).text(val).appendTo(mySelect);

						// select the value also .. if it was specified in the database
						if (val != 0) {
							$("#mydropdownlist").val(val);
						}

						var cell3 = row.insertCell(2);
						cell3.innerHTML = '<a id="del_sch" href="javascript:del_file_table_row(' + row_id + ')">&nbsp;&nbsp;X&nbsp;&nbsp;</a>';

					});

				});

			}
		}
	});

}

	 */
	

