<script>
     $(document).ready(function() {
         
         //$('#activation_status_bar').hide();
         
         $("#create_new").click(function() {
             window.location.href = 'http://localhost/CodeIgniter_Registration/index.php/application_form/new_form';
         });
         
         $('#resend_activation_email').live('click',function(){
              //just send the activation email again
             
           serializedData="";
            
            $.ajax({
                url : "http://localhost/CodeIgniter_Registration/index.php/home/resend_activationemail",
                type : "post",
                data : serializedData,
                success : function(response, textStatus, jqXHR) {
                    console.log('response is ' + response);
                }
            });
              
         });
     });
    
</script>
<?php $this->load->view('includes/header_bar'); 

 $req = 'SELECT activated FROM cr_registration_main WHERE user_id = '.$this->session->userdata('logged_user_id');
            $query = mysql_query($req);
            $result = '';
            if($query){
                while ($row = mysql_fetch_array($query)) {
                    $result = $row['activated'];
                }    
            }
            
?>

<div class="error_status" id="activation_status_bar">
    <center>
        
    </center>
</div> 
<br/>

<div id="create_application_box">
    Create your application to seamlessly interact with the institutes you are applying for.
    <button class="button" name="create_new" id="create_new" tabindex="7">Create Application</button>
    <div style="clear: both"></div>
</div>
<br/>

<div id="my_applications_table">
    <div id="title">
        <h4>Current applications</h4>
    </div>
    
    
</div>
<script>
    if('<?php echo $result; ?>' == 'activated'){
        console.log(' in the activated');
        $('#create_new').removeAttr("disabled");
     
        $('#activation_status_bar').hide();
    }
    else if('<?php echo $this->session->userdata("just_activated")?>' == 'true'){
        // the email is just activated .. hence congratulate
        <?php $this->session->unset_userdata("just_activated") ?>
        
            $('#activation_status_bar').html('<center>Congratulations!!! Account Activated Successfully. </center>');
        $('#activation_status_bar').show();
        
    }
    else{
        console.log('in the not activated');
        $('#activation_status_bar').html('<center>Please activate your account from your email id, to activate the "Create Application Button" </center><br/><a id="resend_activation_email" style="float:right;">Resend Activation Email</a> ');
        $('#activation_status_bar').show();
        $('#create_new').attr('disabled','disabled');  
    }
</script>
