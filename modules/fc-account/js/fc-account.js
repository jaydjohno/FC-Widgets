( function( $ ) 
{
    //this is the Employee AJAX functions
    
    $( "#save-account-details" ).submit(function( event ) 
    {
        //lets get all the form values
        
        $('#account_display_name').each(function()
    	{
            displayname = $(this).val();
        });
        
        $('#account_first_name').each(function()
    	{
            firstname = $(this).val();
        });
        
        $('#account_last_name').each(function()
    	{
            lastname = $(this).val();
        });
        
        $('#account_email').each(function()
    	{
            email = $(this).val();
        });
        
        $('#date_of_birth').each(function()
    	{
            dob = $(this).val();
        });
        
        $('#password_current').each(function()
    	{
            currentpassword = $(this).val();
        });
        
        $('#password_1').each(function()
    	{
            newpassword = $(this).val();
        });
        
        $('#password_2').each(function()
    	{
            newpasswordconfirm = $(this).val();
        });

        //now store the values
        var data = {};
                            
        data['action'] = 'fc_save_account_details';
        data['nonce'] = fc_nonce;
        data['displayname'] = displayname;
        data['firstname'] = firstname;
        data['lastname'] = lastname;
        data['email'] = email;
        data['dob'] = dob;
        
        if(currentpassword !== '')
            data['currentpassword'] = currentpassword;
                            
        if(newpassword !== '')
            data['newpassword'] = newpassword;
            
        if(newpasswordconfirm !== '')
            data['newpasswordconfirm'] = newpasswordconfirm; 
        
        $.ajax({
    		type: 'POST',
            dataType: 'json',
            url: fc_ajax_url,
            data: data,
            success: function(data) 
            {	
                if( data.success === false )
                {
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    
                    if( data.data == 'empty_display_name' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Display Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_first_name' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_first_name"><strong>First Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_last_name' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_last_name"><strong>Last Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_email' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_email"><strong>Email Address</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_dob' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_dob"><strong>Date Of Birth</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'current_password_wrong' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="current_password_wrong"><strong>Current Password</strong> is incorrect, your password has not been changed, please try again.</li></ul></div>' );
                    }
                    if( data.data == 'new_password_empty' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="new_password_empty"><strong>New Password</strong> is empty, your password has not been changed, please try again.</li></ul></div>' );
                    }
                    if( data.data == 'passwords_dont_match' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="passwords_dont_match"><strong>New Password and Confirm Password Don\'t Match</strong>, your password has not been changed, please try again.</li></ul></div>' );
                    }
                }
                else
                {
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    
                    if( data.data == 'user_update_success' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Employee details updated successfully.	</div></div>' );
                    }
                    if( data.data == 'password_update_success' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Password updated successfully, redirecting you to login page.	</div></div>' );
                        
                        window.location.replace("https://www.familyconnectgroup.co.uk/login");
                    }
                }
            },
        });
        
        event.preventDefault();
        
    });
    
    //start our Manage Users AJAX calls
    
    $( "#new-user-submit" ).submit(function( event ) 
    {
        //lets get all the form values
        
        //lets check what type of user we have
        type = $( '#new-user-submit' ).attr("type");
        
        role = $("input[name='employee_type']:checked").val();
        
        $('#account_user_name').each(function()
    	{
            username = $(this).val();
        });
        
        $('#account_display_name').each(function()
    	{
            displayname = $(this).val();
        });
        
        $('#account_first_name').each(function()
    	{
            firstname = $(this).val();
        });
        
        $('#account_last_name').each(function()
    	{
            lastname = $(this).val();
        });
        
        $('#account_email').each(function()
    	{
            email = $(this).val();
        });
        
        $('#date_of_birth').each(function()
    	{
            dob = $(this).val();
        });
        
        if( type == 'senior_manager' )
        {
            if( role === 'employee' )
            {
                store = $( "#store_locations" ).val();
            }
            else if( role === 'store_manager' )
            {
                store = $( "#store_manage" ).val();
            }
            else if( role === 'senior_manager' )
            {
                store = '';
            }
            else if( role === 'multi_manager' )
            {
                store = $( "#multi_location" ).val();
            }
        }
        else
        {
            //store managers have their store done automatically for them
            store = $( '#new-user-submit' ).attr( "store" );
        }
        
        if( store == null )
        {
            store = '';
        }
        
        password_type = $("input[name='password_type']:checked").val();
        
        $('#password_1').each(function()
    	{
            newpassword = $(this).val();
        });
        
        $('#password_2').each(function()
    	{
            newpasswordconfirm = $(this).val();
        });
        
        //get our file data
        file_url = $( '#add-user-image' ).val();

        //now store the values
        var data = new FormData();

        data.append('action', 'fc_add_new_user');
        data.append('nonce', fc_nonce);
        data.append('role', role);
        data.append('username', username);
        data.append('displayname', displayname);
        data.append('firstname', firstname);
        data.append('lastname', lastname);
        data.append('email', email);
        data.append('dob', dob);
        data.append('store', store);
        data.append('password_type', password_type);
        data.append('file', file_url);

        if( password_type == 'create_password' )
        {
            data.append('newpassword', newpassword);
            
            data.append('newpasswordconfirm', newpasswordconfirm);
        }

        $.ajax({
    		type: 'POST',
            url: fc_ajax_url,
            contentType: false,
            processData: false,
            data: data,
            success: function(data) 
            {	
                if( data.success === false )
                {
                    if( data.data == 'empty_username' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Username</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_display_name' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Display Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_first_name' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_first_name"><strong>First Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_last_name' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_last_name"><strong>Last Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_email' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_email"><strong>Email Address</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_dob' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_dob"><strong>Date Of Birth</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_employee_store' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_store"><strong>Advisors Store Location</strong> is a required field.</li></ul></div>' );
                    }
                     if( data.data == 'empty_manager_store' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_store"><strong>Managers Store Locationn</strong> is a required field.</li></ul></div>' );
                    }
                     if( data.data == 'empty_multi_store' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_store"><strong>Multi Store Managers Locations</strong> are a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_image' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_dob"><strong>Profile Picture</strong> is required for the portal, please upload one.</li></ul></div>' );
                    }
                    if( data.data == 'empty_password' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="new_password_empty"><strong>New Password</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'passwords_dont_match' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-success" role="alert"><li data-id="passwords_dont_match"><strong>New Password and Confirm Password Don\'t Match</strong>, your account has not been created, please try again.</li></ul></div>' );
                    }
                    if( data.data == 'username_exists' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Username</strong> is already registered, please try again.</li></ul></div>' );
                    }
                    if( data.data == 'email_exists' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Email Address</strong> is already registered, please try again.</li></ul></div>' );
                    }
                    if( data.data == 'illegal_characters' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Illegal Characters Detected</strong> your IP address has been logged.</li></ul></div>' );
                    }
                    if( data.data == 'user_displayname_too_long' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Display Name Too Long</strong> Display name may not be longer than 50 characters..</li></ul></div>' );
                    }
                    
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
                else
                {
                    if( type = 'multi_manager' )
                    {
                        $("#delete-submit").attr("disabled", true);
                        $("#edit-save-account").attr("disabled", true);
            
                        //clear our edit form
                        $( '#multi_store_manage' ).val('').trigger('change');
                        $( '#eusers' ).empty();
                        $( '#editstore' ).hide();
                        
                        //clear our delete form
                        $( '#delete_multi_store_manage' ).val('').trigger('change');;
                        $( '#dusers' ).empty();
                        $( '#deleteselect' ).hide();
                    }
                    
                    get_edit_list();
                    get_delete_list();
                    
                    $( '#new-user-submit' )[0].reset();
                    
                    $( '#add-image-container' ).hide();
                    
                    if( type == 'senior_manager' )
                    {
                        $("#employee").prop('checked', true).trigger('change');
                    }

                    if( data.data == 'advisor_created' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Advisor was registered successfully.	</div></div>' );
                    }
                    if( data.data == 'senior_advisor_created' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Senior Advisor was registered successfully.	</div></div>' );
                    }
                    if( data.data == 'store_manager_created' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Store Manager was registered successfully.</div></div>' );
                    }
                    if( data.data == 'multi_manager_created' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Multi Store Manager was registered successfully.</div></div>' );
                    }
                    if( data.data == 'senior_manager_created' )
                    {
                        $( "#form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Senior Manager was registered successfully.</div></div>' );
                    }
                    
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            },
        });
        
        event.preventDefault();
    });
    
    $( "#manager-edit-details" ).submit(function( event ) 
    {
        //lets get our user type
        type = $( '#manager-edit-details' ).attr( "type" );
        
        role = $( '#manager-edit-details' ).attr( "role" );
        
        if(role == 'advisor' || role == 'senior_advisor')
        {
            advisor_role = $('#edit_advisor_type_select option:selected').val();
        }
        
        //lets get all the form values
        $('#edit_account_user_name').each(function()
    	{
            username = $(this).val();
        });
        
        $('#edit_account_display_name').each(function()
    	{
            displayname = $(this).val();
        });
        
        $('#edit_account_first_name').each(function()
    	{
            firstname = $(this).val();
        });
        
        $('#edit_account_last_name').each(function()
    	{
            lastname = $(this).val();
        });
        
        $('#edit_account_email').each(function()
    	{
            email = $(this).val();
        });
        
        $('#edit_date_of_birth').each(function()
    	{
            dob = $(this).val();
        });
        
        $('#edit_password_1').each(function()
    	{
            newpassword = $(this).val();
        });
        
        $('#edit_password_2').each(function()
    	{
            newpasswordconfirm = $(this).val();
        });
        
        user_id = $( '#user_id' ).val();
        
        file_url = $( '#edit-user-image' ).val();
        
        if( type == 'senior_manager' )
        {
            if( role === 'multi_manager' )
            {
                store = $( "#edit_store_multi" ).val();
            }
            else
            {
                store = $( '#manager-edit-details' ).attr( "store" );
            }
        }
        else
        {
            //store managers have their store done automatically for them
            store = $( '#manager-edit-details' ).attr( "store" );
        }

        //now store the values
        var data = {};
                            
        data['action'] = 'fc_manager_edit_details';
        data['nonce'] = fc_nonce;
        data['username'] = username;
        data['displayname'] = displayname;
        data['firstname'] = firstname;
        data['lastname'] = lastname;
        data['email'] = email;
        data['dob'] = dob;
        data['id'] = id;
        data['file'] = file_url;
        data['store'] = store;
        data['role'] = role;
        
        if(role == 'advisor' || role == 'senior_advisor')
        {
            if(role !== advisor_role)
            {
                //advisor has new role, lets send it
                data['advisor_role'] = advisor_role;
            }
        }
        
        //if these values are not empty the user chose a password
        if(newpassword !== '')
            data['newpassword'] = newpassword;
            
        if(newpasswordconfirm !== '')
            data['newpasswordconfirm'] = newpasswordconfirm;
            
        $.ajax({
    		type: 'POST',
            dataType: 'json',
            url: fc_ajax_url,
            data: data,
            success: function(data) 
            {	
                if( data.success === false )
                {
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    
                    if( data.data == 'empty_display_name' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_display_name"><strong>Display Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_first_name' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_first_name"><strong>First Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_last_name' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_last_name"><strong>Last Name</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_email' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_email"><strong>Email Address</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_dob' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_dob"><strong>Date Of Birth</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'empty_store' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="account_dob"><strong>Employee Store</strong> is a required field.</li></ul></div>' );
                    }
                    if( data.data == 'passwords_dont_match' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="passwords_dont_match"><strong>New Password and Confirm Password Don\'t Match</strong>, your password has not been changed, please try again.</li></ul></div>' );
                    }
                }
                else
                {
                    //reset form details
                    $( '#manager-edit-details' )[0].reset();
                    $( '#eusers' ).val('').trigger( 'change' );
                    $( '#edit_store_manage' ).val('').trigger( 'change' );
                    $('input[type=select]').prop('checked',false);
                    $('input[type=select]').prop('selected',false);
                    $("#edit-user-image").val( '' ).toggle('change');
                    $("#edit-image-preview").attr("src", '' );
                    
                    $( '#edit_store_location' ).hide();
                    $( '#edit_store_managed' ).hide();
                    $( '#edit_store_multiple' ).hide();
                    $( '#edit-image-container' ).hide();

                    if( data.data == 'user_update_success' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Employee details updated successfully.	</div></div>' );
                    }
                    if( data.data == 'password_update_success' )
                    {
                        $( "#edit-form-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Employee details and password updated successfully.	</div></div>' );
                    }
                    
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            },
        });
        
        event.preventDefault();
    });
    
    $( "#delete_user" ).submit(function( event ) 
    {
        type = $( '#delete_user' ).attr("type");

        //now store the values
        var data = {};
                            
        data['action'] = 'fc_delete_user';
        data['nonce'] = fc_nonce;
        data['id'] = id;
        data['type'] = type;
        
        $.ajax({
    		type: 'POST',
            dataType: 'json',
            url: fc_ajax_url,
            data: data,
            success: function(data) 
            {	
                if( type == 'multi_manager' )
                {
                    $("#delete-submit").attr("disabled", true);
                    $("#edit-save-account").attr("disabled", true);
        
                    //clear our edit form
                    $( '#multi_store_manage' ).val('').trigger('change');
                    $( '#eusers' ).empty();
                    $( '#editstore' ).hide();
                    
                    //clear our delete form
                    $( '#delete_multi_store_manage' ).val('').trigger('change');;
                    $( '#dusers' ).empty();
                    $( '#deleteselect' ).hide();
                }
                else
                {
                    get_edit_list();
                    get_delete_list();
                }
                
                $( '#delete_outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">' + data.data +' </div></div>' );
                
                $("html, body").animate({ scrollTop: 0 }, "slow");
            },
        });
        
        event.preventDefault();
    });
    
    function get_delete_list()
    {
        var data = {};
                            
        data['action'] = 'fc_get_user_select_list';
        data['nonce'] = fc_nonce;
        data['type'] = 'delete';

        $.ajax({
        	type: 'POST',
            dataType: 'html',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {	
                $( "#deleteselect" ).html( data );
                
                $("#dusers").select2(
    			{
    			    placeholder: 'Select a User to Delete',
                    width: '100%',
                });
                
                $( '#dusers' ).val('').trigger( 'change' );
            },
        });
    }
    
    function get_edit_list()
    {
        var data = {};
                            
        data['action'] = 'fc_get_user_select_list';
        data['nonce'] = fc_nonce;
        data['type'] = 'edit';

        $.ajax({
        	type: 'POST',
            dataType: 'html',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {	
                $( "#editselect" ).html( data );
                
                $("#eusers").select2(
    			{
    			    placeholder: "Select a User to Edit",
                    width: '100%',
                });
            },
        });
    }
    
    $( "#manager-sales-input-form" ).submit(function( event ) 
    {
        var submit = true;
        var error = false;

        //whats our users role
        var role = $( '#manager-sales-input-form' ).attr( "role" );
        
        //lets start by validating our form inputs
        
        //senior managers get to choose store, lets check its chosen
        if ( role == 'senior_manager' )
        {
            var store_location = $( ".store_locations" ).val();
            
            if ( store_location == '' )
            {
                $( '.store' ).html( '<p style="color:red;">Please set the Store before submitting Sales</p>').show();
                submit = false;
                error = true;
            }
            else
            {
                $( '.store' ).html( '' ).hide();
            }
        }
        
        if ( role !== 'senior_manager' )
        {
            var advisor_chosen = $( ".advisor option:selected" ).val();
            
            if ( advisor_chosen == '' && store_location !== '' )
            {
                $( '.choose_advisor_error' ).html( '<p style="color:red;">Please select the Advisor before submitting Sales</p>').show();
                submit = false;
                error = true;
            }
            else
            {
                $( '.choose_advisor_error' ).html( '' ).hide();
            }
        }
        
        $( '.type' ).each(function() 
        {
            if( $(this).val() == '')
            {
                $( '.type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                submit = false;
                error = true;
            }
            else
            {
                $( '.type-error' ).html( '' ).hide();
            }
        });
        
        $( '.product_type' ).each(function() 
        {
            if( $(this).val() == '')
            {
                $( '.product-type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                submit = false;
                error = true;
            }
            else
            {
                $( '.product-type-error' ).html( '' ).hide();
            }
        });
        
        if( ! $('.device').prop('disabled') )
        {
            $( '.device' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.device-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.device-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.discount-type').prop('disabled') )
        {
            $( '.discount-type' ).each(function() 
            {
                if( $(this).val() == '' )
                {
                    $( '.discount-type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.discount-type-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.product_discount').prop('disabled') )
        {
            $( '.product_discount' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.product-discount-left' ).html( '<p style="color:red;">Because you chose a discount, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.product-discount-left' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.product_discount_2').prop('disabled') )
        {
            $( '.product_discount_2' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.product-discount-2-left' ).html( '<p style="color:red;">Because you chose both discounts, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.product-discount-2-left' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.tariff_type_select').prop('disabled') )
        {
            $( '.tariff_type_select' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.tariff-type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.tariff-type-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.tariff').prop('disabled') )
        {
            $( '.tariff' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.tariff-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.tariff-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.broadband-tv-type').prop('disabled') )
        {
            $( '.broadband-tv-type' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.broadband-tv-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.broadband-tv-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.tariff-discount-type').prop('disabled') )
        {
            $( '.tariff-discount-type' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.tariff-discount-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.tariff-discount-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.accessories').prop('disabled') )
        {
            $( '.accessories' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.accessories-error' ).html( '<p style="color:red;">Because you chose an accessory, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.accessories-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.accessory_discount').prop('disabled') )
        {
            $( '.accessory_discount' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.accessory-discount-left' ).html( '<p style="color:red;">Because you chose the accessory discount, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.accessory-discount-left' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.insurance_type').prop('disabled') )
        {
            $( '.insurance_type' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.insurance-type-error' ).html( '<p style="color:red;">Because you chose the insurance option, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.insurance-type-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.insurance_choices').prop('disabled') )
        {
            $( '.insurance_choices' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.insurance-choice-error' ).html( '<p style="color:red;">Because you chose the insurance option, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.insurance-choice-error' ).html( '' ).hide();
                }
            });
        }
        
        if(error)
        {
            $( ".sales-errors" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="sales-input-errors">Please check your sales forms, you have not filled in all the required fields.</li></ul></div>' );
            $( ".sales-errors" ).show();
            
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
        else
        {
            $( ".sales-errors" ).html( '' );
            $( ".sales-errors" ).hide();
        }
        
        if( submit )
        {
            //lets get all the values for our ajax call
            
            //get our store
            var store = $( '#manager-sales-input-form' ).attr("store");
            
            //get our staff role
            var role = $( '#manager-sales-input-form' ).attr("role");
            
            var date = jQuery( "#sales_date" ).val();
            
            if( role== 'senior_manager' )
            {
                var advisor = $( '.advisor_name' ).val();
            }
            else
            {
                //get our advisor
                var advisor = $( '#manager-sales-input-form' ).attr("employee");
            }
            
            //get our sale ID
            var sale_id = $( '#manager-sales-input-form' ).attr("sale_id");
            
            //get our users role
            var role = $( '#manager-sales-input-form' ).attr( "role" );
            
            $('.type').each(function()
            {
                type = $(this).val();
            });
                
            $('.product_type').each(function()
            {
                product_type = $(this).val();
            });
            
            $('.device').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                device = $( option ).text();
            });
            
            $('.discount-type').each(function()
            {
                device_discount_type = $(this).val();
            });
            
            $('.product_discount').each(function()
            {
                device_discount = $(this).val();
            });
            
            if( device_discount_type == 'both' )
            {
                $('.product_discount_2').each(function()
                {
                    device_discount_2 = $(this).val();
                });
            }
            else
            {
                device_discount_2 = '';
            }
            
            $('.tariff_type_select').each(function()
            {
                tariff_type = $(this).val();
            });
                
            $('.tariff').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                tariff = $( option ).text();
            });
            
            $('.broadband-tv-type').each(function()
            {
                broadband_tv_type = $(this).val();
            });
            
            $('.tariff-discount-type').each(function()
            {
                tariff_discount_type = $(this).val();
            });
            
            if( tariff_discount_type == 'perk' || tariff_discount_type == 'compass' || tariff_discount_type == 'mrc' )
            {
                 $('.tariff_discount').each(function()
                {
                    tariff_discount = $(this).val();
                });
            }
            
            $('.accessory-radio:checked').each(function()
            {
                accessory_needed = $(this).val();
            });
            
            $('.accessories').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                accessory = $( option ).text();
            });
            
            $('.accessory-discount-radio:checked').each(function()
            {
                accessory_discount = $(this).val();
            });
            
            $('.accessory_discount').each(function()
            {
                accessory_discount_value = $(this).val();
            });
            
            $('.insurance-radio:checked').each(function()
            {
                insurance = $(this).val();
            });
            
            $('.insurance_type').each(function()
            {
                insurance_type = $(this).val();
            });
            
            $('.insurance_choices').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                insurance_choice = $( option ).text();
            });
            
            hrc = '';
            
            $('.hrc-radio:checked').each(function()
            {
                hrc = $(this).val();
            });
            
            if(hrc == '' )
            {
                hrc = 'no';
            }
            
            pobo = '';
            
            $('.pobo-radio:checked').each(function()
            {
                pobo = $(this).val();
            });
            
            if( pobo == '' )
            {
                pobo = 'no';
            }
            
            $('.pl').each(function()
            {
                profit_loss = $(this).val();
            });
            
            $('.ap').each(function()
            {
                accessory_profit = $(this).val();
            });
            
            $('.ap-old').each(function()
            {
                accessory_cost = $(this).val();
            });
            
            $('.inp').each(function()
            {
                insurance_profit = $(this).val();
            });
            
            $('.tp').each(function()
            {
                total_profit = $(this).val();
            });
            
            $('#sale_comment').each(function()
            {
                comment = $(this).val();
            });
    
            //now store the values
            var data = {};
            
            data['action'] = 'fc_manager_save_sales_inputs';
            data['nonce'] = fc_nonce;
            data['date'] = date;
            data['store'] = store;
            data['advisor'] = advisor;
            data['sale_id'] = sale_id;
            data['type'] = type;
            data['product_type'] = product_type;
            data['device'] = device;
            data['device_discount_type'] = device_discount_type;
            data['device_discount'] = device_discount;
            
            if( device_discount_2 !== '' )
            {
                data['device_discount_2'] = device_discount_2;
            }
            
            data['tariff_type'] = tariff_type;
            
            if( tariff_discount_type == 'perk' || tariff_discount_type == 'compass' || tariff_discount_type == 'mrc' )
            {
                data['tariff_discount'] = tariff_discount;
            }
            
            data['tariff'] = tariff;
            data['broadband_tv_type'] = broadband_tv_type;
            data['tariff_discount_type'] = tariff_discount_type;
            data['accessory_needed'] = accessory_needed;
            data['accessory'] = accessory;
            data['accessory_cost'] = accessory_cost;
            data['accessory_discount'] = accessory_discount;
            data['accessory_discount_value'] = accessory_discount_value;
            data['insurance'] = insurance;
            data['insurance_type'] = insurance_type;
            data['insurance_choice'] = insurance_choice;
            data['pobo'] = pobo;
            data['hrc'] = hrc;
            data['profit_loss'] = profit_loss;
            data['total_profit'] = total_profit;
            
            if( comment !== '' )
            {
                data['comment'] = comment;
            }
            
            if( accessory_profit !== '' )
            {
                data['accessory_profit'] = accessory_profit;
            }
            
            if( insurance_profit !== '' )
            {
                data['insurance_profit'] = insurance_profit;
            }
            
            if( sale_id !== '' )
            {
                data['approve_sale'] = 'yes';
            }

            $.ajax({
        		type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: data,
                success: function(data) 
                {	
                    if( data.data == 'sale_added' )
                    {
                        $( '.sales-outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Sale Added Successfully</div></div>' );
                        $( '.sales-outcome' ).show();
                        
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        
                        if( device_discount > 0 )
                        {
                            var discount_data = {};
                                
                            discount_data['action'] = 'fc_senior_get_discounts';
                            discount_data['nonce'] = fc_nonce;
                            discount_data['store'] = store;
                                            
                            jQuery.ajax({
                                type: 'POST',
                                dataType: 'json',
                                url: fc_ajax_url,
                                data: discount_data,
                                success: function( data ) 
                                {   
                                    rmdiscount = data.data.rm;
                                    frandiscount = data.data.fran;
                                                    
                                    jQuery( '.rm-discount-pot' ).show();
                                    jQuery( '.rm-discount' ).show();
                                    jQuery( '.rm-used' ).show();
                                    jQuery( '.fran-discount' ).show();
                                    jQuery( '.rm-discount-pot' ).html( data.data.rm_pot );
                                    jQuery( '.rm-used' ).html( data.data.rm_used );
                                    jQuery( '.rm-discount' ).html( data.data.rm_left );
                                    jQuery( '.fran-discount' ).html( data.data.fran_left );
                                },
                            });
                        }
                    }
                    if( data.data == 'sale_updated' )
                    {
                        $( '.sales-outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Sale Updated Successfully</div></div>' );
                        $( '.sales-outcome' ).show();
                        
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        
                        if( role == 'store_manager' || role == 'multi_manager' )
                        {
                            $("#manager-sales-input-form :input").prop("disabled", true);
                            $(".save-sales").html("Sale Approved");
                            $( '.approve-message' ).show();
                        }
                    }
                    
                    if( role == 'senior_manager' )
                    {
                        var data = {};
                                                        
                        data['action'] = 'fc_get_senior_sales';
                        data['nonce'] = fc_nonce;
                        data['store'] = store;
                        data['date'] = date;
            
            			jQuery.ajax({
            				type: 'POST',
            				url: fc_ajax_url,
            				data: data,
            				success: function( data ) 
            				{   
            					jQuery( '#sales' ).children( '.tab' ).remove();
            					sales = data.data;
            	
            					if( sales.length > 0 )
            					{
            						jQuery( '#manager-sales-input-form' ).attr( 'type' , 'existing' );
            						type = 'existing';
            	
            						//remove our sales message
            						jQuery( '.sales-message' ).hide();
            						jQuery( '.sales-message' ).text( '' );
            	
            						for( var i = 0; i < sales.length; i++ ) 
            						{
            							var obj = sales[i][0];
            	
            							var salenum = i + 1;
            							
            							if( role== 'senior_manager' )
                                        {
                                            var name = '';
        							
                							name += obj.advisor;
                
                                            if(obj.product_type == 'homebroadband') {
                                                name += '<br/>Home Broadband';
                                            } else if(obj.product_type == 'simonly') {
                                                name += '<br/>Sim Only';
                                            } else if(obj.product_type == 'handset') {
                                                name += '<br/>Handset';
                                            } else if(obj.product_type == 'tablet') {
                                                name += '<br/>Tablet';
                                            } else if(obj.product_type == 'connected') {
                                                name += '<br/>Connected';
                                            } else if(obj.product_type == 'accessory') {
                                                name += '<br/>Accessory';
                                            } else if(obj.product_type == 'insurance') {
                                                name += '<br/>Insurance';
                                            }
                                        } else {
                                            var name = '';
        
                                            if(obj.product_type == 'homebroadband') {
                                                name = 'Home Broadband';
                                            } else if(obj.product_type == 'simonly') {
                                                name = 'Sim Only';
                                            } else if(obj.product_type == 'handset') {
                                                name = 'Handset';
                                            } else if(obj.product_type == 'tablet') {
                                                name = 'Tablet';
                                            } else if(obj.product_type == 'connected') {
                                                name = 'Connected';
                                            } else if(obj.product_type == 'accessory') {
                                                name = 'Accessory';
                                            } else if(obj.product_type == 'insurance') {
                                                name = 'Insurance';
                                            }
                                        }
            	
            	
            							pill = '<li class="tab" id="tab"><a  id="' + obj.id + '" data-toggle="pill" href="">' + name + '</a></li>';
            	
            							jQuery( pill ).insertBefore( "#plustab" );
            	
            							if( salenum > 0 )
            							{
            								jQuery( '#minustab' ).show();
            							}
            							else
            							{
            								jQuery( '#minustab' ).hide();
            							}
            						}
            	
            						//activate our clone functions
            						clone_elements();
            	
            						//remove our disabled class
            						jQuery( '#plustab' ).removeClass( 'disabled' );
            						jQuery( '#minustab' ).removeClass( 'disabled' );
            	
            						//show our plus tab
            						jQuery( '#plustab' ).show();
            	
            						//get our first sale
            						var first_sale = jQuery('ul#sales li:first');
            	
            						//add our active class
            	
            						first_sale.addClass( 'active' );
            	
            						var first_id = jQuery('ul#sales li:first a').attr('id');
            						
            						get_sale( first_id );
            					}
            					else
            					{
            						no_sales();
            					}
            				},
            			});
                    }
                    else
                    {
                        var action = $( '#manager-sales-input-form' ).attr("action");
                        
                        var sdata = {};
                        
                        sdata['action'] = 'fc_get_sales_info';
                        sdata['nonce'] = fc_nonce;
                        sdata['advisor'] = advisor;
                        sdata['date'] = date;
                        sdata['type'] = action;
                        
                        $.ajax({
                            type: 'POST',
                            url: fc_ajax_url,
                            data: sdata,
                            success: function( data ) 
                            {   
                                jQuery( '#sales' ).children( '.tab' ).remove();
                                var sales = data.data;
                                $( '#manager-sales-input-form' ).attr( "updated" , 'yes' );
                                
                                $('ul#sales li').not('li:nth-last-child(1) , li:nth-last-child(2)').remove();
                                
                                if( sales.length > 0 )
                                {
                                    //remove our sales message
                                    $( '.sales-message' ).hide();
                                    $( '.sales-message' ).text( '' );
                                    
                                    for( var i = 0; i < sales.length; i++ ) 
                                    {
                                        var obj = sales[i][0];
                                        
                                        var salenum = i + 1;
                                        
                                        var name = '';
        
                                        if(obj.product_type == 'homebroadband') {
                                            name = 'Home Broadband';
                                        } else if(obj.product_type == 'simonly') {
                                            name = 'Sim Only';
                                        } else if(obj.product_type == 'handset') {
                                            name = 'Handset';
                                        } else if(obj.product_type == 'tablet') {
                                            name = 'Tablet';
                                        } else if(obj.product_type == 'connected') {
                                            name = 'Connected';
                                        } else if(obj.product_type == 'accessory') {
                                            name = 'Accessory';
                                        } else if(obj.product_type == 'insurance') {
                                            name = 'Insurance';
                                        }
                    
                                        pill = '<li class="tab" id="tab"><a  id="' + obj.id + '" data-toggle="pill" href="">' + name + '</a></li>';
                                    
                                        $( pill ).insertBefore( "#plustab" );
                                        
                                        if( salenum > 0 )
                                        {
                                            $( '#minustab' ).show();
                                        }
                                        else
                                        {
                                            $( '#minustab' ).hide();
                                        }
                                    }
                                    
                                    //activate our clone functions
                                    clone_elements();
                                    
                                    //remove our disabled class
                                    $( '#plustab' ).removeClass( 'disabled' );
                                    $( '#minustab' ).removeClass( 'disabled' );
                                    
                                    //show our plus tab
                                    $( '#plustab' ).show();
                                    
                                    //get our first sale
                                    var first_sale = $('ul#sales li:first');
                                    
                                    //add our active class
                                    
                                    first_sale.addClass( 'active' );
                                    
                                    var first_id = $('ul#sales li:first a').attr('id');
                                    
                                    get_sale( first_id );
                                }
                                else
                                {
                                    jQuery( '#sales_date' ).trigger('change');
                                }
                            },
                        });
                    }
                },
            });
        }
        
        event.preventDefault();
    });
    
    $( "#staff-sales-input-form" ).submit(function( event ) 
    {
        var submit = true;
        var error = false;
        var count = 0;

        //whats our users role
        var role = $( '#staff-sales-input-form' ).attr( "role" );
        
        //lets start by validating our form inputs

        $( '.type' ).each(function() 
        {
            if( $(this).val() == '')
            {
                $( '.type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                submit = false;
                error = true;
            }
            else
            {
                $( '.type-error' ).html( '' ).hide();
            }
        });
        
        $( '.product_type' ).each(function() 
        {
            if( $(this).val() == '')
            {
                $( '.product-type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                submit = false;
                error = true;
            }
            else
            {
                $( '.product-type-error' ).html( '' ).hide();
            }
        });
        
        if( ! $('.device').prop('disabled') )
        {
            $( '.device' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.device-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.device-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.discount-type').prop('disabled') )
        {
            $( '.discount-type' ).each(function() 
            {
                if( $(this).val() == '' )
                {
                    $( '.discount-type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.discount-type-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.product_discount').prop('disabled') )
        {
            $( '.product_discount' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.product-discount-left' ).html( '<p style="color:red;">Because you chose a discount, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.product-discount-left' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.product_discount_2').prop('disabled') )
        {
            $( '.product_discount_2' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.product-discount-2-left' ).html( '<p style="color:red;">Because you chose both discounts, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.product-discount-2-left' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.tariff_type_select').prop('disabled') )
        {
            $( '.tariff_type_select' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.tariff-type-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.tariff-type-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.tariff').prop('disabled') )
        {
            $( '.tariff' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.tariff-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.tariff-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.broadband-tv-type').prop('disabled') )
        {
            $( '.broadband-tv-type' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.broadband-tv-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.broadband-tv-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.tariff-discount-type').prop('disabled') )
        {
            $( '.tariff-discount-type' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.tariff-discount-error' ).html( '<p style="color:red;">This is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.tariff-discount-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.accessories').prop('disabled') )
        {
            $( '.accessories' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.accessories-error' ).html( '<p style="color:red;">Because you chose an accessory, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.accessories-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.accessory_discount').prop('disabled') )
        {
            $( '.accessory_discount' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.accessory-discount-left' ).html( '<p style="color:red;">Because you chose the accessory discount, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.accessory-discount-left' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.insurance_type').prop('disabled') )
        {
            $( '.insurance_type' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.insurance-type-error' ).html( '<p style="color:red;">Because you chose the insurance option, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.insurance-type-error' ).html( '' ).hide();
                }
            });
        }
        
        if( ! $('.insurance_choices').prop('disabled') )
        {
            $( '.insurance_choices' ).each(function() 
            {
                if( $(this).val() == '')
                {
                    $( '.insurance-choice-error' ).html( '<p style="color:red;">Because you chose the insurance option, this is a required field</p>').show();
                    submit = false;
                    error = true;
                }
                else
                {
                    $( '.insurance-choice-error' ).html( '' ).hide();
                }
            });
        }
        
        if(error)
        {
            $( ".sales-errors" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="sales-input-errors">Please check your sales forms, you have not filled in all the required fields.</li></ul></div>' );
            $( ".sales-errors" ).show();
            
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
        else
        {
            $( ".sales-errors" ).html( '' );
            $( ".sales-errors" ).hide();
        }
        
        if( submit )
        {
            //lets get all the values for our ajax call
            var store = $( '#staff-sales-input-form' ).attr("store");
            
            var date = $( '#staff-sales-input-form' ).attr("date");
            
            //get our advisor from the advisor attribute
            var advisor = $( '#staff-sales-input-form' ).attr("employee");
            
            //Get our next sale number
            var sale = $( '#staff-sales-input-form' ).attr("sale");
            
            $('.type').each(function()
            {
                type = $(this).val();
            });
            
            $('.product_type').each(function()
            {
                product_type = $(this).val();
            });
            
            $('.device').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                device = $( option ).text();
            });
            
            $('.discount-type').each(function()
            {
                device_discount_type = $(this).val();
            });
            
            $('.product_discount').each(function()
            {
                device_discount = $(this).val();
            });
            
            if( device_discount_type == 'both' )
            {
                $('.product_discount_2').each(function()
                {
                    device_discount_2 = $(this).val();
                });
            }
            else
            {
                device_discount_2 = '';
            }
            
            $('.tariff_type_select').each(function()
            {
                tariff_type = $(this).val();
            });
            
            $('.tariff').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                tariff = $( option ).text();
            });
            
            $('.broadband-tv-type').each(function()
            {
                broadband_tv_type = $(this).val();
            });
            
            $('.tariff-discount-type').each(function()
            {
                tariff_discount_type = $(this).val();
            });
            
            if( tariff_discount_type == 'perk' || tariff_discount_type == 'compass' || tariff_discount_type == 'mrc' )
            {
                 $('.tariff_discount').each(function()
                {
                    tariff_discount = $(this).val();
                });
            }
            
            $('.accessory-radio:checked').each(function()
            {
                accessory_needed = $(this).val();
            });
            
            $('.accessories').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                accessory = $( option ).text();
            });
            
            $('.accessory-discount-radio:checked').each(function()
            {
                accessory_discount = $(this).val();
            });
            
            $('.accessory_discount').each(function()
            {
                accessory_discount_value = $(this).val();
            });
            
            $('.insurance-radio:checked').each(function()
            {
                insurance = $(this).val();
            });
            
            $('.insurance_type').each(function()
            {
                insurance_type = $(this).val();
            });
            
            $('.insurance_choices').each(function()
            {
                var option = $( this ).find('option:selected');
            	    
                insurance_choice = $( option ).text();
            });
            
             hrc = '';
            
            $('.hrc-radio:checked').each(function()
            {
                hrc = $(this).val();
            });
            
            if(hrc == '' )
            {
                hrc = 'no';
            }
            
            pobo = '';
            
            $('.pobo-radio:checked').each(function()
            {
                pobo = $(this).val();
            });
            
            if( pobo == '' )
            {
                pobo = 'no';
            }
            
            $('.pl').each(function()
            {
                profit_loss = $(this).val();
            });
            
            $('.ap').each(function()
            {
                accessory_profit = $(this).val();
            });
            
            $('.ap-old').each(function()
            {
                accessory_cost = $(this).val();
            });
            
            $('.inp').each(function()
            {
                insurance_profit = $(this).val();
            });
            
            $('.tp').each(function()
            {
                total_profit = $(this).val();
            });
    
            //now store the values
            var data = {};
            
            data['action'] = 'fc_staff_save_sales_inputs';
            data['nonce'] = fc_nonce;
            data['date'] = date;
            data['store'] = store;
            data['sale'] = sale;
            data['advisor'] = advisor;
            data['type'] = type;
            data['product_type'] = product_type;
            data['device'] = device;
            data['device_discount_type'] = device_discount_type;
            data['device_discount'] = device_discount;
            
            if( device_discount_2 !== '' )
            {
                data['device_discount_2'] = device_discount_2;
            }
            
            data['tariff_type'] = tariff_type;
            data['tariff'] = tariff;
            data['broadband_tv_type'] = broadband_tv_type;
            data['tariff_discount_type'] = tariff_discount_type;
            
            if( tariff_discount_type == 'perk' || tariff_discount_type == 'compass' || tariff_discount_type == 'mrc' )
            {
                data['tariff_discount'] = tariff_discount;
            }
            
            data['accessory_needed'] = accessory_needed;
            data['accessory'] = accessory;
            data['accessory_cost'] = accessory_cost;
            data['accessory_discount'] = accessory_discount;
            data['accessory_discount_value'] = accessory_discount_value;
            data['insurance'] = insurance;
            data['insurance_type'] = insurance_type;
            data['insurance_choice'] = insurance_choice;
            data['pobo'] = pobo;
            data['hrc'] = hrc;
            data['profit_loss'] = profit_loss;
            data['total_profit'] = total_profit;
            
            if( accessory_profit !== '' )
            {
                data['accessory_profit'] = accessory_profit;
            }
            if( insurance_profit !== '' )
            {
                data['insurance_profit'] = insurance_profit;
            }

            $.ajax({
        		type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: data,
                success: function(data) 
                {	
                    get_next_sale();
                    
                    if( data.data == 'sale_added' )
                    {
                        $( ".sales-errors" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Sale Added Successfully</div></div>' );
                        $( ".sales-errors" ).show();
                        
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        
                        setTimeout( "location.href = 'https://www.familyconnectgroup.co.uk/portal/sales-input/';", 0 );
                    }
                },
            });
        }
        
        event.preventDefault();
        
        function get_next_sale()
        {
            var employee = $( '#staff-sales-input-form' ).attr("employee");
                
            var data = {};
                
            data['action'] = 'fc_get_next_sale';
            data['nonce'] = fc_nonce;
            data['employee'] = employee;
    
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: data,
                success: function(data) 
                {	
                    $( '#staff-sales-input-form' ).attr( "sale" , data.data );
                },
            });
        }
    });
    
    $( "#save-footfall-form" ).submit(function( event ) 
    {
        var submit = true;

        //whats our users role
        var role = $( '#save-footfall-form' ).attr( "role" );
        
        var footfall = $( '#store_footfall').val();
        
        //senior managers get to choose store, lets check its chosen
        if ( role == 'senior_manager' || role == 'multi_manager' )
        {
            var store_location = $( ".store_locations" ).val();
            
            if ( store_location == '' )
            {
                $( '.store' ).html( '<p style="color:red;">Please set the Store before submitting the footfall</p>').show();
                submit = false;
            }
            else
            {
                $( '.store' ).html( '' ).hide();
            }
        }
        
        if( footfall == '' )
        {
            $( '#footfall_outcome' ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="footfall_store">Footfall value cannot be empty</li></ul></div>' );
                
            submit = false;
        }
        else
        {
            $( '#footfall_outcome' ).empty();
        }
        
        if( submit )
        {
            var store = $( '#save-footfall-form' ).attr("store");
            
            var footfall_id = $( '#save-footfall-form' ).attr("footfall-id");
            
            var store = $( '#save-footfall-form' ).attr("store");
            
            var month = $( '#save-footfall-form' ).attr("month");
            
            var year= $( '#save-footfall-form' ).attr("year")
            
            var data = {};
                
            data['action'] = 'fc_save_store_footfall';
            data['nonce'] = fc_nonce;
            data['store'] = store;
            data['footfall'] = footfall;
            data['footfall_id'] = footfall_id;
            data['month'] = month;
            data['year'] = year;
                
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: data,
                success: function(data) 
                {	
                    $( '#store_footfall' ).prop('readonly', true);
                    $( '#edit-footfall' ).show();
                    
                    if( data.data == 'updated' )
                    {
                        $( '#footfall_outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Footfall Edited Successfully</div></div>' );
                    }
                    else
                    {
                        $( '#save-footfall-form' ).attr( "footfall-id" , data.data );
                        
                        $( '#footfall_outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Footfall Added Successfully</div></div>' );
                    }
                },
            });
        }
        
       event.preventDefault();
    });
            
    $( "#edit-footfall" ).click(function( event ) 
    {
        $( '#store_footfall' ).prop('readonly', false);
        $( '#edit-footfall' ).hide();
        event.preventDefault();
    });
            
    if ( $( '#store_footfall' ).is('[readonly]') ) 
    { 
        $( '#edit-footfall' ).show();
    }
    else
    {
        $( '#edit-footfall' ).hide();
    }
    
    $( "#save-kpi-form" ).submit(function( event ) 
    {
        var submit = true;

        //whats our users role
        var role = $( '#save-kpi-form' ).attr( "role" );
        
        var kpi = $( '#store_kpi').val();
        
        //senior managers get to choose store, lets check its chosen
        if ( role == 'senior_manager' || role == 'multi_manager' )
        {
            var store_location = $( ".store_locations" ).val();
            
            if ( store_location == '' )
            {
                $( '.store' ).html( '<p style="color:red;">Please set the Store before submitting the KPI</p>').show();
                submit = false;
            }
            else
            {
                $( '.store' ).html( '' ).hide();
            }
        }
        
        if( kpi == '' )
        {
            $( '#footfall_outcome' ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="footfall_store">KPI value cannot be empty</li></ul></div>' );
                
            submit = false;
        }
        else
        {
            $( '#footfall_outcome' ).empty();
        }
        
        if( submit )
        {
            var store = $( '#save-kpi-form' ).attr("store");
            
            var kpi_id = $( '#save-kpi-form' ).attr("kpi-id");
            
            var store = $( '#save-kpi-form' ).attr("store");
            
            var month = $( '#save-kpi-form' ).attr("month");
            
            var year= $( '#save-kpi-form' ).attr("year")
            
            var data = {};
                
            data['action'] = 'fc_save_store_kpi';
            data['nonce'] = fc_nonce;
            data['store'] = store;
            data['kpi'] = kpi;
            data['kpi_id'] = kpi_id;
            data['month'] = month;
            data['year'] = year;
                
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: data,
                success: function(data) 
                {	
                    $( '#store_kpi' ).prop('readonly', true);
                    $( '#edit-kpi' ).show();
                    
                    if( data.data == 'updated' )
                    {
                        $( '#footfall_outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">KPI Edited Successfully</div></div>' );
                    }
                    else
                    {
                        $( '#save-footfall-form' ).attr( "footfall-id" , data.data );
                        
                        $( '#footfall_outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">KPI Added Successfully</div></div>' );
                    }
                },
            });
        }
        
       event.preventDefault();
    });
    
    $( "#save-nps-form" ).submit(function( event ) 
    {
        var submit = true;

        //whats our users role
        var role = $( '#save-nps-form' ).attr( "role" );
        
        var nps = $( '#advisor_nps').val();
        
        if( nps == '' )
        {
            $( '#nps_outcome' ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="footfall_store">NPS value cannot be empty</li></ul></div>' );
                
            submit = false;
        }
        else
        {
            $( '#nps_outcome' ).empty();
        }
        
        if( submit )
        {
            var advisor = $( '.advisor' ).val();
            
            var month = $( '#save-nps-form' ).attr("month");
            
            var year= $( '#save-nps-form' ).attr("year")
            
            var data = {};
                
            data['action'] = 'fc_save_employee_nps';
            data['nonce'] = fc_nonce;
            data['advisor'] = advisor;
            data['nps'] = nps;
            data['month'] = month;
            data['year'] = year;
                
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: data,
                success: function(data) 
                {	
                    $( '#employee_nps' ).prop('readonly', true);
                    $( '#edit-nps' ).show();
                    
                    if( data.data == 'updated' )
                    {
                        $( '#nps_outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">NPS Edited Successfully</div></div>' );
                    }
                    else
                    {
                        $( '#nps_outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">NPS Added Successfully</div></div>' );
                    }
                },
            });
        }
        
       event.preventDefault();
    });
            
    $( "#edit-kpi" ).click(function( event ) 
    {
        $( '#store_kpi' ).prop('readonly', false);
        $( '#edit-kpi' ).hide();
        event.preventDefault();
    });
            
    if ( $( '#store_footfall' ).is('[readonly]') ) 
    { 
        $( '#edit-kpi' ).show();
    }
    else
    {
        $( '#edit-kpi' ).hide();
    }
    
    $( document ).ready(function() {
        $('.stores').val('');
    });
} ) ( jQuery );