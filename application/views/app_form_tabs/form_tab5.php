<?php

 $this->session->set_userdata('tab_status','form_tab5');
?>
<div id="tab5">
<script type="text/javascript">
	// Convert divs to queue widgets when the DOM is ready
	$(function() {

		$("#uploader").pluploadQueue({
			// General settings
			runtimes : 'gears,flash,silverlight,browserplus,html5',
			url : 'http://localhost/CodeIgniter_Registration/index.php/application_form/plupload_upload',
			max_file_size : '10mb',
			chunk_size : '10mb',
			unique_names : false,
            
			// Resize images on clientside if we can
			/* resize : {
				width : 320,
				height : 240,
				quality : 90
			},*/  //Good thing .. but not using it now

			// Specify what files to browse for
			filters : [{
				title : "Image files",
				extensions : "jpg,gif,png"
			}, {
				title : "Zip files",
				extensions : "zip"
			}],
			// Flash settings
			flash_swf_url : 'http://localhost/CodeIgniter_Registration/plupload/js/plupload.flash.swf',

			// Silverlight settings
			silverlight_xap_url : 'http://localhost/CodeIgniter_Registration/plupload/js/plupload.silverlight.xap',

			preinit : {
				Init : function(up, info) {
					//log('[Init]', 'Info:', info, 'Features:', up.features);
				},

				UploadFile : function(up, file) {
					//log('[UploadFile]', file);
				},

				UploadComplete : function(up, file) {
				    var filename_array = new Array();
				    console.log('uload complete for '+file);
				    
				    $.each(file, function(index, val) {
                         
                                filename_array[index] = val.name;
                                
                                
                                console.log(' the key val is '+index+' val = '+val.name);
                        
                    });
                    
                    insert_file_details_db(filename_array);
                    alert('upload complete for '+file);
					location.reload();
					//$(".plupload_buttons").css("display", "inline");
					//$(".plupload_upload_status").css("display", "inline");
				},
				
				//FilesAdded(uploader:Uploader, files:Array)
				FilesAdded : function(up, files) {
                    
                    
                    
					/* files.each(function(file, i) {
					 $('#myfiles').append("<div>i=" + i +"</div>");

					 });*/

				},

				UploadProgress : function(up, file) {
				},

				PostInit : function(up) {

				},

				QueueChanged : function(up) {
				}
			},

			init : {

				PostInit : function(up) {
					//alert();
					$('#deleteallfiles').click(function(e) {

					});
				}
			}

		});
		
		// Client side form validation
		$('form').submit(function(e) {
			var uploader = $('#uploader').pluploadQueue();

			// Files in queue upload them first
			if (uploader.files.length > 0) {
				// When all files are uploaded submit form
				uploader.bind('StateChanged', function() {
					if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
						$('form')[0].submit();
					}

				});

				uploader.start();

			} else {

				alert('You must queue at least one file.');

			}

			return false;

		});

	});

</script>

	<div style="margin:0px 10px;">

<div id="plupload_form">
<form>
    <div id="uploader">
        <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
    </div>
</form>
    
</div>


   <div id="selected_files_list">
                <strong> &nbsp;&nbsp;Uploaded Files</strong>
                <hr style="color:#ddddd;"/>
                <div id="selected_files_list_scroll">
                    <table id="selec_files_list" width="100%">

                    </table>
                </div>
                <div style="clear: both;"></div>
    </div>

	

	</div>

	<!-- something like a footer starts here -->
	   <div style="clear: both;"></div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<a class="more-link next_tab" current_tab="tab5" next_tab="tab6">&nbsp; Next &nbsp;</a>
		</p>
	</div>
	<div style="float:right;margin:5px 20px;" class="stdlinks">
		<p>
			<?php
if($this->session->userdata('person_category') == 1)
{
			?>
			<a class="more-link prev_tab" current_tab="tab5" next_tab="tab4">&nbsp; Back &nbsp;</a>
			<?php } else { ?>
			<a class="more-link prev_tab" current_tab="tab5" next_tab="tab4_2">&nbsp; Back &nbsp;</a>

			<?php } ?>
		</p>
	</div>
	<div style="clear: both;"></div>
	<div class="tab_error_msg">
		&nbsp;&nbsp;Please correct the highlighted fields to proceed&nbsp;&nbsp;
	</div>
	<div style="clear: both;"></div>
	<script>
		on_tab_load('tab5');
	</script>
</div>