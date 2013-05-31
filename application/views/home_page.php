<!--
Template of any page is

1. Initial jquery scripts
2. include header bar view
3. the core content of the page, starting and ending with a div of your choice.. and having css for it.
4. other jquery scripts
-->

<script>
	$(document).ready(function() {

		//initial setting s on load
        
        $('.inline_colorbox').colorbox({inline:true, width:"35%", transition:"fade"});
        //setting up the enter key press
		$(document).keypress(function(e) {
		    if($('#signinform').is(":visible")){
		        if ((e.keyCode || e.which) == 13) {
                // Enter key pressed
                $('#Sign_in').trigger('click');
            }
		    }
		    if($('#registerform').is(":visible")){
                if ((e.keyCode || e.which) == 13) {
                // Enter key pressed
                $('#register').trigger('click');
            }
            }
		    
			
		});

		$('#registerform').hide();
		$('.err_tip').hide();
		$("#signin_response").hide();
		$('#register_response').hide();

		$("#register_a").click(function() {
			$('#signinform').hide(500);
			$('#registerform').show(500);
			$('#signinform input').each(function(){
			    $(this).val('');
			    $("#signin_response").hide();
			});
		});

		$("#signin_a").click(function() {
			$('#registerform').hide(500);
			$('#signinform').show(500);
			$('#registerform input').each(function(){
			    $(this).removeClass('error');
			    $(this).val('');
			    $("#register_response").hide();
			    $('[id$="_err"]').hide();
			});
		});

		$('[id$="_err"]').hide();

		//end of initial settings

		// Start Validation
		var default_err_msgs = new Array();
		default_err_msgs['firstname'] = 'Please enter only Alphabets';
		default_err_msgs['lastname'] = 'Please enter only Alphabets';
		default_err_msgs['emailid'] = 'Please enter a valid Email id';
		default_err_msgs['phone'] = 'Please enter a valid 10 digit Phone Number';
		default_err_msgs['username'] = 'Username can be only of Alphabets, digits, \'_\' \'.\' and \'-\'';

		var validation_tag = new Array();
		validation_tag['login_username'] = '[0-9a-zA-Z\.\_]{3,20}';
		//allowing dot comma and space also and from 3 to 20 chars
		//validation_tag['login_password'] = '.*(?=^.{7,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])(?=^.*[^\s].*$).*';
		/**  for password : At least 7 chars        At least 1 uppercase char (A-Z)        At least 1 number (0-9)        At least one special char     */

		validation_tag['login_password'] = '';
		//any chars but 7 to 20 length

		validation_tag['firstname'] = '[a-zA-Z\s]{1,50}';
		validation_tag['lastname'] = '[a-zA-Z\s]{1,50}';
		validation_tag['emailid'] = '[a-zA-Z0-9\.\+\_\-]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}';
		validation_tag['phone'] = '[0-9]{10}';
		validation_tag['username'] = '[0-9a-zA-Z\.\_]{3,20}';
		//validation_tag['password'] = '.*(?=.{7,30})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).*';
		validation_tag['password'] = '';
		// no need to validate password characters
		validation_tag['repassword'] = '';

		$('#registerform :input').blur(function() {

			// use the regev in the validation_tag and validate
			r = new RegExp(validation_tag[$(this).attr('id')]);

			if (r.test($(this).val()) == true) {

				notify_success(this);

				if (($(this).attr('id') == 'password') && ($(this).val() == '')) {
					notify_error(this, 'Please enter a password');
				} else if (($('#repassword').val() != '') && (!($(this).val() === $('#repassword').val()))) {
					notify_error($('#repassword'), 'Please re enter the same password');
				}

				//checking for password and repassword match
				if ($(this).attr('id') == 'repassword') {
					if (!($(this).val() === $('#password').val())) {
						notify_error(this, 'Please re enter the same password');
					}
					if ($('#password').val() == '') {
						notify_error(this, 'Please enter a password above');
					}
				}

				if (($(this).attr('id') == 'username') || ($(this).attr('id') == 'emailid')) {
					is_user_existing(this);
					// notifying erros will be managed on the response of this ajax function
				}

			} else {

				notify_error(this, 0);
			}
		});

		function notify_error(elem, title) {

			$(elem).addClass('error');
			$(elem).removeClass('success');
			var this_id = $(elem).attr('id');
			var error_div = '#' + this_id + '_err';
			if (title == 0) {
				//supply the default error message from array
				$(error_div).html(default_err_msgs[this_id]);
			} else {
				$(error_div).html(title);
			}

			$(error_div).fadeIn(500);
		}

		function notify_success(elem) {

			$(elem).removeClass('error');
			$(elem).addClass('success');
			var this_id = $(elem).attr('id');
			var error_div = '#' + this_id + '_err';

			$(error_div).html('');

			$(error_div).fadeOut(500);
		}

		function is_user_existing(elem) {

			var ajax_data = $(elem).attr('id') + '=' + $(elem).attr('value');
			serializedData = ajax_data;

			
			$.ajax({
				url : "http://localhost/CodeIgniter_Registration/index.php/home/is_user_existing",
				type : "post",
				data : serializedData,
				// callback handler that will be called on success
				success : function(response, textStatus, jqXHR) {
					//log a message to the console
					if (response == 'true') {

					} else {
						notify_error(elem, response);
					}

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

		//End Validation

		$("#register").click(function() {
			var err_counter = 0;

			$('#registerform :text, #registerform :password').each(function() {
				$(this).blur();
			});

			$('#registerform .error').each(function() {
				
				err_counter++;
			});

			

			if (err_counter == 0) {
				var pass = $('#password').val();
				$('#password').val(MD5(pass));

				//call function to navigate to other form
				$("#register_response").fadeOut(300);
				serializedData = $('#registerform :input').serialize();
				

				//ajax post
				$.ajax({
					// could have used echo site_url('login/validate_login'); if this was php
					url : "http://localhost/CodeIgniter_Registration/index.php/home/store_registration",
					type : "post",
					data : serializedData,
					// callback handler that will be called on success
					success : function(response, textStatus, jqXHR) {

						if (response == 'true') {
							//send activation mail

							//navigate to your page
							show_registration_confirm();
						} else {
							//display error in the block
							$("#register_response").fadeIn(300);
							$("#register_response").html(response);
						}

						//console.log("Hooray, it worked!");
					},
					// callback handler that will be called on error
					error : function(jqXHR, textStatus, errorThrown) {
						// log the error to the console
						alert("a error has occured" + jqXHR + " and " + textStatus + " naddd" + errorThrown);
						$("#register_response").html("The following error occured: " + textStatus, errorThrown);
					},
					// callback handler that will be called on completion
					// which means, either on success or error
					complete : function() {

						// enable the inputs
						//$inputs.removeAttr("disabled");
					}
				});

				// prevent default posting of form
				event.preventDefault();
			}

		});
        
        $('#resend_password').live("click",function(){
            console.log('clicked resend password');
            /*
             * 1. generate a temp password and send to the email in the email box.
             * 2. Store the temp_password in the login details, if a user is the owner of the email .. he will recieve the password
             * 3. In the login .. if there is a temp passwords .. and the enteredd password is the temp .. while loggining in ..
             *          Replace the original with temp .. and delete temp ..
             *          else continue logging in and delete the temp... (the user remembers the password) 
             */
            $('resend_password_err').hide(50);
            r = new RegExp(validation_tag['emailid']);
            console.log('the r is '+r);
            if (r.test($('#resend_password_email').val()) == true) {
                
            console.log('in the true condition');
            serializedData = 'resend_password_email='+$('#resend_password_email').val();
            $.ajax({
                url : "http://localhost/CodeIgniter_Registration/index.php/home/resend_password",
                type : "post",
                data : serializedData,
                // callback handler that will be called on success
                success : function(response, textStatus, jqXHR) {
                    if(response = 'true'){
                        alert(' password sent to your email id');
                    }
                    else
                    {
                        $('#resend_password_err').html(response);
                        $('resend_password_err').show(100);
                    }
                },
                // callback handler that will be called on error
                error : function(jqXHR, textStatus, errorThrown) {

                }
            });

            }
            else{
                console.log('in the else condition');
               $('#resend_password_err').html('Please enter a valid Email Address'); 
               $('#resend_password_err').show(100);
            }
        });
        
		function show_registration_confirm() {
			alert('registration confirmed');

			$("#register_response").fadeIn(300);
			// have a gif instead of this thing
			$("#register_response").html('Loading..');

			//send an email as the beginning of confirmation
			$.ajax({
				url : "http://localhost/CodeIgniter_Registration/index.php/home/activation_email",
				type : "post",
				data : serializedData,
				// callback handler that will be called on success
				success : function(response, textStatus, jqXHR) {
					//log a message to the console
					if (response == 'true') {
						$("#register_response").fadeOut(300);
						// alert('email sent'+response);
						show_activation_pending();

						// window.location.href = "http://localhost/CodeIgniter_Registration/index.php/home/activation_pending/"+$('#emailid').val();
					} else {
						//display error in the block
						$("#register_response").fadeIn(300);
						$("#register_response").html(response);
					}

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

		function show_activation_pending() {

			var pending_message = 'We have sent you an email at ' + $('#emailid').val() + ' with the activation link.';
			pending_message += '<br/>Please click on the link in the email to activate your account. <a href="http://localhost/CodeIgniter_Registration/index.php/app_home/form">Home</a>';
			$('#content_login').html(pending_message);

		}


		$("#Sign_in").click(function() {

			$("#signin_response").fadeOut(300);

			var err_counter = 0;
			$('#signinform :input').each(function() {
				$(this).blur();
			});

			$('#signinform .error').each(function() {
				
				err_counter++;
			});

			if (($('#login_password').val() == '') || ($('#login_username').val() == '')) {
				err_counter++;
				$("#signin_response").fadeIn(300);
				$("#signin_response").html('Please enter Username and Password');
				if (($('#login_username').val() == '')) {
					$('#login_username').focus()
				} else if (($('#login_password').val() == '')) {
					$('#login_password').focus()
				}

			}

			if (err_counter == 0) {

				var pass = $('#login_password').val();
				$('#login_password').val(MD5(MD5(pass)));
				// 1. hash at register, 2. hash at model

				serializedData = $('#signinform :input').serialize();

				serializedData = serializedData + '&action=signin';

				//ajax post
				$.ajax({
					url : "http://localhost/CodeIgniter_Registration/index.php/home/validate_credentials",
					type : "post",
					data : serializedData,
					// callback handler that will be called on success
					success : function(response, textStatus, jqXHR) {
						//log a message to the console
						if (response == 'true') {

							window.location.href = "http://localhost/CodeIgniter_Registration/index.php/app_home/form";
						} else {
							//display error in the block
							$("#signin_response").fadeIn(300);
							$("#signin_response").html(response);
							$('#login_password').val('');
							$('#login_password').focus();

						}
					},
					// callback handler that will be called on error
					error : function(jqXHR, textStatus, errorThrown) {

					},
					// callback handler that will be called on completion

					complete : function() {

					}
				});

			}

		});

	});

</script>

<?php $this -> load -> view('includes/header_bar'); ?>

<div id="content_login">

	<div id="login_content">

		<div id="signinform" class="entry" style="margin-left:40px;">

			<div style="float:right;margin-right:30px;">

				Don't have an account?&nbsp; <a id ="register_a" href="javascript:void(0)"><strong>Register here.</strong></a>

			</div>
			<h3>Sign in.</h3>

			<p>

				<label for="login_username">Username</label>
				<br />

				<input class="inputbox" id="login_username" name="login_username" type="text" tabindex="2" style="width:250px;" maxlength="30"/>
				&nbsp;<div id="login_username_err"></div

			</p>

			<p>

				<label for="login_password">Password</label>
				<br />

				<input class="inputbox" id="login_password" name="login_password" type="password" tabindex="7" style="width:250px;" maxlength="30"/>
				&nbsp;<div id="login_password_err"></div>

			</p>

			<p>
				<button class="button" name="sign_in" id="Sign_in" tabindex="7">
					Sign in
				</button>
				<div class="error_block" id="signin_response" style="float:right;margin-right:50px;"></div>
			</p>

			<p>
				<a class="inline_colorbox" id="cant_signin" href="#cant_sign_in">Can't Sign in?</a>
			</p>

		</div>

		<!-- registration form starts-->

		<div id="registerform" class="entry" style="margin-left:40px;">

			<div style="float:right;margin-right:30px;">

				<a id="signin_a" href="javascript:void(0)"><strong>Sign in.</strong></a>

			</div>
			<h3>Registration.</h3>

			<table>
				<tr>
					<td><label for="name">First Name</label>
					<br />
					<input class="inputbox" id="firstname" name="firstname" value="" type="text" tabindex="1" style="width:250px;" maxlength="50"/>
					</td>
					<td> &nbsp;<div class="reg_error_msg" id="firstname_err"></div></td>
				</tr>
				<tr>
					<td><label for="name">Last Name</label>
					<br />
					<input class="inputbox" id="lastname" name="lastname" value="" type="text" tabindex="1" style="width:250px;" maxlength="50"/>
					</td>
					<td> &nbsp;<div class="reg_error_msg" id="lastname_err"></div></td>
				</tr>
				<tr>
					<td><label for="emailid">Email id</label>
					<br />
					<input class="inputbox" id="emailid" name="emailid" value="" type="text" tabindex="2" style="width:250px;"maxlength="50"/>
					</td>
					<td> &nbsp;<div class="reg_error_msg" id="emailid_err"></div></td>
				</tr>

				<tr>
					<td><label for="phone">Phone number</label>
					<br />
					<input class="inputbox" id="phone" name="phone" value="" type="text" tabindex="3" style="width:250px;" maxlength="11"/>
					</td>
					<td> &nbsp;<div class="reg_error_msg" id="phone_err"></div></td>
				</tr>
				<tr>
					<td><label for="username">Username</label>
					<br />
					<input class="inputbox" id="username" name="username" value="" type="text" tabindex="4" style="width:250px;" maxlength="30"/>
					</td>
					<td> &nbsp;<div class="reg_error_msg" id="username_err"></div></td>
				</tr>
				<tr>
					<td><label for="password">Password</label>
					<br />
					<input class="inputbox" id="password" name="password" value="" type="password" tabindex="5" style="width:250px;" maxlength="30"/>
					</td>
					<td> &nbsp;<div class="reg_error_msg" id="password_err"></div></td>
				</tr>
				<tr>
					<td><label for="repassword">Re enter password</label>
					<br />
					<input class="inputbox" id="repassword" name="repassword" value="" type="password" tabindex="6" style="width:250px;" maxlength="30"/>
					</td>
					<td> &nbsp;<div class="reg_error_msg" id="repassword_err"></div></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</table>

			<p>

				<input type="checkbox" name="info_send" value="yes" checked="checked">
				&nbsp;&nbsp;I want to recieve notifications about Institutes

			</p>

			<p>

				<button class="button" id="register" name="register" value="Register" tabindex="7">
					Register
				</button>
				<div class="error_block" id="register_response" style="float:right;margin-right:50px;"></div>

			</p>

		</div>

	</div>

</div>

<!-- hidden content for colorboxes and stuff starts here -->

<div style='display:none'>
    <div id="cant_sign_in">
        <strong>Enter your email address to get a new password</strong><br/>
        <input type="text" id="resend_password_email" style="width:230px;"/>&nbsp;&nbsp;&nbsp;&nbsp;<button class="mini_button" id="resend_password">Get New Password</button> <br/>
        <div id="resend_password_err" style="color:#E83F3F;"></div>
        <br/>
        <br/>
        Or
        <br/>
        <br/>
        <strong>Contact Administrator with your email address and a message</strong>
        <br/>
        <table style="margin:20px 33px;">
            <tr>
                <td>
                    Email id<br/>
        <input type="text" id="admin_contact_email" style="width:227px;"/>
                </td>
            </tr>
            <tr>
                <td>
                 Message<br/>
        <textarea cols="30" rows="5" style="height: 70px;" id="admin_contact_text"></textarea> 
                </td>
                <td>
                    &nbsp;&nbsp;&nbsp;  <button style="float:right;margin-top: 40px;" class="mini_button" id="admin_contact_button">Send</button> 
                </td>
                 
            </tr>
            <tr>
                <td>
                    <div id="admin_contact_err" style="color:#E83F3F;"></div>
                </td>
            </tr>
           
        </table>

        
    </div>
    
    
    
</div>


<!-- hidden content and stuff ends here -->


<!-- content end -->

<script>
	// interesting way to do a function call with variable name -->  "window["functionName"]();"

</script>
