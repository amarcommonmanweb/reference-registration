<?php $this -> session -> set_userdata('tab_status', 'form_tab6'); ?>
<div id="tab6">
    
    <div style="margin:0px 10px;">
        <div id="tab6_form">
            
            <div class="data_container">
                <strong>Personal Details</strong>
            <table id="personal_info">
                <tr>
                    <td>Full Name :</td>
                    <td><?php echo $tab2['firstname'] . ' ';
                        if ($tab2['middlename'] != '') { echo $tab2['middlename'] . ' ';
                        }echo $tab2['lastname'];
   ?></td>
                </tr>
                <tr>
                    <td>Date of Birth :</td>
                    <td><?=$tab2['dob'] ?></td>
                </tr>
                <tr>
                    <td>Gender :</td>
                    <td><?=$tab2['gender']?></td>
                </tr>
                <tr>
                    <td>Nationality :</td>
                    <td><?=$tab2['nationality']?></td>
                </tr>
                <tr>
                    <td>Blood Group :</td>
                    <td><?=$tab2['blood_group']?></td>
                </tr>
                <tr>
                    <td>Fathers Name :</td>
                    <td><?=$tab2['fathers_name']?></td>
                </tr>
                <tr>
                    <td>Mothers Name :</td>
                    <td><?=$tab2['mothers_name']?></td>
                </tr>
            </table>
            </div>
            
            <table>
              <tr>
                  <td><strong>Residential</strong></td>
              </tr>
                <tr>
                    <td><?=$tab3['res_line1']?>,</td>
                </tr>  
                 <tr>
                    <td><?=$tab3['res_line2']?>,</td>
                </tr>
                 <tr>
                    <td><?=$tab3['res_city_name']?>,</td>
                </tr>
                 <tr>
                    <td><?=$tab3['res_state_name']?> - <?=$tab3['res_pincode']?></td>
                </tr>
                 <tr>                   
                    <td>Phone 1 : <?=$tab3['res_phone_1']?></td>
                </tr>
                 <tr>                    
                    <td>Phone 2 : <?=$tab3['res_phone_2']?></td>
                </tr>
                <tr>                    
                    <td>Email Id : <?=$tab3['res_email']?></td>
                </tr>
            </table>
                <table>
              <tr>
                  <td><strong>Permanent</strong></td>
              </tr>
                <tr>
                    <td><?=$tab3['permn_line1']?>,</td>
                </tr>  
                 <tr>
                    <td><?=$tab3['permn_line2']?>,</td>
                </tr>
                 <tr>
                    <td><?=$tab3['permn_city_name']?>,</td>
                </tr>
                 <tr>
                    <td><?=$tab3['permn_state_name']?> - <?=$tab3['permn_pincode']?></td>
                </tr>
                 <tr>                   
                    <td>Phone 1 : <?=$tab3['permn_phone_1']?></td>
                </tr>
                 <tr>                    
                    <td>Phone 2 : <?=$tab3['permn_phone_2']?></td>
                </tr>
                 <tr>                    
                    <td>Email Id : <?=$tab3['permn_email']?></td>
                </tr>
            </table>
            
            <?php 
            if($tab2['category_id'] == 1){
                
            ?>
                   <table>
                       <tr>
                           <td><strong>Previous School</strong></td>
                       </tr>
                       <tr>
                           <td><?=$tab4['school_name']?>, <?=$tab4['city_name']?>, <?=$tab4['state_name']?>, </td>
                             <td> From <?=$tab4['from_date']?> To <?=$tab4['to_date']?>.</td>
                       </tr>
                   </table>
            
            <strong>Siblings</strong>
            <table>
                <?php
                foreach ($tab4['full_name'] as $key => $value) {
                ?>
                <tr>
                    <td><?=$tab4['full_name'][$key]?>, <?=$tab4['class'][$key]?>,</td>
                </tr>
                <tr>
                    <td><?=$tab4['gender'][$key]?>, <?=$tab4['dob'][$key]?>,</td>
                </tr>
                <tr>
                    <td><?=$tab4['sibl_school_name'][$key]?>.</td>
                </tr>
                <?php } ?>
            </table>
            <?php }else{ ?>   
                
                <strong> Experience Details</strong>
                    <table>
                        <?php
                        foreach ($tab4['exp_description'] as $key => $value) {
                        ?>
                        <tr>
                            <td><?=$tab4['exp_description'][$key]?></td>
                        </tr>
                        
                        <tr>
                            <td><?=$tab4['city_name'][$key]?>, <?=$tab4['state_name'][$key]?></td>
                        </tr>
                        
                        <tr>
                            <td>From <?=$tab4['exp_from'][$key]?> To <?=$tab4['exp_to'][$key]?></td>
                        </tr>
                       
                        <?php } ?>  
                    </table>
               
               <strong>Qualification Details</strong>
               <table>
                   <?php
                        foreach ($tab4['course'] as $key => $value) {
                        ?>
                        <tr>
                            <td><?=$tab4['course'][$key]?>,</td>
                        </tr>
                        <tr>
                            <td><?=$tab4['institute'][$key]?></td>
                        </tr>
                        <tr>
                            <td>From <?=$tab4['qual_from'][$key]?> To <?=$tab4['qual_to'][$key]?></td>
                        </tr>
                        <tr>
                            <td>Final Percentage : <?=$tab4['qual_percent'][$key]?></td>
                        </tr>
                        
                        
                        <?php } ?>
               </table>
            
            
                <strong>References</strong>
                <table>
                    <?php
                        foreach ($tab4['ref_name'] as $key => $value) {
                        ?>
                    <tr>
                        <td><?=$tab4['ref_name'][$key]?>,</td>
                    </tr>
                    <tr>
                        <td><?=$tab4['ref_description'][$key]?></td>
                    </tr>
                    <tr>
                        <td>Ph: <?=$tab4['ref_phone'][$key]?></td>
                    </tr>
                    <tr>
                        <td>E Mail: <?=$tab4['ref_email'][$key]?></td>
                    </tr>
                    <?php } ?>
                    
                </table>
            <?php } ?>
            
            
               
            <strong>Other Information</strong>
            <table>
                <tr>
                     
            <?php 
            if($tab2['category_id'] == 1){
                
            ?>
                    <td>Student Type :</td>
                    <td><?php echo ($tab4['day_or_hostel'] == 'Day')?'Day Scholor':'Hostelier'; ?></td>
                    <?php }else{ ?>
                    <td>Marital Status :</td>
                    <td><?=$tab4['marital_status']?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Mother Tongue :</td>
                    <td><?=$tab4['mother_tongue']?></td>
                </tr>
                <tr>
                    <td>Birth Place :</td>
                    <td><?=$tab4['birth_place']?></td>
                </tr>
                <tr>
                    <td>Identification Marks :</td>
                    <td><?=$tab4['identification_marks']?></td>
                </tr>
                <tr>
                    <td>Hobbies :</td>
                    <td><?=$tab4['hobbies']?></td>
                </tr>
                <tr>
                    <td>Allergies :</td>
                    <td><?=$tab4['allergies']?></td>
                </tr>
            </table>
        </div>
    </div>
    
    
<!-- something like a footer starts here -->
       <div style="clear: both;"></div>
    <div style="float:right;margin:5px 20px;" class="stdlinks">
        <p>
            <a class="more-link next_tab" current_tab="finish" next_tab="finish">&nbsp; Finish &nbsp;</a>
        </p>
    </div>
    <div style="float:right;margin:5px 20px;" class="stdlinks">
        <p>
           
            <a class="more-link prev_tab" current_tab="finish" next_tab="tab5">&nbsp; Back &nbsp;</a>

           
        </p>
    </div>
    <div style="clear: both;"></div>
    <div class="tab_error_msg">
        &nbsp;&nbsp;Please correct the highlighted fields to proceed&nbsp;&nbsp;
    </div>
    <div style="clear: both;"></div>
    <script>
		on_tab_load('tab6');
    </script>
</div>
