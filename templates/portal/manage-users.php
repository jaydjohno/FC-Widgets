<?php

global $wpdb;

$locations = array();

$multi_locations = array();

$user = wp_get_current_user();

$employees = fc_get_users();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC;" ) );

foreach ( $results as $result )
{
    $locations[] = $result->location;
}

//get our multi managers stores
if( $user && in_array( 'multi_manager', $user->roles ) )
{
    $location1 = get_user_meta( $user->ID, 'store_managed_1', true);
    $location2 = get_user_meta( $user->ID, 'store_managed_2', true);
    $location3 = get_user_meta( $user->ID, 'store_managed_3', true);
    $location4 = get_user_meta( $user->ID, 'store_managed_4', true);
    $location5 = get_user_meta( $user->ID, 'store_managed_5', true);
                
    if( $location1 !== '' )
    {
        $success[ 'location1' ] = esc_attr( $location1 );
        
        $multi_locations[] = $location1;
    }
                
    if( $location2 !== '' )
    {
        $success[ 'location2' ] = esc_attr( $location2 );
        
        $multi_locations[] = $location2;
    }
    
    if( $location3 !== '' )
    {
        $success[ 'location3' ] = esc_attr( $location3 );
        
        $multi_locations[] = $location3;
    }
                
    if( $location4 !== '' )
    {
        $success[ 'location4' ] = esc_attr( $location4 );
        
        $multi_locations[] = $location4;
    }
    
    if( $location5 !== '' )
    {
        $success[ 'location5' ] = esc_attr( $location5 );
        
        $multi_locations[] = $location5;
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-user-plus"></i> Add User</a></li>
                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-user-cog"></i> Edit User</a></li>
                    <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab"><i class="fas fa-user-times"></i> Delete User</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                        
                        <div id="form-outcome"></div>
                            
                            <?php
                            if( $user && in_array( 'senior_manager', $user->roles ) )
                        	{
                            ?>
                            <form class="stilesAddUserForm add-user" id="new-user-submit" action="" method="post" type="senior_manager" enctype="multipart/form-data" >
                                <div class="user_type"> 
                                    <p>User Type: <abbr class="required" title="required">*</abbr></p>
                                    
                                    <div class="radio">
                                        <label for="advisor"><input type="radio" id="advisor" class="radio" name="employee_type" value="employee" checked>Advisor</label>
                                    </div>
                                    
                                    <div class="radio">
                                        <label for="senior_advisor"><input type="radio" id="senior_advisor" class="radio" name="employee_type" value="senior_advisor" checked>Senior Advisor</label>
                                    </div>
                                    
                                    <div class="radio">
                                        <label for="store_manager"><input type="radio" id="store_manager" class="radio" name="employee_type" value="store_manager">Store Manager</label>
                                    </div>
                                    
                                    <div class="radio">
                                        <label for="multi_manager"><input type="radio" id="multi_manager" class="radio" name="employee_type" value="multi_manager">Multi Site Manager</label>
                                    </div>
                                    
                                    <div class="radio">
                                        <label for="senior_manager"><input type="radio" id="senior_manager" class="radio" name="employee_type" value="senior_manager">Senior Manager</label>
                                    </div>
                                </div>
                            <?php
                            }
                            else
                            {
                            ?>
                            <form class="stilesAddUserForm add-user" id="new-user-submit" action="" method="post" type="store_manager" store="<?php echo esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) ); ?>" enctype="multipart/form-data" >
                            
                            <div class="radio">
                                <label for="advisor"><input type="radio" id="advisor" class="radio" name="employee_type" value="advisor" checked>Advisor</label>
                            </div>
                                    
                            <div class="radio">
                                <label for="senior_advisor"><input type="radio" id="senior_advisor" class="radio" name="employee_type" value="senior_advisor" checked>Senior Advisor</label>
                            </div>
                            <?php
                            }
                            ?>
                            
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name">
                        		<label for="account_user_name"><?php esc_html_e( 'User Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_user_name" id="account_user_name" value="" /> <span><em><?php esc_html_e( 'This will be what the user uses to log into the portal', 'woocommerce' ); ?></em></span>
                        	</p>
                        	
                        	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide display-name">
                        		<label for="account_display_name"><?php esc_html_e( 'Display Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="" /> <span><em><?php esc_html_e( 'This will be how the users name will be displayed in the portal', 'woocommerce' ); ?></em></span>
                        	</p>
                        
                        	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                        		<label for="account_first_name"><?php esc_html_e( 'First Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="" />
                        	</p>
                        	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                        		<label for="account_last_name"><?php esc_html_e( 'Last Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="" />
                        	</p>
                        	<div class="clear"></div>
                        
                        	<div class="clear"></div>
                        
                        	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        		<label for="account_email"><?php esc_html_e( 'Email Address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="" />
                        	</p>
                        	
                        	<p class="form-row validate-required" id="date_of_birth_field" data-priority=""><label for="date_of_birth" class="">Date of Birth&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="date" class="input-text " name="date_of_birth" id="date_of_birth" placeholder="" value="" min="<?php echo esc_attr( $newtime ); ?>" max="<?php echo esc_attr( $today ); ?>" aria-describedby="date-of-birth-description"></span></p>
                        	
                        	<?php
                        	if( $user && in_array( 'store_manager', $user->roles ) )
                        	{
                        	?>
                            	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            		<label for="account_store"><?php esc_html_e( 'Employee Store', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_store" id="account_store" autocomplete="store" value="<?php echo esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) ); ?>" readonly />
                            	</p>
                        	<?php
                        	}
                        	if( $user && in_array( 'multi_manager', $user->roles ) )
                        	{
                        	?>
                            	<p class="form-row wps-drop" id="store_location" data-priority=""><label for="store_location" class="">Choose Employees Store &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="store_locations" id="store_locations" class="select " data-placeholder="">
                                    	    <?php
                                    	    echo '<option value="">Choose Store</option>';
            							    foreach ( $multi_locations as $location )
                                            {
                                                echo '<option value="' . $location .'">' . $location .'</option>';
                                            }
                                            ?>
        						        </select>
    						       </span>
						        </p>
						        
						        <script>
    						        jQuery(document).ready(function() 
    						        {
                                        jQuery("#store_locations").select2(
    						            {
                                            width: '100%',
                                        });
                                        
                                        var option = jQuery( '#store_locations' ).find('option:selected');

                                        //get the value from the option
                                        var value = option.val();
                                        
                                        jQuery( '#new-user-submit' ).attr( "store", value );
                                    });
                                    
                                    jQuery( '#store_locations' ).change(function() 
                                    {
                                        var option = jQuery( this ).find('option:selected');

                                        //get the value from the option
                                        var value = option.val();
                                        
                                        jQuery( '#new-user-submit' ).attr( "store", value );
                                    });
    						    </script>
                        	<?php
                        	}
                        	if( $user && in_array( 'senior_manager', $user->roles ) )
                        	{
                            ?>
                            	<p class="form-row wps-drop" id="store_location" data-priority="" style="display:none"><label for="store_location" class="">Choose Employees Store &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="store_locations" id="store_locations" class="select " data-placeholder="">
                                    	    <?php
                                    	    echo '<option value="">Choose Store</option>';
            							    foreach ( $locations as $location )
                                            {
                                                echo '<option value="' . $location .'">' . $location .'</option>';
                                            }
                                            ?>
        						        </select>
    						       </span>
						       </p>
						       
						       <p class="form-row wps-drop" id="store_managed" data-priority="" style="display:none"><label for="store_managed" class="">Choose Managers Store &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="store_manage" id="store_manage" class="select " data-placeholder="">
            							    <?php
            							    foreach ( $locations as $location )
                                            {
                                                echo '<option value="' . $location .'">' . $location .'</option>';
                                            }
                                            ?>
        						        </select>
    						       </span>
    						    </p>
    						    
    						    <p class="form-row wps-drop" id="multi_locations" data-priority="" style="display:none"><label for="multi_locations" class="">Choose Managers Locations &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="multi_location" id="multi_location" class="select " data-placeholder="" multiple="multiple">
            							    <?php
            							    foreach ( $locations as $location )
                                            {
                                                echo '<option value="' . $location .'">' . $location .'</option>';
                                            }
                                            ?>
        						        </select>
    						       </span>
    						    </p>
    						    
    						    <script>
    						        jQuery(document).ready(function() 
    						        {
    						            jQuery("#store_manage").select2(
    						            {
    						                placeholder: 'Choose Store',
                                            width: '100%',
                                        });
                                        
                                        jQuery("#store_locations").select2(
    						            {
    						                placeholder: 'Choose Store',
                                            width: '100%',
                                        });
                                        
                                        jQuery("#multi_location").select2(
    						            {
    						                placeholder: 'Choose Store',
                                            width: '100%',
                                        });
                                    });
    						    </script>
                        	<?php
                        	}
                        	?>
                        	
                        	<fieldset class="profile-picture" >
                        		<legend><?php esc_html_e( 'Profile Picture', 'woocommerce' ); ?>
                        		</legend>
                        		
                        		<div id="add-image-container" style="display:none">
                        		    
                        		    <h4>Preview Picture</h4>
                        		    <img id="add-image-preview" src="" alt="Profile Picture">
                        		</div>

                        		   <p class="form-row validate-required" data-priority="">
                        		       <label for="image" class="">Choose Profile Image (JPG, PNG) <abbr class="required" title="required">*</abbr></label>
                        		       <div class="col-md-12" id="add-image">
                                            <span class="woocommerce-input-wrapper">
                                                <label class="btn-bs-file btn btn-md image-button">
                                                    Browse
                                                    <input type="file" name="add-file" id="add-file"  multiple="false" accept="image/*" /> 
                                                </label>
                                                <label class="custom-file-label">No Profile Image Uploaded</label>
                                            </span>
                                        </div>
                        		   </p>
                        	</fieldset>
                        	    
                        	<script>
                        	    jQuery( '#add-image' ).on('change', '#add-file', function()
                        	    {
                                     add_image_upload();
                                });
                        	    
                                function add_image_upload()
                                {
                                  var formData = new FormData();
                                  formData.append("action", "upload-attachment");
                                	
                                  var fileInputElement = document.getElementById("add-file");
                                  formData.append("async-upload", fileInputElement.files[0]);
                                  formData.append("name", fileInputElement.files[0].name);
                                  	
                                  //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
                                  <?php $my_nonce = wp_create_nonce('media-form'); ?>
                                  formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                
                                  var xhr = new XMLHttpRequest();
                                  xhr.onreadystatechange=function()
                                  {
                                    if (xhr.readyState==4 && xhr.status==200)
                                    {
                                        var response = JSON.parse(xhr.responseText);
                                        jQuery( "#add-user-image" ).val( response.data.url );
                                        jQuery("#add-image-preview").attr("src", response.data.url );
                                        jQuery("#add-image-container").show();
                                    }
                                  }
                                  xhr.open("POST","/wp-admin/async-upload.php",true);
                                  xhr.send(formData);
                                }
                                </script>
                                
                                <script>
                                    jQuery( document ).on('change', '#edit-file', function()
                            	    {
                                        edit_image_upload();
                                    });
                                    
                                    function edit_image_upload()
                                    {
                                      var formData = new FormData();
                                      formData.append("action", "upload-attachment");
                                    	
                                      var fileInputElement = document.getElementById("edit-file");
                                      formData.append("async-upload", fileInputElement.files[0]);
                                      formData.append("name", fileInputElement.files[0].name);
                                      	
                                      //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
                                      <?php $my_nonce = wp_create_nonce('media-form'); ?>
                                      formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                    
                                      var xhr = new XMLHttpRequest();
                                      xhr.onreadystatechange=function()
                                      {
                                        if (xhr.readyState==4 && xhr.status==200)
                                        {
                                            var response = JSON.parse(xhr.responseText);
                                            jQuery( "#edit-user-image" ).val( response.data.url );
                                            jQuery("#edit-image-preview").attr("src", response.data.url );
                                            jQuery("#edit-image-container").show();
                                        }
                                      }
                                      xhr.open("POST","/wp-admin/async-upload.php",true);
                                      xhr.send(formData);
                                    }
                                </script>
                                
                            <input type="hidden" id="add-user-image" name="add-user-image" value=""> 
                        
                        	<fieldset class="create-password" >
                        		<legend><?php esc_html_e( 'Create Password', 'woocommerce' ); ?></legend>
                        		
                        		<div class="password-options">
                            		<label class="radio-inline control-label" for="generate_password">
                                        <input type="radio" id="generate_password" class="radio" name="password_type" value="generate_password" checked="">Generate Password
                                    </label>
                                    
                                    <label class="radio-inline control-label" for="create_password">
                                        <input type="radio" id="create_password" class="radio" name="password_type" value="create_password">Create Password
                                    </label>
                                </div>
                        
                        		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" id="new_password">
                        			<label for="password_1"><?php esc_html_e( 'Password', 'woocommerce' ); ?> &nbsp;<span class="required">*</span></label>
                        			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                        		</p>
                        		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" id="confirm_password">
                        			<label for="password_2"><?php esc_html_e( 'Confirm Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                        		</p>
                        	</fieldset>
                        	<div class="clear"></div>
                        
                        	<p>
                        		<button type="submit" id="add-save-account" class="woocommerce-Button button" style="margin-top:20px" name="save_account_details" value="<?php esc_attr_e( 'Add User', 'woocommerce' ); ?>"><?php esc_html_e( 'Add User', 'woocommerce' ); ?>
                        		</button>
                        	</p>
                        </form>
                            
                        <?php
                        if( $user && in_array( 'senior_manager', $user->roles ) )
                        {
                        ?>
                            <script>
                            jQuery(document).ready(function() 
                            {
                                //hide our password form until user selects
                                jQuery("#new_password").hide();
                                jQuery("#confirm_password").hide();
                                jQuery("#password_1").prop('disabled', true);
                                jQuery("#password_2").prop('disabled', true);
                                jQuery("#generate_password").prop('checked', true); 
                                jQuery("#create_password").prop('checked', false);
                               
                                var form = 'advisor';
                    
                                if( form == 'advisor' )
                                {
                                    jQuery("#store_managed").hide();
                                    jQuery("#store_location").show();
                                    jQuery("#multi_locations").hide();
                                    jQuery("#store_manage").prop('disabled', true);
                                    jQuery("#multi_location").prop('disabled', true);
                                    jQuery("#store_locations").prop('disabled', false);
                                    jQuery("#store_manager").prop('checked', false); 
                                    jQuery("#senior_manager").prop('checked', false); 
                                    jQuery("#multi_manager").prop('checked', false); 
                                    jQuery("#advisor").prop('checked', true);
                                    jQuery("#senior_advisor").prop('checked', false);
                                }
                                else if( form == 'senior_advisor' )
                                {
                                    jQuery("#store_managed").hide();
                                    jQuery("#store_location").show();
                                    jQuery("#multi_locations").hide();
                                    jQuery("#store_manage").prop('disabled', true);
                                    jQuery("#multi_location").prop('disabled', true);
                                    jQuery("#store_locations").prop('disabled', false);
                                    jQuery("#store_manager").prop('checked', false); 
                                    jQuery("#senior_manager").prop('checked', false); 
                                    jQuery("#multi_manager").prop('checked', false); 
                                    jQuery("#advisor").prop('checked', false);
                                    jQuery("#senior_advisor").prop('checked', true);
                                }
                                else if( form == 'store_manager' )
                                {
                                    jQuery("#store_managed").show();
                                    jQuery("#store_location").hide();
                                    jQuery("#multi_locations").hide();
                                    jQuery("#store_manage").prop('disabled', false);
                                    jQuery("#store_locations").prop('disabled', true);
                                    jQuery("#multi_location").prop('disabled', true);
                                    jQuery("#store_manager").prop('checked', true); 
                                    jQuery("#senior_manager").prop('checked', false);
                                    jQuery("#multi_manager").prop('checked', false); 
                                    jQuery("#advisor").prop('checked', false);
                                    jQuery("#senior_advisor").prop('checked', false);
                                }
                                else if( form == 'multi_manager' )
                                {
                                    jQuery("#store_managed").hide();
                                    jQuery("#store_location").hide();
                                    jQuery("#multi_locations").show();
                                    jQuery("#store_manage").prop('disabled', true);
                                    jQuery("#store_locations").prop('disabled', true);
                                    jQuery("#multi_location").prop('disabled', false);
                                    jQuery("#store_manager").prop('checked', false); 
                                    jQuery("#senior_manager").prop('checked', false); 
                                    jQuery("#multi_manager").prop('checked', true); 
                                    jQuery("#advisor").prop('checked', false);
                                    jQuery("#senior_advisor").prop('checked', false);
                                }
                                else if( form == 'senior_manager' )
                                {
                                    jQuery("#store_managed").hide();
                                    jQuery("#store_location").hide();
                                    jQuery("#multi_locations").hide();
                                    jQuery("#store_manage").prop('disabled', true);
                                    jQuery("#store_locations").prop('disabled', true);
                                    jQuery("#multi_location").prop('disabled', true);
                                    jQuery("#store_manager").prop('checked', false); 
                                    jQuery("#senior_manager").prop('checked', true); 
                                    jQuery("#advisor").prop('checked', false);
                                    jQuery("#senior_advisor").prop('checked', false);
                                }
                    
                                jQuery(document).on('change','.stilesAddUserForm .radio',function()
                                {
                                    if( jQuery(this).is(":checked") )
                                    {
                                        form = jQuery(this).val();
                                    }
                                    
                                    if( form == 'advisor' )
                                    {
                                        jQuery("#store_managed").hide();
                                        jQuery("#store_location").show();
                                        jQuery("#multi_locations").hide();
                                        jQuery("#store_manage").prop('disabled', true);
                                        jQuery("#multi_location").prop('disabled', true);
                                        jQuery("#store_locations").prop('disabled', false);
                                        jQuery("#store_manager").prop('checked', false); 
                                        jQuery("#senior_manager").prop('checked', false); 
                                        jQuery("#multi_manager").prop('checked', false); 
                                        jQuery("#advisor").prop('checked', true);
                                        jQuery("#senior_advisor").prop('checked', false);
                                    }
                                    if( form == 'senior_advisor' )
                                    {
                                        jQuery("#store_managed").hide();
                                        jQuery("#store_location").show();
                                        jQuery("#multi_locations").hide();
                                        jQuery("#store_manage").prop('disabled', true);
                                        jQuery("#multi_location").prop('disabled', true);
                                        jQuery("#store_locations").prop('disabled', false);
                                        jQuery("#store_manager").prop('checked', false); 
                                        jQuery("#senior_manager").prop('checked', false); 
                                        jQuery("#multi_manager").prop('checked', false); 
                                        jQuery("#advisor").prop('checked', false);
                                        jQuery("#senior_advisor").prop('checked', true);
                                    }
                                    else if( form == 'store_manager' )
                                    {
                                        jQuery("#store_managed").show();
                                        jQuery("#store_location").hide();
                                        jQuery("#multi_locations").hide();
                                        jQuery("#store_manage").prop('disabled', false);
                                        jQuery("#store_locations").prop('disabled', true);
                                        jQuery("#multi_location").prop('disabled', true);
                                        jQuery("#store_manager").prop('checked', true); 
                                        jQuery("#senior_manager").prop('checked', false);
                                        jQuery("#multi_manager").prop('checked', false); 
                                        jQuery("#advisor").prop('checked', false);
                                        jQuery("#senior_advisor").prop('checked', false);
                                    }
                                    else if( form == 'multi_manager' )
                                    {
                                        jQuery("#store_managed").hide();
                                        jQuery("#store_location").hide();
                                        jQuery("#multi_locations").show();
                                        jQuery("#store_manage").prop('disabled', true);
                                        jQuery("#store_locations").prop('disabled', true);
                                        jQuery("#multi_location").prop('disabled', false);
                                        jQuery("#store_manager").prop('checked', false); 
                                        jQuery("#senior_manager").prop('checked', false); 
                                        jQuery("#multi_manager").prop('checked', true); 
                                        jQuery("#advisor").prop('checked', false);
                                        jQuery("#senior_advisor").prop('checked', false);
                                    }
                                    else if( form == 'senior_manager' )
                                    {
                                        jQuery("#store_managed").hide();
                                        jQuery("#store_location").hide();
                                        jQuery("#multi_locations").hide();
                                        jQuery("#store_manage").prop('disabled', true);
                                        jQuery("#store_locations").prop('disabled', true);
                                        jQuery("#multi_location").prop('disabled', true);
                                        jQuery("#store_manager").prop('checked', false); 
                                        jQuery("#senior_manager").prop('checked', true); 
                                        jQuery("#advisor").prop('checked', false);
                                        jQuery("#senior_advisor").prop('checked', false);
                                    }
                                    else if( form == 'generate_password' )
                                    {
                                        jQuery("#new_password").hide();
                                        jQuery("#confirm_password").hide();
                                        jQuery("#password_1").prop('disabled', true);
                                        jQuery("#password_2").prop('disabled', true);
                                        jQuery("#generate_password").prop('checked', true); 
                                        jQuery("#create_password").prop('checked', false);
                                    }
                                    else if( form == 'create_password' )
                                    {
                                        jQuery("#new_password").show();
                                        jQuery("#confirm_password").show();
                                        jQuery("#password_1").prop('disabled', false);
                                        jQuery("#password_2").prop('disabled', false);
                                        jQuery("#generate_password").prop('checked', false); 
                                        jQuery("#create_password").prop('checked', true);
                                    }
                                });
                            });
                        </script>
                        <?php
                        }
                        else
                        {
                        ?>
                            <script>
                            jQuery(document).ready(function() 
                            {
                                //hide our password form until user selects
                                jQuery("#new_password").hide();
                                jQuery("#confirm_password").hide();
                                jQuery("#password_1").prop('disabled', true);
                                jQuery("#password_2").prop('disabled', true);
                                jQuery("#generate_password").prop('checked', true); 
                                jQuery("#create_password").prop('checked', false);
                                
                                var form = 'advisor';
                                
                                if( form == 'advisor' )
                                {
                                    jQuery("#advisor").prop('checked', true);
                                    jQuery("#senior_advisor").prop('checked', false);
                                }
                                else if( form == 'senior_advisor' )
                                {
                                    jQuery("#advisor").prop('checked', false);
                                    jQuery("#senior_advisor").prop('checked', true);
                                }
                    
                                jQuery(document).on('change','.stilesAddUserForm .radio',function()
                                {
                                    if( jQuery(this).is(":checked") )
                                    {
                                        form = jQuery(this).val();
                                    }
                                    
                                    if( form == 'advisor' )
                                    {
                                        jQuery("#advisor").prop('checked', true);
                                        jQuery("#senior_advisor").prop('checked', false);
                                    }
                                    else if( form == 'senior_advisor' )
                                    {
                                        jQuery("#advisor").prop('checked', false);
                                        jQuery("#senior_advisor").prop('checked', true);
                                    }
                                    else if( form == 'generate_password' )
                                    {
                                        jQuery("#new_password").hide();
                                        jQuery("#confirm_password").hide();
                                        jQuery("#password_1").prop('disabled', true);
                                        jQuery("#password_2").prop('disabled', true);
                                        jQuery("#generate_password").prop('checked', true); 
                                        jQuery("#create_password").prop('checked', false);
                                    }
                                    else if( form == 'create_password' )
                                    {
                                        jQuery("#new_password").show();
                                        jQuery("#confirm_password").show();
                                        jQuery("#password_1").prop('disabled', false);
                                        jQuery("#password_2").prop('disabled', false);
                                        jQuery("#generate_password").prop('checked', false); 
                                        jQuery("#create_password").prop('checked', true);
                                    }
                                });
                            });
                        </script>
                        <?php
                        }
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                        
                        <div id="edit-form-outcome"></div>
                        
                        <?php
                        if( $user && in_array( 'senior_manager', $user->roles ) )
                        {
                        ?>
                            <form class="manager-Account-Edit edit-account" id="manager-edit-details" action="" method="post" type="senior_manager" role="" store="">
                        <?php
                        }
                        elseif( $user && in_array( 'store_manager', $user->roles )  )
                        {
                        ?>
                            <form class="manager-Account-Edit edit-account" id="manager-edit-details" action="" method="post" type="store_manager" role="" store="">
                        <?php
                        }
                        elseif( $user && in_array( 'multi_manager', $user->roles )  )
                        {
                        ?>
                            <form class="manager-Account-Edit edit-account" id="manager-edit-details" action="" method="post" type="multi_manager" role="" store="">
                        <?php
                        }
                        	do_action( 'woocommerce_edit_account_form_start' );
                        	
                        	if( $user && in_array( 'multi_manager', $user->roles )  )
                            {
                            ?>
                                <div id="storeselect">
                                	<label for="user">Choose Store:</label>
                                    <select name="multi_store_manage" id="multi_store_manage">
                                        <option value="">Select Store To Manage</option>';
                                        
                                    <?php
                						foreach ( $multi_locations as $location )
                                        {
                                            echo '<option value="' . $location .'">' . $location .'</option>';
                                        }
                                    ?>
                                	
                                    </select>
                                </div>
                                
                                <div id="editstore" style="display:none">
                                	<label for="user">Choose a user:</label>
                                    <select name="eusers" id="eusers">
                                        <option value="">Select Store to Edit Users</option>';
                                    </select>
                                </div>
                            <?php
                            }
                            else
                            {
                            ?>
                                <div id="editselect">
                                    <label for="user">Choose a user:</label>
                                    <select name="eusers" id="eusers">
                                        <option value="">Select User To Edit</option>';
                                        
                                    <?php
                                	
                                	foreach( $employees as $id => $employee )
                                	{
                                	    echo '<option value="' . $id . '">' . $employee . '</option>';
                                	}
                                	
                                	?>
                                	</select>
                                </div>
                            <?php
                            }
                            ?>

                            <script>
                        	    jQuery(document).ready(function() 
                        	    {
                        	        jQuery("#multi_store_manage").select2(
            						{
                                        width: '100%',
                                    });
                                    
                                    jQuery('#multi_store_manage').change(function() 
                                    {
                                        store = jQuery(this).val();
                                        
                                        if( store !== '' )
                                        {
                                            var data = {};
                                    
                                            data['action'] = 'fc_get_multi_users';
                                            data['nonce'] = fc_nonce;
                                            data['store'] = store;
                                                
                                            jQuery.ajax({
                                            	type: 'POST',
                                                dataType: 'json',
                                                url: fc_ajax_url,
                                                data: data,
                                                success: function(data) 
                                                {
                                                    jQuery('#eusers')
                                                    .empty()
                                                    .append( data.data );
                                                        
                                                    jQuery( '#editstore' ).show();
                                                    jQuery( '#eusers' ).prop('disabled', false);
                                                }
                                            });
                                        }
                                        else
                                        {
                                            jQuery( '#editstore' ).hide();
                                            jQuery('#eusers').empty();
                                        }
                                    });
                                    
                                    <?php
                                    if( $user && in_array( 'multi_manager', $user->roles ) )
                                    {
                                    ?>
                                        jQuery("#eusers").select2(
                						{
                                            width: '100%',
                                        });
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                            	        jQuery("#eusers").select2(
                						{
                						    placeholder: "Select a User to Edit",
                                            width: '100%',
                                        });
                                    <?php
                                    }
                                    ?>
                                    
                                    jQuery( document ).on("change","#eusers",function() 
                                    {
                                        id = jQuery(this).val();
                                        
                                        if( id !== '' )
                                        {
                                            var data = {};
                                
                                            data['action'] = 'fc_get_edit_user';
                                            data['nonce'] = fc_nonce;
                                            data['id'] = id;
                                            
                                            jQuery.ajax({
                                        		type: 'POST',
                                                dataType: 'json',
                                                url: fc_ajax_url,
                                                data: data,
                                                success: function(data) 
                                                {	
                                                    if( data.success === false )
                                                    {
                                                        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                                                        
                                                        jQuery( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name">There has been an unexpected error, please try again.</li></ul></div>' );
                                                    }
                                                    else
                                                    {
                                                        jQuery( "#user_id" ).val( id );
                                                        jQuery( "#edit_account_user_name" ).val( data.data.user_name );
                                                        jQuery( "#edit_account_display_name" ).val( data.data.display_name );
                                                        jQuery( "#edit_account_first_name" ).val( data.data.first_name );
                                                        jQuery( "#edit_account_last_name" ).val( data.data.last_name );
                                                        jQuery( "#edit_account_email" ).val( data.data.email );
                                                        jQuery( "#edit_date_of_birth" ).val( data.data.dob );
                                                        jQuery("#edit-image-preview").attr("src", data.data.url );
                                                        jQuery("#edit-user-image").val( data.data.url );
                                                        jQuery("#edit-image-container").show();
                                                        jQuery("#manager-edit-details").attr("role", data.data.type );
                                                        jQuery("#manager-edit-details").attr("store", data.data.location );
                                                        
                                                        if( data.data.type == 'advisor' )
                                                        {
                                                            jQuery( "#edit_account_store" ).val( data.data.location );
                                                            jQuery('#edit_store_locations').val( data.data.location );
                                                            jQuery( '#select2-edit_store_locations-container' ).attr( 'title' , data.data.location );
                                                            jQuery( '#select2-edit_store_locations-container' ).text( data.data.location );
                                                            jQuery('#edit_advisor_type_select').val( data.data.type );
                                                            jQuery( '#select2-edit_advisor_type_select-container' ).attr( 'title' , 'Advisor' );
                                                            jQuery( '#select2-edit_advisor_type_select-container' ).text( 'Advisor' );
                                                            
                                                            jQuery('#edit_store_location').show();
                                                            jQuery('#edit_advisor_type').show();
                                                            jQuery('#edit_store_managed').hide();
                                                            jQuery('#edit_store_multiple').hide();
                                                        }
                                                        if( data.data.type == 'senior_advisor' )
                                                        {
                                                            jQuery( "#edit_account_store" ).val( data.data.location );
                                                            jQuery('#edit_store_locations').val( data.data.location );
                                                            jQuery( '#select2-edit_store_locations-container' ).attr( 'title' , data.data.location );
                                                            jQuery( '#select2-edit_store_locations-container' ).text( data.data.location );
                                                            jQuery('#edit_advisor_type_select').val( data.data.type );
                                                            jQuery( '#select2-edit_advisor_type_select-container' ).attr( 'title' , 'Senior Advisor' );
                                                            jQuery( '#select2-edit_advisor_type_select-container' ).text( 'Senior Advisor' );
                                                            
                                                            jQuery('#edit_store_location').show();
                                                            jQuery('#edit_advisor_type').show();
                                                            jQuery('#edit_store_managed').hide();
                                                            jQuery('#edit_store_multiple').hide();
                                                        }
                                                        else if( data.data.type === 'store_manager' )
                                                        {
                                                            jQuery('#edit_store_manage').val( data.data.location );
                                                            jQuery( '#select2-edit_store_manage-container' ).attr( 'title' , data.data.location );
                                                            jQuery( '#select2-edit_store_manage-container' ).text( data.data.location );
                                                        
                                                            jQuery('#edit_store_location').hide();
                                                            jQuery('#edit_advisor_type').hide();
                                                            jQuery('#edit_store_managed').show();
                                                            jQuery('#edit_store_multiple').hide();
                                                        }
                                                        else if( data.data.type === 'multi_manager' )
                                                        {
                                                            jQuery('#edit_store_location').hide();
                                                            jQuery('#edit_advisor_type').hide();
                                                            jQuery('#edit_store_managed').hide();
                                                            jQuery('#edit_store_multiple').show();
                                                            
                                                            jQuery('#edit_store_multi')
                                                            .empty()
                                                            .append( data.data.selects );
                                                        }
                                                        else if( data.data.type === 'senior_manager' )
                                                        {
                                                            jQuery('#edit_store_location').hide();
                                                            jQuery('#edit_advisor_type').hide();
                                                            jQuery('#edit_store_managed').hide();
                                                            jQuery('#edit_store_multiple').hide();
                                                            jQuery("#store_manage").prop('disabled', true);
                                                            jQuery("#store_locations").prop('disabled', true);
                                                            jQuery("#store_location").hide();
                                                        }
                                                        
                                                        jQuery("#manager-edit-details :input").not( '#multi_store_manage' ).prop("disabled", false);
                                                        jQuery("#edit_account_user_name").prop("disabled", true );
                                                    }
                                                },
                                            });
                                        }
                                    });
                                });
                        	</script>
                        	
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name">
                        		<label for="account_user_name"><?php esc_html_e( 'User Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_user_name" id="edit_account_user_name" value="" disabled /> <span><em><?php esc_html_e( 'This is what the user uses to log into the portal (This cannot be Changed)', 'woocommerce' ); ?></em></span>
                        	</p>
                        	
                        	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide display-name">
                        		<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="edit_account_display_name" value="" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the portal', 'woocommerce' ); ?></em></span>
                        	</p>
                        
                        	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                        		<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="edit_account_first_name" autocomplete="given-name" value="" />
                        	</p>
                        	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                        		<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="edit_account_last_name" id="edit_account_last_name" autocomplete="family-name" value="" />
                        	</p>
                        	<div class="clear"></div>
                        
                        	<div class="clear"></div>
                        
                        	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="edit_account_email" autocomplete="email" value="" />
                        	</p>
                        	
                        	<p class="form-row validate-required" id="date_of_birth_field" data-priority=""><label for="date_of_birth" class="">Date of Birth&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="date" class="input-text " name="date_of_birth" id="edit_date_of_birth" placeholder="" value="" min="<?php echo esc_attr( $newtime ); ?>" max="<?php echo esc_attr( $today ); ?>" aria-describedby="date-of-birth-description"></span></p>
                        	
                        	<?php
                        	if( $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
                        	{
                        	?>
                            	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            		<label for="account_store"><?php esc_html_e( 'Employee Store', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_store" id="edit_account_store" autocomplete="store" value="" readonly />
                            	</p>
                            	
                            	<p class="form-row wps-drop" id="edit_advisor_type" data-priority="" style="display:none"><label for="advisor_type" class="">Choose Advisors Role &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="advisor_type" id="edit_advisor_type_select" class="select " data-placeholder="">
            							    <option value="advisor">Advisor</option>
            							    <option value="senior_advisor">Senior Advisor</option>
        						        </select>
    						       </span>
    						    </p>
                        	<?php
                        	}
                        	if( $user && in_array( 'senior_manager', $user->roles ) )
                        	{
                            ?>
                            	<p class="form-row wps-drop" id="edit_store_location" data-priority="" style="display:none"><label for="store_location" class="">Choose Employees Store &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="store_locations" id="edit_store_locations" class="select " data-placeholder="">
                                    	    <?php
            							    foreach ( $locations as $location )
                                            {
                                                echo '<option value="' . $location .'">' . $location .'</option>';
                                            }
                                            ?>
        						        </select>
    						       </span>
						       </p>
						       
						       <p class="form-row wps-drop" id="edit_advisor_type" data-priority="" style="display:none"><label for="advisor_type" class="">Choose Advisors Role &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="advisor_type" id="edit_advisor_type_select" class="select " data-placeholder="">
            							    <option value="advisor">Advisor</option>
            							    <option value="senior_advisor">Senior Advisor</option>
        						        </select>
    						       </span>
    						    </p>
						       
						       <p class="form-row wps-drop" id="edit_store_managed" data-priority="" style="display:none"><label for="store_managed" class="">Choose Managers Store &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="store_manage" id="edit_store_manage" class="select " data-placeholder="">
            							    <?php
            							    foreach ( $locations as $location )
                                            {
                                                echo '<option value="' . $location .'">' . $location .'</option>';
                                            }
                                            ?>
        						        </select>
    						       </span>
    						    </p>
    						    
    						    <p class="form-row wps-drop" id="edit_store_multiple" data-priority="" style="display:none"><label for="store_managed" class="">Choose Managers Locations &nbsp;<span class="required">*</span></label>
                                	<span class="woocommerce-input-wrapper">
                                    	<select name="store_manage" id="edit_store_multi" class="select " data-placeholder="" multiple>
            							    <?php
            							    foreach ( $locations as $location )
                                            {
                                                echo '<option value="' . $location .'">' . $location .'</option>';
                                            }
                                            ?>
        						        </select>
    						       </span>
    						    </p>
    						    
    						    <script>
    						        jQuery(document).ready(function() 
    						        {
    						            jQuery("#edit_store_manage").select2(
    						            {
                                            width: '100%',
                                        });
                                        
                                        jQuery("#edit_advisor_type_select").select2(
    						            {
                                            width: '100%',
                                        });
                                        
                                        jQuery('#edit_store_manage').change(function() 
                                        {
                                            store = jQuery(this).val();
                                            jQuery( '#manager-edit-details' ).attr( "store", store );
                                        });
                                        
                                        jQuery("#edit_store_locations").select2(
    						            {
    						                placeholder: "Select Store",
                                            width: '100%',
                                        });
                                        
                                        jQuery('#edit_store_locations').change(function() 
                                        {
                                            store = jQuery(this).val();
                                            jQuery( '#manager-edit-details' ).attr( "store", store );
                                        });
                                        
                                        jQuery("#edit_store_multi").select2(
    						            {
    						                placeholder: "Select Store",
                                            width: '100%',
                                        });
                                    });
    						    </script>
                        	<?php
                        	}
                        	else
                        	{
                        	    ?>
                        	    <script>
    						        jQuery(document).ready(function() 
    						        {
                                        jQuery("#edit_advisor_type_select").select2(
    						            {
                                            width: '100%',
                                        });
                                    });
    						    </script>
    						    <?php
                        	}
                        	?>
                        	
                        	<fieldset class="profile-picture" >
                        		<legend><?php esc_html_e( 'Profile Picture', 'woocommerce' ); ?>
                        		</legend>
                        		
                        		<div id="edit-image-container" style="display:none">
                        		    
                        		    <h4>Preview Picture</h4>
                        		    <img id="edit-image-preview" src="" alt="Profile Picture">
                        		</div>

                        		   <p class="form-row validate-required" data-priority="">
                        		       <label for="image" class="">Edit Profile Image (JPG, PNG)<abbr class="required" title="required">*</abbr></label>
                        		       <div class="col-md-12" id="edit-image">
                                            <span class="woocommerce-input-wrapper">
                                                <label class="btn-bs-file btn btn-md image-button">
                                                    Browse
                                                    <input type="file" name="edit-file" id="edit-file" multiple="false" accept="image/*" /> 
                                                </label>
                                                <label class="custom-file-label">No Profile Image Uploaded</label>
                                            </span>
                                        </div>
                        		   </p>
                        	</fieldset>
                        
                        	<fieldset class="edit-password">
                        		<legend><?php esc_html_e( 'Change Users Password', 'woocommerce' ); ?></legend>
                        
                        		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        			<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                        			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="edit_password_1" autocomplete="off" />
                        		</p>
                        		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        			<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
                        			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="edit_password_2" autocomplete="off" />
                        		</p>
                        	</fieldset>
                        	<div class="clear"></div>
                        
                        	<?php do_action( 'woocommerce_edit_account_form' ); ?>
                        
                        	<p>
                        		<button type="submit" id="edit-save-account" class="woocommerce-Button button" style="margin-top:20px" name="save_account_details" value="<?php esc_attr_e( 'Edit User', 'woocommerce' ); ?>"><?php esc_html_e( 'Edit User', 'woocommerce' ); ?></button>
                        	</p>
                        	
                        	  <input type="hidden" id="user_id" name="user_id" value=""> 
                        	  
                        	  <input type="hidden" id="edit-user-image" name="edit-user-image" value=""> 
                        
                        	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section3">
                        
                        <div id="delete_outcome"></div>
                        
                        <?php
                        if( $user && in_array( 'senior_manager', $user->roles ) )
                        {
                        ?>
                            <form class="StilesDeleteUser delete-user" id="delete_user" action="" method="post" type="senior_manager" id="">
                        <?php
                        }
                        elseif( $user && in_array( 'store_manager', $user->roles ) )
                        {
                        ?>
                            <form class="StilesDeleteUser delete-user" id="delete_user" action="" method="post" type="store_manager" id="">
                        <?php
                        }
                        elseif( $user && in_array( 'multi_manager', $user->roles ) )
                        {
                        ?>
                            <form class="StilesDeleteUser delete-user" id="delete_user" action="" method="post" type="multi_manager" id="">
                        <?php
                        }
                        
                        if( $user && in_array( 'multi_manager', $user->roles )  )
                        {
                        ?>
                            <div id="deletestore">
                                <label for="user">Choose Store:</label>
                                <select name="delete_multi_store_manage" id="delete_multi_store_manage">
                                    <option value="">Select Store To Manage</option>';
                                        
                                    <?php
                						foreach ( $multi_locations as $location )
                                        {
                                            echo '<option value="' . $location .'">' . $location .'</option>';
                                        }
                                    ?>
                                	
                                </select>
                            </div>
                                
                            <div id="deleteselect" style="display:none">
                                <label for="user">Choose a user:</label>
                                <select name="dusers" id="dusers">
                                    <option value="">Select User To Delete</option>';
                                </select>
                            </div>
                            
                            <script>
                                jQuery( document ).ready(function() 
                                {
                                    jQuery("#delete_multi_store_manage").select2(
            						{
                                        width: '100%',
                                    });
                                });
                                
                                jQuery('#delete_multi_store_manage').change(function() 
                                {
                                    store = jQuery(this).val();
                                    
                                    if( store !== '' )
                                    {
                                        var data = {};
                                    
                                        data['action'] = 'fc_get_multi_users';
                                        data['nonce'] = fc_nonce;
                                        data['store'] = store;
                                                
                                        jQuery.ajax({
                                            type: 'POST',
                                            dataType: 'json',
                                            url: fc_ajax_url,
                                            data: data,
                                            success: function(data) 
                                            {
                                                jQuery('#dusers')
                                                .empty()
                                                .append( data.data );
                                                        
                                            jQuery( '#deleteselect' ).show();
                                            }
                                        });
                                    }
                                    else
                                    {
                                        jQuery( '#deleteselect' ).hide();
                                        jQuery('#dusers').empty();
                                    }
                                });
                            </script>
                            <?php
                            }
                            else
                            {
                                ?>
                                <div id="deleteselect">
                                    <label for="user">Choose a user:</label>
                                    <select name="dusers" id="dusers">
                                        <option value="">Select User To Delete</option>';
                                        
                                    <?php
                                	
                                	foreach( $employees as $id => $employee )
                                	{
                                	    echo '<option value="' . $id . '">' . $employee . '</option>';
                                	}
                                	
                                	?>
                                	</select>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <button type="submit" id="delete-submit" class="delete-submit woocommerce-Button button" style="margin-top:20px" name="delete_account" value="<?php esc_attr_e( 'Delete User', 'woocommerce' ); ?>"><?php esc_html_e( 'Delete User', 'woocommerce' ); ?>
                        </form>
                        
                        <script>
                        
                        jQuery(document).ready(function() 
                        {
                            jQuery("#dusers").select2(
    						{
                                width: '100%',
                            });
                            
                            jQuery( document ).on("change","#dusers",function() 
                            {
                                id = jQuery(this).val();
                                jQuery("#delete-submit").attr("disabled", false);
                            });
                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery( document ).ready(function() 
    {
        //disable our edit and delete buttons
        jQuery("#delete-submit").attr("disabled", true);

        <?php
        if( $user && in_array( 'store_manager', $user->roles )  )
        {
        ?>
            jQuery("#manager-edit-details :input").not( '#eusers' ).prop("disabled", true);
        <?php
        }
        else
        {
            ?>
            jQuery("#manager-edit-details :input").not( '#multi_store_manage' ).prop("disabled", true);
            <?php
        }
        ?>
        
        <?php
        if( $user && in_array( 'senior_manager', $user->roles ) )
        {
        ?>
            jQuery( '#eusers' ).prop('disabled', false);
        <?php
        }
        ?>
    });
</script>

<?php
