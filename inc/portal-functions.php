<?php

//add our ajax endpoints

//user edit details
add_action("wp_ajax_fc_save_account_details", "save_employee_details");
add_action("wp_ajax_nopriv_fc_save_account_details", "redirect_to_login");

//manager add user
add_action("wp_ajax_fc_add_new_user", "manager_add_user");
add_action("wp_ajax_nopriv_fc_add_new_user", "redirect_to_login");

//manager edit user
add_action("wp_ajax_fc_manager_edit_details", "manager_edit_user");
add_action("wp_ajax_nopriv_fc_manager_edit_details", "redirect_to_login");

//manager delete user
add_action("wp_ajax_fc_delete_user", "manager_delete_user");
add_action("wp_ajax_nopriv_fc_delete_user", "redirect_to_login");

//Multi manager store select
add_action("wp_ajax_fc_get_multi_users", "multi_users_list");
add_action("wp_ajax_nopriv_fc_get_multi_users", "redirect_to_login");

add_action("wp_ajax_fc_get_commission_users", "commission_users_list");
add_action("wp_ajax_nopriv_fc_get_commission_users", "redirect_to_login");

//return user's details on ID
add_action("wp_ajax_fc_get_edit_user", "return_user_object");
add_action("wp_ajax_nopriv_fc_get_edit_user", "redirect_to_login");

//get our update users iist after adding. or deleting user
add_action("wp_ajax_fc_get_user_select_list", "return_user_select_list");
add_action("wp_ajax_nopriv_fc_get_user_select_list", "redirect_to_login");

//get our update users iist after adding. or deleting user
add_action("wp_ajax_fc_upload_csv", "import_csv_to_db");
add_action("wp_ajax_nopriv_fc_upload_csv", "redirect_to_login");

//get our profit info
add_action("wp_ajax_fc_get_accessory_profit", "accessory_profit");
add_action("wp_ajax_nopriv_fc_get_accessory_profit", "redirect_to_login");

add_action("wp_ajax_fc_get_tariff_profit", "tariff_profit");
add_action("wp_ajax_nopriv_fc_get_tariff_profit", "redirect_to_login");

add_action("wp_ajax_fc_get_handset_cost", "handset_cost");
add_action("wp_ajax_nopriv_fc_get_handset_cost", "redirect_to_login");

//get our store staff for sales form
add_action("wp_ajax_fc_senior_get_sales_staff", "get_sales_staff");
add_action("wp_ajax_nopriv_fc_senior_get_sales_staff", "redirect_to_login");

add_action("wp_ajax_fc_senior_get_approved_staff", "get_approved_staff");
add_action("wp_ajax_nopriv_fc_senior_get_approved_staff", "redirect_to_login");

add_action("wp_ajax_fc_senior_get_review_staff", "get_review_staff");
add_action("wp_ajax_nopriv_fc_senior_get_review_staff", "redirect_to_login");

//save our sales information
add_action("wp_ajax_fc_manager_save_sales_inputs", "manager_save_sales_inputs");
add_action("wp_ajax_nopriv_fc_manager_save_sales_inputs", "redirect_to_login");

add_action("wp_ajax_fc_staff_save_sales_inputs", "staff_save_sales_inputs");
add_action("wp_ajax_nopriv_fc_staff_save_sales_inputs", "redirect_to_login");

//get our next sale number
add_action("wp_ajax_fc_get_next_sale", "get_next_sale");
add_action("wp_ajax_nopriv_fc_get_next_sale", "redirect_to_login");

//get our sales info for managers
add_action("wp_ajax_fc_get_sales_info", "get_sales_info");
add_action("wp_ajax_nopriv_fc_get_sales_info", "redirect_to_login");

add_action("wp_ajax_fc_get_senior_sales", "get_senior_sales_info");
add_action("wp_ajax_nopriv_fc_get_senior_sales", "redirect_to_login");

//return back the up to date sales info
add_action("wp_ajax_fc_get_sale", "get_sale");
add_action("wp_ajax_nopriv_fc_get_sale", "redirect_to_login");

add_action("wp_ajax_fc_get_unapproved_info", "get_unapproved_info");
add_action("wp_ajax_nopriv_fc_get_unapproved_info", "redirect_to_login");

add_action("wp_ajax_fc_delete_sale", "delete_sale");
add_action("wp_ajax_nopriv_fc_delete_sale", "redirect_to_login");

//get our store profits for multi and senior managers
add_action("wp_ajax_fc_senior_get_profit", "get_profit_info");
add_action("wp_ajax_nopriv_fc_senior_get_profit", "redirect_to_login");

//save our store footfall
add_action("wp_ajax_fc_save_store_footfall", "save_store_footfall");
add_action("wp_ajax_nopriv_fc_save_store_footfall", "redirect_to_login");

//get our store footfall
add_action("wp_ajax_fc_senior_get_footfall", "get_store_footfall");
add_action("wp_ajax_nopriv_fc_senior_get_footfall", "redirect_to_login");

add_action("wp_ajax_fc_get_footfall", "get_store_footfall");
add_action("wp_ajax_nopriv_fc_get_footfall", "redirect_to_login");

//save our store kpi
add_action("wp_ajax_fc_save_store_kpi", "save_store_kpi");
add_action("wp_ajax_nopriv_fc_save_store_kpi", "redirect_to_login");

//get our KPi Target
add_action("wp_ajax_fc_senior_get_kpi", "get_store_kpi");
add_action("wp_ajax_nopriv_fc_senior_get_kpi", "redirect_to_login");

add_action("wp_ajax_fc_get_kpi", "get_store_kpi");
add_action("wp_ajax_nopriv_fc_get_kpi", "redirect_to_login");

//save our employee nps
add_action("wp_ajax_fc_save_employee_nps", "save_employee_nps");
add_action("wp_ajax_nopriv_fc_save_employee_nps", "redirect_to_login");

//get our NPS Target
add_action("wp_ajax_fc_get_advisor_nps", "get_employee_nps");
add_action("wp_ajax_nopriv_fc_get_advisor_nps", "redirect_to_login");

//get our NPS Target
add_action("wp_ajax_fc_get_store_nps", "get_store_nps");
add_action("wp_ajax_nopriv_fc_get_store_nps", "redirect_to_login");

//override our commission info
add_action("wp_ajax_fc_override_commissions", "override_commission_info");
add_action("wp_ajax_nopriv_fc_override_commissions", "redirect_to_login");

//remove our overrides
add_action("wp_ajax_fc_remove_override", "remove_commission_override");
add_action("wp_ajax_nopriv_fc_remove_override", "redirect_to_login");

//get our hours info
add_action("wp_ajax_fc_multi_get_rota", "get_hours_rota");
add_action("wp_ajax_nopriv_fc_multi_get_rota", "redirect_to_login");

//add our hours info
add_action("wp_ajax_fc_save_hours", "save_rota_hours");
add_action("wp_ajax_nopriv_fc_save_hours", "redirect_to_login");

//save our store targets
add_action("wp_ajax_fc_save_targets", "save_store_targets");
add_action("wp_ajax_nopriv_fc_save_targets", "redirect_to_login");

//save our sales multipliers
add_action("wp_ajax_fc_save_multipliers", "save_sales_multipliers");
add_action("wp_ajax_nopriv_fc_save_multipliers", "redirect_to_login");

//save our banking info
add_action("wp_ajax_fc_save_banking", "save_banking_information");
add_action("wp_ajax_nopriv_fc_save_banking", "redirect_to_login");

//get our banking information
add_action("wp_ajax_fc_get_banking_info", "get_banking_information");
add_action("wp_ajax_nopriv_fc_save_banking", "redirect_to_login");

//get our discount pots for our senior staff
add_action("wp_ajax_fc_senior_get_discounts", "get_discount_pots");
add_action("wp_ajax_nopriv_fc_senior_get_discounts", "redirect_to_login");

add_action("wp_ajax_fc_get_discount_pot_table", "get_discount_pot_table");
add_action("wp_ajax_nopriv_fc_get_discount_pot_table", "redirect_to_login");

//delete our assets from database
add_action("wp_ajax_fc_delete_asset", "delete_assets");
add_action("wp_ajax_nopriv_fc_delete_asset", "redirect_to_login");

//download our assets from database
if ( isset($_GET['action'] ) && $_GET['action'] == 'download_devices_csv' )  {
	// Handle CSV Export
	add_action( 'init', 'device_csv_export' );
}
elseif ( isset($_GET['action'] ) && $_GET['action'] == 'download_tariffs_csv' )  {
	// Handle CSV Export
	add_action( 'init', 'tariff_csv_export' );
}
elseif ( isset($_GET['action'] ) && $_GET['action'] == 'download_accessories_csv' )  {
	// Handle CSV Export
	add_action( 'init', 'accessory_csv_export' );
}

//delete all our assets from database
add_action("wp_ajax_fc_delete_all_assets", "delete_all_assets");
add_action("wp_ajax_nopriv_fc_delete_all_assets", "redirect_to_login");

//get our store profit info
add_action("wp_ajax_fc_get_store_information", "get_store_information");
add_action("wp_ajax_nopriv_fc_get_store_information", "redirect_to_login");

//get our store commission info
add_action("wp_ajax_fc_get_store_commission", "get_store_commission");
add_action("wp_ajax_nopriv_fc_get_store_commission", "redirect_to_login");

//get our reports
add_action("wp_ajax_fc_get_daily_chart", "get_daily_chart");
add_action("wp_ajax_nopriv_fc_get_daily_chart", "redirect_to_login");

add_action("wp_ajax_fc_get_employee_daily_chart", "get_employee_daily_chart");
add_action("wp_ajax_nopriv_fc_get_employee_daily_chart", "redirect_to_login");

//get our employee daily sales
add_action("wp_ajax_fc_get_employee_daily_sales", "get_employee_daily_sales");
add_action("wp_ajax_nopriv_fc_get_employee_daily_sales", "redirect_to_login");

add_action("wp_ajax_fc_get_monthly_chart", "get_monthly_chart");
add_action("wp_ajax_nopriv_fc_get_monthly_chart", "redirect_to_login");

add_action("wp_ajax_fc_get_average_profits", "get_average_profits");
add_action("wp_ajax_nopriv_fc_get_average_profits", "redirect_to_login");

add_action("wp_ajax_fc_get_staff_average_profits", "get_staff_average_profits");
add_action("wp_ajax_nopriv_fc_get_staff_average_profits", "redirect_to_login");

//get our cover staff
add_action("wp_ajax_fc_senior_get_cover_staff", "get_cover_staff");
add_action("wp_ajax_nopriv_fc_senior_get_cover_staff", "redirect_to_login");

//check cover staff
add_action("wp_ajax_fc_senior_get_cover_info", "get_cover_info");
add_action("wp_ajax_nopriv_fc_senior_get_cover_info", "redirect_to_login");

//save our store cover
add_action("wp_ajax_fc_save_store_cover", "save_staff_cover");
add_action("wp_ajax_nopriv_fc_save_store_cover", "redirect_to_login");

//save our store cover
add_action("wp_ajax_fc_delete_store_cover", "delete_staff_cover");
add_action("wp_ajax_nopriv_fc_delete_store_cover", "redirect_to_login");

//get our staff review info
add_action("wp_ajax_fc_senior_get_staff_review", "get_staff_review");
add_action("wp_ajax_nopriv_fc_senior_get_staff_review", "redirect_to_login");

//get our unapproved sales info
add_action("wp_ajax_fc_get_unapproved_sales_info", "get_unapproved_Sales_info");
add_action("wp_ajax_nopriv_fc_get_unapproved_sales_info", "redirect_to_login");

add_action("wp_ajax_fc_search_sales", "get_sales_search");
add_action("wp_ajax_nopriv_fc_search_sales", "redirect_to_login");

add_action("wp_ajax_fc_senior_manage_sales", "manage_sales");
add_action("wp_ajax_nopriv_fc_senior_manage_sales", "redirect_to_login");

add_action("wp_ajax_fc_senior_manage_month_sales", "manage_month_sales");
add_action("wp_ajax_nopriv_fc_senior_manage_month_sales", "redirect_to_login");

add_action("wp_ajax_fc_generate_sales_report", "generate_sales_report");
add_action("wp_ajax_nopriv_fc_generate_sales_report", "redirect_to_login");

function redirect_to_login()
{
    wp_safe_redirect( 'https://www.familyconnectgroup.co.uk/login' );
    exit;
}

function save_employee_details()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $current_user;
    get_currentuserinfo();
    
    $data     = array();
	$error = array();
	$passwordchange = false;
	
	$data = $_POST;
	
	$dname   = ! empty( $data[ 'displayname' ] ) ? $data[ 'displayname' ] : '';
	$fname   = ! empty( $data[ 'firstname' ] ) ? $data[ 'firstname' ] : '';
	$lname   = ! empty( $data[ 'lastname' ] ) ? $data[ 'lastname' ] : '';
	$email   = ! empty( $data[ 'email' ] ) ? $data[ 'email' ] : '';
	$dob  = ! empty( $data[ 'dob' ] ) ? $data[ 'dob' ] : '';
	$currentpassword   = ! empty( $data[ 'currentpassword' ] ) ? $data[ 'currentpassword' ] : '';
	$password = ! empty( $data[ 'newpassword' ] ) ? $data[ 'newpassword' ] : '';
	$confirmpass = ! empty( $data[ 'newpasswordconfirm' ] ) ? $data[ 'newpasswordconfirm' ] : '';
	
	//now we have details lets run some error checking before proceeding
	
	//check all our required fields are entered
	
	if( $dname == '' )
	{
	    wp_send_json_error( 'empty_display_name' );
	}
	
	if( $fname == '' )
	{
	    wp_send_json_error( 'empty_first_name' );
	}
	
	if( $lname == '' )
	{
	    wp_send_json_error( 'empty_last_name' );
	}
	
	if( $email == '' )
	{
	    wp_send_json_error( 'empty_email' );
	}
	
	if( $dob == '' )
	{
	    wp_send_json_error( 'empty_dob' );
	}
	
	//all fields are entered, check email is not registered
	
	//get our current registered email
	$registeredEmail = $current_user->user_email;
	
	//if submitted email is not the same as registered email, check email is not already used, return error if it is.
	if( $email !== $registeredEmail )
	{
	    $exists = email_exists( $email );
	
    	if( $exists )
    	{
    	    wp_send_json_error( 'email_exists' );
    	}
	}
	
	//if current password is entered, lets check its correct
	if( $currentpassword  !== '' )
	{
	    if ( ! wp_check_password( $currentpassword, $current_user->data->user_pass, $current_user->ID ) ) 
	    {
            wp_send_json_error( 'current_password_wrong' );
        }
        
        //current password is correct, lets check the new passwords match
    	if( $password !== $confirmpass )
    	{
    	    wp_send_json_error( 'passwords_dont_match' );
    	}
    	
    	if ( $password !== '' )
    	{
    	    $passwordchange = true;
    	}
    	else
    	{
    	    wp_send_json_error( 'new_password_empty' );
    	}
	}
	
	//all checks complete update our user info first
	
	$args = array(
        'ID'         => $current_user->ID,
        'display_name' => $dname,
        'first_name' => $fname,
        'last_name' => $lname,
        'user_email' => $email,
    );
    
    if( wp_update_user( $args ) )
    {
        //updated user info was successful, now update user meta info
        
        update_user_meta( $current_user->ID, 'date_of_birth', $dob );
        
        //check if password needs changed
        
        if( $passwordchange )
        {
            wp_set_password( $password, $current_user->ID );
            
            wp_send_json_success('password_update_success');
        }
        
        wp_send_json_success('user_update_success');
    }
    else
    {
        wp_send_json_error('update_error');
    }
}

function manager_add_user()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
	$error = array();
	$stores = array();
	
	$data = $_POST;
	
	$role = ! empty( $data[ 'role' ] ) ? $data[ 'role' ] : '';
	$uname   = ! empty( $data[ 'username' ] ) ? $data[ 'username' ] : '';
	$dname   = ! empty( $data[ 'displayname' ] ) ? $data[ 'displayname' ] : '';
	$fname   = ! empty( $data[ 'firstname' ] ) ? $data[ 'firstname' ] : '';
	$lname   = ! empty( $data[ 'lastname' ] ) ? $data[ 'lastname' ] : '';
	$email   = ! empty( $data[ 'email' ] ) ? $data[ 'email' ] : '';
	$dob  = ! empty( $data[ 'dob' ] ) ? $data[ 'dob' ] : '';
	$file  = ! empty( $data[ 'file' ] ) ? $data[ 'file' ] : '';
	$ptype = ! empty( $data[ 'password_type' ] ) ? $data[ 'password_type' ] : '';
	$password = ! empty( $data[ 'newpassword' ] ) ? $data[ 'newpassword' ] : '';
	$confirmpass = ! empty( $data[ 'newpasswordconfirm' ] ) ? $data[ 'newpasswordconfirm' ] : '';
	
	if( $role == "advisor" || $role == "senior_advisor" || $role == "store_manager" || $role == "multi_manager" )
	{
	    $store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	}
	
	if( $uname == '' )
	{
	    wp_send_json_error( 'empty_username' );
	}
	
	if( $dname == '' )
	{
	    wp_send_json_error( 'empty_display_name' );
	}
	
	if( $fname == '' )
	{
	    wp_send_json_error( 'empty_first_name' );
	}
	
	if( $lname == '' )
	{
	    wp_send_json_error( 'empty_last_name' );
	}
	
	if( $email == '' )
	{
	    wp_send_json_error( 'empty_email' );
	}
	
	if( $dob == '' )
	{
	    wp_send_json_error( 'empty_dob' );
	}
	
	if( $role == 'advisor' && $store == '' )
	{
	    wp_send_json_error( 'empty_employee_store' );
	}
	
	if( $role == 'senior_advisor' && $store == '' )
	{
	    wp_send_json_error( 'empty_employee_store' );
	}
	
	if( $role == 'store_manager' && $store == '' )
	{
	    wp_send_json_error( 'empty_manager_store' );
	}
	
	if( $role == 'multi_manager' && $store == '' )
	{
	    wp_send_json_error( 'empty_multi_store' );
	}
	
	if( $file == '' )
	{
	    wp_send_json_error( 'empty_image' );
	}
	
	//do we have a password or does it need generating
	if( $ptype == 'create_password' )
	{
	    //if we have a password was it entered
	    if( $password === '' )
    	{
    	    wp_send_json_error( 'empty_password' );
    	}
	
    	if( $password !== $confirmpass )
    	{
    	    wp_send_json_error( 'passwords_dont_match' );
    	}
	}
	elseif( $ptype == 'generate_password' )
	{
	   $password = wp_generate_password( $length = 8, $include_standard_special_chars = false );
	}
	
	//now lets check our username or email is not already been used
	$user_id = username_exists( $uname );
	$user_email = email_exists( $email );
	
	if ( $user_id )
	{
	    wp_send_json_error( 'username_exists' );
	}
	elseif ( $user_email )
	{
	    wp_send_json_error( 'email_exists' );
	}
	
	//all checks complete
	
	//remove any wrong characters from our username
	$uname = sanitize_user( $uname , true );

    $uname = trim( $uname );
    
    //do one last check to ensure username is not empty now we have removed characters
    if( $uname == '' )
    {
        wp_send_json_error( 'illegal_characters' );
    }
    
    //check the display name length
    if ( mb_strlen( $user_nicename ) > 50 ) 
    {
        wp_send_json_error( 'user_displayname_too_long' );
    }
    
    //strip out illegal characters from our display name
    $dname = sanitize_text_field( $dname );
    
    //filter our first name and last name
    $fname = sanitize_text_field( $fname );

    $lname = sanitize_text_field( $lname );

    //sanitise email to remove ilegal characters
    $email = sanitize_email( $email );
    
    //sanitise our url for our image
    $file = esc_url_raw( $file );
    
    if($role == 'advisor' )
    {
        $role = 'employee';
    }
	
	//all fields santised, now create our user
	$userdata = array(
        'user_login'       =>  $uname,
        'user_pass'        =>  $password,
        'user_email'       =>  $email,
        'display_name'     =>  $dname,
        'first_name'       =>  $fname,
        'last_name'        =>  $lname,
        'user_registered'  =>  date_i18n( 'Y-m-d H:i:s', time() ),
        'role'             =>  $role
    );
               
    $user_id = wp_insert_user( $userdata );
	
	if( $user_id )
	{
	    if( $role == 'store_manager' )
	    {
	        $emailrole = 'Store Manager';
	    }
	    if( $role == 'senior_manager' )
	    {
	        $emailrole = 'Senior Manager';
	    }
	    if( $role == 'employee' )
	    {
	        $emailrole = 'Advisor';
	    }
	    if( $role == 'senior_advisor' )
	    {
	        $emailrole = 'Senior Advisor';
	    }
	    if( $role == 'multi_manager' )
	    {
	        $emailrole = 'Multi Store Manager';
	    }
	    
	    $headers[] = 'Content-type: text/plain; charset=UTF-8';
        $headers[] = 'From: Family Connect Portal <no-reply@familyconnectgroup.co.uk>' . "\r\n\r\n";
        $to =  $email . ', shane@stiles.media';
        $subject = 'New ' . $emailrole . ' account created for you' . "\r\n\r\n";
	    
	    if ( $role == 'employee' || $role == 'senior_advisor' )
	    {
            $message = '';
            
            $message .= 'Welcome ' . $fname . ' ' . $lname . "\r\n\r\n";
            $message .= 'A new account has been created for you on the Family Connect Portal' . "\r\n\r\n";
            $message .= 'This portal allows you to view your employee details, change any of your details, check your commission and even view your shifts for the week / month' . "\r\n\r\n";
            $message .= 'Your username is ' . $uname . "\r\n\r\n";
            $message .= 'Your password is ' . $password ."\r\n\r\n";
            $message .= 'If there is any issues please contact your manager' . "\r\n\r\n";
            $message .= 'Family Connect';
	    }
	    elseif ( $role == 'store_manager' )
	    {
            $message = '';
            
            $message .= 'Welcome ' . $fname . ' ' . $lname . "\r\n\r\n";
            $message .= 'A new account has been created for you on the Family Connect Portal' . "\r\n\r\n";
            $message .= 'This portal allows you to view your employee details, change any of your details, manage your store, and check the sales and profit for the day' . "\r\n\r\n";
            $message .= 'Your username is ' . $uname . "\r\n\r\n";
            $message .= 'Your password is ' . $password ."\r\n\r\n";
            $message .= 'If there is any issues please contact Masih or Grace' . "\r\n\r\n";
            $message .= 'Family Connect';
	    }
	    elseif ( $role == 'multi_manager' )
	    {
            $message = '';
            
            $message .= 'Welcome ' . $fname . ' ' . $lname . "\r\n\r\n";
            $message .= 'A new account has been created for you on the Family Connect Portal' . "\r\n\r\n";
            $message .= 'This portal allows you to view your employee details, change any of your details, manage your stores, and check the sales and profit for the day' . "\r\n\r\n";
            $message .= 'Your username is ' . $uname . "\r\n\r\n";
            $message .= 'Your password is ' . $password ."\r\n\r\n";
            $message .= 'If there is any issues please contact Masih or Grace' . "\r\n\r\n";
            $message .= 'Family Connect';
	    }
	    elseif ( $role == 'senior_manager' )
	    {
            $message = '';
            
            $message .= 'Welcome ' . $fname . ' ' . $lname . "\r\n\r\n";
            $message .= 'A new account has been created for you on the Family Connect Portal' . "\r\n\r\n";
            $message .= 'This portal allows you to view your employee details, change any of your details, manage the staff that have access to the portal, and amend the staff details and details' . "\r\n\r\n";
            $message .= 'Your username is ' . $uname . "\r\n\r\n";
            $message .= 'Your password is ' . $password ."\r\n\r\n";
            $message .= 'If there is any issues please contact Masih or Grace' . "\r\n\r\n";
            $message .= 'Family Connect';
	    }
        
	    //update the date of birth field
	    update_user_meta( $user_id, 'date_of_birth', $dob );
	    
	    //add our profile picture URL
	    update_user_meta( $user_id, 'profile_picture', $file );
	    
	    if ( $role == 'employee' )
	    {
	        update_user_meta( $user_id, 'store_location', $store );
	        
	        if ( wp_mail( $to, $subject, $message, $headers) )
	        {
	            wp_send_json_success( 'advisor_created' );
	        }
	    }
	    elseif ( $role == 'senior_advisor' )
	    {
	        update_user_meta( $user_id, 'store_location', $store );
	        
	        if ( wp_mail( $to, $subject, $message, $headers) )
	        {
	            wp_send_json_success( 'senior_advisor_created' );
	        }
	    }
	    elseif ( $role == 'store_manager' )
	    {
	        update_user_meta( $user_id, 'store_managed', $store );
	        
	        if ( wp_mail( $to, $subject, $message, $headers) )
	        {
	            wp_send_json_success( 'store_manager_created' );
	        }
	    }
	    elseif ( $role == 'multi_manager' )
	    {
            $i = 1;
            
            $stores = explode( ',' , $store );
        
            foreach ( $stores as $store )  
            {
                //create our meta name for User meta
                $meta = 'store_managed_' . $i;
                
                //update the users metadata
                update_user_meta( $user_id, $meta, $store );
                
                //Implement our counter by 1 so we know we have moved onto the next one
                $i++;
            }
            
	        if ( wp_mail( $to, $subject, $message, $headers) )
	        {
	            wp_send_json_success( 'multi_manager_created' );
	        }
	    }
	    elseif ($role == 'senior_manager' )
	    {
	        update_user_meta( $user_id, 'store_managed', 'all' );
	        
	        if ( wp_mail( $to, $subject, $message, $headers) )
	        {
	            wp_send_json_success( 'senior_manager_created' );
	        }
	    }
	}
	else
	{
	    wp_send_json_error( $user_id );
	}
}

function manager_edit_user()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
	$error = array();
	$passwordchange = false;
	
	$data = $_POST;
	
	$dname   = ! empty( $data[ 'displayname' ] ) ? $data[ 'displayname' ] : '';
	$fname   = ! empty( $data[ 'firstname' ] ) ? $data[ 'firstname' ] : '';
	$lname   = ! empty( $data[ 'lastname' ] ) ? $data[ 'lastname' ] : '';
	$email   = ! empty( $data[ 'email' ] ) ? $data[ 'email' ] : '';
	$dob  = ! empty( $data[ 'dob' ] ) ? $data[ 'dob' ] : '';
	$file  = ! empty( $data[ 'file' ] ) ? $data[ 'file' ] : '';
	$currentpassword   = ! empty( $data[ 'currentpassword' ] ) ? $data[ 'currentpassword' ] : '';
	$password = ! empty( $data[ 'newpassword' ] ) ? $data[ 'newpassword' ] : '';
	$confirmpass = ! empty( $data[ 'newpasswordconfirm' ] ) ? $data[ 'newpasswordconfirm' ] : '';
	$id  = ! empty( $data[ 'id' ] ) ? $data[ 'id' ] : '';
	$role = ! empty( $data[ 'role' ] ) ? $data[ 'role' ] : '';
	$advisor_role = ! empty( $data[ 'advisor_role' ] ) ? $data[ 'advisor_role' ] : '';
	
	if( $role == 'multi_manager' )
	{
	    $stores = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	}
	else
	{
	    $store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	}
	
	$user = get_user_by('id', $id );
	
	//now we have details lets run some error checking before proceeding
	
	//check all our required fields are entered
	
	if( $dname == '' )
	{
	    wp_send_json_error( 'empty_display_name' );
	}
	
	if( $fname == '' )
	{
	    wp_send_json_error( 'empty_first_name' );
	}
	
	if( $lname == '' )
	{
	    wp_send_json_error( 'empty_last_name' );
	}
	
	if( $email == '' )
	{
	    wp_send_json_error( 'empty_email' );
	}
	
	if( $dob == '' )
	{
	    wp_send_json_error( 'empty_dob' );
	}
	
	//all fields are entered, check email is not registered
	
	//get the registered email for the user
	$registeredEmail = $user->user_email;
	
	//if submitted email is not the same as registered email, check email is not already used, return error if it is.
	if( $email !== $registeredEmail )
	{
	    $exists = email_exists( $email );
	
    	if( $exists )
    	{
    	    wp_send_json_error( 'email_exists' );
    	}
	}
	
	//if current password is entered, lets check its correct
	if( $password  !== '' )
	{
        //current password is correct, lets check the new passwords match
    	if( $password !== $confirmpass )
    	{
    	    wp_send_json_error( 'passwords_dont_match' );
    	}
    	
    	if ( $password !== '' )
    	{
    	    $passwordchange = true;
    	}
    	else
    	{
    	    wp_send_json_error( 'new_password_empty' );
    	}
	}
	
	if( $role == 'multi_manager' && $stores == '' )
	{
	    wp_send_json_error( 'empty_store' );
	}
	elseif( $role !== 'senior_manager' && $store == '' )
	{
	    wp_send_json_error( 'empty_store' );
	}
	
	//all checks complete update our user info first
	
	if($advisor_role !== '')
	{
	    //if this isnt empty it means advisors role has changed
	    $role = $advisor_role;
	}
	
	if($role == 'advisor')
	{
	    $role = 'employee';
	}
	
	$args = array(
        'ID'         => $id,
        'display_name' => $dname,
        'first_name' => $fname,
        'last_name' => $lname,
        'user_email' => $email,
        'role' => $role,
    );
    
    if( wp_update_user( $args ) )
    {
        //updated user info was successful, now update user meta info
        
        update_user_meta( $user->ID, 'date_of_birth', $dob );
        
        //do we need to update the profile picture, lets check
        if( $file !== '')
        {
            //there is a url, lets update
            update_user_meta( $user->ID, 'profile_picture', $file );
        }
        
        //check if password needs changed
        
        if( $passwordchange )
        {
            wp_set_password( $password, $user->ID );
            
            wp_send_json_success( 'password_update_success' );
        }
        
        if( $role == 'multi_manager' )
        {
            //we have a multi manager selected
            $i = 1;
        
            foreach ( $stores as $store )  
            {
                //create our meta name for User meta
                $meta = 'store_managed_' . $i;
                
                //update the users metadata
                update_user_meta( $user->ID, $meta, $store );
                
                //Implement our counter by 1 so we know we have moved onto the next one
                $i++;
            }
        }
        elseif( $role == 'employee' )
        {
            update_user_meta( $user->ID, 'store_location', $store );
            wp_send_json_success('user_update_success');
        }
        elseif( $role == 'senior_advisor' )
        {
            update_user_meta( $user->ID, 'store_location', $store );
            wp_send_json_success('user_update_success');
        }
        elseif( $role == 'store_manager' )
        {
            update_user_meta( $user->ID, 'store_managed', $store );
            wp_send_json_success('user_update_success');
        }
        
        wp_send_json_success('user_update_success');
    }
    else
    {
        wp_send_json_error('update_error');
    }
}

function manager_delete_user()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $current_user;
    get_currentuserinfo();
    
    $data     = array();
	$error = array();
	
	$data = $_POST;
	
	$id  = ! empty( $data[ 'id' ] ) ? $data[ 'id' ] : '';
	$type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
	$deleted_user = get_user_by('id', $id );
	
	$deleted_user = $deleted_user->first_name . ' ' . $deleted_user->last_name;

    wp_delete_user( $id );
    
    if ( $type == 'senior_manager' )
    {
        $store = 'all';
    }
    elseif ( $type == 'store_manager' )
    {
        $role = 'employee';
        $store = get_user_meta( $current_user->ID, 'store_managed' , true );
        $orderby = 'user_nicename';
        $order = 'ASC';
    }
    
    $store = strtolower( $store );
    
    if ( $store == 'all' )
    {
        $users = get_users();
    }
    else
    {
        $args = array(
            'role'    => $role,
            'orderby' => $orderby,
            'order'   => $order
        );
        
        $users = get_users( $args );
    }
    
    $employees = array();
    
    foreach ( $users as $user ) 
    {
        if ( $store == 'all' )
        {
            $id = $user->ID;
            $user_info = get_userdata( $id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            
            $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        }
        else
        {
            $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
            $employee_store = strtolower( $employee_store );
            
            if( $employee_store === $store )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
                
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
        }
    }
    
    wp_send_json_success( $deleted_user . ' successfully deleted' );
}

function return_user_object()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$id   = ! empty( $data[ 'id' ] ) ? $data[ 'id' ] : '';
	
	$user = get_user_by( 'id', $id );
	
	if( $user )
	{
    	//We need the managers location and staff location
    	
    	$manager_location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
        $staff_location = esc_attr( get_user_meta( $user->ID, 'store_location' , true ) );
    	
    	$success[ 'user_name' ] = $user->user_login;
    	$success[ 'display_name' ] = $user->display_name;
    	$success[ 'first_name' ] = $user->first_name;
    	$success[ 'last_name' ] = $user->last_name;
    	$success[ 'email' ] = $user->user_email;
        $success[ 'dob' ] = esc_attr( get_user_meta( $user->ID, 'date_of_birth' , true ) );
        $success[ 'url' ] = esc_attr( get_user_meta( $user->ID, 'profile_picture' , true ) );
        
        //check if te chosen user is an employee, store manager or senior manager and return correct value.
        if( $user && in_array( 'employee', $user->roles ) )
        {
            $success[ 'type' ] = 'advisor';
            $success[ 'location' ] = esc_attr( get_user_meta( $user->ID, 'store_location' , true ) );
        }
        if( $user && in_array( 'senior_advisor', $user->roles ) )
        {
            $success[ 'type' ] = 'senior_advisor';
            $success[ 'location' ] = esc_attr( get_user_meta( $user->ID, 'store_location' , true ) );
        }
        elseif( $user && in_array( 'store_manager', $user->roles ) )
        {
            $success[ 'type' ] = 'store_manager';
            $success[ 'location' ] = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
        }
        elseif( $user && in_array( 'multi_manager', $user->roles ) )
        {
            $success[ 'type' ] = 'multi_manager';
            
            global $wpdb;
            
            $locations = array();
            
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

            foreach ( $results as $result )
            {
                $locations[] = $result->location;
            }
            
            $location1 = get_user_meta( $user->ID, 'store_managed_1', true);
            $location2 = get_user_meta( $user->ID, 'store_managed_2', true);
            $location3 = get_user_meta( $user->ID, 'store_managed_3', true);
            $location4 = get_user_meta( $user->ID, 'store_managed_4', true);
            $location5 = get_user_meta( $user->ID, 'store_managed_5', true);
            
            $selected = array();
                                                        
            if ( isset( $location1 ) )
            {
                array_push($selected, $location1 );
            }
            if ( isset( $location2 ) )
            {
                array_push($selected, $location2 );
            }
            if ( isset( $location3 ) )
            {
                array_push($selected, $location3 );
            }
            if ( isset( $location4 ) )
            {
                array_push($selected, $location4 );
            }
            if ( isset( $location5 ) )
            {
                array_push($selected, $location5 );
            }
            
            $selects = '';
            
            foreach ( $locations as $location )
            {
                if ( in_array( $location, $selected ) ) 
                { 
                    $selects .= '<option value="' . $location . '" selected="selected">' . $location . '</option>';
                }
                else
                {
                    $selects .= '<option value="' . $location . '">' . $location . '</option>';
                }
            }
            
            $success[ 'selects' ] = $selects;
        }
        elseif( $user && in_array( 'senior_manager', $user->roles ) )
        {
            $success[ 'type' ] = 'senior_manager';
        }
        
        wp_send_json_success( $success );
	}
	else
	{
	    wp_send_json_error( 'There has been an error, please try again' );
	}
}

function return_user_select_list()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$type   = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
    $user = wp_get_current_user();
    
    if( $user && in_array( 'senior_manager', $user->roles ) )
    {
        $store = 'all';
    }
    elseif( $user && in_array( 'store_manager', $user->roles ) )
    {
        $store = get_user_meta( $user->ID, 'store_managed' , true );
    }
    
    $store = strtolower( $store );
    
    $users = get_users();

    $employees = array();
    
    echo '<label for="user">Choose a user:</label>';
    
    if( $type == 'delete' )
    {
        echo '<select name="dusers" id="dusers">';
        echo '<option value="">Select User To Delete</option>';
    }
    elseif( $type == 'edit' )
    {
        echo '<select name="eusers" id="eusers">';
        echo '<option value="">Select User To Edit</option>';
    }
    
    foreach ( $users as $user ) 
    {
        if ( $store == 'all' )
        {
            if( $user && ! in_array( 'administrator', $user->roles ) )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
    
                echo '<option value="' . $id . '">' . $first_name . ' ' . $last_name . '</option>';
            }
        }
        else
        {
            $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
            $employee_store = strtolower( $employee_store );
            
            if( $employee_store === $store )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
    
                echo '<option value="' . $id . '">' . $first_name . ' ' . $last_name . '</option>';
            }
        }
    }
    
     echo '</select>';
     
     wp_die();
}

function import_csv_to_db()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$table = '';
	$updatemessage = '';
	$insertmessage = '';

	$data = $_POST;
	
	$csvtype   = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';

    $link = ! empty( $data[ 'csv' ] ) ? $data[ 'csv' ] : '';
    
    if( $csvtype == 'devices' )
    {
        $table = 'wp_fc_devices';
        $updatemessage = 'devices updated';
        $insertmessage = 'devices inserted';
    }
    
    if( $csvtype == 'tariffs' )
    {
        $updatemessage = 'tariffs updated';
        $insertmessage = 'tariffs inserted';
    }
    
    if( $csvtype == 'accessories' )
    {
        $table = 'wp_fc_accessories';
        $updatemessage = 'accessories updated';
        $insertmessage = 'accessories inserted';
    }
    
    if( $csvtype == 'profit' )
    {
        $table = 'wp_fc_profit_targets';
        $updatemessage = 'profits updated';
        $insertmessage = 'profits inserted';
    }
    
    if( $csvtype == 'discount' )
    {
        $table = 'wp_fc_discount_pots';
        $updatemessage = 'discounts updated';
        $insertmessage = 'discounts inserted';
    }
    
    if( $csvtype == 'commission' )
    {
        $table = 'wp_fc_commission_percentages';
        $updatemessage = 'commission percentages updated';
        $insertmessage = 'commission percentages inserted';
    }
    
    $totalInserted = 0;
    $totalUpdated = 0;
    
    $csvFile = fopen( $link , 'r' );
    
    fgetcsv($csvFile); // Skipping header row
    
    // Read file
    while( ( $csvData = fgetcsv( $csvFile ) ) !== FALSE )
    {
        $csvData = array_map( "utf8_encode" , $csvData );
        
        // Row column length
        $dataLen = count($csvData);
        
        //our tariffs csv uploader
        if( $csvtype == 'tariffs' )
        {
            // Skip row if length != 5
            if( !( $dataLen == 6 ) ) continue;
            
            // Assign value to variables
            $type = trim( $csvData[0] );
            $tariff = trim( $csvData[1] );
            $upgrade = trim( $csvData[2] );
            $new = trim( $csvData[3] );
            $mrc = trim( $csvData[4] );
            $active = trim( $csvData[5] );
            
            if($active == '') 
            {
                $active = 'no';
            }
            
            if($type == 'Standard' || $type == 'SIMO' || $type == 'BSIMO' || $type == 'Business') {
                //these are the mutiplier tariffs
                $table = 'wp_fc_multiplier_tariffs';
            } else {
                $table = 'wp_fc_tariffs';
            }
            
            // Check record already exists or not
            $cntSQL = "SELECT count(*) as count FROM {$table} where tariff='". $tariff . "'" . "AND type='" . $type ."'";
            $record = $wpdb->get_results( $cntSQL, OBJECT );
            
            if( $record[0]->count == 0 )
            {
                // Check if variable is empty or not
                if( ! empty( $type ) && ! empty( $tariff ) && ! empty( $upgrade ) && ! empty( $new ) ) 
                {
                    // Insert Record
                    if($type == 'Standard' || $type == 'SIMO' || $type == 'BSIMO' || $type == 'Business') {
                        //these are the mutiplier tariffs
                        $wpdb->insert( $table , array(
                            'type' => $type,
                            'tariff' => $tariff,
                            'value' => $new,
                            'tariff_active' => $active,
                        ));
                    } else {
                        $wpdb->insert( $table , array(
                            'type' => $type,
                            'tariff' => $tariff,
                            'upgrade_price' => $upgrade,
                            'new_price' => $new,
                            'mrc' => $mrc,
                            'tariff_active' => $active,
                        ));
                    }
                        
                    if( $wpdb->insert_id > 0 )
                    {
                        $totalInserted++;
                    }
                }
            }
            else
            {
                //if it exists then lets update with new info
                $table_name = $table;
                
                if($type == 'Standard' || $type == 'SIMO' || $type == 'BSIMO' || $type == 'Business') {
                    $data_update = array( 
                        'type' => $type, 
                        'tariff' => $tariff, 
                        'value' => $new,
                        'tariff_active' => $active
                    );
                } else {
                    $data_update = array( 
                        'type' => $type, 
                        'tariff' => $tariff, 
                        'upgrade_price' => $upgrade, 
                        'new_price' => $new, 
                        'mrc' => $mrc,
                        'tariff_active' => $active
                    );
                }
                
                $data_where = array( 'tariff' => $tariff, 'type' => $type );
                
                //we have info lets run the query
                $wpdb->update( $table_name , $data_update, $data_where );
                
                if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
                {
                    //failed to update, do nothing
                }
                else
                {
                    $totalUpdated++;
                }
            }
        }
        
        //our tariffs csv uploader
        if( $csvtype == 'devices' )
        {
            // Skip row if length != 3
            if( !( $dataLen == 3 ) ) continue;
            
            // Assign value to variables
            $type = trim( $csvData[0] );
            $device = trim( $csvData[1] );
            $cost = trim( $csvData[2] );

            // Check record already exists or not
            $cntSQL = "SELECT count(*) as count FROM {$table} where device='". $device . "'" . "AND type='" . $type ."'";
            $record = $wpdb->get_results( $cntSQL, OBJECT );
            
            if( $record[0]->count == 0 )
            {
                // Check if variable is empty or not
                if( ! empty( $type ) && ! empty( $device ) && ! empty( $cost ) ) 
                {
                    // Insert Record
                    $wpdb->insert( $table , array(
                        'type' => $type,
                        'device' => $device,
                        'cost' => $cost,
                    ));
                        
                    if( $wpdb->insert_id > 0 )
                    {
                        $totalInserted++;
                    }
                }
            }
            else
            {
                //if it exists then lets update with new info
                $table_name = $table;
                $data_update = array( 'type' => $type, 'device' => $device, 'cost' => $cost );
                $data_where = array( 'device' => $device, 'type' => $type );
                
                //we have info lets run the query
                $wpdb->update( $table_name , $data_update, $data_where );
                
                if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
                {
                    //failed to update, do nothing
                }
                else
                {
                    $totalUpdated++;
                }
            }
        }
        
        //our accessories CVS uploader
        if( $csvtype == 'accessories' )
        {
            // Skip row if length != 4
             if( !( $dataLen == 4 ) ) continue;
      
            // Assign value to variables
            $code = trim( $csvData[0] );
            $accessory = trim( $csvData[1] );
            $cost = trim( $csvData[2] );
            $rrp = trim( $csvData[3] );
            
            // Check record already exists or not
            $cntSQL = "SELECT count(*) as count FROM {$table} where accessory='". $accessory . "'" . "AND productcode='" . $code . "'";
            $record = $wpdb->get_results( $cntSQL, OBJECT );
            
            if( $record[0]->count == 0 )
            {
                // Check if variable is empty or not
                if( ! empty( $code ) && ! empty( $accessory ) && ! empty( $cost ) && ! empty( $rrp ) ) 
                {
                    // Insert Record
                    $wpdb->insert( $table , array(
                        'productcode' => $code,
                        'accessory' => $accessory,
                        'cost' => $cost,
                        'rrp' => $rrp
                    ));
                        
                    if( $wpdb->insert_id > 0 )
                    {
                        $totalInserted++;
                    }
                }
            }
            else
            {
                //if it exists then lets update with new info
                $table_name = $table;
                $data_update = array( 'productcode' => $code, 'accessory' => $accessory, 'cost' => $cost, 'rrp' => $rrp );
                $data_where = array( 'accessory' => $accessory, 'productcode' => $code );
                
                //we have info lets run the query
                $wpdb->update( $table_name , $data_update, $data_where );
                
                if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
                {
                    //failed to update, do nothing
                }
                else
                {
                    $totalUpdated++;
                }
            }
        }
        
        if( $csvtype == 'profit' )
        {
            // Skip row if length != 4
             if( !( $dataLen == 4 ) ) continue;
      
            // Assign value to variables
            $store = trim( $csvData[0] );
            $target = trim( $csvData[1] );
            $month = trim( $csvData[2] );
            $year = trim( $csvData[3] );
            
            // Check record already exists or not
            $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND month='" . $month . "'" . "AND year='" . $year . "'";
            $record = $wpdb->get_results( $cntSQL, OBJECT );
            
            if( $record[0]->count == 0 )
            {
                // Check if variable is empty or not
                if( ! empty( $store ) && ! empty( $target ) && ! empty( $month ) && ! empty( $year ) ) 
                {
                    // Insert Record
                    $wpdb->insert( $table , array(
                        'store' => $store,
                        'target' => $target,
                        'month' => $month,
                        'year' => $year
                    ));
                        
                    if( $wpdb->insert_id > 0 )
                    {
                        $totalInserted++;
                    }
                }
            }
            else
            {
                //if it exists then lets update with new info
                $table_name = $table;
                $data_update = array( 'store' => $store, 'target' => $target, 'month' => $month, 'year' => $year );
                $data_where = array( 'store' => $store, 'month' => $month, 'year' => $year );
                
                //we have info lets run the query
                $wpdb->update( $table_name , $data_update, $data_where );
                
                if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
                {
                    //failed to update, do nothing
                }
                else
                {
                    $totalUpdated++;
                }
            }
        }
        
        if( $csvtype == 'discount' )
        {
            // Skip row if length != 5
             if( ! ( $dataLen == 5 ) ) continue;
      
            // Assign value to variables
            $store = trim( $csvData[0] );
            $rm_pot = trim( $csvData[1] );
            $fran_pot = trim( $csvData[2] );
            $month = trim( $csvData[3] );
            $year = trim( $csvData[4] );
            
            // Check record already exists or not
            $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND month='" . $month . "'" . "AND year='" . $year . "'";
            $record = $wpdb->get_results( $cntSQL, OBJECT );
            
            if( $record[0]->count == 0 )
            {
                // Check if variable is empty or not
                if( ! empty( $store ) && ! empty( $fran_pot ) && ! empty( $rm_pot ) && ! empty( $month ) && ! empty( $year ) ) 
                {
                    $table = 'wp_fc_discount_pots';
                    
                    // Insert Record
                    $wpdb->insert( $table , array(
                        'store' => $store,
                        'franchise' => $fran_pot,
                        'regionalManager' => $rm_pot,
                        'month' => $month,
                        'year' => $year
                    ));
                        
                    if( $wpdb->insert_id > 0 )
                    {
                        $table = 'wp_fc_discount_tracker';

                        // Insert Record
                        $wpdb->insert( $table , array(
                            'store' => $store,
                            'franchise' => $fran_pot,
                            'regionalManager' => $rm_pot,
                            'month' => $month,
                            'year' => $year
                        ));
                        
                        if( $wpdb->insert_id > 0 )
                        {
                            $totalInserted++;
                        }
                    }
                }
            }
            else
            {
                //if it exists then lets update with new info
                $table = 'wp_fc_discount_pots';
                
                $table_name = $table;
                $data_update = array( 'store' => $store, 'franchise' => $fran_pot, 'regionalManager' => $rm_pot, 'month' => $month, 'year' => $year );
                $data_where = array( 'store' => $store, 'month' => $month, 'year' => $year );
                
                //we have info lets run the query
                $wpdb->update( $table_name , $data_update, $data_where );
                
                if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
                {
                    //failed to update, do nothing
                }
                else
                {
                    $table = 'wp_fc_discount_tracker';
                    
                    $table_name = $table;
                    $data_update = array( 'store' => $store, 'franchise' => $fran_pot, 'regionalManager' => $rm_pot, 'month' => $month, 'year' => $year );
                    $data_where = array( 'store' => $store, 'month' => $month, 'year' => $year );
                    
                    if( $wpdb->update( $table_name , $data_update, $data_where ) !== FALSE )
                    {
                        $totalUpdated++;
                    }
                }
            }
        }
        
        if( $csvtype == 'commission' )
        {
            // Skip row if length != 5
             if( ! ( $dataLen == 5 ) ) continue;
      
            // Assign value to variables
            $store = trim( $csvData[0] );
            $rm_pot = trim( $csvData[1] );
            $fran_pot = trim( $csvData[2] );
            $month = trim( $csvData[3] );
            $year = trim( $csvData[4] );
            
            // Check record already exists or not
            $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND month='" . $month . "'" . "AND year='" . $year . "'";
            $record = $wpdb->get_results( $cntSQL, OBJECT );
            
            if( $record[0]->count == 0 )
            {
                // Check if variable is empty or not
                if( ! empty( $store ) && ! empty( $fran_pot ) && ! empty( $rm_pot ) && ! empty( $month ) && ! empty( $year ) ) 
                {
                    $table = 'wp_fc_discount_pots';
                    
                    // Insert Record
                    $wpdb->insert( $table , array(
                        'store' => $store,
                        'franchise' => $fran_pot,
                        'regionalManager' => $rm_pot,
                        'month' => $month,
                        'year' => $year
                    ));
                        
                    if( $wpdb->insert_id > 0 )
                    {
                        $totalInserted++;
                    }
                }
            }
            else
            {
                //if it exists then lets update with new info
                $table = 'wp_fc_commission_percentages';
                
                $table_name = $table;
                $data_update = array( 'store' => $store, 'franchise' => $fran_pot, 'regionalManager' => $rm_pot, 'month' => $month, 'year' => $year );
                $data_where = array( 'store' => $store, 'month' => $month, 'year' => $year );
                
                //we have info lets run the query
                $wpdb->update( $table_name , $data_update, $data_where );
                
                if( $wpdb->update( $table_name , $data_update, $data_where ) !== FALSE )
                {
                    $totalUpdated++;
                }
                
            }
        }
    }
    
    if ( $totalInserted > 0 )
    {
        $success[ 'insert' ] = $totalInserted . ' ' . $insertmessage;
    }
    
    if ( $totalUpdated > 0 )
    {
        $success[ 'update' ] = $totalUpdated . ' ' . $updatemessage;
    }
    
    wp_send_json_success( $success );
}

function accessory_profit()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$profit = '';

	$data = $_POST;
	
	$accessory   = ! empty( $data[ 'accessory' ] ) ? $data[ 'accessory' ] : '';
	
    //get our accessories list
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_accessories" ) );
    
    foreach ( $results as $result )
    {
        if( $result->accessory == $accessory )
        {
            $cost = $result->cost;
            $rrp = $result->rrp;
            
            $profit = $rrp - $cost;
            
            $profit = round( $profit , 2 );
            wp_send_json_success( $profit );
        }
    }
}

function tariff_profit()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$profit = '';

	$data = $_POST;
	
	$tariff   = ! empty( $data[ 'tariff' ] ) ? $data[ 'tariff' ] : '';
	$type   = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	$over   = ! empty( $data[ 'over' ] ) ? $data[ 'over' ] : '';
	
	$allowed = 'no';
	
    //get our accessories list
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_tariffs" ) );
    
    foreach ( $results as $result )
    {
        if( $result->tariff == $tariff )
        {
            if ($result->type == 'TLO')
            {
                $allowed = 'no';
            } elseif($result->type == 'HSM')
            {
                $allowed = 'no';
            } else
            {
                $allowed = 'yes';
            }
            
            if($over == 'yes' && $allowed == 'yes')
            {
                $price = $result->over_629_price;
            } 
            else 
            {
                $new = $result->new_price;
                $upgrade = $result->upgrade_price;
            }
        }
    }
    
    if($over == 'yes' && $allowed == 'yes')
    {
        wp_send_json_success( $price );
    }
    elseif( $type == 'new' )
    {
        wp_send_json_success( $new );
    }
    elseif( $type == 'upgrade' )
    {
        wp_send_json_success( $upgrade );
    }
}

function handset_cost()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$profit = '';

	$data = $_POST;
	
	$handset   = ! empty( $data[ 'handset' ] ) ? $data[ 'handset' ] : '';
	
    //get our accessories list
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_devices" ) );
    
    foreach ( $results as $result )
    {
        if( $result->device == $handset )
        {
            $cost = $result->cost;
        }
    }
    
    wp_send_json_success( $cost );
}

function get_sales_staff()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	$date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	$type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
	$store = strtolower( $store );
	
	global $wpdb;
    
    $users = get_users();

    $employees = array();
    
    echo "<label for='sales_advisor'>Choose Advisor <span class='required'>*</span></label>";
    
    echo '<select name="advisor[]" class="advisor" autocomplete="off">';
    
    foreach ( $users as $user ) 
    {
        $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
        $employee_store = strtolower( $employee_store );
        
        $id = $user->ID;
        $user_info = get_userdata( $id );
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
            
        $advisor = $first_name . ' ' . $last_name;
        
        if( $type == 'approve' )
        {
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = '$date' AND approve_sale = ''" ) );
            
            foreach( $results as $result )
            {
                if( $result->advisor == $advisor && strtolower( $result->store ) == $store )
                {
                    $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
                }
            }
        }
        else
        {
            if( $employee_store === $store )
            {
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
            
            $user = wp_get_current_user();
    
            $id = $user->ID;
            $user_info = get_userdata( $id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            
            $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        }
    }
    
    if( ! empty( $employees ) )
    {
        echo '<option value="">Choose Advisor</option>';

        foreach( $employees as $id => $employee)
        {
            echo '<option value="' . $id . '">' . $employee . '</option>';
        }
    }
    else
    {
        echo '<option value="">No Sales to Approve</option>';
    }
    
    echo '</select>';
     
    wp_die();
}

function get_review_staff()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';

	$store = strtolower( $store );
	
	global $wpdb;
    
    $users = get_users();

    $employees = array();
    
    echo "<label for='review_advisor'>" . esc_html_e( 'Choose Advisor', 'woocommerce' ) . "&nbsp; <span class='required'>*</span></label>";
    
    echo '<select name="review_advisor" class="review_advisor" autocomplete="off">';
    
    foreach ( $users as $user ) 
    {
        $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
        $employee_store = strtolower( $employee_store );
        
        $id = $user->ID;
        $user_info = get_userdata( $id );
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
            
        $advisor = $first_name . ' ' . $last_name;
        
        if( $employee_store === $store )
        {
            $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        }
    }
    
    if( ! empty( $employees ) )
    {
        echo '<option value="">Choose Advisor</option>';

        foreach( $employees as $id => $employee)
        {
            echo '<option value="' . $id . '">' . $employee . '</option>';
        }
    }
    
    echo '</select>';
     
    wp_die();
}

function get_approved_staff()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$store = strtolower( $store );
    
    $users = get_users();

    $employees = array();
    
    echo "<label for='sales_advisor'>" . esc_html_e( 'Choose Advisor', 'woocommerce' ) . "&nbsp; <span class='required'>*</span></label>";
    
    echo '<select name="advisor" class="advisor" autocomplete="off">';
    echo '<option value="">Choose Advisor</option>';
    
    foreach ( $users as $user ) 
    {
        $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
        $employee_store = strtolower( $employee_store );
            
        if( $employee_store === $store )
        {
            $id = $user->ID;
            $user_info = get_userdata( $id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            
            $employees[] = $first_name . ' ' . $last_name;
        }
    }
    
    foreach( $employees as $employee )
    {
        $results[] = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE approve_sale is NULL or approve_sale = ''  AND advisor = '$employee'  AND sale_date = '$date' " ) );
    }

    unset( $employees );
    
    $employees = array();
    
    foreach( $results as $result )
    {
        foreach( $result as $r )
        {
            $employees[ $r->advisor ] = $r->advisor;
        }
    }
    
    $count = 0;
    
    foreach( $employees as $employee )
    {
        $count++;
        echo '<option value="' . $count . '">' . $employee . '</option>';
    }
    
    if( $count == 0 )
    {
        echo '<option value="">No Sales to be Approved</option>';
    }
    
    echo '</select>';
     
    wp_die();
}

function manager_save_sales_inputs()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
    
    $form   = ! empty( $data[ 'form' ] ) ? $data[ 'form' ] : '';
    $date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    $store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    $advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
    $type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
    $sale_id = ! empty( $data[ 'sale_id' ] ) ? $data[ 'sale_id' ] : '';
    $product_type = ! empty( $data[ 'product_type' ] ) ? $data[ 'product_type' ] : '';
    $device = ! empty( $data[ 'device' ] ) ? $data[ 'device' ] : '';
    $device_discount_type = ! empty( $data[ 'device_discount_type' ] ) ? $data[ 'device_discount_type' ] : '';
    $device_discount = ! empty( $data[ 'device_discount' ] ) ? $data[ 'device_discount' ] : '';
    $device_discount_2 = ! empty( $data[ 'device_discount_2' ] ) ? $data[ 'device_discount_2' ] : '';
    $tariff_type = ! empty( $data[ 'tariff_type' ] ) ? $data[ 'tariff_type' ] : '';
    $tariff_discount = ! empty( $data[ 'tariff_discount' ] ) ? $data[ 'tariff_discount' ] : '';
    $tariff = ! empty( $data[ 'tariff' ] ) ? $data[ 'tariff' ] : '';
    $broadband_tv = ! empty( $data[ 'broadband_tv_type' ] ) ? $data[ 'broadband_tv_type' ] : '';
    $tariff_discount_type = ! empty( $data[ 'tariff_discount_type' ] ) ? $data[ 'tariff_discount_type' ] : '';
    $tariff_discount = ! empty( $data[ 'tariff_discount' ] ) ? $data[ 'tariff_discount' ] : '';
    $accessory_needed = ! empty( $data[ 'accessory_needed' ] ) ? $data[ 'accessory_needed' ] : '';
    $accessory = ! empty( $data[ 'accessory' ] ) ? $data[ 'accessory' ] : '';
    $accessory_cost = ! empty( $data[ 'accessory_cost' ] ) ? $data[ 'accessory_cost' ] : '';
    $accessory_discount = ! empty( $data[ 'accessory_discount' ] ) ? $data[ 'accessory_discount' ] : '';
    $accessory_discount_value = ! empty( $data[ 'accessory_discount_value' ] ) ? $data[ 'accessory_discount_value' ] : '';
    $insurance = ! empty( $data[ 'insurance' ] ) ? $data[ 'insurance' ] : '';
    $insurance_type = ! empty( $data[ 'insurance_type' ] ) ? $data[ 'insurance_type' ] : '';
    $insurance_choice = ! empty( $data[ 'insurance_choice' ] ) ? $data[ 'insurance_choice' ] : '';
    $hrc = ! empty( $data[ 'hrc' ] ) ? $data[ 'hrc' ] : '';
    $pobo = ! empty( $data[ 'pobo' ] ) ? $data[ 'pobo' ] : '';
    $profit_loss = ! empty( $data[ 'profit_loss' ] ) ? $data[ 'profit_loss' ] : '';
    $total_profit = ! empty( $data[ 'total_profit' ] ) ? $data[ 'total_profit' ] : '';
    $accessory_profit = ! empty( $data[ 'accessory_profit' ] ) ? $data[ 'accessory_profit' ] : '';
    $insurance_profit = ! empty( $data[ 'insurance_profit' ] ) ? $data[ 'insurance_profit' ] : '';
    $approve_sale = ! empty( $data[ 'approve_sale' ] ) ? $data[ 'approve_sale' ] : '';
    $comment = ! empty( $data[ 'comment' ] ) ? $data[ 'comment' ] : '';
    
    $split = explode("-", $date );
    
    $monthNum = $split[1];
    
    $dateObj   = DateTime::createFromFormat( '!m', $monthNum );
    $month = $dateObj->format('F');
    
    $year = $split[0];
    
    $day = $split[2];
    
    $time = date("H:i:s");
    $time_stamp = $date . ' ' . $time;
    
    if( $device == 'Choose Device' )
    {
        //no device selected
        $device = '';
    }
    
    if( $tariff == 'Choose Tariff' )
    {
        //no tariff selected
        $tariff = '';
    }
    
    if( $accessory == 'Choose Accessories' )
    {
        //no accessory selected
        $accessory = '';
    }
    
    if( $insurance_choice == 'Choose Insurance' )
    {
        //no accessory selected
        $insurance_choice = '';
    }
    
    if( $sale_id == '' )
    {
        if( $device_discount !== '' )
        {
            //a device discount was added, lets update our discount pots
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_tracker WHERE month = '$month'" ) );
    
            foreach ( $results as $result )
            {
                if( $result->store == $store )
                {
                    $fran_pot = floatval( $result->franchise );
                    $rm_pot = floatval( $result->regionalManager );
                }
            }
            
            $table_name = 'wp_fc_discount_tracker';
            
            if( $device_discount_type == 'rm' )
            {
                $pot_discount = floatval( $device_discount );
                
                $rm_pot = $rm_pot - $pot_discount;
                
                $data_update = array( 
                    'regionalManager' => $rm_pot );
            }
            
            if( $device_discount_type == 'franchise' )
            {
                $pot_discount = floatval( $device_discount );
                
                $fran_pot = $fran_pot - $pot_discount;
                
                $data_update = array( 
                    'franchise' => $fran_pot );
            }
            
            if( $device_discount_type == 'both' )
            {
                $pot_discount = floatval( $device_discount );
                
                $rm_pot = $rm_pot - $pot_discount;
                
                $data_update = array( 
                    'regionalManager' => $rm_pot );
            }
                    
            $data_where = array( 'store' => $store , 'month' => $month , 'year' => $year );
                    
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );
        }
        
        if( $device_discount_2 !== '' )
        {
            //a device discount was added, lets update our discount pots
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_tracker" ) );
    
            foreach ( $results as $result )
            {
                if( $result->store == $store )
                {
                    $fran_pot = floatval( $result->franchise );
                    $rm_pot = floatval( $result->regionalManager );
                }
            }
            
            $pot_discount = floatval( $device_discount );
                
            $fran_pot = $fran_pot - $pot_discount;
                
            $data_update = array( 
                'franchise' => $fran_pot );
        }
        
        if( $device_discount_2 !== '' )
        {
            $wpdb->insert( 'wp_fc_sales_info' , array(
                'store' => $store,
                'advisor' => $advisor,
                'type' => $type,   
                'product_type' => $product_type,
                'device' => $device,
                'device_discount_type' => $device_discount_type,
                'device_discount' => $device_discount,
                'device_discount_2' => $device_discount_2,
                'tariff_type' => $tariff_type,
                'tariff' => $tariff,
                'broadband_tv' => $broadband_tv,
                'tariff_discount_type' => $tariff_discount_type,
                'tariff_discount' => $tariff_discount,
                'accessory_needed' => $accessory_needed,
                'accessory' => $accessory,
                'accessory_cost' => $accessory_cost,
                'accessory_discount' => $accessory_discount,
                'accessory_discount_value' => $accessory_discount_value,
                'insurance' => $insurance,
                'insurance_type' => $insurance_type,
                'profit_loss' => $profit_loss,
                'total_profit' => $total_profit,
                'accessory_profit' => $accessory_profit,
                'insurance_profit' => $insurance_profit,
                'insurance_choice' => $insurance_choice,
                'hrc' => $hrc,
                'pobo' => $pobo,
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'sale_date' => $time_stamp,
            ));
            
            if( $wpdb->insert_id > 0 )
            {
                wp_send_json_success('sale_added');
            }
        }
        else
        {
            $wpdb->insert( 'wp_fc_sales_info' , array(
                'store' => $store,
                'advisor' => $advisor,
                'type' => $type,   
                'product_type' => $product_type,
                'device' => $device,
                'device_discount_type' => $device_discount_type,
                'device_discount' => $device_discount,
                'tariff_type' => $tariff_type,
                'tariff' => $tariff,
                'broadband_tv' => $broadband_tv,
                'tariff_discount_type' => $tariff_discount_type,
                'tariff_discount' => $tariff_discount,
                'accessory_needed' => $accessory_needed,
                'accessory' => $accessory,
                'accessory_cost' => $accessory_cost,
                'accessory_discount' => $accessory_discount,
                'accessory_discount_value' => $accessory_discount_value,
                'insurance' => $insurance,
                'insurance_type' => $insurance_type,
                'profit_loss' => $profit_loss,
                'total_profit' => $total_profit,
                'accessory_profit' => $accessory_profit,
                'insurance_profit' => $insurance_profit,
                'insurance_choice' => $insurance_choice,
                'hrc' => $hrc,
                'pobo' => $pobo,
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'sale_date' => $time_stamp,
            ));
            
            if( $wpdb->insert_id > 0 )
            {
                wp_send_json_success('sale_added');
            }
        }
    }
    else
    {
        $table_name = 'wp_fc_sales_info';
        $data_update = array( 
            'store' => $store,
            'advisor' => $advisor,
            'type' => $type,   
            'product_type' => $product_type,
            'device' => $device,
            'device_discount_type' => $device_discount_type,
            'device_discount' => $device_discount,
            'tariff_type' => $tariff_type,
            'tariff' => $tariff,
            'broadband_tv' => $broadband_tv,
            'tariff_discount_type' => $tariff_discount_type,
            'tariff_discount' => $tariff_discount,
            'accessory_needed' => $accessory_needed,
            'accessory' => $accessory,
            'accessory_cost' => $accessory_cost,
            'accessory_discount' => $accessory_discount,
            'accessory_discount_value' => $accessory_discount_value,
            'insurance' => $insurance,
            'insurance_type' => $insurance_type,
            'profit_loss' => $profit_loss,
            'total_profit' => $total_profit,
            'accessory_profit' => $accessory_profit,
            'insurance_profit' => $insurance_profit,
            'hrc' => $hrc,
            'pobo' => $pobo,
            'approve_sale' => $approve_sale,
            'comment' => $comment );
        $data_where = array( 'id' => $sale_id );
                
        //we have info lets run the query
        $wpdb->update( $table_name , $data_update, $data_where );
        
        if( $wpdb->update( $table_name , $data_update, $data_where ) !== FALSE )
        {
            wp_send_json_success('sale_updated');
        }
    }
}

function staff_save_sales_inputs()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
    
    $date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    $store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    $advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
    $type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
    $product_type = ! empty( $data[ 'product_type' ] ) ? $data[ 'product_type' ] : '';
    $device = ! empty( $data[ 'device' ] ) ? $data[ 'device' ] : '';
    $device_discount_type = ! empty( $data[ 'device_discount_type' ] ) ? $data[ 'device_discount_type' ] : '';
    $device_discount = ! empty( $data[ 'device_discount' ] ) ? $data[ 'device_discount' ] : '';
    $device_discount_2 = ! empty( $data[ 'device_discount_2' ] ) ? $data[ 'device_discount_2' ] : '';
    $tariff_type = ! empty( $data[ 'tariff_type' ] ) ? $data[ 'tariff_type' ] : '';
    $tariff = ! empty( $data[ 'tariff' ] ) ? $data[ 'tariff' ] : '';
    $broadband_tv = ! empty( $data[ 'broadband_tv_type' ] ) ? $data[ 'broadband_tv_type' ] : '';
    $tariff_discount_type = ! empty( $data[ 'tariff_discount_type' ] ) ? $data[ 'tariff_discount_type' ] : '';
    $tariff_discount = ! empty( $data[ 'tariff_discount' ] ) ? $data[ 'tariff_discount' ] : '';
    $accessory_needed = ! empty( $data[ 'accessory_needed' ] ) ? $data[ 'accessory_needed' ] : '';
    $accessory = ! empty( $data[ 'accessory' ] ) ? $data[ 'accessory' ] : '';
    $accessory_cost = ! empty( $data[ 'accessory_cost' ] ) ? $data[ 'accessory_cost' ] : '';
    $accessory_discount = ! empty( $data[ 'accessory_discount' ] ) ? $data[ 'accessory_discount' ] : '';
    $accessory_discount_value = ! empty( $data[ 'accessory_discount_value' ] ) ? $data[ 'accessory_discount_value' ] : '';
    $insurance = ! empty( $data[ 'insurance' ] ) ? $data[ 'insurance' ] : '';
    $insurance_type = ! empty( $data[ 'insurance_type' ] ) ? $data[ 'insurance_type' ] : '';
    $insurance_choice = ! empty( $data[ 'insurance_choice' ] ) ? $data[ 'insurance_choice' ] : '';
    $hrc = ! empty( $data[ 'hrc' ] ) ? $data[ 'hrc' ] : '';
    $pobo = ! empty( $data[ 'pobo' ] ) ? $data[ 'pobo' ] : '';
    $profit_loss = ! empty( $data[ 'profit_loss' ] ) ? $data[ 'profit_loss' ] : '';
    $total_profit = ! empty( $data[ 'total_profit' ] ) ? $data[ 'total_profit' ] : '';
    $accessory_profit = ! empty( $data[ 'accessory_profit' ] ) ? $data[ 'accessory_profit' ] : '';
    $insurance_profit = ! empty( $data[ 'insurance_profit' ] ) ? $data[ 'insurance_profit' ] : '';
    
    $split = explode("-", $date );
    
    $monthNum = $split[1];
    
    $dateObj   = DateTime::createFromFormat( '!m', $monthNum );
    $month = $dateObj->format('F');
    
    $year = $split[0];
    
    $day = $split[2];
    
    $time = date("H:i:s");
    $time_stamp = $date . ' ' . $time;
    
    if( $device == 'Choose Device' )
    {
        //no device selected
        $device = '';
    }
    
    if( $tariff == 'Choose Tariff' )
    {
        //no tariff selected
        $tariff = '';
    }
    
    if( $accessory == 'Choose Accessories' )
    {
        //no accessory selected
        $accessory = '';
    }
    
    if( $insurance_choice == 'Choose Insurance' )
    {
        //no accessory selected
        $insurance_choice = '';
    }
    
    if( $device_discount !== '' )
    {
        //a device discount was added, lets update our discount pots
         $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_tracker WHERE month = '$month'" ) );
    
        foreach ( $results as $result )
        {
            if( $result->store == $store )
            {
                $fran_pot = floatval( $result->franchise );
                $rm_pot = floatval( $result->regionalManager );
            }
        }
            
        $table_name = 'wp_fc_discount_tracker';
            
        if( $device_discount_type == 'rm' )
        {
            $pot_discount = floatval( $device_discount );
                
            $rm_pot = $rm_pot - $pot_discount;
                
            $data_update = array( 
                'regionalManager' => $rm_pot );
        }
            
        if( $device_discount_type == 'franchise' )
        {
            $pot_discount = floatval( $device_discount );
                
            $fran_pot = $fran_pot - $pot_discount;
                
            $data_update = array( 
                'franchise' => $fran_pot );
        }
            
        if( $device_discount_type == 'both' )
        {
            $pot_discount = floatval( $device_discount );
                
            $rm_pot = $rm_pot - $pot_discount;
                
            $data_update = array( 
                'regionalManager' => $rm_pot );
        }
                    
        $data_where = array( 'store' => $store , 'month' => $month , 'year' => $year );
                    
        //we have info lets run the query
        $wpdb->update( $table_name , $data_update, $data_where );
    }
        
    if( $device_discount_2 !== '' )
    {
        //a device discount was added, lets update our discount pots
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_tracker" ) );
    
        foreach ( $results as $result )
        {
            if( $result->store == $store )
            {
                $fran_pot = floatval( $result->franchise );
                $rm_pot = floatval( $result->regionalManager );
            }
        }
            
        $pot_discount = floatval( $device_discount );
                
        $fran_pot = $fran_pot - $pot_discount;
                
        $data_update = array( 
            'franchise' => $fran_pot );
    }
    
    if( $device_discount_2 !== '' )
    {
        $wpdb->insert( 'wp_fc_sales_info' , array(
            'store' => $store,
            'advisor' => $advisor,
            'type' => $type,
            'product_type' => $product_type,
            'device' => $device,
            'device_discount_type' => $device_discount_type,
            'device_discount' => $device_discount,
            'device_discount_2' => $device_discount_2,
            'tariff_type' => $tariff_type,
            'tariff' => $tariff,
            'broadband_tv' => $broadband_tv,
            'tariff_discount_type' => $tariff_discount_type,
            'tariff_discount' => $tariff_discount,
            'accessory_needed' => $accessory_needed,
            'accessory' => $accessory,
            'accessory_cost' => $accessory_cost,
            'accessory_discount' => $accessory_discount,
            'accessory_discount_value' => $accessory_discount_value,
            'insurance' => $insurance,
            'insurance_type' => $insurance_type,
            'insurance_choice' => $insurance_choice,
            'hrc' => $hrc,
            'pobo' => $pobo,
            'profit_loss' => $profit_loss,
            'total_profit' => $total_profit,
            'accessory_profit' => $accessory_profit,
            'insurance_profit' => $insurance_profit,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'sale_date' => $time_stamp
        ));
        
        if( $wpdb->insert_id > 0 )
        {
            wp_send_json_success('sale_added');
        }
    }
    else
    {
        $wpdb->insert( 'wp_fc_sales_info' , array(
            'store' => $store,
            'advisor' => $advisor,
            'type' => $type,
            'product_type' => $product_type,
            'device' => $device,
            'device_discount_type' => $device_discount_type,
            'device_discount' => $device_discount,
            'tariff_type' => $tariff_type,
            'tariff' => $tariff,
            'broadband_tv' => $broadband_tv,
            'tariff_discount_type' => $tariff_discount_type,
            'tariff_discount' => $tariff_discount,
            'accessory_needed' => $accessory_needed,
            'accessory' => $accessory,
            'accessory_cost' => $accessory_cost,
            'accessory_discount' => $accessory_discount,
            'accessory_discount_value' => $accessory_discount_value,
            'insurance' => $insurance,
            'insurance_type' => $insurance_type,
            'insurance_choice' => $insurance_choice,
            'hrc' => $hrc,
            'pobo' => $pobo,
            'profit_loss' => $profit_loss,
            'total_profit' => $total_profit,
            'accessory_profit' => $accessory_profit,
            'insurance_profit' => $insurance_profit,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'sale_date' => $time_stamp
        ));
        
        if( $wpdb->insert_id > 0 )
        {
            wp_send_json_success('sale_added');
        }
    }
}

function get_next_sale()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$employee   = ! empty( $data[ 'employee' ] ) ? $data[ 'employee' ] : '';
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE() AND advisor = '$employee'" ) );

    //get our number of sales for today
    $sales = $wpdb->num_rows;
    
    //add 1 to get our next sale number
    $nextsale = $sales + 1;
    
    wp_send_json_success( $nextsale );
}

function save_store_footfall()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	$footfall   = ! empty( $data[ 'footfall' ] ) ? $data[ 'footfall' ] : '';
	$footfall_id = ! empty( $data[ 'footfall_id' ] ) ? $data[ 'footfall_id' ] : '';
	$month   = ! empty( $data[ 'month' ] ) ? $data[ 'month' ] : '';
	$year   = ! empty( $data[ 'year' ] ) ? $data[ 'year' ] : '';
	
	//get the number of days in the month
    $days = date('t');

    //lets start by getting our current date
    $currentdate =  date( "j" );

    if( $currentdate == 1 )
    {
        //start of the month
        $pastdays = $currentdate;
    }
    else
    {
        $pastdays = $currentdate - 1;
    }
	
	//work out our average footfall and predicted footfall
	
	$store_footfall = floatval( $footfall );
    $pastdays = floatval( $pastdays );
    
    $average_footfall = ( $store_footfall / $pastdays );
    
    $average_footfall = round( $average_footfall );
    
    //now get our predicted months footfall
    $predicted_footfall = ( $average_footfall * $days );
	
	if ( $footfall_id !== '' )
	{
	    //if it exists then lets update with new info
        $table_name = 'wp_fc_footfall';
        $data_update = array( 'store' => $store, 'footfall' => $footfall, 'average_footfall' => $average_footfall, 'predicted_footfall' => $predicted_footfall, 'month' => $month, 'year' => $year );
        $data_where = array( 'id' => $footfall_id );
                
        //we have info lets run the query
        $wpdb->update( $table_name , $data_update, $data_where );
                
        if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
        {
            //failed to update, do nothing
        }
        else
        {
            wp_send_json_success( 'updated' );
        }
	}
	else
	{
    	$wpdb->insert( 'wp_fc_footfall' , array(
            'store' => $store,
            'footfall' => $footfall,
            'average_footfall' => $average_footfall, 
            'predicted_footfall' => $predicted_footfall,
            'month' => $month,
            'year' => $year
        ));
    
        if( $wpdb->insert_id > 0 )
        {
            $id = $wpdb->insert_id;
            wp_send_json_success( $id );
        }
	}
}

function save_store_kpi()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	$kpi   = ! empty( $data[ 'kpi' ] ) ? $data[ 'kpi' ] : '';
	$kpi_id = ! empty( $data[ 'kpi_id' ] ) ? $data[ 'kpi_id' ] : '';
	$month   = ! empty( $data[ 'month' ] ) ? $data[ 'month' ] : '';
	$year   = ! empty( $data[ 'year' ] ) ? $data[ 'year' ] : '';
	
	if ( $kpi_id !== '' )
	{
	    //if it exists then lets update with new info
        $table_name = 'wp_fc_kpi';
        $data_update = array( 'store' => $store, 'kpi' => $kpi, 'month' => $month, 'year' => $year );
        $data_where = array( 'id' => $kpi_id );
                
        //we have info lets run the query
        $wpdb->update( $table_name , $data_update, $data_where );
                
        if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
        {
            //failed to update, do nothing
        }
        else
        {
            wp_send_json_success( 'updated' );
        }
	}
	else
	{
    	$wpdb->insert( 'wp_fc_kpi' , array(
            'store' => $store,
            'kpi' => $kpi,
            'month' => $month,
            'year' => $year
        ));
    
        if( $wpdb->insert_id > 0 )
        {
            $id = $wpdb->insert_id;
            wp_send_json_success( $id );
        }
	}
}

function save_employee_nps()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
	
	$id   = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	$nps   = ! empty( $data[ 'nps' ] ) ? $data[ 'nps' ] : '';
	$month   = ! empty( $data[ 'month' ] ) ? $data[ 'month' ] : '';
	$year   = ! empty( $data[ 'year' ] ) ? $data[ 'year' ] : '';

    $user = get_user_by('id', $id);
    
    $user_info = get_userdata( $user->ID );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $advisor = $first_name . ' ' . $last_name;
	
	$table = 'wp_fc_nps';
	
	// Check record already exists or not
    $cntSQL = "SELECT count(*) as count FROM {$table} where advisor='". $advisor . "'" ."AND month='" . $month . "'" . "AND year='" . $year . "'";
    $record = $wpdb->get_results( $cntSQL, OBJECT );
    
    if( $record[0]->count == 0 )
    {
	    if($wpdb->insert( 'wp_fc_nps' , array('advisor' => $advisor,'nps' => $nps, 'override_nps' => '', 'override_kpi' => '','month' => $month,'year' => $year))) {
	        wp_send_json_success( 'added' );
	    }
	}
	else
	{
	    //if it exists then lets update with new info
        $data_update = array( 'advisor' => $advisor, 'nps' => $nps, 'month' => $month, 'year' => $year );
        $data_where = array( 'advisor' => $advisor, 'month' => $month, 'year' => $year );
                
        //we have info lets run the query
        $wpdb->update( $table , $data_update, $data_where );
                
        if( $wpdb->update( $table , $data_update, $data_where ) === FALSE )
        {
            //failed to update, do nothing
        }
        else
        {
            wp_send_json_success( 'updated' );
        }
	}
}

function override_commission_info()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$id   = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	$override   = ! empty( $data[ 'override' ] ) ? $data[ 'override' ] : '';
	$date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$split = explode(" ", $date );
    
    $month = $split[0];
    $year = $split[1];

    $user = get_user_by('id', $id);
    
    $user_info = get_userdata( $user->ID );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $advisor = $first_name . ' ' . $last_name;
	
	$table = 'wp_fc_nps';
	
	// Check record already exists or not
    $cntSQL = "SELECT count(*) as count FROM {$table} where advisor='". $advisor . "'" ."AND month='" . $month . "'" . "AND year='" . $year . "'";
    $record = $wpdb->get_results( $cntSQL, OBJECT );
    
    if( $record[0]->count == 0 )
    {
        if($override == 'kpi') {
            if($wpdb->insert( 'wp_fc_nps' , array('advisor' => $advisor,'nps' => '', 'override_nps' => '', 'override_kpi' => 'yes','month' => $month,'year' => $year))) {
    	        wp_send_json_success( 'added' );
    	    }
        } else {
            if($wpdb->insert( 'wp_fc_nps' , array('advisor' => $advisor,'nps' => '', 'override_nps' => 'yes', 'override_kpi' => '','month' => $month,'year' => $year))) {
    	        wp_send_json_success( 'added' );
    	    }
        }
	}
	else
	{
	    //if it exists then lets update with new info
	    if($override == 'kpi') {
	        $data_update = array( 'override_kpi' => 'yes' );
        } else {
            $data_update = array( 'override_nps' => 'yes' );
        }
        
        $data_where = array( 'advisor' => $advisor, 'month' => $month, 'year' => $year );
                
        //we have info lets run the query
        $wpdb->update( $table , $data_update, $data_where );
                
        if( $wpdb->update( $table , $data_update, $data_where ) === FALSE )
        {
            //failed to update, do nothing
        }
        else
        {
            wp_send_json_success( 'updated' );
        }
	}
}

function remove_commission_override() 
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$advisor   = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	$remove   = ! empty( $data[ 'remove' ] ) ? $data[ 'remove' ] : '';
	$date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$split = explode(" ", $date );
    
    $month = $split[0];
    $year = $split[1];
	
	$table = 'wp_fc_nps';;
	
	// Check record already exists or not
    $cntSQL = "SELECT count(*) as count FROM {$table} where advisor='". $advisor . "'" ."AND month='" . $month . "'" . "AND year='" . $year . "'";
    $record = $wpdb->get_results( $cntSQL, OBJECT );
    
    if( $record[0]->count == 0 )
    {
        if($remove == 'kpi') {
            if($wpdb->insert( 'wp_fc_nps' , array('advisor' => $advisor,'nps' => '', 'override_nps' => '', 'override_kpi' => '','month' => $month,'year' => $year))) {
    	        wp_send_json_success( 'added' );
    	    }
        } else {
            if($wpdb->insert( 'wp_fc_nps' , array('advisor' => $advisor,'nps' => '', 'override_nps' => '', 'override_kpi' => '','month' => $month,'year' => $year))) {
    	        wp_send_json_success( 'added' );
    	    }
        }
	}
	else
	{
	    //if it exists then lets update with new info
	    if($remove == 'kpi') {
	        $data_update = array( 'override_kpi' => '' );
        } else {
            $data_update = array( 'override_nps' => '' );
        }
        
        $data_where = array( 'advisor' => $advisor, 'month' => $month, 'year' => $year );
                
        //we have info lets run the query
        $wpdb->update( $table , $data_update, $data_where );
                
        if( $wpdb->update( $table , $data_update, $data_where ) === FALSE )
        {
            //failed to update, do nothing
        }
        else
        {
            wp_send_json_success( 'updated' );
        }
	}
}

function get_store_footfall()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();

	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$month = date('F');
                    
    $year = date('Y');
    
    //get the number of days in the month
    $days = date('t');
    
    //lets start by getting our current date
    $currentdate =  date( "j" );

    if( $currentdate == 1 )
    {
        //start of the month
        $pastdays = $currentdate;
    }
    else
    {
        $pastdays = $currentdate - 1;
    }
	
	//work out our average footfall and predicted footfall
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_footfall" ) );

	foreach ( $results as $result )
    {
        if ( $result->store == $store )
        {
            if( $result->month == $month && $result->year == $year )
            {
                $footfall = $result->footfall;
                $footfall_id = $result->id;
            }
        }
    }
    
    if( $footfall !== '' )
    {
    	$store_footfall = floatval( $footfall );
        $pastdays = floatval( $pastdays );
        
        $average_footfall = ( $store_footfall / $pastdays );
        
        $average_footfall = round( $average_footfall );
        
        //now get our predicted months footfall
        $predicted_footfall = ( $average_footfall * $days );
        
        $success[ 'footfall' ] = $store_footfall;
        $success[ 'average_footfall' ] = $average_footfall;
        $success[ 'predicted_footfall' ] = $predicted_footfall;
        $success[ 'id' ] = $footfall_id;
        
        wp_send_json_success( $success );
    }
    else
    {
        wp_send_json_success( 'no data' );
    }
}

function get_store_kpi()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();

	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$month = date('F');
                    
    $year = date('Y');
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_kpi" ) );

    foreach ( $results as $result )
    {
        if ( $result->store == $store )
        {
            if( $result->month == $month && $result->year == $year )
            {
                $kpi = $result->kpi;
                $kpi_id = $result->id;
            }
        }
    }
    
    if( is_null( $kpi )  )
    {
        wp_send_json_success( 'no data' );
    }
    else
    {
        $success[ 'kpi' ] = $kpi;
        $success[ 'id' ] = $kpi_id;
        
        wp_send_json_success( $success );
    }
}

function get_employee_nps()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();

	$data = $_POST;
	
	$id   = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	
	$month = ! empty( $data[ 'month' ] ) ? $data[ 'month' ] : '';
                    
    $year = ! empty( $data[ 'year' ] ) ? $data[ 'year' ] : '';
    
    $user = get_user_by('id', $id);
    
    $user_info = get_userdata( $user->ID );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $advisor = $first_name . ' ' . $last_name;
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_nps" ) );

    foreach ( $results as $result )
    {
        if ( $result->advisor == $advisor )
        {
            if( $result->month == $month && $result->year == $year )
            {
                $nps = $result->nps;
            }
        }
    }
    
    if( is_null( $nps )  )
    {
        wp_send_json_success( '' );
    }
    else
    {
        wp_send_json_success( $nps );
    }
}

function get_store_nps()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();

	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$month = ! empty( $data[ 'month' ] ) ? $data[ 'month' ] : '';
                    
    $year = ! empty( $data[ 'year' ] ) ? $data[ 'year' ] : '';
    
    $users = get_users();
	    
    $employees = array();
    
    foreach ( $users as $user ) 
    {
        $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
        $employee_store = strtolower( $employee_store );
            
        if( $employee_store === strtolower($store) )
        {
            $id = $user->ID;
            $user_info = get_userdata( $id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
        
            $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        }
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_nps" ) );

    foreach ( $results as $result )
    {
        foreach($employees as $id => $employee) {
            if ( $result->advisor == $employee )
            {
                if( $result->month == $month && $result->year == $year )
                {
                    $storeNPS[$id] = $result;
                }
            }
        }
    }
    
    $user = wp_get_current_user();
    
    if(!empty($storeNPS)) {
        ob_start(); ?>
        
        <h3 style="text-align: center; margin-top:20px; margin-bottom:20px;"><?php echo $store . ' NPS Percentages for ' . $month . ' ' . $year; ?></h3>
        
        <table class="table">
            <thead>
                <tr>
                    <th class="col">Advisor</th>
                    <th class="col">NPS Percentage</th>
                    <th class="col">Override NPS</th>
                    <th class="col">Override KPI</th>
                    
                    <?php if( $user && in_array( 'senior_manager', $user->roles ) )
                    { ?>
                        <th class="col">Remove KPI Override</th>
                        <th class="col">Remove NPS Override</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            
            <?php foreach($storeNPS as $id => $nps) { 
            ?>
                <tr>
                    <td><?php echo $nps->advisor; ?></td>
                    <td><?php echo $nps->nps; ?></td>
                    <td><?php echo $nps->override_nps; ?></td>
                    <td><?php echo $nps->override_kpi; ?></td>
                    
                    <?php if( $user && in_array( 'senior_manager', $user->roles ) )
                    { 
                        if($nps->override_kpi == 'yes') { ?>
                            <td><button type="button" advisor="<?php echo $nps->advisor;; ?>" id="remove-kpi-override" class="woocommerce-Button button" name="remove-kpi-override" value="<?php esc_attr_e( 'Remove KPI Override', 'woocommerce' ); ?>"><?php esc_html_e( 'Remove KPI Override', 'woocommerce' ); ?></button></td>
                        <?php } else { ?>
                            <td></td>
                        <?php }
                        
                        if($nps->override_nps == 'yes') { ?>
                            <td><button type="button" advisor="<?php echo $nps->advisor;; ?>" id="remove-nps-override" class="woocommerce-Button button" name="remove-nps-override" value="<?php esc_attr_e( 'Remove NPS Override', 'woocommerce' ); ?>"><?php esc_html_e( 'Remove NPS Override', 'woocommerce' ); ?></button></td>
                        <?php } else { ?>
                            <td></td>
                        <?php }
                    }
                    ?>
                </tr>
            <?php } ?>
            
            </tbody>
        </table>
        
        <?php 
        wp_Send_json_success(ob_get_clean());
    } else {
        wp_Send_json_success('No NPS values to show for ' . $store . ' in ' . $month . ' ' . $year);
    }
}

function get_sales_info()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	//array to hold all our sales values
	$sales= array();
	
	//temporary array to hold our current sales
	$sale = array();
	
	$data = $_POST;
	
	$advisor   = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	
	$date      = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$action    = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
	if( $action == 'approve' )
	{
	    $results = $wpdb->get_results( $wpdb->prepare( "SELECT id, product_type FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = '$date' AND advisor = '$advisor' AND approve_sale = ''" ) );
	}
	else
	{
	    $results = $wpdb->get_results( $wpdb->prepare( "SELECT id, product_type FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = '$date' AND advisor = '$advisor'" ) );
	}
	
	foreach ( $results as $result )
    {
        //clear our temporary array
        unset($sale);
        $sale = array();
        
        //add our database result to our temporary array
        $sale[] = $result;
        
        //add the value in the temporary array to our sales array
        $sales[] = $sale;
    }
    
    wp_send_json_success( $sales );
}

function get_senior_sales_info()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	//array to hold all our sales values
	$sales= array();
	
	//temporary array to hold our current sales
	$sale = array();
	
	$data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$date      = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = '$date' AND store = '$store'" ) );
	
	foreach ( $results as $result )
    {
        //clear our temporary array
        unset($sale);
        $sale = array();
        
        //add our database result to our temporary array
        $sale[] = $result;
        
        //add the value in the temporary array to our sales array
        $sales[] = $sale;
    }
    
    wp_send_json_success( $sales );
}

function get_sale()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$id   = ! empty( $data[ 'id' ] ) ? $data[ 'id' ] : '';

	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE id = '$id'" ) );
	
	wp_send_json_success( $results );
}

function get_unapproved_info()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	//array to hold all our sales values
	$sales= array();
	
	//temporary array to hold our current sales
	$sale = array();
	
	$data = $_POST;
	
	$advisor   = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	
	$date      = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$split = explode("-", $date );
    
    $monthNum = $split[1];
    
    $dateObj   = DateTime::createFromFormat( '!m', $monthNum );
    $month = $dateObj->format('F');
    
    $year = $split[0];
    
    $day = $split[2];
	
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '$advisor' AND sale_date = '$date'" ) );
	
	foreach ( $results as $result )
    {
        //clear our temporary array
        unset($sale);
        $sale = array();
        
        //add our database result to our temporary array
        $sale[] = $result;
            
        //add the value in the temporary array to our sales array
        $sales[] = $sale;
    }
    
    wp_send_json_success( $sales );
}

function multi_users_list()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
    
    $data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$store = strtolower( $store );
	
	if( $store !== '' )
	{
	    $users = get_users();
	    
        $employees = array();
        
        foreach ( $users as $user ) 
        {
            $employee_store = get_user_meta( $user->ID, 'store_location' , true );
                
            $employee_store = strtolower( $employee_store );
                
            if( $employee_store === $store )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
            
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
        }
        
        $html = '';
        
        if( ! empty( $employees ) )
        {
            $html .= '<option value="">Select User to Edit</option>';
            
            foreach( $employees as $id => $employee )
            {
                 $html .= '<option value="' . $id . '">' . $employee . '</option>';
            }
        }
        else
        {
            $store = ucfirst( $store );
            
            $html .= '<option value="">No Users Exist for the ' . $store . ' Store</option>';
        }
        
        wp_send_json_success( $html );
	}
}

function commission_users_list()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
    
    $data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$store = strtolower( $store );
	
	if( $store !== '' )
	{
	    $users = get_users();
	    
        $employees = array();
        
        foreach ( $users as $user ) 
        {
            $employee_store = get_user_meta( $user->ID, 'store_location' , true );
                
            $employee_store = strtolower( $employee_store );
                
            if( $employee_store === $store )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
            
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
        }
        
        $html = '';
        
        if( ! empty( $employees ) )
        {
            $html .= '<option value="">Choose Advisor</option>';
            
            foreach( $employees as $id => $employee )
            {
                 $html .= '<option value="' . $id . '">' . $employee . '</option>';
            }
        }
        else
        {
            $store = ucfirst( $store );
            
            $html .= '<option value="">No Users Exist for the ' . $store . ' Store</option>';
        }
        
        wp_send_json_success( $html );
	}
}

function get_hours_rota()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
    
    $data = $_POST;
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$store = strtolower( $store );
	
	$rota_week1 = array();
    $rota_week2 = array();
    $rota_week3 = array();
    $rota_week4 = array();
    $rota_week5 = array();
    
    $month = date('F');
                    
    $year = date('Y');
    
    $days = date('t');
    
    if( $store !== '' )
    {
        $users = get_users();
	    
        $employees = array();
        
        foreach ( $users as $user ) 
        {
            $employee_store = get_user_meta( $user->ID, 'store_location' , true );
                
            $employee_store = strtolower( $employee_store );
                
            if( $employee_store === $store )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
            
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
        }
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_rota" ) );
    
    foreach( $employees as $id => $employee )
    {
        foreach ( $results as $result )
        {
            if( $result->week == '1' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $rota_week1[ $employee ] = $result;
            }
            
            if( $result->week == '2' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $rota_week2[ $employee ] = $result;
            }
            
            if( $result->week == '3' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $rota_week3[ $employee ] = $result;
            }
            
            if( $result->week == '4' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $rota_week4[ $employee ] = $result;
            }
            
            if( $result->week == '5' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $rota_week5[ $employee ] = $result;
            }
        }
    }
    
	if( $store !== '' )
	{
        $wk1 = '';
        $wk2 = '';
        $wk3 = '';
        $wk4 = '';
        $wk5 = '';
        
        if( ! empty( $employees ) )
        {
            foreach( $employees as $id => $employee )
            {
                $week1 = $rota_week1[ $employee ];
                $week2 = $rota_week2[ $employee ];
                $week3 = $rota_week3[ $employee ];
                $week4 = $rota_week4[ $employee ];
                
                if( $days > 28 )
                {
                    $week5 = $rota_week5[ $employee ];
                }
                
                if( ! empty( $week1 ) )
                {
                    $wk1 .= '<tr class="week1">';
                    $wk1 .=  '<th scope="col">' . $employee . '</th>';
                    
                    $total = intval( $week1->day1 ) + intval( $week1->day2 ) + intval( $week1->day3 ) + intval( $week1->day4 ) + intval( $week1->day5 ) + intval( $week1->day6 ) + intval( $week1->day7 );
                    
                    if( $total == 0 )
                    {
                        $total = '';
                    }
                    
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week1->day1 . '</td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week1->day2 . '</td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week1->day3 . '</td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week1->day4 . '</td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week1->day5 . '</td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week1->day6 . '</td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week1->day7 . '</td>';
                    $wk1 .= '<td class="total">' . $total .'</td>';
                    $wk1 .= '</tr>';
                }
                else
                {
                    $wk1 .= '<tr class="week1">';
                    $wk1 .=  '<th scope="col">' . $employee . '</th>';
                    
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk1 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk1 .= '<td class="total"></td>';
                    $wk1 .= '</tr>';
                }
                
                if( ! empty( $week2 ) )
                {
                    $wk2 .=  '<tr class="week2">';
                    $wk2 .= '<th scope="col">' . $employee . '</th>';
                    
                    $total = intval( $week2->day1 ) + intval( $week2->day2 ) + intval( $week2->day3 ) + intval( $week2->day4 ) + intval( $week2->day5 ) + intval( $week2->day6 ) + intval( $week2->day7 );
                                    
                    if( $total == 0 )
                    {
                        $total = '';
                    }
                    
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week2->day1 . '</td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week2->day2 . '</td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week2->day3 . '</td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week2->day4 . '</td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week2->day5 . '</td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week2->day6 . '</td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week2->day7 . '</td>';
                    $wk2 .= '<td class="total">' . $total .'</td>';
                    $wk2 .= '</tr>';
                }
                else
                {
                    $wk2 .=  '<tr class="week2">';
                    $wk2 .= '<th scope="col">' . $employee . '</th>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk2 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk2 .= '<td class="total"></td>';
                    $wk2 .= '</tr>';
                }
                
                if( ! empty( $week3 ) )
                {
                    $wk3 .= '<tr class="week3">';
                    $wk3 .= '<th scope="col">' . $employee . '</th>';
                    
                    $total = intval( $week3->day1 ) + intval( $week3->day2 ) + intval( $week3->day3 ) + intval( $week3->day4 ) + intval( $week3->day5 ) + intval( $week3->day6 ) + intval( $week3->day7 );
                                    
                    if( $total == 0 )
                    {
                        $total = '';
                    }
                    
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week3->day1 . '</td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week3->day2 . '</td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week3->day3 . '</td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week3->day4 . '</td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week3->day5 . '</td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week3->day6 . '</td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week3->day7 . '</td>';
                    $wk3 .= '<td class="total">' . $total .'</td>';
                    $wk3 .= '</tr>';
                }
                else
                {
                    $wk3 .= '<tr class="week3">';
                    $wk3 .= '<th scope="col">' . $employee . '</th>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk3 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk3 .= '<td class="total"></td>';
                    $wk3 .= '</tr>';
                }
                    
                if( ! empty( $week4 ) )
                {  
                    $wk4 .= '<tr class="week4">';
                    $wk4 .= '<th scope="col">' . $employee . '</th>';
                    
                    $total = intval( $week4->day1 ) + intval( $week4->day2 ) + intval( $week4->day3 ) + intval( $week4->day4 ) + intval( $week4->day5 ) + intval( $week4->day6 ) + intval( $week4->day7 );
                                    
                    if( $total == 0 )
                    {
                        $total = '';
                    }
                    
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week4->day1 . '</td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week4->day2 . '</td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week4->day3 . '</td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week4->day4 . '</td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week4->day5 . '</td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week4->day6 . '</td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week4->day7 . '</td>';
                    $wk4 .= '<td class="total">' . $total .'</td>';
                    $wk4 .= '</tr>';
                }
                else
                {
                    $wk4 .= '<tr class="week4">';
                    $wk4 .= '<th scope="col">' . $employee . '</th>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk4 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                    $wk4 .= '<td class="total"></td>';
                    $wk4 .= '</tr>';
                }
                
                if( $days > 28 )
                {
                    if( ! empty( $week5 ) )
                    { 
                        $wk5 .= '<tr class="week5">';
                        $wk5 .= '<th scope="col">' . $employee . '</th>';
                        
                        $total = intval( $week5->day1 ) + intval( $week5->day2 ) + intval( $week5->day3 ) + intval( $week5->day4 ) + intval( $week5->day5 ) + intval( $week5->day6 ) + intval( $week5->day7 );
                                        
                        if( $total == 0 )
                        {
                            $total = '';
                        }
                        
                        if( $days == 29 )
                        {
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week5->day1 . '</td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="total">' . $total .'</td>';
                            $wk5 .= '</tr>';
                        }
                            
                        elseif( $days == 30 )
                        {
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week5->day1 . '</td>';
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week5->day2 . '</td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="total">' . $total .'</td>';
                            $wk5 .= '</tr>';
                        }
                            
                        elseif( $days == 31 )
                        {
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week5->day1 . '</td>';
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week5->day2 . '</td>';
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)">' . $week5->day3 . '</td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="total">' . $total .'</td>';
                            $wk5 .= '</tr>';
                        }
                    }
                    else
                    {
                        $wk5 .= '<tr class="week5">';
                        $wk5 .= '<th scope="col">' . $employee . '</th>';
                        
                        if( $days == 29 )
                        {
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="total"></td>';
                            $wk5 .= '</tr>';
                        }
                            
                        elseif( $days == 30 )
                        {
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="total"></td>';
                            $wk5 .= '</tr>';
                        }
                            
                        elseif( $days == 31 )
                        {
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                            $wk5 .= '<td contenteditable="true" onkeyup="totalHours(this)"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="blank-row"></td>';
                            $wk5 .= '<td class="total"></td>';
                            $wk5 .= '</tr>';
                        }
                    }
                }
            }
        }
        else
        {
            wp_send_json_success( 'no_users' );
        }
        
        $success[ 'week1' ] = $wk1;
        $success[ 'week2' ] = $wk2;
        $success[ 'week3' ] = $wk3;
        $success[ 'week4' ] = $wk4;
        
        if( $days > 28 )
        {
            $success[ 'week5' ] = $wk5;
        }
        
        wp_send_json_success( $success );
	}
}

function save_rota_hours()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$days = date('t');
                
    $month = date('F');;
                
    $year = date('Y');
    
    $advisor = '';
    
    $data = $_POST;
	
	$week1   = ! empty( $data[ 'week1' ] ) ? $data[ 'week1' ] : '';
	$week2   = ! empty( $data[ 'week2' ] ) ? $data[ 'week2' ] : '';
	$week3   = ! empty( $data[ 'week3' ] ) ? $data[ 'week3' ] : '';
	$week4   = ! empty( $data[ 'week4' ] ) ? $data[ 'week4' ] : '';
	
	if( $days > 28 )
	{
	    $week5   = ! empty( $data[ 'week5' ] ) ? $data[ 'week5' ] : '';
	}
	
	$store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';

	$table = 'wp_fc_rota';
	
	$week = '';
	
    foreach( $week1 as $item ) 
    { 
        $week = '1';
        
        // Check record already exists or not
        $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND week='" . $week ."'" . "AND month='" . $month . "'" . "AND year='" . $year . "'" . "AND advisor='" . $item[ 'name' ] . "'";
        $record = $wpdb->get_results( $cntSQL, OBJECT );

        if( $record[0]->count == 0 )
        {
            // Check if variable is empty or not
            if( ! empty( $item ) ) 
            {
                // Insert Record
                $wpdb->insert( $table , array(
                    'advisor' => $item[ 'name' ],
                    'week' => $week,
                    'day1' => $item[ '1' ],
                    'day2' => $item[ '2' ],
                    'day3' => $item[ '3' ],
                    'day4' => $item[ '4' ],
                    'day5' => $item[ '5' ],
                    'day6' => $item[ '6' ],
                    'day7' => $item[ '7' ],
                    'total_hours' => $item[ 'total_hours' ],
                    'month' => $month,
                    'year' => $year,
                    'store' => $store
                ));

                if( $wpdb->insert_id > 0 )
                {
                    $totalInserted++;
                }
            }
        }
        else
        {
            //if it exists then lets update with new info
            $table_name = $table;
            $data_update = array( 
                'advisor' => $item[ 'name' ], 
                'week' => $week, 
                'day1' => $item[ '1' ], 
                'day2' => $item[ '2' ], 
                'day3' => $item[ '3' ], 
                'day4' => $item[ '4' ], 
                'day5' => $item[ '5' ], 
                'day6' => $item[ '6' ], 
                'day7' => $item[ '7' ], 
                'total_hours' => $item[ 'total_hours' ], 
                'month' => $month, 
                'year' => $year, 
                'store' => $store );
            $data_where = array( 'store' => $store, 'week' => $week, 'month' => $month, 'year' => $year, 'advisor' => $item[ 'name' ] );
            
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );

            if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
            {
                //failed to update, do nothing
            }
            else
            {
                $totalUpdated++;
            }
        }
    }
    
    foreach( $week2 as $item ) 
    { 
        $week = '2';
        
        // Check record already exists or not
        $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND week='" . $week ."'" . "AND month='" . $month . "'" . "AND year='" . $year . "'" . "AND advisor='" . $item[ 'name' ] . "'";
        $record = $wpdb->get_results( $cntSQL, OBJECT );

        if( $record[0]->count == 0 )
        {
            // Check if variable is empty or not
            if( ! empty( $item ) ) 
            {
                // Insert Record
                $wpdb->insert( $table , array(
                    'advisor' => $item[ 'name' ],
                    'week' => $week,
                    'day1' => $item[ '1' ],
                    'day2' => $item[ '2' ],
                    'day3' => $item[ '3' ],
                    'day4' => $item[ '4' ],
                    'day5' => $item[ '5' ],
                    'day6' => $item[ '6' ],
                    'day7' => $item[ '7' ],
                    'total_hours' => $item[ 'total_hours' ],
                    'month' => $month,
                    'year' => $year,
                    'store' => $store
                ));

                if( $wpdb->insert_id > 0 )
                {
                    $totalInserted++;
                }
            }
        }
        else
        {
            //if it exists then lets update with new info
            $table_name = $table;
            $data_update = array( 
                'advisor' => $item[ 'name' ], 
                'week' => $week, 
                'day1' => $item[ '1' ], 
                'day2' => $item[ '2' ], 
                'day3' => $item[ '3' ], 
                'day4' => $item[ '4' ], 
                'day5' => $item[ '5' ], 
                'day6' => $item[ '6' ], 
                'day7' => $item[ '7' ], 
                'total_hours' => $item[ 'total_hours' ], 
                'month' => $month, 
                'year' => $year, 
                'store' => $store );            
            $data_where = array( 'store' => $store, 'week' => $week, 'month' => $month, 'year' => $year, 'advisor' => $item[ 'name' ] );
            
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );

            if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
            {
                //failed to update, do nothing
            }
            else
            {
                $totalUpdated++;
            }
        }
    }
    
    foreach( $week3 as $item ) 
    { 
        $week = '3';
        
        // Check record already exists or not
        $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND week='" . $week ."'" . "AND month='" . $month . "'" . "AND year='" . $year . "'" . "AND advisor='" . $item[ 'name' ] . "'";
        $record = $wpdb->get_results( $cntSQL, OBJECT );

        if( $record[0]->count == 0 )
        {
            // Check if variable is empty or not
            if( ! empty( $item ) ) 
            {
                // Insert Record
                $wpdb->insert( $table , array(
                    'advisor' => $item[ 'name' ],
                    'week' => $week,
                    'day1' => $item[ '1' ],
                    'day2' => $item[ '2' ],
                    'day3' => $item[ '3' ],
                    'day4' => $item[ '4' ],
                    'day5' => $item[ '5' ],
                    'day6' => $item[ '6' ],
                    'day7' => $item[ '7' ],
                    'total_hours' => $item[ 'total_hours' ],
                    'month' => $month,
                    'year' => $year,
                    'store' => $store
                ));

                if( $wpdb->insert_id > 0 )
                {
                    $totalInserted++;
                }
            }
        }
        else
        {
            //if it exists then lets update with new info
            $table_name = $table;
            $data_update = array( 
                'advisor' => $item[ 'name' ], 
                'week' => $week, 
                'day1' => $item[ '1' ], 
                'day2' => $item[ '2' ], 
                'day3' => $item[ '3' ], 
                'day4' => $item[ '4' ], 
                'day5' => $item[ '5' ], 
                'day6' => $item[ '6' ], 
                'day7' => $item[ '7' ], 
                'total_hours' => $item[ 'total_hours' ], 
                'month' => $month, 
                'year' => $year, 
                'store' => $store );            
            $data_where = array( 'store' => $store, 'week' => $week, 'month' => $month, 'year' => $year, 'advisor' => $item[ 'name' ] );
            
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );

            if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
            {
                //failed to update, do nothing
            }
            else
            {
                $totalUpdated++;
            }
        }
    }
    
    foreach( $week4 as $item ) 
    { 
        $week = '4';
        
        // Check record already exists or not
        $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND week='" . $week ."'" . "AND month='" . $month . "'" . "AND year='" . $year . "'" . "AND advisor='" . $item[ 'name' ] . "'";
        $record = $wpdb->get_results( $cntSQL, OBJECT );

        if( $record[0]->count == 0 )
        {
            // Check if variable is empty or not
            if( ! empty( $item ) ) 
            {
                // Insert Record
                $wpdb->insert( $table , array(
                    'advisor' => $item[ 'name' ],
                    'week' => $week,
                    'day1' => $item[ '1' ],
                    'day2' => $item[ '2' ],
                    'day3' => $item[ '3' ],
                    'day4' => $item[ '4' ],
                    'day5' => $item[ '5' ],
                    'day6' => $item[ '6' ],
                    'day7' => $item[ '7' ],
                    'total_hours' => $item[ 'total_hours' ],
                    'month' => $month,
                    'year' => $year,
                    'store' => $store
                ));

                if( $wpdb->insert_id > 0 )
                {
                    $totalInserted++;
                }
            }
        }
        else
        {
            //if it exists then lets update with new info
            $table_name = $table;
            $data_update = array( 
                'advisor' => $item[ 'name' ], 
                'week' => $week, 
                'day1' => $item[ '1' ], 
                'day2' => $item[ '2' ], 
                'day3' => $item[ '3' ], 
                'day4' => $item[ '4' ], 
                'day5' => $item[ '5' ], 
                'day6' => $item[ '6' ], 
                'day7' => $item[ '7' ], 
                'total_hours' => $item[ 'total_hours' ], 
                'month' => $month, 
                'year' => $year, 
                'store' => $store );            
            $data_where = array( 'store' => $store, 'week' => $week, 'month' => $month, 'year' => $year, 'advisor' => $item[ 'name' ] );
            
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );

            if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
            {
                //failed to update, do nothing
            }
            else
            {
                $totalUpdated++;
            }
        }
    }
    
    if( $days > 28 )
    {
        foreach( $week5 as $item ) 
        { 
            $week = '5';
            
            // Check record already exists or not
            $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND week='" . $week ."'" . "AND month='" . $month . "'" . "AND year='" . $year . "'" . "AND advisor='" . $item[ 'name' ] . "'";
            $record = $wpdb->get_results( $cntSQL, OBJECT );
    
            if( $record[0]->count == 0 )
            {
                // Check if variable is empty or not
                if( ! empty( $item ) ) 
                {
                    // Insert Record
                    $wpdb->insert( $table , array(
                        'advisor' => $item[ 'name' ],
                        'week' => $week,
                        'day1' => $item[ '1' ],
                        'day2' => $item[ '2' ],
                        'day3' => $item[ '3' ],
                        'day4' => $item[ '4' ],
                        'day5' => $item[ '5' ],
                        'day6' => $item[ '6' ],
                        'day7' => $item[ '7' ],
                        'total_hours' => $item[ 'total_hours' ],
                        'month' => $month,
                        'year' => $year,
                        'store' => $store
                    ));
    
                    if( $wpdb->insert_id > 0 )
                    {
                        $totalInserted++;
                    }
                }
            }
            else
            {
                //if it exists then lets update with new info
                $table_name = $table;
                $data_update = array( 
                    'advisor' => $item[ 'name' ], 
                    'week' => $week, 
                    'day1' => $item[ '1' ], 
                    'day2' => $item[ '2' ], 
                    'day3' => $item[ '3' ], 
                    'day4' => $item[ '4' ], 
                    'day5' => $item[ '5' ], 
                    'day6' => $item[ '6' ], 
                    'day7' => $item[ '7' ], 
                    'total_hours' => $item[ 'total_hours' ], 
                    'month' => $month, 
                    'year' => $year, 
                    'store' => $store );                
                $data_where = array( 'store' => $store, 'week' => $week, 'month' => $month, 'year' => $year, 'advisor' => $item[ 'name' ] );
                
                //we have info lets run the query
                $wpdb->update( $table_name , $data_update, $data_where );
    
                if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
                {
                    //failed to update, do nothing
                }
                else
                {
                    $totalUpdated++;
                }
            }
        }
    }
    
    $success[ 'updated' ] = $totalUpdated;
    $success['inserted' ] = $totalInserted;
    
    wp_send_json_success( $success );
}

function save_store_targets()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
                
    $month = date('F');;
                
    $year = date('Y');
    
    $data = $_POST;
	
	$targets = ! empty( $data[ 'targets' ] ) ? $data[ 'targets' ] : '';
	
	$table = 'wp_fc_sales_targets';
	
    foreach( $targets as $target ) 
    { 
        // Check record already exists or not
        $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $target['store'] . "'" . "AND month='" . $month . "'" . "AND year='" . $year . "'";
        $record = $wpdb->get_results( $cntSQL, OBJECT );

        if( $record[0]->count == 0 )
        {
            // Check if variable is empty or not
            if( ! empty( $target ) ) 
            {
                // Insert Record
                $wpdb->insert( $table , array(
                    'store' => $target[ 'store' ],
                    'new_handset' => $target[ 'new_handset' ],
                    'new_sim' => $target[ 'new_sim' ],
                    'new_data' => $target[ 'new_data' ],
                    'upgrade_handset' => $target[ 'upgrade_handset' ],
                    'upgrade_sim' => $target[ 'upgrade_sim' ],
                    'new_bt' => $target[ 'new_bt' ],
                    'regrade' => $target[ 'regrade' ],
                    'insurance' => $target[ 'insurance' ],
                    'profit_target' => $target[ 'profit_target' ],
                    'month' => $month,
                    'year' => $year
                ));

                if( $wpdb->insert_id > 0 )
                {
                    $totalInserted++;
                }
            }
        }
        else
        {
            //if it exists then lets update with new info
            $table_name = $table;
            $data_update = array( 
                'store' => $target[ 'store' ],
                'new_handset' => $target[ 'new_handset' ],
                'new_sim' => $target[ 'new_sim' ],
                'new_data' => $target[ 'new_data' ],
                'upgrade_handset' => $target[ 'upgrade_handset' ],
                'upgrade_sim' => $target[ 'upgrade_sim' ],
                'new_bt' => $target[ 'new_bt' ],
                'regrade' => $target[ 'regrade' ],
                'insurance' => $target[ 'insurance' ],
                'profit_target' => $target[ 'profit_target' ],
                'month' => $month,
                'year' => $year
            );
            
            $data_where = array( 'store' => $target[ 'store' ], 'month' => $month, 'year' => $year);
            
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );

            if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
            {
                //failed to update, do nothing
            }
            else
            {
                $totalUpdated++;
            }
        }
    }
    
    $success[ 'updated' ] = $totalUpdated;
    $success['inserted' ] = $totalInserted;
    
    wp_send_json_success( $success );
}

function save_sales_multipliers()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$multipliers = ! empty( $data[ 'multipliers' ] ) ? $data[ 'multipliers' ] : '';
	
	$day = date('d');
	$month = date('F');
    $year = date('Y');
	
	$table = 'wp_fc_sales_multipliers';
	
    foreach( $multipliers as $multiplier ) 
    { 
        // Check if variable is empty or not
        if( ! empty( $multiplier ) ) 
        {
            // Insert Record
            $wpdb->insert( $table , array(
                'multiplier' => $multiplier[ 'multiplier' ],
                'multiplier_value' => $multiplier[ 'value' ],
                'valid_from' => $day . ' ' . $month . ' ' . $year
            ));

            if( $wpdb->insert_id > 0 )
            {
                $totalInserted++;
            }
        }
    }
    
    $success['inserted' ] = $totalInserted;
    
    wp_send_json_success( $success );
}

function get_banking_information()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
    
    $data = $_POST;
    
    $store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    
    $date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    
    $dateSplit = explode( ' ', $date );
    
    $month = $dateSplit[0];
                
    $year = $dateSplit[1];
    
    $days = cal_days_in_month(CAL_GREGORIAN, date('m'), $year);
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_banking" ) );
    
    foreach ( $results as $result )
    {
        if( $result->store == $store && $result->month == $month && $result->year == $year )
        {
            $store_banking[ $result->day ] = $result;
        }
    }
    
    ob_start(); ?>
    
    <h2 class="text-center"><?php echo $store; ?> Banking</h2>
        
    <p>Do not enter your figures with a £ sign as the form only works with numbers, if the total is £5.99 enter 5.99.</p>
    <table class="table spacer banking-table" store="<?php echo $store; ?>">
        <thead>
            <tr>
                <th class="col-xs-3" scope="col">Date</th>
                <th class="col-xs-3" scope="col">Till 1</th>
                <th class="col-xs-3" scope="col">Till 2</th>
                <th class="col-xs-3" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for( $i = 1; $i <= $days; $i++ )
                { 
                    $num = str_pad($i,2,"0",STR_PAD_LEFT);
                    $date = $num . ' ' . $month . ' ' . $year;
                    
                    if( ! empty( $store_banking[ $num ] ) )
                    { 
                        $bankFigure = $store_banking[ $num ];
                    ?>
                        <tr class="banking">
                            <th scope="col"><?php echo $date; ?></th>
                            <td contenteditable="true" onkeyup="totalMoney(this)"><?php echo $bankFigure->till_1; ?></td>
                            <td contenteditable="true" onkeyup="totalMoney(this)"><?php echo $bankFigure->till_2; ?></td>
                            <td><?php echo $bankFigure->total; ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr class="banking">
                            <th scope="col"><?php echo $date; ?></th>
                            <td contenteditable="true" onkeyup="totalMoney(this)"></td>
                            <td contenteditable="true" onkeyup="totalMoney(this)"></td>
                            <td></td>
                            
                        </tr>
                    <?php }
                } ?>
        </tbody>
    </table>
    
    <?php
    echo ob_get_clean();
    wp_die();
}

function save_banking_information()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
    
    $data = $_POST;
    
    $date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    
    $dateSplit = explode( ' ', $date );
    
    $month = $dateSplit[0];
                
    $year = $dateSplit[1];
    
    $store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$banking = ! empty( $data[ 'banking' ] ) ? $data[ 'banking' ] : '';
	
	$table = 'wp_fc_banking';
	
    foreach( $banking as $bankFigure ) 
    { 
        $dateString = explode(" ", $bankFigure['date']);
        $day = $dateString[0];
        
        // Check record already exists or not
        $cntSQL = "SELECT count(*) as count FROM {$table} where store='". $store . "'" . "AND day='". $day . "'" . "AND month='" . $month . "'" . "AND year='" . $year . "'";
        $record = $wpdb->get_results( $cntSQL, OBJECT );

        if( $record[0]->count == 0 )
        {
            // Check if variable is empty or not
            if( ! empty( $bankFigure ) ) 
            {
                // Insert Record
                $wpdb->insert( $table , array(
                    'store' => $store,
                    'till_1' => $bankFigure[ 'till_1' ],
                    'till_2' => $bankFigure[ 'till_2' ],
                    'total' => $bankFigure[ 'total' ],
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ));

                if( $wpdb->insert_id > 0 )
                {
                    $totalInserted++;
                }
            }
        }
        else
        {
            //if it exists then lets update with new info
            $table_name = $table;
            $data_update = array( 
                'store' => $store,
                'till_1' => $bankFigure[ 'till_1' ],
                'till_2' => $bankFigure[ 'till_2' ],
                'total' => $bankFigure[ 'total' ],
                'day' => $day, 
                'month' => $month,
                'year' => $year
            );
            
            $data_where = array( 'store' => $store, 'day' => $day, 'month' => $month, 'year' => $year);
            
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );

            if( $wpdb->update( $table_name , $data_update, $data_where ) === FALSE )
            {
                //failed to update, do nothing
            }
            else
            {
                $totalUpdated++;
            }
        }
    }
    
    $success[ 'updated' ] = $totalUpdated;
    $success['inserted' ] = $totalInserted;
    
    wp_send_json_success( $success );
}

function get_profit_info()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$profit = '';
	
    //get our profit info
    $profit = '';
    $daily_profit = '';
    $profit_target = '';
    $profit_variance = '';
    
    $month = date('F');
    $year = date("Y");
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE month  = '" . $month . "' AND year = '" . $year . "'" ) ); 

    foreach ( $results as $result )
    {
        if( $result->store == $store )
        {
            $profit = floatval( $profit ) + floatval( $result->total_profit );
            $success[ 'profit' ] = $profit;
        }
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_profit_targets" ) );

    foreach ( $results as $result )
    {
        if( $result->store == $store )
        {
            $profit_target = floatval( $result->target );
            $success[ 'profit_target' ] = $profit_target;
        }
    }
    
    if( $profit > $profit_target )
    {
        $profit_variance = $profit - $profit_target;
        $profit_variance = '+' . $profit_variance;
        
        $success[ 'profit_variance' ] = $profit_variance;
    }
    else
    {
        $profit_variance = floatval( $profit_target ) - floatval( $profit );
        $profit_variance = '-' . strval( $profit_variance );
        
        $success[ 'profit_variance' ] = $profit_variance;
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE()" ) );
    
    foreach ( $results as $result )
    {
        if( $result->store == $store )
        {
            $daily_profit = floatval( $daily_profit ) + floatval( $result->total_profit );
            $success[ 'daily_profit' ] = $daily_profit;
            
            
        }
        else
        {
            $daily_profit = 0;
            $success[ 'daily_profit' ] = $daily_profit;
        }
    }
    
    wp_send_json_success( $success );
   
}

function delete_assets()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
	$id = ! empty( $data[ 'id' ] ) ? $data[ 'id' ] : '';
	
	if( $type == 'device' )
	{
	    $where = array( 
            'id' => $id
        );
        
        $table_name = 'wp_fc_devices'; 
        
	    if( $wpdb->delete( $table_name , $where ) )
	    {
	        wp_send_json_success( 'device_deleted' );
	    }
	    else
	    {
	        wp_send_json_error( 'error' );
	    }
	}
	elseif( $type == 'tariff' )
	{
	    $where = array( 
            'id' => $id
        );
        
        $table_name = 'wp_fc_tariffs'; 
    
	    if( $wpdb->delete( $table_name , $where ) )
	    {
	        wp_send_json_success( 'tariff_deleted' );
	    }
	    else
	    {
	        wp_send_json_error( 'error' );
	    }
	}
	elseif( $type == 'accessory' )
	{
	    $where = array( 
            'id' => $id
        );
        
        $table_name = 'wp_fc_accessories'; 
        
	    if( $wpdb->delete( $table_name , $where ) )
	    {
	        wp_send_json_success( 'accessory_deleted' );
	    }
	    else
	    {
	        wp_send_json_error( 'error' );
	    }
	}
}

function device_csv_export()
{
    $nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
    if ( ! wp_verify_nonce( $nonce, 'download_csv' ) ) {
        die( 'Security check error' );
    }
    
    global $wpdb;
	
	$table_name = 'wp_fc_devices';
	$type = 'device';
	
    $csv_data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    
    if( count($csv_data) > 0 ) 
    {
        convert_to_csv($type, $csv_data, $type . '-export-' . date("j-n-Y-H-i") .'.csv');
    }
}

function tariff_csv_export()
{
    $nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
    if ( ! wp_verify_nonce( $nonce, 'download_csv' ) ) {
        die( 'Security check error' );
    }
    
    global $wpdb;
	
	$table_name = 'wp_fc_tariffs';
	$type = 'tariff';
	
    $csv_data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    
    if( count($csv_data) > 0 ) 
    {
        convert_to_csv($type, $csv_data, $type . '-export-' . date("j-n-Y-H-i") .'.csv');
    }
}

function accessory_csv_export()
{
    $nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
    if ( ! wp_verify_nonce( $nonce, 'download_csv' ) ) {
        die( 'Security check error' );
    }
    
    global $wpdb;
	
	$table_name = 'wp_fc_accessories';
	$type = 'accessory';
	
    $csv_data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    
    if( count($csv_data) > 0 ) 
    {
        convert_to_csv($type, $csv_data, $type . '-export-' . date("j-n-Y-H-i") .'.csv');
    }
}

function convert_to_csv($type, $input_array, $output_file_name)
{
    ob_start();
    $filename = $output_file_name;
    
    $data_rows = array();
    
    if( $type == 'device' ) 
	{
        $header_row = array(
            'ID', 
            'Type', 
            'Device'
        );
        
        foreach( $input_array as $value ) {
            $row = array(
                $value['id'],
                $value['type'],
                $value['device']
            );
            $data_rows[] = $row;
        }
	}
	elseif( $type == 'tariff' ) 
	{
	    $header_row = array(
	        'ID', 
	        'Type', 
	        'Tariff'
	    );
	    
	    foreach( $input_array as $value ) {
            $row = array(
                $value['id'],
                $value['type'],
                $value['tariff']
            );
            $data_rows[] = $row;
        }
    }
	elseif( $type == 'accessory' ) 
	{
	    $header_row = array(
	        'ID', 
	        'Product Code', 
	        'Accessory'
	    );
	    
	    foreach( $input_array as $value ) {
            $row = array(
                $value['id'],
                $value['productcode'],
                $value['accessory']
            );
            $data_rows[] = $row;
        }
	}
	
	$fh = @fopen( 'php://output', 'w' );
    fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Content-Description: File Transfer' );
    header( 'Content-type: text/csv' );
    header( "Content-Disposition: attachment; filename={$filename}" );
    header( 'Expires: 0' );
    header( 'Pragma: public' );
    fputcsv( $fh, $header_row );
    foreach ( $data_rows as $data_row ) {
        fputcsv( $fh, $data_row );
    }
    fclose( $fh );
    
    ob_end_flush();
    
    die();
}

function delete_all_assets()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
	if( $type == 'device' ) 
	{
	    $table_name = 'wp_fc_devices';
	    
	    if( $wpdb->query("TRUNCATE TABLE $table_name") )
	    {
	        wp_send_json_success( 'devices deleted' );
	    }
	    else
	    {
	        wp_send_json_error( 'error deleting' );
	    }
	}
	elseif( $type == 'tariff' ) 
	{
	    $table_name = 'wp_fc_tariffs';
	    
	    if( $wpdb->query("TRUNCATE TABLE $table_name") )
	    {
	        wp_send_json_success( 'tariffs deleted' );
	    }
	    else
	    {
	        wp_send_json_error( 'error deleting' );
	    }
	}
	elseif( $type == 'accessory' ) 
	{
	    $table_name = 'wp_fc_accessories';
	    
	    if( $wpdb->query("TRUNCATE TABLE $table_name") )
	    {
	        wp_send_json_success( 'accessories deleted' );
	    }
	    else
	    {
	        wp_send_json_error( 'error deleting' );
	    }
	}
	else 
	{
	    wp_send_json_error('error with type');
	}
}

function get_discount_pots()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$rm_discount = array();
    $fran_discount = array();
    
    $split = explode( "-", $date );
	
	//we need our month and year
	$monthNum  = $split[1];
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $month = $dateObj->format('F'); // March
                 
    $year = $split[0];
    
    //first get our discount pot info
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_pots" ) );

    foreach ( $results as $result )
    {
        if( $result->store == $store && $result->month == $month && $result->year == $year )
        {
            $rm_discount_pot = $result->regionalManager;
            $fran_discount_pot = $result->franchise;
        }
    }
    
    $success[ 'rm_pot' ] = $rm_discount_pot;
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE device_discount_type = 'rm' OR device_discount_type = 'both'" ) );
    
    $all_rm = 0;
    
    foreach ( $results as $result )
    {
        if( $result->store == $store and $result->month == $month and $result->year == $year )
        {
            $all_rm = floatval( $all_rm ) + floatval( $result->device_discount );
            
            $rm_used = $all_rm;
        }
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE device_discount_type = 'franchise' OR device_discount_type = 'both'" ) );
    
    $all_fran = 0;
    
    foreach ( $results as $result )
    {
        if( $result->store == $store and $result->month == $month and $result->year == $year )
        {
            if( $result->device_discount_type == 'franchise' )
            {
                $all_fran = floatval( $all_fran ) + floatval( $result->device_discount );
            }
            elseif( $result->device_discount_type == 'both' )
            {
                $all_fran = floatval( $all_fran ) + floatval( $result->device_discount_2 );
            }
            
            $fran_used = $all_fran;
        }
    }
    
    $rm_left = $rm_discount_pot - $rm_used;
    $fran_left = $fran_discount_pot - $fran_used;
    
    $rm_left = number_format( ( float )$rm_left , 2 , '.',  '' );
    $fran_left = number_format( ( float )$fran_left , 2 , '.',  '' );
    
    $success[ 'rm_left' ] = $rm_left;
    $success[ 'fran' ] = $fran_left;
    $success[ 'rm' ] = $rm_left;
    $franchise = $fran_left;
    
    $fran_used = number_format( ( float )$franchise_used , 2 , '.',  '' );
    
    $rm_used = number_format( ( float )$rm_used , 2 , '.',  '' );
    
    $success[ 'fran_left' ] = $fran_left;
    
    $success[ 'rm_used' ] = $rm_used;
    
    wp_send_json_success( $success );
}

function delete_sale()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
    $id = ! empty( $data[ 'id' ] ) ? $data[ 'id' ] : '';
    $store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE id = '$id' " ) );
    
    foreach( $results as $result )
    {
        if( $result->device_discount !== '' )
        {
            $device_discount = $result->device_discount;
            $sale_date = $result->sale_date;
            
            $sale_date = strtotime( $sale_date );
            
            $sale_date = date( 'Y-F', $sale_date );
            
            $split = explode( "-", $sale_date );
	
        	//we need our month and year
        	$month = $split[1];
                        
            $year = $split[0];
            
            //a device discount was added, lets update our discount pots
            $discounts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_tracker" ) );
    
            foreach ( $discounts as $discount )
            {
                if( $discount->store == $store )
                {
                    $fran_pot = floatval( $discount->franchise );
                    $rm_pot = floatval( $discount->regionalManager );
                }
            }
            
            $table_name = 'wp_fc_discount_tracker';
            
            if( $result->device_discount_type == 'rm' )
            {
                $pot_discount = floatval( $device_discount );
                
                $rm_pot = $rm_pot + $pot_discount;
                
                $data_update = array( 
                    'regionalManager' => $rm_pot );
            }
            
            if( $result->device_discount_type == 'franchise' )
            {
                $pot_discount = floatval( $device_discount );
                
                $fran_pot = $fran_pot + $pot_discount;
                
                $data_update = array( 
                    'franchise' => $fran_pot );
            }
                    
            $data_where = array( 'store' => $store , 'month' => $month , 'year' => $year );
            
            //we have info lets run the query
            $wpdb->update( $table_name , $data_update, $data_where );
        }
    }
    
    $where = array( 
        'id' => $id
    );
        
    $table_name = 'wp_fc_sales_info';

	if( $wpdb->delete( $table_name , $where ) )
	{
	    wp_send_json_success( 'deleted' );
	}
	else
	{
	    wp_send_json_error( 'error' );
	}
}

function get_store_information()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$split = explode(" ", $date );
	
	//we need our month and year
	$month = $split[0];
                
    $year = $split[1];
    
    $date = '1 ' . $date;
    
    $month_num = date( 'm',strtotime( $month ) );

    $days = cal_days_in_month( CAL_GREGORIAN , $month_num , $year );
    
    $total_week1 = array();
    $total_week2 = array();
    $total_week3 = array();
    $total_week4 = array();
    $total_week5 = array();
    
    $type = 'new';
	
	//get our employees first
	if( $store !== '' )
	{
	    $users = get_users();
	    
        $employees = array();
        
        foreach ( $users as $user ) 
        {
            $employee_store = get_user_meta( $user->ID, 'store_location' , true );
                
            if( $employee_store === $store )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
            
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
        }
	}
	
	if(strtotime($date) < strtotime("1 May 2021"))
    {
        $type = old;
        
    	//lets start by getting our footfall info
    	$predicted_footfall = '';
    
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_footfall" ) );
        
        foreach ( $results as $result )
        {
            if ( $result->store == $store )
            {
                if( $result->month == $month && $result->year == $year )
                {
                    $store_footfall = $result->footfall;
                    $average_footfall = $result->average_footfall;
                    $predicted_footfall = $result->predicted_footfall;
                }
            }
        }
    }
    
    //get the total number of staff hours
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_rota" ) );
    
    $total_hours = array();
    $advisor_hours = array();
    
    foreach ( $results as $result )
    {
        if ( $result->store == $store && $result->month == $month && $result->year == $year )
        {
            $total_hours[] =  $result->total_hours;
        }
    }
    
    foreach ( $total_hours as $thours )
    {
        $total = intval( $total ) + intval( $thours );
    }
    
    foreach( $employees as $id => $employee )
    {
        foreach ( $results as $result )
        {
            if( $result->week == '1' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $total_week1[ $employee ] = $result->total_hours;
            }
            
            if( $result->week == '2' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $total_week2[ $employee ] = $result->total_hours;
            }
            
            if( $result->week == '3' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $total_week3[ $employee ] = $result->total_hours;
            }
            
            if( $result->week == '4' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $total_week4[ $employee ] = $result->total_hours;
            }
            
            if( $result->week == '5' && $result->month == $month && $result->year == $year && $result->advisor == $employee )
            {
                $total_week5[ $employee ] = $result->total_hours;
            }
        }
    }
    
    foreach( $employees as $id => $employee )
    {
        $week1 = $total_week1[ $employee ];
        $week2 = $total_week2[ $employee ];
        $week3 = $total_week3[ $employee ];
        $week4 = $total_week4[ $employee ];
                
        if( $days > 28 )
        {
            $week5 = $total_week5[ $employee ];
        }
        
        $advisor_hours[ $employee ] = intval( $week1 ) + intval( $week2 ) + intval( $week3 ) + intval( $week4 ) + intval( $week5 );
    }
    
    if(strtotime($date) < strtotime("1 May 2021"))
    {
        foreach( $employees as $id => $employee )
        {
            //get our staffs sales for the current month
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $employee . "' AND store = '" . $store . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) ); 
            
            $all_new = 0;
            $all_upgrade = 0;
            $new_handsets = 0;
            $new_broadband = 0;
            $upgrade_broadband = 0;
            
            //we need to work out our percentages
            $total_insurance_sales = 0;
            $insurance_sale = 0;
            
            $total_broadband_sales = 0;
            $bt_tv_sales = 0;
            
            //get our accessories sold and profit
            $accessories_sold = 0;
            $accessories_profit = 0;
            $ac_profit = 0;
            
            //get our advisors sale info
    
            foreach( $results as $result )
            {
                if( $result->type == 'new' && $result->product_type !== 'homebroadband' && $result->type == 'new' && $result->product_type !== 'insurance' && $result->type == 'new' && $result->product_type !== 'accessory' )
                {
                    //this is all our new connections
                    $all_new++;
                }
                if( $result->type == 'upgrade' && $result->product_type !== 'homebroadband' && $result->type == 'upgrade' && $result->product_type !== 'insurance' && $result->type == 'upgrade' && $result->product_type !== 'accessory' )
                {
                    //this is all our upgrade connections
                    $all_upgrade++;
                }
                if( $result->type == 'new' && $result->product_type == 'handset' )
                {
                    //this is all our new handset connections
                    $new_handsets++;
                }
                if( $result->type == 'new' && $result->product_type == 'homebroadband' )
                {
                    ///this is all our new home broadband connections
                    $new_broadband++;
                }
                if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
                {
                    //this is all our home broadband upgrades
                    $upgrade_broadband++;
                }
                if( $result->product_type == 'homebroadband' )
                {
                    if(strtotime($date) < strtotime("1 February 2022"))
                    {
                        //find out if its a BT Tariff sold
                        if ( strpos( $result->tariff , 'BT' ) !== false ) 
                        {
                            $total_broadband_sales++;
                        }
                    } else {
                        $total_broadband_sales++;
                    }
                    
                    //find out if a BT TV Tariff was sold
                    if( $result->broadband_tv == 'bt' )
                    {
                        $bt_tv_sales++;
                    }
                }
                if( $result->product_type == 'handset' || $result->product_type == 'tablet' || $result->product_type == 'connected' || $result->product_type == 'insurance' )
                {
                    //these are our insurance sales
                    $total_insurance_sales++;
                    
                    //was an insurance sold
                    if( $result->insurance == 'yes' )
                    {
                        $insurance_sale++;
                    }
                }
                if( $result->accessory_needed == 'yes' )
                {
                    //accessory was sold
                    $accessories_sold++;
                    
                    $ac_profit = floatval( $ac_profit ) + floatval( $result->accessory_profit );
                }
                
                //lets add all our sales info
                $all_new_sales[ $employee ] = $all_new;    
                $all_upgrade_sales[ $employee ] = $all_upgrade;
                $new_handset_sales[ $employee ] = $new_handsets;
                $new_broadband_sales[ $employee ] =$new_broadband;
                $upgrade_broadband_sales[ $employee ] = $upgrade_broadband;
                $accessory_sales[ $employee ] = $accessories_sold;
                $total_insurance_sold[ $employee ] = $total_insurance_sales;
                $insurance_sales[ $employee ] = $insurance_sale;
                $bt_tv_sold[ $employee ] = $bt_tv_sales;
                $total_broadband_sold[ $employee ] = $total_broadband_sales;
                    
                $accessory_profit[ $employee ] = $ac_profit;
                    
                $advisor_profit[ $employee ] = floatval( $advisor_profit[ $employee ] ) + floatval( $result->total_profit );
            }
        }
    
        //get our targets
        $tnc = ( 6 / 100 ) * intval( $predicted_footfall );
        $nhc = ( 3 / 100 ) * intval( $predicted_footfall );
        $tuc = ( 11 / 100 ) * intval( $predicted_footfall );
        $nhb = ( 1 / 100 ) * intval( $predicted_footfall );
        $uhb = ( 1 / 100 ) * intval( $predicted_footfall );
        
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_profit_targets WHERE store = '" . $store . "'" ) );
    
        foreach ( $results as $result )
        {
            if( $result->month == $month && $result->year == $year )
            {
                $store_profit = $result->target;
            }
        }
    
        //update our targets for the advisors
        foreach( $employees as $id => $employee )
        {
            $total_profit = floatval( $total_profit ) + floatval( $advisor_profit[ $employee ] );
            $advisor_tnc[ $employee ] = ceil( ( $tnc / $total ) * $advisor_hours[ $employee ] );
            $advisor_nhc[ $employee ] = ceil( ( $nhc / $total ) * $advisor_hours[ $employee ] );
            $advisor_tuc[ $employee ] = ceil( ( $tuc / $total ) * $advisor_hours[ $employee ] );
            $advisor_nhb[ $employee ] = ceil( ( $nhb / $total ) * $advisor_hours[ $employee ] );
            $advisor_uhb[ $employee ] = ceil( ( $uhb / $total ) * $advisor_hours[ $employee ] );
            
            //lets get our BT TV and our Insurance Percentage
            if( $insurance_sales[ $employee ] == 0 || $total_insurance_sold[ $employee ] == 0 )
            {
                $insurance_percentage[ $employee ] = 0;
            }
            else
            {
                $insurance_percentage[ $employee ] = ( intval( $insurance_sales[ $employee ] ) / intval( $total_insurance_sold[ $employee ] ) ) * 100;
            }
            
            if( $bt_tv_sold[ $employee ] == 0 || $total_broadband_sold[ $employee ] == 0 )
            {
                $bt_tv_percentage[ $employee ] = 0;
            }
            else
            {
                $bt_tv_percentage[ $employee ] = ( intval( $bt_tv_sold[ $employee ] ) / intval( $total_broadband_sold[ $employee ] ) ) * 100;
            }
            
            $insurance_percentage[ $employee ] = number_format( ( float )$insurance_percentage[ $employee ] , 2 , '.',  '' );
            $insurance_percentage[ $employee ] = floatval( $insurance_percentage[ $employee ] );
            
            $bt_tv_percentage[ $employee ] = number_format( ( float )$bt_tv_percentage[ $employee ] , 2 , '.',  '' );
            $bt_tv_percentage[ $employee ] = floatval( $bt_tv_percentage[ $employee ] );
            
            //finally get our percentages
            if ( $all_new_sales[ $employee ] == 0 )
            {
                $tnc_percentage[ $employee ] = 0;
            }
            else
            {
                $tnc_percentage[ $employee ] = ceil( ( $all_new_sales[ $employee ] / $advisor_tnc[ $employee ] ) * 100 );
            }
            
            if ( $new_handset_sales[ $employee ] == 0 )
            {
                $nhc_percentage[ $employee ] = 0;
            }
            else
            {
                $nhc_percentage[ $employee ] = ceil( ( $new_handset_sales[ $employee ] / $advisor_nhc[ $employee ] ) * 100 );
            }
            
            if ( $all_upgrade_sales[ $employee ] == 0 )
            {
                $tuc_percentage[ $employee ] = 0;
            }
            else
            {
                $tuc_percentage[ $employee ] = ceil( ( $all_upgrade_sales[ $employee ] / $advisor_tuc[ $employee ] ) * 100 );
            }
            
            if ( $new_broadband_sales[ $employee ] == 0 )
            {
                $nhb_percentage[ $employee ] = 0;
            }
            else
            {
                $nhb_percentage[ $employee ] = ceil( ( $new_broadband_sales[ $employee ] / $advisor_nhb[ $employee ] ) * 100 );
            }
            
            if ( $upgrade_broadband_sales[ $employee ] == 0 )
            {
                $uhb_percentage[ $employee ] = 0;
            }
            else
            {
                $uhb_percentage[ $employee ] = ceil( ( $upgrade_broadband_sales[ $employee ] / $advisor_uhb[ $employee ] ) * 100 );
            }
        }
    
    	if( $store !== '' )
    	{
    	    //get our profits info
            $profits = '';
            $profits .= '<h3 class="text-center spacer">Profits</h3>';
            $profits .= '<table class="table">';
            $profits .= '<thead>';
            $profits .= '<tr>';
            $profits .= '<th class="col-md-4">Staff Name</th>';
            $profits .= '<th class="col-md-2">Profit</th>';
            $profits .= '<th class="col-md-2">Profit Target</th>';
            $profits .= '<th class="col-md-2">Variance</th>';
            $profits .= '<th class="col-md-2">%</th>';
            $profits .= '</tr>';
            $profits .= '</head>';
            $profits .= '<tbody>';
            
            if( ! empty( $employees ) )
            {
                foreach( $employees as $id => $employee )
                {
                    $advisor_profit_target = ceil( ( $store_profit / $total ) * $advisor_hours[ $employee ] );
                    
                    if( $advisor_profit_target > 0 )
                    {
                        $profit_percentage = ceil( ( $advisor_profit[ $employee ] / $advisor_profit_target ) * 100 );
                    }
                    else
                    {
                        $profit_percentage = 0;
                    }
                    
                    $profits .= '<tr>';
                    $profits .= '<td>' . $employee . '</td>';
                    
                    if( $advisor_profit[ $employee ] > 0 )
                    {
                        $profits .= '<td>£' . $advisor_profit[ $employee ] . '</td>';
                    }
                    else
                    {
                        $profits .= '<td>£0</td>';
                    }
                    
                    $profits .= '<td>£' . $advisor_profit_target . '</td>';
                    
                    if( $advisor_profit[ $employee ] > $advisor_profit_target )
                    {
                        $profit_variance = $advisor_profit[ $employee ] - $advisor_profit_target;
                        $profits .= '<td class="variance-plus">+£' . $profit_variance . '</td>';
                    }
                    else
                    {
                        $profit_variance = $advisor_profit_target - $advisor_profit[ $employee ];
                        $profits .= '<td class="variance-minus">-£' . $profit_variance . '</td>';
                    }
                    
                    $profits .= '<td>'. $profit_percentage . '%</td>';
                    $profits .= '</tr>';
                }
                
                $profits .= '<tr>';
                $profits .= '<td class="blank-row"></td>';
                $profits .= '<td class="blank-row"></td>';
                $profits .= '<td class="blank-row"></td>';
                $profits .= '<td class="blank-row"></td>';
                $profits .= '</tr>';
                $profits .= '<tr>';
                $profits .= '<th class="col-md-4 blank-row"></th>';
                $profits .= '<th class="col-md-2">Total Profit</th>';
                $profits .= '<th class="col-md-2">Actual Total</th>';
                $profits .= '<th class="col-md-2">Variance</th>';
                $profits .= '<th class="col-md-2">%</th>';
                $profits .= '</tr>';
                
                $profits .= '<tr>';
                $profits .= '<td class="blank-row"></td>';
                $profits .= '<td>£' . $total_profit . '</td>';
                $profits .= '<td>£' . $store_profit . '</td>';
                
                if( $total_profit > $store_profit )
                {
                    $profit_variance = $total_profit - $store_profit;
                    $profits .= '<td class="variance-plus">+£' . $profit_variance . '</td>';
                }
                else
                {
                    $profit_variance = $store_profit - $total_profit;
                    $profits .= '<td class="variance-minus">-£' . $profit_variance . '</td>';
                }
                
                $profit_percentage = ceil( ( $total_profit / $store_profit ) * 100 );
                
                $profits .= '<td>' . $profit_percentage . '%</td>';
                $profits .= '</tr>';
            }
            else
            {
                $profits .= '<tr>';
                $profits = ucfirst( $store );
                
                $profits .= '<td>>No Users Exist for the ' . $store . ' Store</td>';
                $profits .= '</tr>';
            }
            
            $profits .= '</tbody>';
            $profits .= '</table>';
            
            //now get our new information
            $new = '';
            $new .= '<h3 class="text-center spacer">New</h3>';
            $new .= '<table class="table">';
            $new .= '<thead>';
            $new .= '<tr>';
            $new .= '<th class="col-md-4">Staff Name</th>';
            $new .= '<th class="col-md-2">Target</th>';
            $new .= '<th class="col-md-2">Actual</th>';
            $new .= '<th class="col-md-2">Variance</th>';
            $new .= '<th class="col-md-2">%</th>';
            $new .= '</tr>';
            $new .= '</head>';
            $new .= '<tbody>';
            
            $total_tnc = 0;
            $actual_tnc_total = 0;
            
            foreach( $employees as $id => $employee )
            {
                $total_tnc = $total_tnc + intval( $advisor_tnc[ $employee ] );
                $actual_tnc_total = $actual_tnc_total + intval( $all_new_sales[ $employee ] );
                
                $new .= '<tr>';
                $new .= '<td>' . $employee . '</td>';
                $new .= '<td>' . $advisor_tnc[ $employee ] . '</td>';
                
                if ( $all_new_sales[ $employee ] == '' )
                {
                    $new .= '<td>0</td>';
                }
                else
                {
                    $new .= '<td>' . $all_new_sales[ $employee ] . '</td>';
                }
                
                if ( $all_new_sales[ $employee ] > $advisor_tnc[ $employee ] )
                {
                    $variance = intval( $all_new_sales[ $employee ] ) - intval( $advisor_tnc[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $new .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $new .= '<td class="variance-plus">+' . $variance . '</td>';
                    }
                }
                else
                {
                    $variance = intval( $advisor_tnc[ $employee ] ) - intval( $all_new_sales[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $new .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $new .= '<td class="variance-minus">-' . $variance . '</td>';
                    }
                }
                
                $new .= '<td>' . $tnc_percentage[ $employee ] . '%</td>';
                $new .= '</tr>';
            }
            
            $new .= '<tr>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '</tr>';
            $new .= '<tr>';
            $new .= '<th class="blank-row"></th>';
            $new .= '<th>Target Total</th>';
            $new .= '<th>Actual Total</th>';
            $new .= '<th>Variance</th>';
            $new .= '</tr>';
            $new .= '<tr>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td>' . $total_tnc .'</td>';
            $new .= '<td>' . $actual_tnc_total . '</td>';
            
            if ( $actual_tnc_total > $total_tnc )
            {
                $variance = $actual_tnc_total - $total_tnc;
    
                if( $variance == 0 )
                {
                    $new .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $new .= '<td class="variance-plus">+' . $variance . '</td>';
                }
            }
            else
            {
                $variance = $total_tnc - $actual_tnc_total;
    
                if( $variance == 0 )
                {
                    $new .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $new .= '<td class="variance-minus">-' . $variance . '</td>';
                }
            }
            
            $new .= '<td class="blank-row"></td>';
            $new .= '</tr>';
            
            $new .= '<tr>';  
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '</tr>';
            $new .= '<tr>';
            $new .= '<th class="col-md-4">Staff Name</th>';
            $new .= '<th class="col-md-2">Handset Targets</th>';
            $new .= '<th class="col-md-2">Handset Actual</th>';
            $new .= '<th class="col-md-2">Variance</th>';
            $new .= '<th class="col-md-2">%</th>';
            $new .= '</tr>';
            
            $total_nnc = 0;
            $actual_nnc_total = 0;
            
            foreach( $employees as $id => $employee )
            {
                $total_nhc = $total_nhc + intval( $advisor_nhc[ $employee ] );
                $actual_nhc_total = $actual_nhc_total + intval( $new_handset_sales[ $employee ] );
                
                $new .= '<tr>';
                $new .= '<td>' . $employee . '</td>';
                $new .= '<td>' . $advisor_nhc[ $employee ] . '</td>';
                
                if ( $new_handset_sales[ $employee ] == '' )
                {
                    $new .= '<td>0</td>';
                }
                else
                {
                    $new .= '<td>' . $new_handset_sales[ $employee ] . '</td>';
                }
                
                if ( $new_handset_sales[ $employee ] > $advisor_nhc[ $employee ] )
                {
                    $variance = intval( $new_handset_sales[ $employee ] ) - intval( $advisor_nhc[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $new .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $new .= '<td class="variance-plus">+' . $variance . '</td>';
                    }
                }
                else
                {
                    $variance = intval( $advisor_nhc[ $employee ] ) - intval( $new_handset_sales[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $new .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $new .= '<td class="variance-minus">-' . $variance . '</td>';
                    }
                }
                
                $new .= '<td>' . $nhc_percentage[ $employee ] . '%</td>';
                $new .= '</tr>';
            }
            
            
            $new .= '<tr>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td class="blank-row"></td>';
            $new .= '</tr>';
            $new .= '<tr>';
            $new .= '<th class="blank-row"></th>';
            $new .= '<th>Target Total</th>';
            $new .= '<th>Actual Total</th>';
            $new .= '<th>Variance</th>';
            $new .= '</tr>';
            $new .= '<tr>';
            $new .= '<td class="blank-row"></td>';
            $new .= '<td>' . $total_nhc .'</td>';
            $new .= '<td>' . $actual_nhc_total . '</td>';
            
            if ( $actual_nhc_total > $total_nhc )
            {
                $variance = $actual_nhc_total - $total_nhc;
    
                if( $variance == 0 )
                {
                    $new .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $new .= '<td class="variance-plus">+' . $variance . '</td>';
                }
            }
            else
            {
                $variance = $total_nhc - $actual_nhc_total;
    
                if( $variance == 0 )
                {
                    $new .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $new .= '<td class="variance-minus">-' . $variance . '</td>';
                }
            }
            
            $new .= '</tr>';
            $new .= '</tbody>';
            $new .= '</table>';
            
            //now get our upgrade information
            $upgrade = '';
            $upgrade .= '<h3 class="text-center spacer">Upgrades</h3>';
            $upgrade .= '<table class="table">';
            $upgrade .= '<thead>';
            $upgrade .= '<tr>';
            $upgrade .= '<th class="col-md-4">Staff Name</th>';
            $upgrade .= '<th class="col-md-2">Target</th>';
            $upgrade .= '<th class="col-md-2">Actual</th>';
            $upgrade .= '<th class="col-md-2">Variance</th>';
            $upgrade .= '<th class="col-md-2">%</th>';
            $upgrade .= '</tr>';
            $upgrade .= '</head>';
            $upgrade .= '<tbody>';
            
            $total_tuc = 0;
            $actual_tuc_total = 0;
            
            foreach( $employees as $id => $employee )
            {
                $total_tuc = $total_tuc + intval( $advisor_tuc[ $employee ] );
                $actual_tuc_total = $actual_tuc_total + intval( $all_upgrade_sales[ $employee ] );
                
                $upgrade .= '<tr>';
                $upgrade .= '<td>' . $employee . '</td>';
                
                if ( $advisor_tuc[ $employee ] == '' )
                {
                    $advisor_tuc[ $employee ] = 0;
                }
                
                if( $all_upgrade_sales[ $employee ] == '' )
                {
                    $all_upgrade_sales[ $employee ] = 0;
                }
                
                $upgrade .= '<td>' . $advisor_tuc[ $employee ] . '</td>';
                $upgrade .= '<td>' . $all_upgrade_sales[ $employee ] . '</td>';
                
                if ( $all_upgrade_sales[ $employee ] > $advisor_tuc[ $employee ] )
                {
                    $variance = intval( $all_upgrade_sales[ $employee ] ) - intval( $advisor_tuc[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $upgrade .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $upgrade .= '<td class="variance-plus">+' . $variance . '</td>';
                    }
                }
                else
                {
                    $variance = intval( $advisor_tuc[ $employee ] ) - intval( $all_upgrade_sales[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $upgrade .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $upgrade .= '<td class="variance-minus">-' . $variance . '</td>';
                    }
                }
                
                $upgrade .= '<td>' . $tuc_percentage[ $employee ] . '%</td>';
                $upgrade .= '</tr>';
            }
            
            $upgrade .= '<tr>';
            $upgrade .= '<td class="blank-row"></td>';
            $upgrade .= '<td class="blank-row"></td>';
            $upgrade .= '<td class="blank-row"></td>';
            $upgrade .= '<td class="blank-row"></td>';
            $upgrade .= '</tr>';
            $upgrade .= '<tr>';
            $upgrade .= '<th class="blank-row"></th>';
            $upgrade .= '<th>Target Total</th>';
            $upgrade .= '<th>Actual Total</th>';
            $upgrade .= '<th>Variance</th>';
            $upgrade .= '</tr>';
            $upgrade .= '<tr>';
            $upgrade .= '<td class="blank-row"></td>';
            $upgrade .= '<td>' . $total_tuc .'</td>';
            $upgrade .= '<td>' . $actual_tuc_total . '</td>';
            
            if ( $actual_tuc_total > $total_tuc )
            {
                $variance = $actual_tuc_total - $total_tuc;
    
                if( $variance == 0 )
                {
                    $upgrade .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $upgrade .= '<td class="variance-plus">+' . $variance . '</td>';
                }
            }
            else
            {
                $variance = $total_tuc - $actual_tuc_total;
    
                if( $variance == 0 )
                {
                    $upgrade .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $upgrade .= '<td class="variance-minus">-' . $variance . '</td>';
                }
            }
            
            $upgrade .= '</tr>';
            
            $upgrade .= '</tbody>';
            $upgrade .= '</table>';
            
            //now get our new HBB information
            $hbb_new = '';
            $hbb_new .= '<h3 class="text-center spacer">New HBB</h3>';
            $hbb_new .= '<table class="table">';
            $hbb_new .= '<thead>';
            $hbb_new .= '<tr>';
            $hbb_new .= '<th class="col-md-4">Staff Name</th>';
            $hbb_new .= '<th class="col-md-2">Target</th>';
            $hbb_new .= '<th class="col-md-2">Actual</th>';
            $hbb_new .= '<th class="col-md-2">Variance</th>';
            $hbb_new .= '<th class="col-md-2">%</th>';
            $hbb_new .= '</tr>';
            $hbb_new .= '</head>';
            $hbb_new .= '<tbody>';
            
            $total_nhb = 0;
            $actual_nhb_total = 0;
            
            foreach( $employees as $id => $employee )
            {
                $total_nhb = $total_nhb + intval( $advisor_nhb[ $employee ] );
                $actual_nhb_total = $actual_nhb_total + intval( $new_broadband_sales[ $employee ] );
                
                $hbb_new .= '<tr>';
                $hbb_new .= '<td>' . $employee . '</td>';
                
                if( $advisor_nhb[ $employee ] == '' )
                {
                    $advisor_nhb[ $employee ] = 0;
                }
                
                if( $new_broadband_sales[ $employee ] == '' )
                {
                    $new_broadband_sales[ $employee ] = 0;
                }
                
                $hbb_new .= '<td>' . $advisor_nhb[ $employee ] . '</td>';
                $hbb_new .= '<td>' . $new_broadband_sales[ $employee ] . '</td>';
                
                if ( $new_broadband_sales[ $employee ] > $advisor_nhb[ $employee ] )
                {
                    $variance = intval( $new_broadband_sales[ $employee ] ) - intval( $advisor_nhb[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $hbb_new .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $hbb_new .= '<td class="variance-plus">+' . $variance . '</td>';
                    }
                }
                else
                {
                    $variance = intval( $advisor_nhb[ $employee ] ) - intval( $new_broadband_sales[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $hbb_new .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $hbb_new .= '<td class="variance-minus">-' . $variance . '</td>';
                    }
                }
                
                $hbb_new .= '<td>' . $nhb_percentage[ $employee ] . '%</td>';
                $hbb_new .= '</tr>';
            }
            
            $hbb_new .= '<tr>';
            $hbb_new .= '<td class="blank-row"></td>';
            $hbb_new .= '<td class="blank-row"></td>';
            $hbb_new .= '<td class="blank-row"></td>';
            $hbb_new .= '<td class="blank-row"></td>';
            $hbb_new .= '</tr>';
            $hbb_new .= '<tr>';
            $hbb_new .= '<th class="blank-row"></th>';
            $hbb_new .= '<th>Target Total</th>';
            $hbb_new .= '<th>Actual Total</th>';
            $hbb_new .= '<th>Variance</th>';
            $hbb_new .= '</tr>';
            $hbb_new .= '<tr>';
            $hbb_new .= '<td class="blank-row"></td>';
            $hbb_new .= '<td>' . $total_nhb .'</td>';
            $hbb_new .= '<td>' . $actual_nhb_total . '</td>';
            
            if ( $actual_nhb_total > $total_nhb )
            {
                $variance = $actual_nhb_total - $total_nhb;
    
                if( $variance == 0 )
                {
                    $hbb_new .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $hbb_new .= '<td class="variance-plus">+' . $variance . '</td>';
                }
            }
            else
            {
                $variance = $total_nhb - $actual_nhb_total;
    
                if( $variance == 0 )
                {
                    $hbb_new .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $hbb_new .= '<td class="variance-minus">-' . $variance . '</td>';
                }
            }
            
            $hbb_new .= '</tr>';
            
            $hbb_new .= '</tbody>';
            $hbb_new .= '</table>';
            
            //now get our HBB Upgrades information
            $hbb_upgrades = '';
            $hbb_upgrades .= '<h3 class="text-center spacer">HBB Upgrades</h3>';
            $hbb_upgrades .= '<table class="table">';
            $hbb_upgrades .= '<thead>';
            $hbb_upgrades .= '<tr>';
            $hbb_upgrades .= '<th class="col-md-4">Staff Name</th>';
            $hbb_upgrades .= '<th class="col-md-2">Target</th>';
            $hbb_upgrades .= '<th class="col-md-2">Actual</th>';
            $hbb_upgrades .= '<th class="col-md-2">Variance</th>';
            $hbb_upgrades .= '<th class="col-md-2">%</th>';
            $hbb_upgrades .= '</tr>';
            $hbb_upgrades .= '</head>';
            $hbb_upgrades .= '<tbody>';
            
            $total_uhb = 0;
            $actual_uhb_total = 0;
            
            foreach( $employees as $id => $employee )
            {
                $total_uhb = $total_uhb + intval( $advisor_uhb[ $employee ] );
                $actual_uhb_total = $actual_uhb_total + intval( $upgrade_broadband_sales[ $employee ] );
                
                $hbb_upgrades .= '<tr>';
                $hbb_upgrades .= '<td>' . $employee . '</td>';
                
                if( $advisor_uhb[ $employee ] == '' )
                {
                    $advisor_uhb[ $employee ] = 0;
                }
                
                if( $upgrade_broadband_sales[ $employee ] == '' )
                {
                    $upgrade_broadband_sales[ $employee ] = 0;
                }
                
                $hbb_upgrades .= '<td>' . $advisor_uhb[ $employee ] . '</td>';
                $hbb_upgrades .= '<td>' . $upgrade_broadband_sales[ $employee ] . '</td>';
                
                if ( $upgrade_broadband_sales[ $employee ] > $advisor_nhb[ $employee ] )
                {
                    $variance = intval( $upgrade_broadband_sales[ $employee ] ) - intval( $advisor_uhb[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $hbb_upgrades .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $hbb_upgrades .= '<td class="variance-plus">+' . $variance . '</td>';
                    }
                }
                else
                {
                    $variance = intval( $advisor_uhb[ $employee ] ) - intval( $upgrade_broadband_sales[ $employee ] );
                    
                    if( $variance == 0 )
                    {
                        $hbb_upgrades .= '<td>' . $variance . '</td>';
                    }
                    else
                    {
                        $hbb_upgrades .= '<td class="variance-minus">-' . $variance . '</td>';
                    }
                }
                
                $hbb_upgrades .= '<td>' . $uhb_percentage[ $employee ] . '%</td>';
                $hbb_upgrades .= '</tr>';
            }
            
            $hbb_upgrades .= '<tr>';
            $hbb_upgrades .= '<td class="blank-row"></td>';
            $hbb_upgrades .= '<td class="blank-row"></td>';
            $hbb_upgrades .= '<td class="blank-row"></td>';
            $hbb_upgrades .= '<td class="blank-row"></td>';
            $hbb_upgrades .= '</tr>';
            $hbb_upgrades .= '<tr>';
            $hbb_upgrades .= '<th class="blank-row"></th>';
            $hbb_upgrades .= '<th>Target Total</th>';
            $hbb_upgrades .= '<th>Actual Total</th>';
            $hbb_upgrades .= '<th>Variance</th>';
            $hbb_upgrades .= '</tr>';
            $hbb_upgrades .= '<tr>';
            $hbb_upgrades .= '<td class="blank-row"></td>';
            $hbb_upgrades .= '<td>' . $total_uhb .'</td>';
            $hbb_upgrades .= '<td>' . $actual_uhb_total . '</td>';
            
            if ( $actual_uhb_total > $total_uhb )
            {
                $variance = $actual_uhb_total - $total_uhb;
    
                if( $variance == 0 )
                {
                    $hbb_upgrades .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $hbb_upgrades .= '<td class="variance-plus">+' . $variance . '</td>';
                }
            }
            else
            {
                $variance = $total_uhb - $actual_uhb_total;
    
                if( $variance == 0 )
                {
                    $hbb_upgrades .= '<td>' . $variance . '</td>';
                }
                else
                {
                    $hbb_upgrades .= '<td class="variance-minus">-' . $variance . '</td>';
                }
            }
            
            $hbb_upgrades .= '</tr>';
            
            $hbb_upgrades .= '</tbody>';
            $hbb_upgrades .= '</table>';
            
            //now get our accessories information
            $accessories = '';
            $accessories .= '<h3 class="text-center spacer">Accessories</h3>';
            $accessories .= '<table class="table">';
            $accessories .= '<thead>';
            $accessories .= '<tr>';
            $accessories .= '<th class="col-md-4">Staff Name</th>';
            $accessories .= '<th class="col-md-2">Number Sold</th>';
            $accessories .= '<th class="col-md-2">Profit</th>';
            $accessories .= '</head>';
            $accessories .= '<tbody>';
            
            $total_acessories = 0;
            $accessories_profit_total = 0;
            
            foreach( $employees as $id => $employee )
            {
                
                $total_acessories = $total_acessories + intval( $accessory_sales[ $employee ] );
                $accessories_profit_total = floatval( $accessories_profit_total ) + floatval( $accessory_profit[ $employee ] );
            
                $accessories .= '<tr>';
                $accessories .= '<td>' . $employee . '</td>';
                if( $accessory_sales[ $employee ] == '' )
                {
                    $accessory_sales[ $employee ] = 0;
                }
                
                $accessories .= '<td>' . $accessory_sales[ $employee ] . '</td>';
                
                if( $accessory_profit[ $employee ] == '' )
                {
                    $accessory_profit[ $employee ] = 0;
                }
                
                $accessories .= '<td>£' . $accessory_profit[ $employee ] . '</td>';
                $accessories .= '</tr>';
            }
            
            $accessories .= '<tr>';
            $accessories .= '<td class="blank-row"></td>';
            $accessories .= '<td class="blank-row"></td>';
            $accessories .= '<td class="blank-row"></td>';
            $accessories .= '</tr>';
            $accessories .= '<tr>';
            $accessories .= '<th class="blank-row"></th>';
            $accessories .= '<th>Accessories Total</th>';
            $accessories .= '<th>Accessories Total Profit</th>';
            $accessories .= '</tr>';
            $accessories .= '<tr>';
            $accessories .= '<td class="blank-row"></td>';
            $accessories .= '<td>' . $total_acessories .'</td>';
            $accessories .= '<td>£' . $accessories_profit_total . '</td>';
            
            $accessories .= '</tr>';
            
            $accessories .= '</tbody>';
            $accessories .= '</table>';
            
            //now get our BT TV information
            $bt_tv = '';
            $bt_tv .= '<h3 class="text-center spacer">BT TV</h3>';
            $bt_tv .= '<table class="table">';
            $bt_tv .= '<thead>';
            $bt_tv .= '<tr>';
            $bt_tv .= '<th class="col-md-4">Staff Name</th>';
            $bt_tv .= '<th class="col-md-2">Target</th>';
            $bt_tv .= '<th class="col-md-2">Actual</th>';
            $bt_tv .= '</tr>';
            $bt_tv .= '</head>';
            $bt_tv .= '<tbody>';
            
            foreach( $employees as $id => $employee )
            {
                $bt_tv .= '<tr>';
                $bt_tv .= '<td>' . $employee . '</td>';
                $bt_tv .= '<td>30%</td>';
                $bt_tv .= '<td>' . $bt_tv_percentage[ $employee ] . '%</td>';
                $bt_tv .= '</tr>';
            }
            
            $bt_tv .= '</tbody>';
            $bt_tv .= '</table>';
            
            //now get our insurance information
            $insurance = '';
            $insurance .= '<h3 class="text-center spacer">Insurance</h3>';
            $insurance .= '<table class="table">';
            $insurance .= '<thead>';
            $insurance .= '<tr>';
            $insurance .= '<th class="col-md-4">Staff Name</th>';
            $insurance .= '<th class="col-md-2">Target</th>';
            $insurance .= '<th class="col-md-2">Actual</th>';
            $insurance .= '</tr>';
            $insurance .= '</head>';
            $insurance .= '<tbody>';
            
            foreach( $employees as $id => $employee )
            {
                $insurance .= '<tr>';
                $insurance .= '<td>' . $employee . '</td>';
                $insurance .= '<td>30%</td>';
                $insurance .= '<td>' . $insurance_percentage[ $employee ] . '%</td>';
                $insurance .= '</tr>';
            }
            
            $insurance .= '</tbody>';
            $insurance .= '</table>';
            
            $success[ 'profits' ] = $profits;
            $success[ 'new' ] = $new;
            $success[ 'upgrade' ] = $upgrade;
            $success[ 'hbb_new' ] = $hbb_new;
            $success[ 'hbb_upgrades' ] = $hbb_upgrades;
            $success[ 'accessories' ] = $accessories;
            $success[ 'bt_tv' ] = $bt_tv;
            $success[ 'insurance' ] = $insurance;
            $success[ 'type' ] = $type;
            
            wp_send_json_success( $success );
    	}
    }
    else
    {
        foreach( $employees as $id => $employee )
        {
            //get our staffs sales for the current month
            //$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $employee . "' AND store = '" . $store . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) ); 
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $employee . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) ); 
            
            $all_new_handset = 0;
            $all_new_sim = 0;
            $all_new_data = 0;
            $all_upgrade_handset = 0;
            $all_upgrade_sim = 0;
            $all_new_bt = 0;
            $all_regrade = 0;
            $all_insurance = 0;
            $all_profit = 0;
            
            //get our advisors sale info
            foreach( $results as $result )
            {
                if( $result->type == 'new' && $result->product_type == 'handset' )
                {
                    //this is all our new connections
                    $all_new_handset++;
                }
                
                if( $result->type == 'new' && $result->product_type == 'simonly' )
                {
                    //this is all our new connections
                    $all_new_sim++;
                }
                
                if(strtotime($date) < strtotime("1 July 2021"))
                {
                    if( $result->type == 'new' && $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' )
                    {
                        $all_new_data++;
                    }
                }
                else {
                    if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
                    {
                        if(strtotime($date) < strtotime("1 March 2022"))
                        {
                            $all_new_data++;
                        } else {
                            if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                                $all_new_data += floatval(fc_get_data_tariff_mrc($result->tariff));
                            } else {
                                $all_new_data += floatval(fc_get_tariff_mrc($result->tariff));
                            }
                        }
                    }
                }
                
                if( $result->type == 'upgrade' && $result->product_type == 'handset' )
                {
                    //this is all our new connections
                    $all_upgrade_handset++;
                }
                
                if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
                {
                    //this is all our new connections
                    $all_regrade++;
                }
                
                if(strtotime($date) < strtotime("1 July 2021"))
                {
                    if( $result->type == 'upgrade' && $result->product_type == 'simonly' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
                    {
                        if(strtotime($date) < strtotime("1 March 2022"))
                        {
                            $all_upgrade_sim++;
                        } else {
                            if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                                $all_upgrade_sim += floatval(fc_get_data_tariff_mrc($result->tariff));
                            } else {
                                $all_upgrade_sim += floatval(fc_get_tariff_mrc($result->tariff));
                            }
                        }
                    }
                }
                else {
                    if( $result->type == 'upgrade' && $result->product_type == 'simonly' )
                    {
                        //this is all our new connections
                        $all_upgrade_sim++;
                    }
                }
                
                if( $result->type == 'new' && $result->product_type == 'homebroadband' )
                {
                    if(strtotime($date) < strtotime("1 February 2022"))
                    {
                        //find out if its a BT Tariff sold
                        if ( strpos( $result->tariff , 'BT' ) !== false ) 
                        {
                            $all_new_bt++;
                        }
                    } else {
                        $all_new_bt++;
                    }
                }
                
                if( $result->insurance == 'yes' )
                {
                    $all_insurance++;
                }
                
                if( $result->hrc !== 'yes' )
                {
                    if( $result->pobo == 'yes' )
                    {
                        $profit = (80 / 100) * $result->total_profit;
                        $all_profit += $profit;
                    }
                    else
                    {
                        $all_profit += $result->total_profit;
                    }
                }
            }
            
            $all_new_handset_sales[ $employee ] = $all_new_handset;;
            $all_new_sim_sales[ $employee ] = $all_new_sim;
            $all_new_data_sales[ $employee ] = $all_new_data;
            $all_upgrade_handset_sales[ $employee ] = $all_upgrade_handset;
            $all_upgrade_sim_sales[ $employee ] = $all_upgrade_sim;
            $all_new_bt_sales[ $employee ] = $all_new_bt;
            $all_regrade_sales[ $employee ] = $all_regrade;
            $all_insurance_sales[ $employee ] = $all_insurance;
            $all_profit_sales[ $employee ] = $all_profit;
        }
        
        //get our targets
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_targets" ) );
        
        foreach ( $results as $result )
        {
            if ( $result->store == $store )
            {
                if( $result->month == $month && $result->year == $year )
                {
                    $new_handset = $result->new_handset;
                    $new_sim = $result->new_sim;
                    $new_data = $result->new_data;
                    $upgrade_handset = $result->upgrade_handset;
                    $upgrade_sim = $result->upgrade_sim;
                    $new_bt = $result->new_bt;
                    $regrade = $result->regrade;
                    $insurance = $result->insurance;
                    $profit_target = $result->profit_target;
                }
            }
        }
        
        foreach( $employees as $id => $employee )
        {
            $advisor_new_handset[ $employee ] = ceil( ( $new_handset / $total ) * $advisor_hours[ $employee ] );
            $advisor_new_sim[ $employee ] = ceil( ( $new_sim / $total ) * $advisor_hours[ $employee ] );
            $advisor_new_data[ $employee ] = ceil( ( $new_data / $total ) * $advisor_hours[ $employee ] );
            $advisor_upgrade_handset[ $employee ] = ceil( ( $upgrade_handset / $total ) * $advisor_hours[ $employee ] );
            $advisor_upgrade_sim[ $employee ] = ceil( ( $upgrade_sim / $total ) * $advisor_hours[ $employee ] );
            $advisor_new_bt[ $employee ] = ceil( ( $new_bt / $total ) * $advisor_hours[ $employee ] );
            $advisor_regrade[ $employee ] = ceil( ( $regrade / $total ) * $advisor_hours[ $employee ] );
            $advisor_insurance[ $employee ] = ceil( ( $insurance / $total ) * $advisor_hours[ $employee ] );
            $advisor_profit_target[ $employee ] = ceil( ( $profit_target / $total ) * $advisor_hours[ $employee ] );
            
            $user = get_user_by('id', $id);
            
            if( $user && in_array( 'employee', $user->roles ) )
            {
                $percent[ $employee ] = 8;
            }
            else if( $user && in_array( 'senior_advisor', $user->roles ) )
            {
                $percent[ $employee ] = 10;
            }
        }
        
        ob_start();        
        ?>
        
        <h4 class="text-center"><?php echo $month ?> Targets</h4>

        <div class="container-fluid spacer table-responsive">
            <div class="row">
                <?php if(strtotime($date) < strtotime("1 July 2021")) { ?>
                    <table class="table spacer">
                        <thead>
                            <tr>
                                <th class="col-md-1 blank-row"></th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1">New Handset</th>
                                <th class="col-md-1">New Sim</th>
                                <?php
                                if(strtotime($date) < strtotime("1 July 2021"))
                                {
                                    echo '<th class="col-md-1">New Data</th>';
                                } else {
                                    echo '<th class="col-md-1">Data Value</th>';
                                }?>
                                <th class="col-md-1">Upgrade Handset</th>
                                <?php
                                if(strtotime($date) < strtotime("1 July 2021"))
                                {
                                    echo '<th class="col-md-1">Upgrade Sim / other</th>';
                                } else {
                                    echo '<th class="col-md-1">Upgrade Sim</th>';
                                }
                                if(strtotime($date) < strtotime("1 February 2022"))
                                { ?>
                                    <th class="col-md-1">New BT</th>
                                <?php } else { ?>
                                    <th class="col-md-1">New HBB</th>
                                <?php } ?>
                                
                                <th class="col-md-1">Insurance</th>
                                <th class="col-md-1">Profit</th>
                                <th class="col-md-1">Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach( $employees as $id => $employee )
                            {
                                if( $all_new_handset_sales[ $employee ] >= $advisor_new_handset[ $employee ] )
                                {
                                    $new_handset_colour = 'green';
                                    $new_handset_text = 'white';
                                    $new_handset_met = true;
                                }
                                else
                                {
                                    $new_handset_colour = 'red';
                                    $new_handset_text = 'white';
                                    $new_handset_met = false;
                                }
                                
                                if( $all_new_sim_sales[ $employee ] >= $advisor_new_sim[ $employee ] )
                                {
                                    $new_sim_colour = 'green';
                                    $new_sim_text = 'white';
                                    $new_sim_met = true;
                                }
                                else
                                {
                                    $new_sim_colour = 'red';
                                    $new_sim_text = 'white';
                                    $new_sim_met = false;
                                }
                                
                                if(strtotime($date) < strtotime("1 March 2022"))
                                {
                                    if( $all_new_data_sales[ $employee ] >= $advisor_new_data[ $employee ] )
                                    {
                                        $new_data_colour = 'green';
                                        $new_data_text = 'white';
                                        $new_data_met = true;
                                    }
                                    else
                                    {
                                        $new_data_colour = 'red';
                                        $new_data_text = 'white';
                                        $new_data_met = false;
                                    }
                                } else {
                                    if( floatval($all_new_data_sales[ $employee ]) >= floatval($advisor_new_data[ $employee ]) )
                                    {
                                        $new_data_colour = 'green';
                                        $new_data_text = 'white';
                                        $new_data_met = true;
                                    }
                                    else
                                    {
                                        $new_data_colour = 'red';
                                        $new_data_text = 'white';
                                        $new_data_met = false;
                                    }
                                }
                                
                                if( $all_upgrade_handset_sales[ $employee ] >= $advisor_upgrade_handset[ $employee ] )
                                {
                                    $upgrade_handset_colour = 'green';
                                    $upgrade_handset_text = 'white';
                                    $upgrade_handset_met = true;
                                }
                                else
                                {
                                    $upgrade_handset_colour = 'red';
                                    $upgrade_handset_text = 'white';
                                    $upgrade_handset_met = false;
                                }
                                
                                if( $all_upgrade_sim_sales[ $employee ] >= $advisor_upgrade_sim[ $employee ] )
                                {
                                    $upgrade_sim_colour = 'green';
                                    $upgrade_sim_text = 'white';
                                    $upgrade_sim_met = true;
                                }
                                else
                                {
                                    $upgrade_sim_colour = 'red';
                                    $upgrade_sim_text = 'white';
                                    $upgrade_sim_met = false;
                                }
                                
                                if( $all_new_bt_sales[ $employee ] >= $advisor_new_bt[ $employee ] )
                                {
                                    $bt_colour = 'green';
                                    $bt_text = 'white';
                                    $new_bt_met = true;
                                }
                                else
                                {
                                    $bt_colour = 'red';
                                    $bt_text = 'white';
                                    $new_bt_met = false;
                                }
                                
                                if( $all_insurance_sales[ $employee ] >= $advisor_insurance[ $employee ] )
                                {
                                    $insurance_colour = 'green';
                                    $insurance_text = 'white';
                                    $all_insurance_met = true;
                                }
                                else
                                {
                                    $insurance_colour = 'red';
                                    $insurance_text = 'white';
                                    $all_insurance_met = false;
                                }
                                
                                if( $all_profit_sales[ $employee ] >= $advisor_profit_target[ $employee ] )
                                {
                                    $potential_colour = 'green';
                                    $potential_text = 'white';
                                    $all_profit_met = true;
                                }
                                else
                                {
                                    $potential_colour = 'red';
                                    $potential_text = 'white';
                                    $all_profit_met = false;
                                }
                                
                                if( $new_handset_met && $new_sim_met && $new_data_met && $upgrade_handset_met && $upgrade_sim_met && $new_bt_met && $all_profit_met && $all_insurance_met )
                                {
                                    $avdisor_profit_colour = 'green';
                                    $avdisor_profit_text = 'white';
                                    
                                    $difference = floatval($all_profit_sales[ $employee ]) - floatval($advisor_profit_target[ $employee ]);
                                    
                                    $extra = ($advisor_profit_target[ $employee ] / 100) * 10;
                                    
                                    $extra = $difference / $extra;
                                    
                                    if($extra >= 1 ) {
                                        $extra = floor($extra);
                                        
                                        $extra = $extra * 0.5;
                                        
                                        $percentage = floatval($percent[ $employee ]) + floatval($extra);
                                    } else {
                                        $percentage = $percent[ $employee ];
                                    }
                                    
                                    $advisor_profit_bonus = number_format( ($all_profit_sales[ $employee ] / 100 ) * $percentage, 2, '.', '');
                                }
                                else
                                {
                                    $advisor_profit_bonus = number_format( ($advisor_profit_target[ $employee ] / 100 ) * $percent[ $employee ], 2, '.', '');
                                    $avdisor_profit_colour = 'red';
                                    $avdisor_profit_text = 'white';
                                }
                                ?>
                                
                                <tr>
                                    <td class="blank-row"></td>
                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><?php echo $employee; ?></td>
                                    <td>Actual</td>
                                    <td style="background-color:<?php echo $new_handset_colour; ?>; color:<?php echo $new_handset_text; ?>"><?php echo $all_new_handset_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $new_sim_colour; ?>; color:<?php echo $new_sim_text; ?>"><?php echo $all_new_sim_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $new_data_colour; ?>; color:<?php echo $new_data_text; ?>"><?php echo $all_new_data_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $upgrade_handset_colour; ?>; color:<?php echo $upgrade_handset_text; ?>"><?php echo $all_upgrade_handset_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $upgrade_sim_colour; ?>; color:<?php echo $upgrade_sim_text; ?>"><?php echo $all_upgrade_sim_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $bt_colour; ?>; color:<?php echo $bt_text; ?>"><?php echo $all_new_bt_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $insurance_colour; ?>; color:<?php echo $insurance_text; ?>"><?php echo $all_insurance_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $potential_colour; ?>; color:<?php echo $potential_text; ?>"><?php echo '£' . number_format($all_profit_sales[ $employee ], 2, '.', ''); ?></td>
                                    <td rowspan="2" style="vertical-align : middle;text-align:center; background-color:<?php echo $avdisor_profit_colour; ?>; color:<?php echo $avdisor_profit_text; ?>"><?php echo '£' . $advisor_profit_bonus; ?></td>
                                </tr>
                                <tr>
                                    <td class="blank-row"></td>
                                    <td>Target</td>
                                    <td><?php echo $advisor_new_handset[ $employee ]; ?></td>
                                    <td><?php echo $advisor_new_sim[ $employee ]; ?></td>
                                    <td><?php echo $advisor_new_data[ $employee ]; ?></td>
                                    <td><?php echo $advisor_upgrade_handset[ $employee ]; ?></td>
                                    <td><?php echo $advisor_upgrade_sim[ $employee ]; ?></td>
                                    <td><?php echo $advisor_new_bt[ $employee ]; ?></td>
                                    <td><?php echo $advisor_insurance[ $employee ]; ?></td>
                                    <td><?php echo '£' . number_format($advisor_profit_target[ $employee ], 2, '.', ''); ?></td>
                                    <td class="blank-row"></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <table class="table spacer">
                        <thead>
                            <tr>
                                <th class="col-md-1 blank-row"></th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1">New Handset</th>
                                <th class="col-md-1">New Sim</th>
                                
                                <?php if(strtotime("now") < strtotime("1 March 2022"))
                                { ?>
                                    <th class="col-md-1">New Data</th>
                                <?php } else { ?>
                                    <th class="col-md-1">Data Value</th>
                                <?php } ?>
                                
                                <th class="col-md-1">Upgrade Handset</th>
                                <th class="col-md-1">Upgrade Sim / other</th>
                                
                                <?php if(strtotime($date) < strtotime("1 February 2022"))
                                { ?>
                                    <th class="col-md-1">New BT</th>
                                <?php } else { ?>
                                    <th class="col-md-1">New HBB</th>
                                <?php } ?>
                                
                                <th class="col-md-1">Regrades</th>
                                <th class="col-md-1">Insurance</th>
                                <th class="col-md-1">Profit</th>
                                <th class="col-md-1">Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //get our nps values
                            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_nps" ) );
                            foreach( $employees as $id => $employee )
                            {
                                foreach ( $results as $result )
                                {
                                    if ( $result->advisor == $employee )
                                    {
                                        if( $result->month == $month && $result->year == $year )
                                        {
                                            $npsValue = floatval($result->nps);
                                            $overrideKPI = $result->override_kpi;
                                            $overrideNPS = $result->override_nps;
                                        }
                                    }
                                }
                                
                                if($npsValue > 85) {
                                $nps_met = true;
                            } else {
                                $nps_met = false;
                            }
                            
                            if($overrideKPI == 'yes')
                            {
                                $overrideKPI = true;
                            } else {
                                $overrideKPI = false;
                            }
                            
                            if($overrideNPS == 'yes')
                            {
                                $overrideNPS = true;
                            } else {
                                $overrideNPS = false;
                            }
    
                                if( $all_new_handset_sales[ $employee ] >= $advisor_new_handset[ $employee ] )
                                {
                                    $new_handset_colour = 'green';
                                    $new_handset_text = 'white';
                                    $new_handset_met = true;
                                }
                                else
                                {
                                    $new_handset_colour = 'red';
                                    $new_handset_text = 'white';
                                    $new_handset_met = false;
                                }
                                
                                if( $all_new_sim_sales[ $employee ] >= $advisor_new_sim[ $employee ] )
                                {
                                    $new_sim_colour = 'green';
                                    $new_sim_text = 'white';
                                    $new_sim_met = true;
                                }
                                else
                                {
                                    $new_sim_colour = 'red';
                                    $new_sim_text = 'white';
                                    $new_sim_met = false;
                                }
                                
                                if(strtotime($date) < strtotime("1 March 2022"))
                                {
                                    if( $all_new_data_sales[ $employee ] >= $advisor_new_data[ $employee ] )
                                    {
                                        $new_data_colour = 'green';
                                        $new_data_text = 'white';
                                        $new_data_met = true;
                                    }
                                    else
                                    {
                                        $new_data_colour = 'red';
                                        $new_data_text = 'white';
                                        $new_data_met = false;
                                    }
                                } else {
                                    if( floatval($all_new_data_sales[ $employee ]) >= floatval($advisor_new_data[ $employee ]) )
                                    {
                                        $new_data_colour = 'green';
                                        $new_data_text = 'white';
                                        $new_data_met = true;
                                    }
                                    else
                                    {
                                        $new_data_colour = 'red';
                                        $new_data_text = 'white';
                                        $new_data_met = false;
                                    }
                                }
                                
                                if( $all_upgrade_handset_sales[ $employee ] >= $advisor_upgrade_handset[ $employee ] )
                                {
                                    $upgrade_handset_colour = 'green';
                                    $upgrade_handset_text = 'white';
                                    $upgrade_handset_met = true;
                                }
                                else
                                {
                                    $upgrade_handset_colour = 'red';
                                    $upgrade_handset_text = 'white';
                                    $upgrade_handset_met = false;
                                }
                                
                                if( $all_upgrade_sim_sales[ $employee ] >= $advisor_upgrade_sim[ $employee ] )
                                {
                                    $upgrade_sim_colour = 'green';
                                    $upgrade_sim_text = 'white';
                                    $upgrade_sim_met = true;
                                }
                                else
                                {
                                    $upgrade_sim_colour = 'red';
                                    $upgrade_sim_text = 'white';
                                    $upgrade_sim_met = false;
                                }
                                
                                if( $all_new_bt_sales[ $employee ] >= $advisor_new_bt[ $employee ] )
                                {
                                    $bt_colour = 'green';
                                    $bt_text = 'white';
                                    $new_bt_met = true;
                                }
                                else
                                {
                                    $bt_colour = 'red';
                                    $bt_text = 'white';
                                    $new_bt_met = false;
                                }
                                
                                if( $all_regrade_sales[ $employee ] >= $advisor_regrade[ $employee ] )
                                {
                                    $regrade_colour = 'green';
                                    $regrade_text = 'white';
                                    $regrade_met = true;
                                }
                                else
                                {
                                    $regrade_colour = 'red';
                                    $regrade_text = 'white';
                                    $regrade_met = false;
                                }
                                
                                if( $all_insurance_sales[ $employee ] >= $advisor_insurance[ $employee ] )
                                {
                                    $insurance_colour = 'green';
                                    $insurance_text = 'white';
                                    $all_insurance_met = true;
                                }
                                else
                                {
                                    $insurance_colour = 'red';
                                    $insurance_text = 'white';
                                    $all_insurance_met = false;
                                }
                                
                                if( $all_profit_sales[ $employee ] >= $advisor_profit_target[ $employee ] )
                                {
                                    $potential_colour = 'green';
                                    $potential_text = 'white';
                                    $all_profit_met = true;
                                }
                                else
                                {
                                    $potential_colour = 'red';
                                    $potential_text = 'white';
                                    $all_profit_met = false;
                                }
                                
                                if( $new_handset_met && $new_sim_met && $new_data_met && $upgrade_handset_met && $upgrade_sim_met && $new_bt_met && $all_profit_met && $all_insurance_met )
                                {
                                    $avdisor_profit_colour = 'green';
                                    $avdisor_profit_text = 'white';
                                    
                                    $difference = floatval($all_profit_sales[ $employee ]) - floatval($advisor_profit_target[ $employee ]);
                                    
                                    $extra = ($advisor_profit_target[ $employee ] / 100) * 10;
                                    
                                    $extra = $difference / $extra;
                                    
                                    if($extra >= 1 ) {
                                        $extra = floor($extra);
                                        
                                        $extra = $extra * 0.5;
                                        
                                        $percentage = floatval($percent[ $employee ]) + floatval($extra);
                                    } else {
                                        $percentage = $percent[ $employee ];
                                    }
                                    
                                    $advisor_profit_bonus = number_format( ($all_profit_sales[ $employee ] / 100 ) * $percentage, 2, '.', '');
                                    
                                    if(!$nps_met && !$overrideNPS) {
                                        $advisor_profit_bonus = number_format( (60 / 100 ) * $advisor_profit_bonus, 2, '.', '');
                                    }
                                }
                                else
                                {
                                    $advisor_profit_bonus = number_format( ($advisor_profit_target[ $employee ] / 100 ) * $percent[ $employee ], 2, '.', '');
                                    $avdisor_profit_colour = 'red';
                                    $avdisor_profit_text = 'white';
                                    
                                    if($overrideKPI) {
                                        $avdisor_profit_colour = 'green';
                                        $avdisor_profit_text = 'white';
                                        
                                        $difference = floatval($all_profit_sales[ $employee ]) - floatval($advisor_profit_target[ $employee ]);
                                        
                                        $extra = ($advisor_profit_target[ $employee ] / 100) * 10;
                                        
                                        $extra = $difference / $extra;
                                        
                                        if($extra >= 1 ) {
                                            $extra = floor($extra);
                                            
                                            $extra = $extra * 0.5;
                                            
                                            $percentage = floatval($percent[ $employee ]) + floatval($extra);
                                        } else {
                                            $percentage = $percent[ $employee ];
                                        }
                                        
                                        $advisor_profit_bonus = number_format( ($all_profit_sales[ $employee ] / 100 ) * $percentage, 2, '.', '');
                                        
                                        //now deduct the 50 percent
                                        $advisor_profit_bonus = number_format( ( $advisor_profit_bonus / 2 ), 2, '.', '');
                                        
                                        if(!$nps_met && !$overrideNPS) {
                                            $advisor_profit_bonus = number_format( (60 / 100 ) * $advisor_profit_bonus, 2, '.', '');
                                        }
                                    }
                                }
                                ?>
                                
                                <tr>
                                    <td class="blank-row"></td>
                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><?php echo $employee; ?></td>
                                    <td>Actual</td>
                                    <td style="background-color:<?php echo $new_handset_colour; ?>; color:<?php echo $new_handset_text; ?>"><?php echo $all_new_handset_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $new_sim_colour; ?>; color:<?php echo $new_sim_text; ?>"><?php echo $all_new_sim_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $new_data_colour; ?>; color:<?php echo $new_data_text; ?>">
                                        <?php if(strtotime($date) < strtotime("1 March 2022")) {
                                            echo $all_new_data_sales[ $employee ];
                                        } else {
                                            echo '£' . $all_new_data_sales[ $employee ];
                                        }
                                        ?>
                                    </td>
                                    <td style="background-color:<?php echo $upgrade_handset_colour; ?>; color:<?php echo $upgrade_handset_text; ?>"><?php echo $all_upgrade_handset_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $upgrade_sim_colour; ?>; color:<?php echo $upgrade_sim_text; ?>"><?php echo $all_upgrade_sim_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $bt_colour; ?>; color:<?php echo $bt_text; ?>"><?php echo $all_new_bt_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $regrade_colour; ?>; color:<?php echo $regrade_text; ?>"><?php echo $all_regrade_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $insurance_colour; ?>; color:<?php echo $insurance_text; ?>"><?php echo $all_insurance_sales[ $employee ]; ?></td>
                                    <td style="background-color:<?php echo $potential_colour; ?>; color:<?php echo $potential_text; ?>"><?php echo '£' . number_format($all_profit_sales[ $employee ], 2, '.', ''); ?></td>
                                    <td rowspan="2" style="vertical-align : middle;text-align:center; background-color:<?php echo $avdisor_profit_colour; ?>; color:<?php echo $avdisor_profit_text; ?>"><?php echo '£' . $advisor_profit_bonus; ?></td>
                                </tr>
                                <tr>
                                    <td class="blank-row"></td>
                                    <td>Target</td>
                                    <td><?php echo $advisor_new_handset[ $employee ]; ?></td>
                                    <td><?php echo $advisor_new_sim[ $employee ]; ?></td>
                                    <td>
                                        <?php if(strtotime($date) < strtotime("1 March 2022")) {
                                            echo $advisor_new_data[ $employee ];
                                        } else {
                                            echo '£' . $advisor_new_data[ $employee ];;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $advisor_upgrade_handset[ $employee ]; ?></td>
                                    <td><?php echo $advisor_upgrade_sim[ $employee ]; ?></td>
                                    <td><?php echo $advisor_new_bt[ $employee ]; ?></td>
                                    <td><?php echo $advisor_regrade[ $employee ]; ?></td>
                                    <td><?php echo $advisor_insurance[ $employee ]; ?></td>
                                    <td><?php echo '£' . number_format($advisor_profit_target[ $employee ], 2, '.', ''); ?></td>
                                    <td class="blank-row"></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <?php
        
        $new = ob_get_clean();
            
        $success[ 'new' ] = $new;
        $success[ 'type' ] = $type;
            
        wp_send_json_success( $success );
    }
}

function get_store_commission()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$split = explode(" ", $date );
	
	//we need our month and year
	$month = $split[0];
                
    $year = $split[1];
    
    $currentDay = intval( date( 'd' ) );
    
    $days = date('t');
    
    $user = get_user_by('id', $advisor);
    
    $store = esc_attr( get_user_meta( $advisor, 'store_location' , true ) );
    
    $kpi_met = false;
    $nps_met = false;
    
    $user_info = get_userdata( $user->ID );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $full_name = $first_name . ' ' . $last_name;
    
    //get our nps values
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_nps" ) );
    
    foreach ( $results as $result )
    {
        if ( $result->advisor == $full_name )
        {
            if( $result->month == $month && $result->year == $year )
            {
                $npsValue = floatval($result->nps);
                $overrideKPI = $result->override_kpi;
                $overrideNPS = $result->override_nps;
            }
        }
    }
    
    if($npsValue > 85) {
        $nps_met = true;
    } else {
        $nps_met = false;
    }
    
    if($overrideKPI == 'yes')
    {
        $overrideKPI = true;
    } else {
        $overrideKPI = false;
    }
    
    if($overrideNPS == 'yes')
    {
        $overrideNPS = true;
    } else {
        $overrideNPS = false;
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_targets" ) );
    
    foreach ( $results as $result )
    {
        if ( $result->store == $store )
        {
            if( $result->month == $month && $result->year == $year )
            {
                $new_handset = $result->new_handset;
                $new_sim = $result->new_sim;
                $new_data = $result->new_data;
                $upgrade_handset = $result->upgrade_handset;
                $upgrade_sim = $result->upgrade_sim;
                $new_bt = $result->new_bt;
                $regrade = $result->regrade;
                $insurance = $result->insurance;
                $profit_target = $result->profit_target;
            }
        }
    }
    
    //get the total number of staff hours
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_rota" ) );
    
    $total_hours = array();
    $advisor_hours = array();
    
    foreach ( $results as $result )
    {
        if ( $result->store == $store && $result->month == $month && $result->year == $year && $result->advisor == $full_name )
        {
            $advisor_hours[] =  $result->total_hours;
        }
        
        if ( $result->store == $store && $result->month == $month && $result->year == $year )
        {
            $total_hours[] =  $result->total_hours;
        }
    }
    
    $hours = 0;
    $total = 0;
    
    foreach ( $advisor_hours as $ahours )
    {
        $hours = intval( $hours ) + intval( $ahours );
    }
    
    foreach ( $total_hours as $thours )
    {
        $total = intval( $total ) + intval( $thours );
    }
    
    //get our staffs sales for the current month
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $full_name . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) );
	
	$advisor_new_handset = ceil( ( $new_handset / $total ) * $hours );
    $advisor_new_sim = ceil( ( $new_sim / $total ) * $hours );
    $advisor_new_data = ceil( ( $new_data / $total ) * $hours );
    $advisor_upgrade_handset = ceil( ( $upgrade_handset / $total ) * $hours );
    $advisor_upgrade_sim = ceil( ( $upgrade_sim / $total ) * $hours );
    $advisor_new_bt = ceil( ( $new_bt / $total ) * $hours );
    $advisor_regrade = ceil( ( $regrade / $total ) * $hours );
    $advisor_insurance = ceil( ( $insurance / $total ) * $hours );
    $advisor_profit_target = ceil( ( $profit_target / $total ) * $hours );
    
    if( $user && in_array( 'employee', $user->roles ) )
    {
        $percent = 8;
    }
    else if( $user && in_array( 'senior_advisor', $user->roles ) )
    {
        $percent = 10;
    }
    
    $all_new_handset = 0;
    $all_new_sim = 0;
    $all_new_data = 0;
    $all_upgrade_handset = 0;
    $all_upgrade_sim = 0;
    $all_new_bt = 0;
    $all_regrade = 0;
    $all_insurance = 0;
    $all_profit = 0;
    
    foreach( $results as $result )
    {
        if( $result->type == 'new' && $result->product_type == 'handset' )
        {
            //this is all our new connections
            $all_new_handset++;
        }
        
        if( $result->type == 'new' && $result->product_type == 'simonly' )
        {
            //this is all our new connections
            $all_new_sim++;
        }
        
        if(strtotime('now') < strtotime("1 July 2021"))
        {
            if( $result->type == 'new' && $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' )
            {
                $all_new_data++;
            }
        }
        else {
            if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                if(strtotime('now') < strtotime("1 March 2022"))
                {
                    $all_new_data++;
                } else {
                    if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                        $all_new_data += floatval(fc_get_data_tariff_mrc($result->tariff));
                    } else {
                        $all_new_data += floatval(fc_get_tariff_mrc($result->tariff));
                    }
                }
            }
        }
        
        if( $result->type == 'upgrade' && $result->product_type == 'handset' )
        {
            //this is all our new connections
            $all_upgrade_handset++;
        }
        
        if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
        {
            //this is all our new connections
            $all_regrade++;
        }
        
        if(strtotime('now') < strtotime("1 July 2021"))
        {
            if( $result->type == 'upgrade' && $result->product_type == 'simonly' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                //this is all our new connections
                $all_upgrade_sim++;
            }
        }
        else {
            if( $result->type == 'upgrade' && $result->product_type == 'simonly' )
            {
                //this is all our new connections
                $all_upgrade_sim++;
            }
        }
        
        if( $result->type == 'new' && $result->product_type == 'homebroadband' )
        {
            //find out if its a BT Tariff sold
            $all_new_bt++;
        }
        
        if( $result->insurance == 'yes' )
        {
            $all_insurance++;
        }
        
        if( $result->hrc !== 'yes' )
        {
            if( $result->pobo == 'yes' )
            {
                $profit = (80 / 100) * $result->total_profit;
                $all_profit += $profit;
            }
            else
            {
                $all_profit += $result->total_profit;
            }
        }
    }
    
    $potential_new_handset = ceil( ( $all_new_handset / $currentDay ) * $days );
    $potential_new_sim = ceil( ( $all_new_sim / $currentDay ) * $days );
    $potential_new_data = ceil( ( $all_new_data / $currentDay ) * $days );
    $potential_upgrade_handset = ceil( ( $all_upgrade_handset / $currentDay ) * $days );
    $potential_upgrade_sim = ceil( ( $all_upgrade_sim / $currentDay ) * $days );
    $potential_new_bt = ceil( ( $all_new_bt / $currentDay ) * $days );
    $potential_regrade = ceil( ( $all_regrade / $currentDay ) * $days );
    $potential_insurance = ceil( ( $all_insurance / $currentDay ) * $days );
    $potential_profit_target = ceil( ( $all_profit / $currentDay ) * $days );
    
    if( $all_new_handset >= $advisor_new_handset )
    {
        $new_handset_colour = 'green';
        $new_handset_text = 'white';
        $new_handset_met = true;
    }
    else
    {
        $new_handset_colour = 'red';
        $new_handset_text = 'white';
        $new_handset_met = false;
    }
    
    if( $all_new_sim >= $advisor_new_sim )
    {
        $new_sim_colour = 'green';
        $new_sim_text = 'white';
        $new_sim_met = true;
    }
    else
    {
        $new_sim_colour = 'red';
        $new_sim_text = 'white';
        $new_sim_met = false;
    }
    
    if(strtotime($date) < strtotime("1 March 2022"))
    {
        if( $all_new_data >= $advisor_new_data )
        {
            $new_data_colour = 'green';
            $new_data_text = 'white';
            $new_data_met = true;
        }
        else
        {
            $new_data_colour = 'red';
            $new_data_text = 'white';
            $new_data_met = false;
        }
    } else {
        if( floatval($all_new_data) >= floatval($advisor_new_data) )
        {
            $new_data_colour = 'green';
            $new_data_text = 'white';
            $new_data_met = true;
        }
        else
        {
            $new_data_colour = 'red';
            $new_data_text = 'white';
            $new_data_met = false;
        }
    }
    
    if( $all_upgrade_handset >= $advisor_upgrade_handset )
    {
        $upgrade_handset_colour = 'green';
        $upgrade_handset_text = 'white';
        $upgrade_handset_met = true;
    }
    else
    {
        $upgrade_handset_colour = 'red';
        $upgrade_handset_text = 'white';
        $upgrade_handset_met = false;
    }
    
    if( $all_upgrade_sim >= $advisor_upgrade_sim )
    {
        $upgrade_sim_colour = 'green';
        $upgrade_sim_text = 'white';
        $upgrade_sim_met = true;
    }
    else
    {
        $upgrade_sim_colour = 'red';
        $upgrade_sim_text = 'white';
        $upgrade_sim_met = false;
    }
    
    if( $all_regrade >= $advisor_regrade )
    {
        $regrade_colour = 'green';
        $regrade_text = 'white';
        $regrade_met = true;
    }
    else
    {
        $regrade_colour = 'red';
        $regrade_text = 'white';
        $regrade_met = false;
    }
    
    if( $all_new_bt >= $advisor_new_bt )
    {
        $bt_colour = 'green';
        $bt_text = 'white';
        $new_bt_met = true;
    }
    else
    {
        $bt_colour = 'red';
        $bt_text = 'white';
        $new_bt_met = false;
    }
    
    if( $all_insurance >= $advisor_insurance )
    {
        $insurance_colour = 'green';
        $insurance_text = 'white';
        $all_insurance_met = true;
    }
    else
    {
        $insurance_colour = 'red';
        $insurance_text = 'white';
        $all_insurance_met = false;
    }
    
    if( $all_profit >= $advisor_profit_target )
    {
        $potential_colour = 'green';
        $potential_text = 'white';
        $all_profit_met = true;
    }
    else
    {
        $potential_colour = 'red';
        $potential_text = 'white';
        $all_profit_met = false;
    }
    
    if( $new_handset_met && $new_sim_met && $new_data_met && $upgrade_handset_met && $upgrade_sim_met && $new_bt_met && $all_profit_met && $all_insurance_met )
    {
        $advisor_profit_colour = 'green';
        $advisor_profit_text = 'white';
        
        $difference = floatval($all_profit) - floatval($advisor_profit_target);
        
        $extra = ($advisor_profit_target / 100) * 10;
        
        $extra = $difference / $extra;
        
        if($extra >= 1 ) {
            $extra = floor($extra);
            
            $extra = $extra * 0.5;
            
            $percentage = floatval($percent) + floatval($extra);
        } else {
            $percentage = $percent;
        }
        
        $advisor_profit_bonus = number_format( ($all_profit / 100 ) * $percentage, 2, '.', '');
        $bonus_text = "Monthly Bonus";
        
        $kpi_met = true;
        
        if(!$nps_met && !$overrideNPS) {
            $advisor_profit_bonus = number_format( (60 / 100 ) * $advisor_profit_bonus, 2, '.', '');
        }
    }
    else
    {
        $advisor_profit_bonus = number_format( ($advisor_profit_target / 100 ) * $percent, 2, '.', '');
        $advisor_profit_colour = 'red';
        $advisor_profit_text = 'white';
        $bonus_text = "Potential Bonus";
        
        $kpi_met = false;
        
        if($overrideKPI) {
            $advisor_profit_colour = 'green';
            $avdisor_profit_text = 'white';
            
            $difference = floatval($all_profit) - floatval($advisor_profit_target);
            
            $extra = ($advisor_profit_target / 100) * 10;
            
            $extra = $difference / $extra;
            
            if($extra >= 1 ) {
                $extra = floor($extra);
                
                $extra = $extra * 0.5;
                
                $percentage = floatval($percent) + floatval($extra);
            } else {
                $percentage = $percent;
            }
            
            $advisor_profit_bonus = number_format( ($all_profit / 100 ) * $percent, 2, '.', '');
            $bonus_text = "Monthly Bonus";
            
            //now deduct the 50 percent
            $advisor_profit_bonus = number_format( ( $advisor_profit_bonus / 2 ), 2, '.', '');
            
            if(!$nps_met && !$overrideNPS) {
                $advisor_profit_bonus = number_format( (60 / 100 ) * $advisor_profit_bonus, 2, '.', '');
            }
        }
    }
    
    ob_start()
    ?>
    
    <h4 class="text-center"><?php echo $month ?> Targets</h4>
    
    <div class="container-fluid spacer table-responsive">
        <div class="row">
            <table class="table spacer">
                <thead>
                    <tr>
                        <th class="col-md-1 blank-row"></th>
                        <th class="col-md-2"></th>
                        <th class="col-md-1">New Handset</th>
                        <th class="col-md-1">New Sim</th>
                        <th class="col-md-1">Data Value</th>
                        <th class="col-md-1">Upgrade Handset</th>
                        <th class="col-md-1">Upgrade Sim / other</th>
                        <th class="col-md-1">New HBB</th>
                        <th class="col-md-1">Regrades</th>
                        <th class="col-md-1">Insurance</th>
                        <th class="col-md-1">Profit</th>
                        <th class="col-md-1 blank-row"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="blank-row"></td>
                        <td>Actual</td>
                        <td style="background-color:<?php echo $new_handset_colour; ?>; color:<?php echo $new_handset_text; ?>"><?php echo $all_new_handset; ?></td>
                        <td style="background-color:<?php echo $new_sim_colour; ?>; color:<?php echo $new_sim_text; ?>"><?php echo $all_new_sim; ?></td>
                        <td style="background-color:<?php echo $new_data_colour; ?>; color:<?php echo $new_data_text; ?>"><?php echo '£' . $all_new_data;?></td>
                        <td style="background-color:<?php echo $upgrade_handset_colour; ?>; color:<?php echo $upgrade_handset_text; ?>"><?php echo $all_upgrade_handset; ?></td>
                        <td style="background-color:<?php echo $upgrade_sim_colour; ?>; color:<?php echo $upgrade_sim_text; ?>"><?php echo $all_upgrade_sim; ?></td>
                        <td style="background-color:<?php echo $bt_colour; ?>; color:<?php echo $bt_text; ?>"><?php echo $all_new_bt; ?></td>
                        <td style="background-color:<?php echo $regrade_colour; ?>; color:<?php echo $regrade_text; ?>"><?php echo $all_regrade; ?></td>
                        <td style="background-color:<?php echo $insurance_colour; ?>; color:<?php echo $insurance_text; ?>"><?php echo $all_insurance; ?></td>
                        <td style="background-color:<?php echo $potential_colour; ?>; color:<?php echo $potential_text; ?>"><?php echo '£' . number_format($all_profit, 2, '.', ''); ?></td>
                        <td class="blank-row"></td>
                    </tr>
                    <tr>
                        <td class="blank-row"></td>
                        <td>Projected</td>
                        <td><?php echo $potential_new_handset; ?></td>
                        <td><?php echo $potential_new_sim; ?></td>
                        <td><?php echo 'N/A'; ?></td>
                        <td><?php echo $potential_upgrade_handset; ?></td>
                        <td><?php echo $potential_upgrade_sim; ?></td>
                        <td><?php echo $potential_new_bt; ?></td>
                        <td><?php echo $potential_regrade; ?></td>
                        <td><?php echo $potential_insurance; ?></td>
                        <td><?php echo '£' . number_format($potential_profit_target, 2, '.', ''); ?></td>
                        <td class="blank-row"></td>
                    </tr>
                    <tr>
                        <td class="blank-row"></td>
                        <td>Target</td>
                        <td><?php echo $advisor_new_handset; ?></td>
                        <td><?php echo $advisor_new_sim; ?></td>
                        <td>
                            <?php if(strtotime('now') < strtotime("1 March 2022")) {
                                echo $advisor_new_data;
                            } else {
                                echo '£' . $advisor_new_data;
                            }
                            ?>
                        </td>
                        <td><?php echo $advisor_upgrade_handset; ?></td>
                        <td><?php echo $advisor_upgrade_sim; ?></td>
                        <td><?php echo $advisor_new_bt; ?></td>
                        <td><?php echo $advisor_regrade; ?></td>
                        <td><?php echo $advisor_insurance; ?></td>
                        <td><?php echo '£' . number_format($advisor_profit_target, 2, '.', ''); ?></td>
                        <td class="blank-row"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th class="col-md-5 blank-row"></th>
                        <th class="col-md-2"><?php echo $bonus_text; ?></th>
                        <th class="col-md-5 blank-row"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-md-5 blank-row"></td>
                        <td class="col-md-2" style="background-color:<?php echo $advisor_profit_colour; ?>; color:<?php echo $advisor_profit_text; ?>"><?php echo '£' . number_format($advisor_profit_bonus, 2, '.', ''); ?></td>
                        <td class="col-md-5 blank-row"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php
    
    echo '<h4 style="margin-bottom:20px;">Advisor KPI\'s</h4>';
    
    if(!$kpi_met) { ?>
        <p>Advisor has not achieved all their KPI's for the month</p>
    <?php }
    
    if(!$kpi_met && $overrideKPI) { ?>
        <p>KPI requirement has been overridden by the manager</p>
    <?php }
    
    if($kpi_met) { ?>
        <p>Advisor has achieved all their KPI's for the month</p>
    <?php }
    
    echo '<h4 style="margin-top:30px; margin-bottom:20px;">Advisor NPS</h4>';
    
    if(!$nps_met) { ?>
        <p>Advisor has an NPS score of <?php echo $npsValue; ?>%, advisor has not met their NPS target.</p>
    <?php }
    
    if(!$nps_met && $overrideNPS) { ?>
        <p>NPS requirement has been overridden by the manager</p>
    <?php }
    
    if($nps_met) { ?>
        <p>Advisor has an NPS score of <?php echo $npsValue; ?>%, advisor has met their NPS target.</p>
    <?php }
    
    if(!$kpi_met && !$overrideKPI || !$nps_met  && !$overrideNPS) {
        echo '<h4 style="margin-top:30px; margin-bottom:0px;">Commission Overrides</h4>';
    
        if(!$kpi_met && !$overrideKPI) { ?>
            <button type="button" id="override-kpi" class="woocommerce-Button button" style="margin-top:20px; margin-right:20px;" name="override-kpi" value="<?php esc_attr_e( 'Override KPI', 'woocommerce' ); ?>"><?php esc_html_e( 'Override KPI', 'woocommerce' ); ?></button>
        <?php }
        
        if(!$nps_met && !$overrideNPS) { ?>
            <button type="submit" id="override-nps" class="woocommerce-Button button" style="margin-top:20px" name="override-nps" value="<?php esc_attr_e( 'Override NPS %', 'woocommerce' ); ?>"><?php esc_html_e( 'Override NPS %', 'woocommerce' ); ?></button>
        <?php }
    }
    
    $commission = ob_get_clean();
    
    $success[ 'commission' ] = $commission;
    
    wp_send_json_success( $success );
}

function get_daily_chart()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

    foreach ( $results as $result )
    {
        $locations[] = $result->location;
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = '" . $date . "'" ) );

    foreach ( $locations as $location )
    {
        $store_daily_profit = 0;
        $store_daily_accessory_profit = 0;
        
        foreach ( $results as $result )
        {
            if( $result->store == $location )
            {
                //get our profits
                $store_daily_profit = floatval( $store_daily_profit ) + floatval( $result->total_profit );
                $store_daily_accessory_profit = floatval( $store_daily_accessory_profit ) + floatval( $result->accessory_profit );
                
                //now create our variables
                $profit_daily[ $location ] = $store_daily_profit;
                $accessory_profit_daily[ $location ] = $store_daily_accessory_profit;
            }
        }
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_profit_targets" ) );
    
    foreach ( $results as $result )
    {
        foreach ( $locations as $location )
        {
            if( $result->store == $location && $result->month == $month && $result->year == $year )
            {
                $profit_target = $result->target;
    
                $store_profit_target[ $location ] = $profit_target;
            }
        }
    }
    
    $daily_profit_total = 0;
    $daily_accessory_total = 0;
    
    $total_profit_target = 0;

    foreach ( $locations as $location )
    {
        //daily first
        $daily_profit_total = floatval( $daily_profit_total ) + floatval( $profit_daily[ $location ] );
        $daily_accessory_total = floatval( $daily_accessory_total ) + floatval( $accessory_profit_daily[ $location ] );
        
        //get our total profit target
        $total_profit_target = floatval( $total_profit_target ) + $store_profit_target[ $location ];
    }
    
    $all_new_total = 0;
    $all_upgrade_total = 0;
    $new_handsets_total = 0;
    $new_broadband_total = 0;
    $upgrade_broadband_total = 0;
    $insurance_total = 0;
    $new_simo_total = 0;
    $hrc_total = 0;
    
    foreach( $locations as $location )
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store='" . $location . "'" . " AND DATE( `sale_date` ) = '$date' " ) );
        
        $all_new = 0;
        $all_upgrade = 0;
        $new_handsets = 0;
        $new_broadband = 0;
        $upgrade_broadband = 0;
        $insurance_sales = 0;
        $new_simo = 0;
        $hrc = 0;
    
        foreach( $results as $result )
        {
            if( $result->type == 'new' && $result->product_type !== 'homebroadband' && $result->type == 'new' && $result->product_type !== 'insurance' && $result->type == 'new' && $result->product_type !== 'accessory' )
            {
                //this is all our new connections
                $all_new++;
                $all_new_total++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type !== 'homebroadband' && $result->type == 'upgrade' && $result->product_type !== 'insurance' && $result->type == 'upgrade' && $result->product_type !== 'accessory' )
            {
                //this is all our upgrade connections
                $all_upgrade++;
                $all_upgrade_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'handset' )
            {
                //this is all our new handset connections
                $new_handsets++;
                $new_handsets_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'homebroadband' )
            {
                ///this is all our new home broadband connections
                $new_broadband++;
                $new_broadband_total++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
            {
                //this is all our home broadband upgrades
                $upgrade_broadband++;
                $upgrade_broadband_total++;
            }
            
            if( $result->insurance == 'yes' )
            {
                //this is all our insurance connections
                $insurance_sales++;
                $insurance_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'simonly' )
            {
                //this is all our new handset connections
                $new_simo++;
                $new_simo_total++;
            }
            
            if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                if(strtotime($date) < strtotime("1 March 2022"))
                {
                    $hrc++;
                    $hrc_total++;
                } else {
                    if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                        $hrc += floatval(fc_get_data_tariff_mrc($result->tariff));
                        $hrc_total += floatval(fc_get_data_tariff_mrc($result->tariff));
                    } else {
                        $hrc += floatval(fc_get_tariff_mrc($result->tariff));
                        $hrc_total += floatval(fc_get_tariff_mrc($result->tariff));
                    }
                }
            }
                
            //lets add all our sales info
            $daily_all_new_sales[ $location ] = $all_new;    
            $daily_all_upgrade_sales[ $location ] = $all_upgrade;
            $daily_new_handset_sales[ $location ] = $new_handsets;
            $daily_new_broadband_sales[ $location ] =$new_broadband;
            $daily_upgrade_broadband_sales[ $location ] = $upgrade_broadband;
            $daily_insurance_sales[ $location ] = $insurance_sales;
            $daily_new_simo_sales[ $location ] = $new_simo;
            $daily_hrc_sales[ $location ] = $hrc;
        }
    }
    
    $total_daily_all_new_sales = $all_new_total;    
    $total_daily_all_upgrade_sales = $all_upgrade_total;
    $total_daily_new_handset_sales = $new_handsets_total;
    $total_daily_new_broadband_sales = $new_broadband_total;
    $total_daily_upgrade_broadband_sales = $upgrade_broadband_total;
    $total_daily_insurance_sales = $insurance_total;
    $total_daily_new_simo_sales = $new_simo_total;
    $total_daily_hrc_sales = $hrc_total;

    echo '<table class="table">';
    echo '    <thead>';
    echo '       <tr>';
    echo '           <th class="col-md-1">Store</th>';
    echo '            <th class="col-md-1">Total New</th>';
    echo '            <th class="col-md-1">New H/S</th>';
    echo '            <th class="col-md-1">Upgrades</th>';
    echo '            <th class="col-md-1">New HBB</th>';
    echo '            <th class="col-md-1">Regrade HBB</th>';
    echo '            <th class="col-md-1">SIMO New</th>';
    echo '            <th class="col-md-1">Insurance</th>';
    echo '            <th class="col-md-1">Data Value</th>';
    echo '            <th class="col-md-1">ACC Profit</th>';
    echo '            <th class="col-md-1">Total Profit</th>';
    echo '        </tr>';
    echo '    </thead>';
    echo '    <tbody>';
            
    foreach ( $locations as $location )
    {
        echo '  <tr>';
        echo '<td>' . $location . '</td>';
        echo '<td>' . $daily_all_new_sales[ $location ] . '</td>';
        echo '<td>' . $daily_new_handset_sales[ $location ] . '</td>';
        echo '<td>' . $daily_all_upgrade_sales[ $location ] . '</td>';
        echo '<td>' . $daily_new_broadband_sales[ $location ] . '</td>';
        echo '<td>' . $daily_upgrade_broadband_sales[ $location ] . '</td>';
        echo '<td>' . $daily_new_simo_sales[ $location ] . '</td>';
        echo '<td>' . $daily_insurance_sales[ $location ] . '</td>';
        echo '<td>' . '£' . $daily_hrc_sales[ $location ] . '</td>';

        if( $accessory_profit_daily[ $location ] == '' )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $accessory_profit_daily[ $location ] , 2, '.', ',') . '</td>';
        }

        if( $profit_daily[ $location ] == '' )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $profit_daily[ $location ] , 2, '.', ',') . '</td>';
        }

        echo '</tr>';

    }

    echo ' <tr>';
    echo '   <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '    <td class="blank-row"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '    <th>Total</th>';
    echo '    <td>' . $total_daily_all_new_sales . '</td>';
    echo '    <td>' . $total_daily_new_handset_sales . '</td>';
    echo '    <td>' . $total_daily_all_upgrade_sales . '</td>';
    echo '    <td>' . $total_daily_new_broadband_sales . '</td>';
    echo '    <td>' . $total_daily_upgrade_broadband_sales . '</td>';
    echo '    <td>' . $total_daily_new_simo_sales . '</td>';
    echo '    <td>' . $total_daily_insurance_sales . '</td>';
    echo '    <td>' . $total_daily_hrc_sales . '</td>';

    if( $daily_accessory_total == 0 )
    {
        echo '<td></td>';
    }
    else
    {
        echo '<td>£' . number_format( $daily_accessory_total , 2, '.', ',') . '</td>';
    }

    if( $daily_profit_total == 0 )
    {
        echo '<td></td>';
    }
    else
    {
        echo '<td>£' . number_format( $daily_profit_total , 2, '.', ',') . '</td>';
    }

    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    
    wp_die();
}

function get_employee_daily_chart()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

    foreach ( $results as $result )
    {
        $locations[] = $result->location;
    }
    
    $user = wp_get_current_user();
    
    foreach( $locations as $location )
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store='" . $location . "'" . " AND DATE( `sale_date` ) = '$date' " ) );
        
        $all_new_handset = 0;
        $all_new_sim = 0;
        $all_new_data = 0;
        $all_upgrade_handset = 0;
        $all_upgrade_sim = 0;
        $all_new_bt = 0;
        $all_regrade = 0;
        $all_insurance = 0;
        $all_profit = 0;
    
        foreach( $results as $result )
        {
            if( $result->type == 'new' && $result->product_type == 'handset' )
            {
                //this is all our new connections
                $all_new_handset++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'simonly' )
            {
                //this is all our new connections
                $all_new_sim++;
            }
            
            if(strtotime('now') < strtotime("1 July 2021"))
            {
                if( $result->type == 'new' && $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' )
                {
                    $all_new_data++;
                }
            }
            else {
                if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
                {
                    if(strtotime('now') < strtotime("1 March 2022"))
                    {
                        $all_new_data++;
                    } else {
                        if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                            $all_new_data += floatval(fc_get_data_tariff_mrc($result->tariff));
                        } else {
                            $all_new_data += floatval(fc_get_tariff_mrc($result->tariff));
                        }
                    }
                }
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'handset' )
            {
                //this is all our new connections
                $all_upgrade_handset++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
            {
                //this is all our new connections
                $all_regrade++;
            }
            
            if(strtotime('now') < strtotime("1 July 2021"))
            {
                if( $result->type == 'upgrade' && $result->product_type == 'simonly' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
                {
                    //this is all our new connections
                    $all_upgrade_sim++;
                }
            }
            else {
                if( $result->type == 'upgrade' && $result->product_type == 'simonly' )
                {
                    //this is all our new connections
                    $all_upgrade_sim++;
                }
            }
            
            if( $result->type == 'new' && $result->product_type == 'homebroadband' )
            {
                //find out if its a BT Tariff sold
                $all_new_bt++;
            }
            
            if( $result->insurance == 'yes' )
            {
                $all_insurance++;
            }
            
            if( $result->hrc !== 'yes' )
            {
                if( $result->pobo == 'yes' )
                {
                    $profit = (80 / 100) * $result->total_profit;
                    $all_profit += $profit;
                }
                else
                {
                    $all_profit += $result->total_profit;
                }
            }
                
            //lets add all our sales info
            $daily_new_handset_sales[ $location ] = $all_new_handset;
            $daily_new_sim_sales[ $location ] = $all_new_sim;
            $daily_data_value_sales[ $location ] = $all_new_data;
            $daily_upgrade_handset_sales[ $location ] = $all_upgrade_handset;
            $daily_upgrade_sim_sales[ $location ] = $all_upgrade_sim;
            $daily_new_hbb_sales[ $location ] = $all_new_bt;
            $daily_regrade_sales[ $location ] = $all_regrade;
            $daily_insurance_sales[ $location ] = $all_insurance;
            $profit_daily[ $location ] = $all_profit;
        }
    }
    
    $employee_location = get_user_meta( $user->ID, 'store_location' , true );
    
    ob_start();
    ?>
    
    <table class="table">
        <thead>
            <tr>
                <th class="col-md-1">Store</th>
                <th class="col-md-1">New Handset</th>
                <th class="col-md-1">New Sim</th>
                <th class="col-md-1">Data Value</th>
                <th class="col-md-1">Upgrade Handset</th>
                <th class="col-md-1">Upgrade Sim / Other</th>
                <th class="col-md-1">New HBB</th>
                <th class="col-md-1">Regrades</th>
                <th class="col-md-1">Insurance</th>
                <th class="col-md-1">Total Profit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $employee_location; ?></td>
                <td><?php echo $daily_new_handset_sales[ $employee_location ]; ?></td>
                <td><?php echo $daily_new_sim_sales[ $employee_location ]; ?></td>
                <td><?php echo '£' . $daily_data_value_sales[ $employee_location ]; ?></td>
                <td><?php echo $daily_upgrade_handset_sales[ $employee_location ]; ?></td>
                <td><?php echo $daily_upgrade_sim_sales[ $employee_location ]; ?></td>
                <td><?php echo $daily_new_hbb_sales[ $employee_location ]; ?></td>
                <td><?php echo $daily_regrade_sales[ $employee_location ]; ?></td>
                <td><?php echo $daily_insurance_sales[ $employee_location ]; ?></td>
    
                <?php
                if( $profit_daily[ $employee_location ] == '' )
                {
                    echo '<td>0</td>';
                }
                else
                {
                    echo '<td>£' . $profit_daily[ $employee_location ] . '</td>';
                }
                ?>

            </tr>
        </tbody>
    </table>

    <?php 
    echo ob_get_clean();
    wp_die();
}

function get_employee_daily_sales()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    
    $user = wp_get_current_user();

    //get our advisor first name and last name
    $id = $user->ID;
    $user_info = get_userdata( $id );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    
    //make our fullname
    $fullname = $first_name . ' ' . $last_name;
    
    //get our sales info
    
    $employee_sales = array();
            
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = '$date' " ) );
    
    foreach ( $results as $result )
    {
        if( $result->advisor == $fullname )
        {
            $employee_sales[] = $result;
        }
    }
    
    if ( ! empty( $employee_sales ) )
    {
        $i = 1;
        foreach($employee_sales as $sale)
        {
            ?>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:15px;">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#sale<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                
                                <?php 
                                if( $sale->product_type == 'homebroadband' )
                                {
                                    ?>
                                    <i class="fas fa-wifi sale-icon"></i> Home Broadband - <?php echo $sale->tariff;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'simonly' )
                                {
                                    ?>
                                    <i class="fas fa-sim-card sale-icon"></i> Sim Only - <?php echo $sale->tariff;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'handset' )
                                {
                                    ?>
                                    <i class="fas fa-mobile sale-icon"></i> Handset - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'tablet' )
                                {
                                    ?>
                                    <i class="fas fa-tablet-alt sale-icon"></i> Tablet - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'connected' )
                                {
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-watch sale-icon" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4 14.333v-1.86A5.985 5.985 0 0 1 2 8c0-1.777.772-3.374 2-4.472V1.667C4 .747 4.746 0 5.667 0h4.666C11.253 0 12 .746 12 1.667v1.86A5.985 5.985 0 0 1 14 8a5.985 5.985 0 0 1-2 4.472v1.861c0 .92-.746 1.667-1.667 1.667H5.667C4.747 16 4 15.254 4 14.333zM13 8A5 5 0 1 0 3 8a5 5 0 0 0 10 0z"/>
                                        <path d="M13.918 8.993A.502.502 0 0 0 14.5 8.5v-1a.5.5 0 0 0-.582-.493 6.044 6.044 0 0 1 0 1.986z"/>
                                        <path fill-rule="evenodd" d="M8 4.5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5H6a.5.5 0 0 1 0-1h1.5V5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    Connected - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'accessory' )
                                {
                                    ?>
                                    <i class="fas fa-headphones-alt sale-icon"></i> Accessory - <?php echo $sale->accessory;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'insurance' )
                                {
                                    ?>
                                   <i class="fas fa-file-alt sale-icon"></i> Insurance - <?php echo $sale->insurance_choice;
                                }
                                ?>
                            </a>
                        </h4>
                    </div>
                    <div id="sale<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                        <div class="panel-body">
                            <?php if( $sale->approve_sale == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-12 spacer">
                                        <p><strong class="color:red;">This sale has been approved</strong></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Sale ID</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo $sale->id; ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Store</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->store); ?></p>
                                </div>
                            </div>
                              
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Sale Type</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->type); ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Product Sold</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->product_type); ?></p>
                                </div>
                            </div>
                            
                            <?php if( $sale->device !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Device</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->device); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Device Discount Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->device_discount_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'rm' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Regional Manager Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'franchise' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Franchise Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'both' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Regional Manager Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Franchise Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount_2; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->broadband_tv !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Broadband TV</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->broadband_tv); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_discount_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Discount Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff_discount_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_discount !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->tariff_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->accessory_needed !== 'no' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->accessory); ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory Cost</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->accessory_cost; ?></p>
                                    </div>
                                </div>
                                <?php
                                
                                if( $sale->accessory_discount !== 'no' )
                                {
                                    ?>
                                    <div class="row sale-row">
                                        <div class="col-xs-6">
                                            <p><strong>Accessory Discount</strong></p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p><?php echo '£' . $sale->accessory_discount_value; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            
                            <?php if( $sale->insurance !== 'no' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->insurance_type); ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->insurance_choice); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->hrc == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>HRC Sale</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->hrc); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->pobo == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>POBO Sale</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->pobo); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->profit_loss !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Profit / Loss</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'. $sale->profit_loss; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->total_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Total Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£' . $sale->total_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->accessory_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£' . $sale->accessory_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->insurance_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo $sale->insurance_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
    }
    else
    {
        ?>
        <p>No sales for this date, this could be for the following reasons:</p><br/>
        <p>1. You were not working on this day</p>
        <p>2. There has been an error while uploading your sales</p>
        <p>3. You have not uploaded your sales</p><br/>
        <p>If point 2 or 3 is the issue then contact your manager who will be able to upload your sales.</p>
        <?php
    }
    
    wp_die();
}

function get_monthly_chart()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	
	$split = explode(" ", $date );
	
	$day = date("d");
	
	//we need our month and year
	$month = $split[0];
                
    $year = $split[1];
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

    foreach ( $results as $result )
    {
        $locations[] = $result->location;
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE month='" . $month . "'" . "AND year='" . $year . "'" ) );

    foreach ( $locations as $location )
    {
        $store_month_profit = 0;
        $store_month_accessory_profit = 0;
        
        foreach ( $results as $result )
        {
            if( $result->store == $location )
            {
                //get our profits
                $store_month_profit = floatval( $store_month_profit ) + floatval( $result->total_profit );
                $store_month_accessory_profit = floatval( $store_month_accessory_profit ) + floatval( $result->accessory_profit );
                
                //now create our variables
                $profit_month[ $location ] = $store_month_profit;
                $accessory_profit_month[ $location ] = $store_month_accessory_profit;
            }
        }
    }
    
    if(strtotime("1 " . $date ) < strtotime("1 May 2021")) 
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_profit_targets" ) );
    
        foreach ( $results as $result )
        {
            foreach ( $locations as $location )
            {
                if( $result->store == $location && $result->month == $month && $result->year == $year )
                {
                    $profit_target = $result->target;
        
                    $store_profit_target[ $location ] = $profit_target;
                }
            }
        }
    }
    else 
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_targets" ) );
        
        foreach ( $results as $result )
        {
            foreach ( $locations as $location )
            {
                if( $result->store == $location && $result->month == $month && $result->year == $year )
                {
                    $profit_target = $result->profit_target;
                    
                    $store_profit_target[ $location ] = $profit_target;
                }
            }
        }
    }
    
    $month_profit_total = 0;
    $month_accessory_total = 0;
    
    $total_profit_target = 0;
    
    foreach ( $locations as $location )
    {
        //now monthly     
        $month_profit_total = floatval( $month_profit_total ) + floatval( $profit_month[ $location ] );
        $month_accessory_total = floatval( $month_accessory_total ) + floatval( $accessory_profit_month[ $location ] );
        
        //get our total profit target
        $total_profit_target = floatval( $total_profit_target ) + $store_profit_target[ $location ];
    }
    
    $all_new_total = 0;
    $all_upgrade_total = 0;
    $new_handsets_total = 0;
    $new_broadband_total = 0;
    $upgrade_broadband_total = 0;
    $insurance_total = 0;
    $new_simo_total = 0;
    $hrc_total = 0;
    
    foreach( $locations as $location )
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store='" . $location . "'" . "AND month='" . $month . "'" . " AND year='" . $year . "'" ) );
        
        $all_new = 0;
        $all_upgrade = 0;
        $new_handsets = 0;
        $new_broadband = 0;
        $upgrade_broadband = 0;
        $insurance_sales = 0;
        $new_simo = 0;
        $hrc = 0;
    
        foreach( $results as $result )
        {
            if( $result->type == 'new' && $result->product_type !== 'homebroadband' && $result->type == 'new' && $result->product_type !== 'insurance' && $result->type == 'new' && $result->product_type !== 'accessory' )
            {
                //this is all our new connections
                $all_new++;
                $all_new_total++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type !== 'homebroadband' && $result->type == 'upgrade' && $result->product_type !== 'insurance' && $result->type == 'upgrade' && $result->product_type !== 'accessory' )
            {
                //this is all our upgrade connections
                $all_upgrade++;
                $all_upgrade_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'handset' )
            {
                //this is all our new handset connections
                $new_handsets++;
                $new_handsets_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'homebroadband' )
            {
                ///this is all our new home broadband connections
                $new_broadband++;
                $new_broadband_total++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
            {
                //this is all our home broadband upgrades
                $upgrade_broadband++;
                $upgrade_broadband_total++;
            }
            
            if( $result->insurance == 'yes' )
            {
                //this is all our new handset connections
                $insurance_sales++;
                $insurance_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'simonly' )
            {
                //this is all our new handset connections
                $new_simo++;
                $new_simo_total++;
            }
            
            if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                if(strtotime($date) < strtotime("1 March 2022"))
                {
                    $hrc++;
                    $hrc_total++;
                } else {
                    if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                        $hrc += floatval(fc_get_data_tariff_mrc($result->tariff));
                        $hrc_total += floatval(fc_get_data_tariff_mrc($result->tariff));
                    } else {
                        $hrc += floatval(fc_get_tariff_mrc($result->tariff));
                        $hrc_total += floatval(fc_get_tariff_mrc($result->tariff));
                    }
                }
            }
                
            //lets add all our sales info
            $monthly_all_new_sales[ $location ] = $all_new;    
            $monthly_all_upgrade_sales[ $location ] = $all_upgrade;
            $monthly_new_handset_sales[ $location ] = $new_handsets;
            $monthly_new_broadband_sales[ $location ] =$new_broadband;
            $monthly_upgrade_broadband_sales[ $location ] = $upgrade_broadband;
            $monthly_insurance_sales[ $location ] = $insurance_sales;
            $monthly_new_simo_sales[ $location ] = $new_simo;
            $monthly_hrc_sales[ $location ] = $hrc;
        }
    }
    
    $total_monthly_all_new_sales = $all_new_total;    
    $total_monthly_all_upgrade_sales = $all_upgrade_total;
    $total_monthly_new_handset_sales = $new_handsets_total;
    $total_monthly_new_broadband_sales = $new_broadband_total;
    $total_monthly_upgrade_broadband_sales = $upgrade_broadband_total;
    $total_monthly_insurance_sales = $insurance_total;
    $total_monthly_new_simo_sales = $new_simo_total;
    $total_monthly_hrc_sales = $hrc_total;
    
    echo '<table class="table">';
    echo '   <thead>';
    echo '        <tr>';
    echo '           <th class="col-md-1">Store</th>';
    echo '            <th class="col-md-1">Total New</th>';
    echo '            <th class="col-md-1">New H/S</th>';
    echo '            <th class="col-md-1">Upgrades</th>';
    echo '            <th class="col-md-1">New HBB</th>';
    echo '            <th class="col-md-1">Regrade HBB</th>';
    echo '            <th class="col-md-1">SIMO New</th>';
    echo '            <th class="col-md-1">Insurance</th>';
    echo '            <th class="col-md-1">Data Value</th>';
    echo '            <th class="col-md-1">ACC Profit</th>';
    echo '            <th class="col-md-1">Total Profit</th>';
    
    //is it current month, if so add the projected monthly profit
    if( $month == date('F') && $year == date("Y") )
    {
        echo '            <th class="col-md-1">Projected Monthly Profit</th>';
    }
    
    echo '            <th class="col-md-1">Profit Target</th>';
    echo '            <th class="col-md-1">Variation</th>';
    echo '        </tr>';
    echo '    </thead>';
    echo '    <tbody>';
            
    foreach ( $locations as $location )
    {
        echo '   <tr>';
        echo '        <td>' . $location . '</td>';
        echo '        <td>' . $monthly_all_new_sales[ $location ] . '</td>';
        echo '        <td>' . $monthly_new_handset_sales[ $location ] . '</td>';
        echo '        <td>' . $monthly_all_upgrade_sales[ $location ] . '</td>';
        echo '        <td>' . $monthly_new_broadband_sales[ $location ] . '</td>';
        echo '        <td>' . $monthly_upgrade_broadband_sales[ $location ] . '</td>';
        echo '        <td>' . $monthly_new_simo_sales[ $location ] . '</td>';
        echo '        <td>' . $monthly_insurance_sales[ $location ] . '</td>';
        echo '        <td>' . '£' . $monthly_hrc_sales[ $location ] . '</td>';

        
        if( $accessory_profit_month[ $location ] == '' )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $accessory_profit_month[ $location ] , 2, '.', ',') . '</td>';
        }
        
        if( $profit_month[ $location ] == '' )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $profit_month[ $location ] , 2, '.', ',') . '</td>';
        }
        
        //is it current month, if so add the projected monthly profit
        if( $month == date('F') && $year == date("Y") )
        {
            if( $profit_month[ $location ] == '' )
            {
                echo '<td></td>';
            }
            else
            {
                //get our projected profit
                //start with number of days in month
                $days = date('t');
                        
                $projected = $profit_month[ $location ] / $day;
                $projected = $projected * $days;
                
                //work out our month projected
                $month_projected_total = $month_projected_total + $projected;
                
                //format the projected
                $projected = number_format( $projected, 2, '.', ',' );

                echo '<td>£' . $projected  . '</td>';
            }
        }
           
        if( $store_profit_target[ $location ] == '' )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $store_profit_target[ $location ] , 2, '.', ',') . '</td>';
        }
            
        if ( $profit_month[ $location ] > $store_profit_target[ $location ] )
        {
            if( $store_profit_target[ $location ] == '' )
            {
                $variance = 0;
            }
            else
            {
                $variance = $profit_month[ $location ] - $store_profit_target[ $location ];
            }
        
            if( $variance == 0 )
            {
                echo '<td></td>';
            }
            else
            {
                echo '<td class="variance-plus">£' . number_format( $variance , 2, '.', ',') . '</td>';
            }
        }
        else
        {
            if( $store_profit_target[ $location ] == '' )
            {
                $variance = 0;
            }
            else
            {
                $variance = $store_profit_target[ $location ] - $profit_month[ $location ];
            }
        
            if( $variance == 0 )
            {
                echo '<td></td>';
            }
            else
            {
                echo '<td class="variance-minus">£' . number_format( $variance , 2, '.', ',') . '</td>';
            }
        }
        echo '</tr>';
    }

    echo '<tr>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        echo '<td class="blank-row"></td>';
        
        if( $month == date('F') && $year == date("Y") )
        {
            echo '<td class="blank-row"></td>';
        }

    echo '</tr>';

    echo '<tr>';
        echo '<th>Total</th>';
        echo '<td>' . $total_monthly_all_new_sales . '</td>';
        echo '<td>' . $total_monthly_new_handset_sales . '</td>';
        echo '<td>' . $total_monthly_all_upgrade_sales . '</td>';
        echo '<td>' . $total_monthly_new_broadband_sales . '</td>';
        echo '<td>' . $total_monthly_upgrade_broadband_sales . '</td>';
        echo '<td>' . $total_monthly_new_simo_sales . '</td>';
        echo '<td>' . $total_monthly_insurance_sales . '</td>';
        echo '<td>' . $total_monthly_hrc_sales . '</td>';
        
        if( $month_accessory_total == 0 )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $month_accessory_total , 2, '.', ',') . '</td>';
        }
        
        if( $month_profit_total == 0 )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $month_profit_total , 2, '.', ',') . '</td>';
        }
        
        //is it current month, if so add the projected monthly profit
        if( $month == date('F') && $year == date("Y") )
        {
            if( $month_projected_total == 0 )
            {
                echo '<td></td>';
            }
            else
            {
                echo '<td>£' . number_format( $month_projected_total , 2, '.', ',') . '</td>';
            }
        }
    
        if( $total_profit_target == 0 )
        {
            echo '<td></td>';
        }
        else
        {
            echo '<td>£' . number_format( $total_profit_target , 2, '.', ',') . '</td>';
        }
    
        if ( $month_profit_total > $total_profit_target )
        {
            if( $total_profit_target == '' )
            {
                $variance = 0;
            }
            else
            {
                $variance = $month_profit_total - $total_profit_target;
            }
    
            if( $variance == 0 )
            {
                echo '<td></td>';
            }
            else
            {
                echo '<td class="variance-plus">£' . number_format( $variance , 2, '.', ',') . '</td>';
            }
        }
        else
        {
            if( $total_profit_target == '' )
            {
                $variance = 0;
            }
            else
            {
                $variance = $total_profit_target - $month_profit_total;
            }
    
            if( $variance == 0 )
            {
                echo '<td></td>';
            }
            else
            {
                echo '<td class="variance-minus">£' . number_format( $variance , 2, '.', ',') . '</td>';
            }
        }
    echo '</tr>';
    
    echo '</tbody>';
    echo '</table>';
    
    wp_die();
}

function get_average_profits()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	$type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
	$split = explode(" ", $date );
	
	$day = date("d");
	
	//we need our month and year
	$month = $split[0];
                
    $year = $split[1];
    
    //get our current user
    $user = wp_get_current_user();
    
    //get all our store locations first
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

    foreach ( $results as $result )
    {
        $locations[] = $result->location;
    }
    
    //if we have a multi manager get our store info
    if( $type == 'multi' )
    {
        $location1 = get_user_meta( $user->ID, 'store_managed_1', true);
        $location2 = get_user_meta( $user->ID, 'store_managed_2', true);
        $location3 = get_user_meta( $user->ID, 'store_managed_3', true);
        $location4 = get_user_meta( $user->ID, 'store_managed_4', true);
        $location5 = get_user_meta( $user->ID, 'store_managed_5', true);
                    
        if( $location1 !== '' )
        {
            $multi_locations[] = $location1;
        }
                    
        if( $location2 !== '' )
        {
            $multi_locations[] = $location2;
        }
        
        if( $location3 !== '' )
        {
            $multi_locations[] = $location3;
        }
                    
        if( $location4 !== '' )
        {
            $multi_locations[] = $location4;
        }
        
        if( $location5 !== '' )
        {
            $multi_locations[] = $location5;
        }
    }
    elseif( $type == 'store' )
    {
        $store_location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
    }

    foreach( $locations as $location )
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store='" . $location . "'" . "AND month='" . $month . "'" . " AND year='" . $year . "'" ) );
        
        $all_new = 0;
        $all_upgrade = 0;
        $new_handsets = 0;
        $new_broadband = 0;
        $upgrade_broadband = 0;
        $insurance_sales = 0;
        $new_simo = 0;
        
        //for our averages
        $upgrade_handsets = 0;
        $upgrade_simo = 0;
        $new_bt = 0;
        $new_connected = 0;
        
        //our profits for average report
        $new_handset_profit_store = 0;
        $new_simo_profit_store = 0;
        $new_data_profit_store = 0;
        $upgrade_handset_profit_store = 0;
        $upgrade_simo_profit_store = 0;
        $new_bt_profit_store = 0;
    
        foreach( $results as $result )
        {
            if( $result->type == 'new' && $result->product_type !== 'homebroadband' && $result->type == 'new' && $result->product_type !== 'insurance' && $result->type == 'new' && $result->product_type !== 'accessory' )
            {
                //this is all our new connections
                $all_new++;
                $all_new_total++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type !== 'homebroadband' && $result->type == 'upgrade' && $result->product_type !== 'insurance' && $result->type == 'upgrade' && $result->product_type !== 'accessory' )
            {
                //this is all our upgrade connections
                $all_upgrade++;
                $all_upgrade_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'handset' )
            {
                //this is all our new handset connections
                $new_handsets++;
                $new_handsets_total++;
                
                //our profit
                $new_handset_profit_store += $result->total_profit;
            }
            
            if( $result->type == 'new' && $result->product_type == 'homebroadband' )
            {
                ///this is all our new home broadband connections
                $new_broadband++;
                $new_broadband_total++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
            {
                //this is all our home broadband upgrades
                $upgrade_broadband++;
                $upgrade_broadband_total++;
            }
            
            if( $result->insurance == 'yes' )
            {
                //this is all our new handset connections
                $insurance_sales++;
                $insurance_total++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'simonly' )
            {
                //this is all our new simonly connections
                $new_simo++;
                $new_simo_total++;
                
                //our profit
                $new_simo_profit_store += $result->total_profit;
            }
            
            //these are for our average profit
            if( $result->type == 'upgrade' && $result->product_type == 'simonly' )
            {
                //this is all our new simonly connections
                $upgrade_simo++;
                
                 //our profit
                $upgrade_simo_profit_store += $result->total_profit;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'handset' )
            {
                //this is all our new handset connections
                $upgrade_handsets++;
                
                //our profit
                $upgrade_handset_profit_store += $result->total_profit;
            }
            
            if(strtotime($date) < strtotime("1 February 2022"))
            {
                if( $result->type == 'new' && $result->product_type == 'homebroadband' && strpos( $result->tariff , 'BT' ) !== false )
                {
                    //this is all our home broadband upgrades
                    $new_bt++;
                    
                    //our profits
                    $new_bt_profit_store += $result->total_profit;
                }
            } else {
                if( $result->type == 'new' && $result->product_type == 'homebroadband')
                {
                    //this is all our home broadband upgrades
                    $new_bt++;
                    
                    //our profits
                    $new_bt_profit_store += $result->total_profit;
                }
            }
            
            if( $result->type == 'new' && $result->product_type == 'connected' )
            {
                //this is all our new simonly connections
                $new_connected++;
                
                //our profits
                $new_data_profit_store += $result->total_profit;
            }
                
            //lets add all our sales info
            $monthly_all_new_sales[ $location ] = $all_new;    
            $monthly_all_upgrade_sales[ $location ] = $all_upgrade;
            $monthly_new_handset_sales[ $location ] = $new_handsets;
            $monthly_new_broadband_sales[ $location ] =$new_broadband;
            $monthly_upgrade_broadband_sales[ $location ] = $upgrade_broadband;
            $monthly_insurance_sales[ $location ] = $insurance_sales;
            $monthly_new_simo_sales[ $location ] = $new_simo;
            
            //for our average profit
            $monthly_upgrade_simo_sales[ $location ] = $upgrade_simo;
            $monthly_upgrade_handset_sales[ $location ] = $upgrade_handsets;
            $monthly_new_bt_sales[ $location ] = $new_bt;
            $monthly_new_connected_sales[ $location ] = $new_connected;
            
            //add all our profits to array
            $new_data_profit[ $location ] = $new_data_profit_store;
            $new_bt_profit[ $location ] = $new_bt_profit_store;
            $upgrade_handset_profit[ $location ] = $upgrade_handset_profit_store;
            $upgrade_simo_profit[ $location ] = $upgrade_simo_profit_store;
            $new_simo_profit[ $location ] = $new_simo_profit_store;
            $new_handset_profit[ $location ] = $new_handset_profit_store;
        }

        //now work out our averages
        if( $new_handset_profit[ $location ] !== 0 && $monthly_new_handset_sales[ $location ] !== 0 )
        {
            $new_handset_average[ $location ] = round( $new_handset_profit[ $location ] / $monthly_new_handset_sales[ $location ] , 2);
            
            if( is_nan( $new_handset_average[ $location ] ) )
            {
                $new_handset_average[ $location ] = 0;
            }
        }
        else
        {
            $new_handset_average[ $location ] = 0;
        }
        
        if( $new_simo_profit[ $location ] !== 0 && $monthly_new_simo_sales[ $location ] !== 0 )
        {
            $new_simo_average[ $location ] = round( $new_simo_profit[ $location ] / $monthly_new_simo_sales[ $location ] , 2);
            
            if( is_nan( $new_simo_average[ $location ] ) )
            {
                $new_simo_average[ $location ] = 0;
            }
        }
        else
        {
            $new_simo_average[ $location ] = 0;
        }
        
        if( $upgrade_handset_profit[ $location ] !== 0 && $monthly_upgrade_handset_sales[ $location ] !== 0 )
        {
            $upgrade_handset_average[ $location ] = round( $upgrade_handset_profit[ $location ] / $monthly_upgrade_handset_sales[ $location ] , 2);
            
            if( is_nan( $upgrade_handset_average[ $location ] ) )
            {
                $upgrade_handset_average[ $location ] = 0;
            }
        }
        else
        {
            $upgrade_handset_average[ $location ] = 0;
        }
        
        if( $upgrade_simo_profit[ $location ] !== 0 && $monthly_upgrade_simo_sales[ $location ] !== 0 )
        {
            $upgrade_simo_average[ $location ] = round( $upgrade_simo_profit[ $location ] / $monthly_upgrade_simo_sales[ $location ] , 2);
            
            if( is_nan( $upgrade_simo_average[ $location ] ) )
            {
                $upgrade_simo_average[ $location ] = 0;
            }
        }
        else
        {
            $upgrade_simo_average[ $location ] = 0;
        }
        
        if( $new_bt_profit[ $location ] !== 0 && $monthly_new_bt_sales[ $location ] !== 0 )
        {
            $new_bt_average[ $location ] = round( $new_bt_profit[ $location ] / $monthly_new_bt_sales[ $location ] , 2);
            
            if( is_nan( $new_bt_average[ $location ] ) )
            {
                $new_bt_average[ $location ] = 0;
            }
        }
        else
        {
            $new_bt_average[ $location ] = 0;
        }
        
        if( $new_data_profit[ $location ] !== 0 && $monthly_new_connected_sales[ $location ] !== 0 )
        {
            $new_data_average[ $location ] = round( $new_data_profit[ $location ] / $monthly_new_connected_sales[ $location ] , 2);
            
            if( is_nan( $new_data_average[ $location ] ) )
            {
                $new_data_average[ $location ] = 0;
            }
        }
        else
        {
            $new_data_average[ $location ] = 0;
        }
    }
    
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Store</th>
                    <th>New Handset</th>
                    <th>New Sim-Only</th>
                    <th>New Data</th>
                    <th>Upgrade Handsets</th>
                    <th>Upgrade Sim-Only</th>
                    <th>New BT Broadband</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if( $type == 'senior' )
                {
                    foreach ( $locations as $location )
                    {
                        ?>
                        <tr>
                            <td><?php echo $location; ?></td>
                            <td><?php echo '£' . $new_handset_average[ $location ]; ?></td>
                            <td><?php echo '£' . $new_simo_average[ $location ]; ?></td>
                            <td><?php echo '£' . $new_data_average[ $location ]; ?></td>
                            <td><?php echo '£' . $upgrade_handset_average[ $location ]; ?></td>
                            <td><?php echo '£' . $upgrade_simo_average[ $location ]; ?></td>
                            <td><?php echo '£' . $new_bt_average[ $location ]; ?></td>
                        </tr>
                        <?php
                    }
                }
                elseif( $type == 'multi' )
                {
                    foreach ( $multi_locations as $location )
                    {
                        ?>    
                        <tr>
                            <td><?php echo $location; ?></td>
                            <td><?php echo '£' . $new_handset_average[ $location ]; ?></td>
                            <td><?php echo '£' . $new_simo_average[ $location ]; ?></td>
                            <td><?php echo '£' . $new_data_average[ $location ]; ?></td>
                            <td><?php echo '£' . $upgrade_handset_average[ $location ]; ?></td>
                            <td><?php echo '£' . $upgrade_simo_average[ $location ]; ?></td>
                            <td><?php echo '£' . $new_bt_average[ $location ]; ?></td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $store_location; ?></td>
                        <td><?php echo '£' . $new_handset_average[ $store_location ]; ?></td>
                        <td><?php echo '£' . $new_simo_average[ $store_location ]; ?></td>
                        <td><?php echo '£' . $new_data_average[ $store_location ]; ?></td>
                        <td><?php echo '£' . $upgrade_handset_average[ $store_location ]; ?></td>
                        <td><?php echo '£' . $upgrade_simo_average[ $store_location ]; ?></td>
                        <td><?php echo '£' . $new_bt_average[ $store_location ]; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    wp_die();
}

function get_staff_average_profits()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
	$type = ! empty( $data[ 'type' ] ) ? $data[ 'type' ] : '';
	
	$split = explode(" ", $date );
	
	$day = date("d");
	
	//we need our month and year
	$month = $split[0];
                
    $year = $split[1];
    
    //get our current user
    $user = wp_get_current_user();
    
    //get all our store locations first
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

    foreach ( $results as $result )
    {
        $locations[] = $result->location;
    }
    
    //if we have a multi manager get our store info
    if( $type == 'multi' )
    {
        $location1 = get_user_meta( $user->ID, 'store_managed_1', true);
        $location2 = get_user_meta( $user->ID, 'store_managed_2', true);
        $location3 = get_user_meta( $user->ID, 'store_managed_3', true);
        $location4 = get_user_meta( $user->ID, 'store_managed_4', true);
        $location5 = get_user_meta( $user->ID, 'store_managed_5', true);
                    
        if( $location1 !== '' )
        {
            $multi_locations[] = $location1;
        }
                    
        if( $location2 !== '' )
        {
            $multi_locations[] = $location2;
        }
        
        if( $location3 !== '' )
        {
            $multi_locations[] = $location3;
        }
                    
        if( $location4 !== '' )
        {
            $multi_locations[] = $location4;
        }
        
        if( $location5 !== '' )
        {
            $multi_locations[] = $location5;
        }
    }
    elseif( $type == 'store' )
    {
        $store_location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
    }

    foreach( $locations as $location )
    {
        $employees = array();
        
        $employees = fc_get_average_users( $location );
        
        foreach( $employees as $employee )
        {
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor='" . $employee . "'" . "AND month='" . $month . "'" . " AND year='" . $year . "'" ) );
            
            $new_handsets = 0;
            $new_simo = 0;
            $upgrade_handsets = 0;
            $upgrade_simo = 0;
            $new_bt = 0;
            $new_connected = 0;
            
            //our profits for average report
            $new_handset_profit_employee = 0;
            $new_simo_profit_employee = 0;
            $new_data_profit_employee = 0;
            $upgrade_handset_profit_employee = 0;
            $upgrade_simo_profit_employee = 0;
            $new_bt_profit_employee = 0;
        
            foreach( $results as $result )
            {
                if( $result->type == 'new' && $result->product_type == 'handset' )
                {
                    //this is all our new handset connections
                    $new_handsets++;
                    $new_handsets_total++;
                    
                    //our profit
                    $new_handset_profit_employee += $result->total_profit;
                }
                
                if( $result->type == 'new' && $result->product_type == 'simonly' )
                {
                    //this is all our new simonly connections
                    $new_simo++;
                    $new_simo_total++;
                    
                    //our profit
                    $new_simo_profit_employee += $result->total_profit;
                }
                
                if( $result->type == 'upgrade' && $result->product_type == 'simonly' )
                {
                    //this is all our upgrade simonly connections
                    $upgrade_simo++;
                    
                     //our profit
                    $upgrade_simo_profit_employee += $result->total_profit;
                }
                
                if( $result->type == 'upgrade' && $result->product_type == 'handset' )
                {
                    //this is all our upgrade handset connections
                    $upgrade_handsets++;
                    
                    //our profit
                    $upgrade_handset_profit_employee += $result->total_profit;
                }
                
                if(strtotime($date) < strtotime("1 February 2022"))
                {
                    if( $result->type == 'new' && $result->product_type == 'homebroadband' && strpos( $result->tariff , 'BT' ) !== false )
                    {
                        //this is all our home broadband upgrades
                        $new_bt++;
                        
                        //our profits
                        $new_bt_profit_store += $result->total_profit;
                    }
                } else {
                    if( $result->type == 'new' && $result->product_type == 'homebroadband')
                    {
                        //this is all our home broadband upgrades
                        $new_bt++;
                        
                        //our profits
                        $new_bt_profit_store += $result->total_profit;
                    }
                }
                
                if( $result->type == 'new' && $result->product_type == 'connected' )
                {
                    //this is all our new connected
                    $new_connected++;
                    
                    //our profits
                    $new_data_profit_employee += $result->total_profit;
                }
                
                //lets add all our sales info
                $employee_monthly_new_handset_sales[ $employee ] = $new_handsets;
                $employee_monthly_new_simo_sales[ $employee ] = $new_simo;
                $employee_monthly_upgrade_simo_sales[ $employee ] = $upgrade_simo;
                $employee_monthly_upgrade_handset_sales[ $employee ] = $upgrade_handsets;
                $employee_monthly_new_bt_sales[ $employee ] = $new_bt;
                $employee_monthly_new_connected_sales[ $employee ] = $new_connected;
                
                //add all our profits to array
                $employee_new_data_profit[ $employee ] = $new_data_profit_employee;
                $employee_new_bt_profit[ $employee ] = $new_bt_profit_employee;
                $employee_upgrade_handset_profit[ $employee ] = $upgrade_handset_profit_employee;
                $employee_upgrade_simo_profit[ $employee ] = $upgrade_simo_profit_employee;
                $employee_new_simo_profit[ $employee ] = $new_simo_profit_employee;
                $employee_new_handset_profit[ $employee ] = $new_handset_profit_employee;
            }
            
            //now work out our averages
            if( $employee_new_handset_profit[ $employee ] !== 0 && $employee_monthly_new_handset_sales[ $employee ] !== 0 )
            {
                $employee_new_handset_average[ $employee ] = round( $employee_new_handset_profit[ $employee ] / $employee_monthly_new_handset_sales[ $employee ] , 2);
                    
                if( is_nan( $employee_new_handset_average[ $employee ] ) )
                {
                    $employee_new_handset_average[ $employee ] = 0;
                }
            }
            else
            {
                $employee_new_handset_average[ $employee ] = 0;
            }
                
            if( $employee_new_simo_profit[ $employee ] !== 0 && $employee_monthly_new_simo_sales[ $employee ] !== 0 )
            {
                $employee_new_simo_average[ $employee ] = round( $employee_new_simo_profit[ $employee ] / $employee_monthly_new_simo_sales[ $employee ] , 2);
                    
                if( is_nan( $employee_new_simo_average[ $employee ] ) )
                {
                    $employee_new_simo_average[ $employee ] = 0;
                }
            }
            else
            {
                $employee_new_simo_average[ $employee ] = 0;
            }
                
            if( $employee_upgrade_handset_profit[ $employee ] !== 0 && $employee_monthly_upgrade_handset_sales[ $employee ] !== 0 )
            {
                $employee_upgrade_handset_average[ $employee ] = round( $employee_upgrade_handset_profit[ $employee ] / $employee_monthly_upgrade_handset_sales[ $employee ] , 2);
                    
                if( is_nan( $employee_upgrade_handset_average[ $employee ] ) )
                {
                    $employee_upgrade_handset_average[ $employee ] = 0;
                }
            }
            else
            {
                $employee_upgrade_handset_average[ $employee ] = 0;
            }
                
            if( $employee_upgrade_simo_profit[ $employee ] !== 0 && $employee_monthly_upgrade_simo_sales[ $employee ] !== 0 )
            {
                $employee_upgrade_simo_average[ $employee ] = round( $employee_upgrade_simo_profit[ $employee ] / $employee_monthly_upgrade_simo_sales[ $employee ] , 2);
                    
                if( is_nan( $employee_upgrade_simo_average[ $employee ] ) )
                {
                    $employee_upgrade_simo_average[ $employee ] = 0;
                }
            }
            else
            {
                $employee_upgrade_simo_average[ $employee ] = 0;
            }
                
            if( $employee_new_bt_profit[ $employee ] !== 0 && $employee_monthly_new_bt_sales[ $employee ] !== 0 )
            {
                $employee_new_bt_average[ $employee ] = round( $employee_new_bt_profit[ $employee ] / $employee_monthly_new_bt_sales[ $employee ] , 2);
                    
                if( is_nan( $employee_new_bt_average[ $employee ] ) )
                {
                    $employee_new_bt_average[ $employee ] = 0;
                }
            }
            else
            {
                $employee_new_bt_average[ $employee ] = 0;
            }
                
            if( $employee_new_data_profit[ $employee ] !== 0 && $employee_monthly_new_connected_sales[ $employee ] !== 0 )
            {
                $employee_new_data_average[ $employee ] = round( $employee_new_data_profit[ $employee ] / $employee_monthly_new_connected_sales[ $employee ] , 2);
                    
                if( is_nan( $employee_new_data_average[ $employee ] ) )
                {
                    $employee_new_data_average[ $employee ] = 0;
                }
            }
            else
            {
                $employee_new_data_average[ $employee ] = 0;
            }
        }
    }
    
    if( $type == 'multi' )
	{
		foreach ( $multi_locations as $location )
		{
			$employees = fc_get_average_users( $location );
			?>
				<h4 class="spacer-bottom text-center"><?php echo $location; ?></h4>
				
				<table class="table">
					<thead>
						<tr>
							<th class="col-md-2">Employee</th>
							<th class="col-md-2">New Handset</th>
							<th class="col-md-2">New Sim-Only</th>
							<th class="col-md-2">New Data</th>
							<th class="col-md-2">Upgrade Handsets</th>
							<th class="col-md-2">Upgrade Sim-Only</th>
							<th class="col-md-2">New BT Broadband</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach( $employees as $employee )
						{
							?>
							<tr>
								<td><?php echo $employee; ?></td>
								<td><?php echo '£' . number_format( (float)$employee_new_handset_average[ $employee ] , 2, '.', ''); ?></td>
								<td><?php echo '£' . number_format( (float)$employee_new_simo_average[ $employee ] , 2, '.', ''); ?></td>
								<td><?php echo '£' . number_format( (float)$employee_new_data_average[ $employee ] , 2, '.', ''); ?></td>
								<td><?php echo '£' . number_format( (float)$employee_upgrade_handset_average[ $employee ] , 2, '.', ''); ?></td>
								<td><?php echo '£' . number_format( (float)$employee_upgrade_simo_average[ $employee ] , 2, '.', ''); ?></td>
								<td><?php echo '£' . number_format( (float)$employee_new_bt_average[ $employee ] , 2, '.', ''); ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			<?php
		}
	}
	elseif( $type == 'store' )
	{
		$employees = fc_get_average_users( $store_location );
		?>
		<h4 class="spacer-bottom text-center"><?php echo $store_location; ?></h4>
		
		<table class="table">
			<thead>
				<tr>
					<th class="col-md-2">Employee</th>
					<th class="col-md-2">New Handset</th>
					<th class="col-md-2">New Sim-Only</th>
					<th class="col-md-2">New Data</th>
					<th class="col-md-2">Upgrade Handsets</th>
					<th class="col-md-2">Upgrade Sim-Only</th>
					<th class="col-md-2">New BT Broadband</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach( $employees as $employee )
				{
					?>
					<tr>
						<td><?php echo $employee; ?></td>
						<td><?php echo '£' . number_format( (float)$employee_new_handset_average[ $employee ] , 2, '.', ''); ?></td>
						<td><?php echo '£' . number_format( (float)$employee_new_simo_average[ $employee ] , 2, '.', ''); ?></td>
						<td><?php echo '£' . number_format( (float)$employee_new_data_average[ $employee ] , 2, '.', ''); ?></td>
						<td><?php echo '£' . number_format( (float)$employee_upgrade_handset_average[ $employee ] , 2, '.', ''); ?></td>
						<td><?php echo '£' . number_format( (float)$employee_upgrade_simo_average[ $employee ] , 2, '.', ''); ?></td>
						<td><?php echo '£' . number_format( (float)$employee_new_bt_average[ $employee ] , 2, '.', ''); ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	<?php
	}
    wp_die();
}

function get_discount_pot_table()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$date = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';

	$split = explode(" ", $date );
	
	$day = date("d");
	
	//we need our month and year
	$month = $split[0];
                
    $year = $split[1];
    
    //get our locations
    $locations = array();
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

    foreach ( $results as $result )
    {
        $locations[] = $result->location;
    }
    
    //get our discount pot info
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_pots" ) );
    
    foreach ( $results as $result )
    {
        foreach ( $locations as $location )
        {
            if( $result->store == $location && $result->month == $month && $result->year == $year )
            {
                $rm_discount_value = $result->regionalManager;
                $fran_discount_value = $result->franchise;
                    
                $franchise_pot[ $location ] = $fran_discount_value;
                $rm_pot[ $location ] = $rm_discount_value;
            }
        }
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE device_discount_type = 'franchise' OR device_discount_type = 'both'" ) );
    
    //work out how much RM has been used
    foreach ( $locations as $location )
    {
        $all_fran = 0;
        
        foreach ( $results as $result )
        {
            if( $result->store == $location and $result->month == $month and $result->year == $year )
            {
                if( $result->device_discount_type == 'franchise' )
                {
                    $all_fran = floatval( $all_fran ) + floatval( $result->device_discount );
                }
                elseif( $result->device_discount_type == 'both' )
                {
                    $all_fran = floatval( $all_fran ) + floatval( $result->device_discount_2 );
                }
                
                $franchise_used[ $location ] = $all_fran;
            }
        }   
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE device_discount_type = 'rm' OR device_discount_type = 'both'" ) );
    
    $all_rm = 0;
    $new_rm = 0;
    $upgrade_rm = 0;
    
    //work out how much RM has been used
    foreach ( $locations as $location )
    {
        $all_rm = 0;
        $new_rm = 0;
        $upgrade_rm = 0;
        
        foreach ( $results as $result )
        {
            if( $result->store == $location and $result->month == $month and $result->year == $year )
            {
                $all_rm = floatval( $all_rm ) + floatval( $result->device_discount );
                
                $rm_used[ $location ] = $all_rm;
                
                if( $result->type == 'new' )
                {
                    $new_rm = floatval( $new_rm ) + floatval( $result->device_discount );
                    
                    $rm_new[ $location ] = $new_rm;
                }
                elseif( $result->type == 'upgrade' )
                {
                    $upgrade_rm = floatval( $upgrade_rm ) + floatval( $result->device_discount );
                    
                    $rm_upgrade[ $location ] = $upgrade_rm;
                }
            }
        }   
    }
    
    //work out how much franchise and RM has been used
    foreach ( $locations as $location )
    {
        $franchise_remaining[ $location ] = floatval( $franchise_pot[ $location ] ) - floatval( $franchise_used[ $location ] );
        $rm_remaining[ $location ] = floatval( $rm_pot[ $location ] ) - floatval( $rm_used[ $location ] );
    }
    
    ?>
    
    <table class="table">
        <thead>
            <tr>
                <th class="col-md-2">Store</th>
                <th class="col-md-2">Franchise Used</th>
                <th class="col-md-2">RM Allocated</th>
                <th class="col-md-2">RM New</th>
                <th class="col-md-2">RM Upgrade</th>
                <th class="col-md-2">RM Remaining</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $franchiseTotal = 0;
            $rmTotal = 0;
            $rmNewTotal = 0;
            $rmUpgradeTotal = 0;
            $rmRemainingTotal = 0;
            
            foreach( $locations as $location )
            {
            ?>
                <tr>
                    <td><?php echo $location; ?></td>
                    
                    <?php
                    if( $franchise_used[ $location ] == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $franchise_used[ $location ] , 2, '.', ',') . '</td>';
                        $franchiseTotal += $franchise_used[ $location ];
                    }
                    ?>
                    
                    <td>
                        <?php 
                        echo '£ ' . number_format( $rm_pot[ $location ] , 2, '.', ',');
                        if($rm_pot[ $location ] !== '' || $rm_pot[ $location ] > 0) {
                            $rmTotal += $rm_pot[ $location ];
                        }
                        ?>
                    </td>
                    
                    <?php
                    if( $rm_new[ $location ] == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $rm_new[ $location ] , 2, '.', ',') . '</td>';
                        $rmNewTotal += $rm_new[ $location ];
                    }
                    
                    if( $rm_upgrade[ $location ] == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $rm_upgrade[ $location ] , 2, '.', ',') . '</td>';
                        $rmUpgradeTotal += $rm_upgrade[ $location ];
                    }
                    
                    if( $rm_remaining[ $location ] == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $rm_remaining[ $location ] , 2, '.', ',') . '</td>';
                        $rmRemainingTotal += $rm_remaining[ $location ];
                    }
                    ?>
                </tr>
            <?php
            }
            ?>
            
            <tr>
                <td class="blank-row"></td>
                <td class="blank-row"></td>
                <td class="blank-row"></td>
                <td class="blank-row"></td>
                <td class="blank-row"></td>
                <td class="blank-row"></td>
            </tr>
            
            <tr>
                <td style="font-weight:bold;">Total</td>
                <td>
                    <?php if( $franchiseTotal > 0 )
                    {
                        echo '£' . number_format( $franchiseTotal , 2, '.', ',');
                    } ?>
                </td>
                    
                <td>
                    <?php if( $rmTotal > 0 )
                    {
                        echo '£' . number_format( $rmTotal , 2, '.', ',');
                    } ?>
                </td>
                
                <td>
                    <?php if( $rmNewTotal > 0 )
                    {
                        echo '£' . number_format( $rmNewTotal , 2, '.', ',');
                    } ?>
                </td>
                
                <td>
                    <?php if( $rmUpgradeTotal > 0 )
                    {
                        echo '£' . number_format( $rmUpgradeTotal , 2, '.', ',');
                    } ?>
                </td>
    
                <td>
                    <?php if( $rmRemainingTotal > 0 )
                    {
                        echo '£' . number_format( $rmRemainingTotal , 2, '.', ',');
                    } ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <?php
    wp_die();
}

function get_cover_staff()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$user = wp_get_current_user();
	
	$employees = array();
    
    echo '<select name="advisor[]" class="advisor" autocomplete="off">';
	
	$store = strtolower( $store );
    
    $users = get_users();

    $employees = array();
    
    foreach ( $users as $user ) 
    {
        $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
        $employee_store = strtolower( $employee_store );
            
        if( $employee_store === $store )
        {
            $id = $user->ID;
            $user_info = get_userdata( $id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
    
            $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        }
    }
    
    //now add our managers
    $user = wp_get_current_user();
    $id = $user->ID;
    $user_info = get_userdata( $id );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    
    $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
    
    echo '<option value="">Choose Advisor</option>';

    foreach( $employees as $id => $employee)
    {
        $cover_store = get_user_meta( $id , 'store_cover' , true );
        
        if( $cover_store == 'yes' )
        {
            echo '<option value="' . $id . '" disabled>' . $employee . '</option>';
        }
        else
        {
            echo '<option value="' . $id . '">' . $employee . '</option>';
        }
    }
    
    echo '</select>';
     
    wp_die();
}

function get_cover_info()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	
	$employees = array();
    
	$store = strtolower( $store );
    
    $users = get_users();
    
    foreach ( $users as $user ) 
    {
        $employee_store = get_user_meta( $user->ID, 'store_location' , true );
            
        $employee_store = strtolower( $employee_store );
            
        if( $employee_store === $store )
        {
            $id = $user->ID;
            $user_info = get_userdata( $id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
    
            $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        }
    }
    
    //add the manager as well
    $user = wp_get_current_user();
    $id = $user->ID;
    $user_info = get_userdata( $id );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    
    $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
    
    $cover = array();
    
    foreach( $employees as $id => $employee )
    {
        $cover_store = get_user_meta( $id , 'store_cover' , true);
        
        if( $cover_store == 'yes' )
        {
            $cover[ $id ] = esc_html( $employee );
        }
    }
    
    if( ! empty( $cover ) )
    {
        echo '<table class="table">';
        echo '   <thead>';
        echo '        <tr>';
        echo '            <th>Staff Member</th>';
        echo '            <th>Store Covering</th>';
        echo '            <th></th>';
        echo '        </tr>';
        echo '    </thead>';
        echo '    <tbody>';
            
            foreach( $cover as $id => $employee )
            {
                $store = get_user_meta( $id , 'cover_store' , true);
                
                echo '<tr>';
                echo '    <td>' . $employee . '</td>';
                echo '    <td>' . $store . '</td>';
                echo '    <td><button type="button" id="' . $id . '" class="woocommerce-Button button cancel-cover" advisor="' . $employee . '" name="cancel-cover" value="Remove Cover">Remove Cover</button></td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
        echo '</table>';
    }
    else
    {
        echo '<p>No Staff currently assigned for store cover</p>';
    }
    
    wp_die();
}

function save_staff_cover()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	$advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	
	update_user_meta( $advisor , 'store_cover', 'yes' );
	update_user_meta( $advisor , 'cover_store', $store );
	
	wp_send_json_success( 'added' );
}

function delete_staff_cover()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    $data     = array();
    $success = array();
	$error = array();
	
	$data = $_POST;
	
	$advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	
	delete_user_meta( $advisor , 'store_cover');
	delete_user_meta( $advisor , 'cover_store');

	wp_send_json_success( 'deleted' );
}

function get_staff_review()
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
	$error = array();

	$data = $_POST;
	
	$advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
	$store = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
	$start = ! empty( $data[ 'start' ] ) ? $data[ 'start' ] : '';
	$end = ! empty( $data[ 'end' ] ) ? $data[ 'end' ] : '';
	
	$start = date( 'Y-m-d' , strtotime( $start ) );
	$end = date( 'Y-m-d' , strtotime( $end ) );
	
	$startoutput = date( 'd/m/Y' , strtotime( $start ) );
	$endoutput = date( 'd/m/Y' , strtotime( $end ) );
	
	$datetime1 = new DateTime( $start );

    $datetime2 = new DateTime( $end );
    
    $difference = $datetime1->diff( $datetime2 );
    
    $range = $difference->d;
    
    $range = intval( $range ) + 1;
    
    $month1 = date( "F", strtotime( $start ) );
    
    $month2 = date( "F", strtotime( $end ) );
    
    $type = '';
    
    if( $month1 !== $month2 )
    {
        echo 'Your start and end dates are in different months, please ensure your review dates and in the same month and try again';
        wp_die();
    }
    else
    {
        $month = $month1;
        $year = date( "Y", strtotime( $start ) );
    }
    
    //are they doing a review for current month
    if( $month == date( 'F' ) && $year == date( 'Y' ) )
    {
        //get the number of days in the month
        $days = date('t');
        
        //lets start by getting our current date
        $currentdate =  date( "j" );
    
        if( $currentdate == 1 )
        {
            //start of the month
            $pastdays = $currentdate;
        }
        else
        {
            $pastdays = $currentdate - 1;
        }
    }
    else
    {
        //previous month
        $month_number = date( "n", strtotime( $start ) );
        
        //get the number of days in the month
        $days = cal_days_in_month( CAL_GREGORIAN, $month_number , $year );
        
        $pastdays = $days;
    }
    
    
    if(strtotime("1 " . $month . ' ' . $year ) < strtotime("1 May 2021"))
    {
        $type = 'old';
    }
    else 
    {
        $type = 'new';
    }
    
    if( $type == 'old' )
    {
        $store_footfall = '';
    
        $predicted_footfall = '';
        
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_footfall" ) );
        
        foreach ( $results as $result )
        {
            if ( $result->store == $store )
            {
                if( $result->month == $month && $result->year == $year )
                {
                    $footfall = $result->footfall;
                }
            }
        }
        
        if( $footfall !== '' )
        {
            if( $month == date( 'F' ) && $year == date( 'Y' ) )
            {
            	$store_footfall = floatval( $footfall );
                $pastdays = floatval( $pastdays );
                
                $average_footfall = ( $store_footfall / $pastdays );
                
                $average_footfall = round( $average_footfall );
                
                //now get our predicted months footfall
                $predicted_footfall = ( $average_footfall * $days );
            }
            else
            {
                $predicted_footfall  = $footfall;
            }
        }
        
        //get our targets
        $tnc = ( 6 / 100 ) * $predicted_footfall;
        $nhc = ( 3 / 100 ) * $predicted_footfall;
        $tuc = ( 11 / 100 ) * $predicted_footfall;
        $nhb = ( 1 / 100 ) * $predicted_footfall;
        $uhb = ( 1 / 100 ) * $predicted_footfall;
        
        //get the total number of staff hours
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_rota" ) );
        
        $total_hours = array();
        $advisor_hours = array();
        
        foreach ( $results as $result )
        {
            if ( $result->store == $store && $result->month == $month && $result->year == $year && $result->advisor == $advisor )
            {
                $advisor_hours[] =  $result->total_hours;
            }
            
            if ( $result->store == $store && $result->month == $month && $result->year == $year )
            {
                $total_hours[] =  $result->total_hours;
            }
        }
        
        $hours = 0;
        $total = 0;
        
        foreach ( $advisor_hours as $ahours )
        {
            $hours = intval( $hours ) + intval( $ahours );
        }
        
        foreach ( $total_hours as $thours )
        {
            $total = intval( $total ) + intval( $thours );
        }
        
        //update our targets for the advisors
        $advisor_tnc = ceil( ( $tnc / $total ) * $hours );
        $advisor_nhc = ceil( ( $nhc / $total ) * $hours );
        $advisor_tuc = ceil( ( $tuc / $total ) * $hours );
        $advisor_nhb = ceil( ( $nhb / $total ) * $hours );
        $advisor_uhb = ceil( ( $uhb / $total ) * $hours );
        
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $advisor . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) ); 
        
        $all_new = 0;
        $all_upgrade = 0;
        $new_handsets = 0;
        $new_broadband = 0;
        $upgrade_broadband = 0;
        
        //we need to work out our percentages
        $total_insurance_sales = 0;
        $insurance_sale = 0;
        
        $total_broadband_sales = 0;
        $bt_tv_sales = 0;
        
        //get our accessories sold and profit
        $accessories_sold = 0;
        $accessory_profit = 0;
        
        //get our advisors profit
        $advisor_profit = 0;
        
        foreach( $results as $result )
        {
            if( $result->type == 'new' && $result->product_type !== 'homebroadband' && $result->type == 'new' && $result->product_type !== 'insurance' && $result->type == 'new' && $result->product_type !== 'accessory' )
            {
                //this is all our new connections
                $all_new++;
            }
            if( $result->type == 'upgrade' && $result->product_type !== 'homebroadband' && $result->type == 'upgrade' && $result->product_type !== 'insurance' && $result->type == 'upgrade' && $result->product_type !== 'accessory' )
            {
                //this is all our upgrade connections
                $all_upgrade++;
            }
            if( $result->type == 'new' && $result->product_type == 'handset' )
            {
                //this is all our new handset connections
                $new_handsets++;
            }
            if( $result->type == 'new' && $result->product_type == 'homebroadband' )
            {
                ///this is all our new home broadband connections
                $new_broadband++;
            }
            if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
            {
                //this is all our home broadband upgrades
                $upgrade_broadband++;
            }
            if( $result->product_type == 'homebroadband' )
            {
                if(strtotime($date) < strtotime("1 February 2022"))
                {
                    //find out if its a BT Tariff sold
                    if ( strpos( $result->tariff , 'BT' ) !== false ) 
                    {
                        $total_broadband_sales++;
                    }
                } else {
                    $total_broadband_sales++;
                }
                
                //find out if a BT TV Tariff was sold
                if( $result->broadband_tv == 'bt' )
                {
                    $bt_tv_sales++;
                }
            }
            if( $result->product_type == 'handset' || $result->product_type == 'tablet' || $result->product_type == 'connected' || $result->product_type == 'insurance' )
            {
                //these are our insurance sales
                $total_insurance_sales++;
                
                //was an insurance sold
                if( $result->insurance == 'yes' )
                {
                    $insurance_sale++;
                }
            }
            if( $result->accessory_needed == 'yes' )
            {
                //accessory was sold
                $accessories_sold++;
                $accessory_profit = floatval( $accessory_profit ) + floatval( $result->accessory_profit );
            }
            
            $advisor_profit = floatval( $advisor_profit ) + floatval( $result->total_profit );
        }
        
        if( $insurance_sale !== 0 && $total_insurance_sales !== 0 )
        {
            $insurance_percentage = ( intval( $insurance_sale ) / intval( $total_insurance_sales ) ) * 100;
        }
        
        if( $bt_tv_sales !== 0 && $total_broadband_sales !== 0 )
        {
            $bt_tv_percentage = ( intval( $bt_tv_sales ) / intval( $total_broadband_sales ) ) * 100;
        }
        
        if( is_nan( $insurance_percentage ) )
        {
            $insurance_percentage = 0;
        }
        else
        {
            $insurance_percentage = number_format( ( float )$insurance_percentage , 2 , '.',  '' );
            $insurance_percentage = floatval( $insurance_percentage );
        }
        
        if( is_nan( $bt_tv_percentage ) )
        {
            $bt_tv_percentage = 0;
        }
        else
        {
            $bt_tv_percentage = number_format( ( float )$bt_tv_percentage , 2 , '.',  '' );
            $bt_tv_percentage = floatval( $bt_tv_percentage );
        }
        
        $store_profit = 0;
        
        //now lets get our profit target
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_profit_targets WHERE store = '" . $store . "'" ) );
        
        foreach ($results as $result )
        {
            if( $result->month == $month && $result->year == $year )
            {
                $store_profit = $result->target;
            }
        }
        
        $advisor_profit_target = ceil( ( $store_profit / $total ) * $hours );
        
        //finally get our percentages
        if ( $all_new == 0 )
        {
            $tnc_percentage = 0;
        }
        else
        {
            $tnc_percentage = ceil( ( $all_new / $advisor_tnc ) * 100 );
        }
            
        if ( $new_handsets == 0 )
        {
            $nhc_percentage = 0;
        }
        else
        {
            $nhc_percentage = ceil( ( $new_handsets / $advisor_nhc ) * 100 );
        }
            
        if ( $all_upgrade == 0 )
        {
            $tuc_percentage = 0;
        }
        else
        {
            $tuc_percentage = ceil( ( $all_upgrade / $advisor_tuc ) * 100 );
        }
            
        if ( $new_broadband == 0 )
        {
            $nhb_percentage = 0;
        }
        else
        {
            $nhb_percentage = ceil( ( $new_broadband / $advisor_nhb ) * 100 );
        }
            
        if ( $upgrade_broadband == 0 )
        {
            $uhb_percentage = 0;
        }
        else
        {
            $uhb_percentage = ceil( ( $upgrade_broadband / $advisor_uhb ) * 100 );
        }
        
        if( $advisor_profit_target > 0 )
        {
            $profit_percentage = ceil( ( $advisor_profit / $advisor_profit_target ) * 100 );
        }
        else
        {
            $profit_percentage = 0;
        }
        
        ?>
        
        <div id="staff-review-info">
            <h4 class="text-center">Staff Review</h4>
            
            <br/>
            
            <p class="text-center">Date: <?php echo $startoutput; ?> - <?php echo $endoutput; ?></p>
            
            <br/>
            
            <table class="table spacer">
                <thead>
                    <tr></tr>
                    <tr>
                        <td class="text-center" colspan="4"><?php echo $advisor; ?></td>
                    </tr>
                    <tr>
                        <td class="blank-row" colspan="4"></td>
                    </tr>
                    <tr>
                        <th class="col-md-3">KPI</th>
                        <th class="col-md-3">Target</th>
                        <th class="col-md-3">Actual</th>
                        <th class="col-md-3">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Profit Target</td>
                        <td><?php echo '£' . $advisor_profit_target; ?></td>
                        <td><?php echo '£' .$advisor_profit; ?></td>
                        <td><?php echo $profit_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Total New Connections</td>
                        <td><?php echo $advisor_tnc; ?></td>
                        <td><?php echo $all_new; ?></td>
                        <td><?php echo $tnc_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>New Handset Connections</td>
                        <td><?php echo $advisor_nhc; ?></td>
                        <td><?php echo $new_handsets; ?></td>
                        <td><?php echo $nhc_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Total Upgrade Connections</td>
                        <td><?php echo $advisor_tuc; ?></td>
                        <td><?php echo $all_upgrade; ?></td>
                        <td><?php echo $tuc_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>New Home Broadband</td>
                        <td><?php echo $advisor_nhb; ?></td>
                        <td><?php echo $new_broadband; ?></td>
                        <td><?php echo $nhb_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Home Broadband Upgrades</td>
                        <td><?php echo $advisor_uhb; ?></td>
                        <td><?php echo $upgrade_broadband; ?></td>
                        <td><?php echo $uhb_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Total Bt TV Sold</td>
                        <td>30%</td>
                        <td><?php echo $bt_tv_percentage . '%'; ?></td>
                        
                        <?php 
                        
                        $percentage = 0;
                        
                        $percentage = ceil( ( $bt_tv_percentage / 30 ) * 100 );
                        
                        ?>
                        
                        <td><?php echo $percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Total Insurance Sales</td>
                        <td>30%</td>
                        <td><?php echo $insurance_percentage . '%'; ?></td>
                        
                        <?php 
                        
                        $percentage = 0;
                        
                        $percentage = ceil( ( $insurance_percentage / 30 ) * 100 );
                        
                        ?>
                        
                        <td><?php echo $percentage . '%'; ?></td>
                    </tr>
                </tbody>
            </table>
        
            <table class="table spacer">
                <thead>
                    <tr>
                        <th class="col-md-3">KPI</th>
                        <th class="col-md-3">Amount Sold</th>
                        <th class="col-md-3">Accessories Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Accessories Sold</td>
                        <td><?php echo $accessories_sold; ?></td>
                        <td><?php echo '£' . $accessory_profit; ?></td>
                    </tr>
                </tbody>
            </table>
            
            <?php
            
            $start = $start . ' 00:00:01';
            $end = $end . ' 23:59:59';
            
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '$advisor' AND sale_date >= '$start' AND sale_date <= '$end'" ) );
            
            $all_new = 0;
            $all_upgrade = 0;
            $new_handsets = 0;
            $new_broadband = 0;
            $upgrade_broadband = 0;
            
            //we need to work out our percentages
            $total_insurance_sales = 0;
            $insurance_sale = 0;
            
            $total_broadband_sales = 0;
            $bt_tv_sales = 0;
            
            //get our accessories sold
            $accessories_sold = 0;
            
            //get our advisors profit
            $advisor_profit = 0;
            
            foreach( $results as $result )
            {
                if( $result->type == 'new' && $result->product_type !== 'homebroadband' && $result->type == 'new' && $result->product_type !== 'insurance' && $result->type == 'new' && $result->product_type !== 'accessory' )
                {
                    //this is all our new connections
                    $all_new++;
                }
                if( $result->type == 'upgrade' && $result->product_type !== 'homebroadband' && $result->type == 'upgrade' && $result->product_type !== 'insurance' && $result->type == 'upgrade' && $result->product_type !== 'accessory' )
                {
                    //this is all our upgrade connections
                    $all_upgrade++;
                }
                if( $result->type == 'new' && $result->product_type == 'handset' )
                {
                    //this is all our new handset connections
                    $new_handsets++;
                }
                if( $result->type == 'new' && $result->product_type == 'homebroadband' )
                {
                    ///this is all our new home broadband connections
                    $new_broadband++;
                }
                if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
                {
                    //this is all our home broadband upgrades
                    $upgrade_broadband++;
                }
                if( $result->product_type == 'homebroadband' )
                {
                    if(strtotime($date) < strtotime("1 February 2022"))
                    {
                        //find out if its a BT Tariff sold
                        if ( strpos( $result->tariff , 'BT' ) !== false ) 
                        {
                            $total_broadband_sales++;
                        }
                    } else {
                        $total_broadband_sales++;
                    }
                    
                    //find out if a BT TV Tariff was sold
                    if( $result->broadband_tv == 'bt' )
                    {
                        $bt_tv_sales++;
                    }
                }
                if( $result->product_type == 'handset' || $result->product_type == 'tablet' || $result->product_type == 'connected' || $result->product_type == 'insurance' )
                {
                    //these are our insurance sales
                    $total_insurance_sales++;
                    
                    //was an insurance sold
                    if( $result->insurance == 'yes' )
                    {
                        $insurance_sale++;
                    }
                }
                if( $result->accessory_needed == 'yes' )
                {
                    //accessory was sold
                    $accessories_sold++;
                }
                
                $advisor_profit = floatval( $advisor_profit ) + floatval( $result->total_profit );
            }
            
            if( $insurance_sale !== 0 && $total_insurance_sales !== 0 )
            {
                $insurance_percentage = ( intval( $insurance_sale ) / intval( $total_insurance_sales ) ) * 100;
            }
            
            if( $bt_tv_sales !== 0 && $total_broadband_sales !== 0 )
            {
                $bt_tv_percentage = ( intval( $bt_tv_sales ) / intval( $total_broadband_sales ) ) * 100;
            }
            
            if( is_nan( $insurance_percentage ) )
            {
                $insurance_percentage = 0;
            }
            else
            {
                $insurance_percentage = number_format( ( float )$insurance_percentage , 2 , '.',  '' );
                $insurance_percentage = floatval( $insurance_percentage );
            }
            
            if( is_nan( $bt_tv_percentage ) )
            {
                $bt_tv_percentage = 0;
            }
            else
            {
                $bt_tv_percentage = number_format( ( float )$bt_tv_percentage , 2 , '.',  '' );
                $bt_tv_percentage = floatval( $bt_tv_percentage );
            }
            
            if( $range <= 7 )
            {
                $divide = 0.25;
            }
            elseif( $range > 7 && $range <= 14 )
            {
                $divide = 0.5;
            }
            elseif( $range > 14 && $range <= 21 )
            {
                $divide = 0.75;
            }
            elseif( $range > 21 )
            {
                $divide = 1;
            }
            
            $advisor_profit_target = ( $advisor_profit_target * $divide );
            
            $advisor_profit_target = ceil( $advisor_profit_target );
            
            //now update our targets for the range chosen
            
            $advisor_tnc = ceil( ( $advisor_tnc * $divide ) );
            
            $advisor_tuc = ceil( ( $advisor_tuc * $divide ) );
            
            $advisor_nhb = ceil( ( $advisor_nhb * $divide ) );
            
            $advisor_uhb = ceil( ( $advisor_uhb * $divide ) );
            
            $advisor_insurance = ( 30 * 1 );
            
            $advisor_bt = ( 30 * 1 );
            
            ?>
            
            <h2 class="text-center">Weekly Sales Info</h2>
            
            <table class="table">
                <thead>
                    <tr></tr>
                    <tr>
                        <th class="col-md-4">KPI</th>
                        <th class="col-md-2">Target</th>
                        <th class="col-md-2">Actual</th>
                        <th class="col-md-2">Var</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>New</td>
                        <td><?php echo $advisor_tnc; ?></td>
                        <td><?php echo $all_new; ?></td>
                        
                        <?php
                        if( $all_new > $advisor_tnc )
                        {
                            $var = $all_new - $advisor_tnc;
                            
                            echo '<td>+' . $var . '</td>';
                        }
                        else if( $advisor_tnc > $all_new )
                        {
                            $var = $advisor_tnc - $all_new;
                            echo '<td>-' . $var . '</td>';
                        }
                        else
                        {
                            echo '<td>0</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>PayM</td>
                        <td><?php echo $advisor_tnc; ?></td>
                        <td><?php echo $all_new; ?></td>
                        
                        <?php
                        if( $all_new > $advisor_tnc )
                        {
                            $var = $all_new - $advisor_tnc;
                            
                            echo '<td>+' . $var . '</td>';
                        }
                        else if( $advisor_tnc > $all_new )
                        {
                            $var = $advisor_tnc - $all_new;
                            echo '<td>-' . $var . '</td>';
                        }
                        else
                        {
                            echo '<td>0</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Upgrade</td>
                        <td><?php echo $advisor_tuc; ?></td>
                        <td><?php echo $all_upgrade; ?></td>
                        
                        <?php
                        if( $all_upgrade > $advisor_tuc )
                        {
                            $var = $all_upgrade - $advisor_tuc;
                            
                            echo '<td>+' . $var . '</td>';
                        }
                        else if( $advisor_tuc > $all_upgrade )
                        {
                            $var = $advisor_tuc - $all_upgrade;
                            echo '<td>-' . $var . '</td>';
                        }
                        else
                        {
                            echo '<td>0</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>HBB</td>
                        <td><?php echo $advisor_nhb; ?></td>
                        <td><?php echo $new_broadband; ?></td>
                        
                        <?php
                        if( $new_broadband > $advisor_nhb )
                        {
                            $var = $new_broadband - $advisor_nhb;
                            
                            $var = ceil( $var );
                            
                            echo '<td>+' . $var . '</td>';
                        }
                        else if( $advisor_nhb > $new_broadband )
                        {
                            $var = $advisor_nhb - $new_broadband;
                            
                            $var = ceil( $var );
                            
                            echo '<td>-' . $var . '</td>';
                        }
                        else
                        {
                            echo '<td>0</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Regrade</td>
                        <td><?php echo $advisor_uhb ?></td>
                        <td><?php echo $upgrade_broadband; ?></td>
                        
                        <?php
                        if( $upgrade_broadband > $advisor_uhb )
                        {
                            $var = $upgrade_broadband - $advisor_uhb;
                            
                            echo '<td>+' . $var . '</td>';
                        }
                        else if( $advisor_uhb > $upgrade_broadband )
                        {
                            $var = $advisor_uhb - $upgrade_broadband;
                            echo '<td>-' . $var . '</td>';
                        }
                        else
                        {
                            echo '<td>0</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Profit</td>
                        <td><?php echo '£' . $advisor_profit_target ?></td>
                        <td><?php echo '£' . $advisor_profit; ?></td>
                        
                        <?php
                        if( $advisor_profit > $advisor_profit_target )
                        {
                            $var = $advisor_profit - $advisor_profit_target;
                            
                            $var = ceil( $var );
                            
                            echo '<td>+ £' . $var . '</td>';
                        }
                        else if( $advisor_profit_target > $advisor_profit )
                        {
                            $var = $advisor_profit_target - $advisor_profit;
                            
                            $var = ceil( $var );
                            
                            echo '<td>- £' . $var . '</td>';
                        }
                        else
                        {
                            echo '<td>0</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Insurance</td>
                        <td><?php echo $advisor_insurance; ?>%</td>
                        <td><?php echo $insurance_percentage; ?>%</td>
                        
                        <?php
                        if( $insurance_percentage > $advisor_insurance )
                        {
                            $var = $insurance_percentage - $advisor_insurance;
                            
                            $var = $var;
                            
                            echo '<td>+' . $var . '%</td>';
                        }
                        else if( $advisor_insurance > $insurance_percentage )
                        {
                            $var = $advisor_insurance - $insurance_percentage;
                            
                            $var = $var;
                            
                            echo '<td>-' . $var . '%</td>';
                        }
                        else
                        {
                            echo '<td>0%</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>BT TV</td>
                        <td><?php echo $advisor_insurance; ?>%</td>
                        <td><?php echo $bt_tv_percentage; ?>%</td>
                        
                        <?php
                        if( $bt_tv_percentage > $advisor_insurance )
                        {
                            $var = $bt_tv_percentage - $advisor_insurance;
                            
                            $var = $var;
                            
                            echo '<td>+' . $var . '%</td>';
                        }
                        else if( $advisor_insurance > $bt_tv_percentage )
                        {
                            $var = $advisor_insurance - $bt_tv_percentage;
                            
                            $var = $var;
                            
                            echo '<td>-' . $var . '%</td>';
                        }
                        else
                        {
                            echo '<td>0%</td>';
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            
            <label class="spacer" for="review-comment">Staff Review Comment:</label>
        
            <textarea class="spacer-bottom" id="reviewcomment" name="reviewcomment" rows="4" cols="50">
            </textarea> 
        </div>
    <?php
    }
    else 
    { 
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_targets" ) );
    
        foreach ( $results as $result )
        {
            if ( $result->store == $store )
            {
                if( $result->month == $month && $result->year == $year )
                {
                    $new_handset = $result->new_handset;
                    $new_sim = $result->new_sim;
                    $new_data = $result->new_data;
                    $upgrade_handset = $result->upgrade_handset;
                    $upgrade_sim = $result->upgrade_sim;
                    $new_bt = $result->new_bt;
                    $regrade = $result->regrade;
                    $insurance = $result->insurance;
                    $profit_target = $result->profit_target;
                }
            }
        }
        
        //get the total number of staff hours
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_rota" ) );
        
        $total_hours = array();
        $advisor_hours = array();
        
        foreach ( $results as $result )
        {
            if ( $result->store == $store && $result->month == $month && $result->year == $year && $result->advisor == $advisor )
            {
                $advisor_hours[] =  $result->total_hours;
            }
            
            if ( $result->store == $store && $result->month == $month && $result->year == $year )
            {
                $total_hours[] =  $result->total_hours;
            }
        }
        
        $hours = 0;
        $total = 0;
        
        foreach ( $advisor_hours as $ahours )
        {
            $hours = intval( $hours ) + intval( $ahours );
        }
        
        foreach ( $total_hours as $thours )
        {
            $total = intval( $total ) + intval( $thours );
        }
        
        $advisor_new_handset = ceil( ( $new_handset / $total ) * $hours );
        $advisor_new_sim = ceil( ( $new_sim / $total ) * $hours );
        $advisor_new_data = ceil( ( $new_data / $total ) * $hours );
        $advisor_upgrade_handset = ceil( ( $upgrade_handset / $total ) * $hours );
        $advisor_upgrade_sim = ceil( ( $upgrade_sim / $total ) * $hours );
        $advisor_new_bt = ceil( ( $new_bt / $total ) * $hours );
        $advisor_regrades = ceil( ( $regrade / $total ) * $hours );
        $advisor_insurance = ceil( ( $insurance / $total ) * $hours );
        $advisor_profit_target = ceil( ( $profit_target / $total ) * $hours );
        
        if( $user && in_array( 'employee', $user->roles ) )
        {
            $percent = 8;
        }
        else if( $user && in_array( 'senior_advisor', $user->roles ) )
        {
            $percent = 10;
        }
        
        $all_new_handset = 0;
        $all_new_sim = 0;
        $all_new_data = 0;
        $all_upgrade_handset = 0;
        $all_upgrade_sim = 0;
        $all_regrades = 0;
        $all_new_bt = 0;
        $all_insurance = 0;
        $all_profit = 0;
        
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $advisor . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) ); 
        
        foreach( $results as $result )
        {
            if( $result->type == 'new' && $result->product_type == 'handset' )
            {
                //this is all our new connections
                $all_new_handset++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'simonly' )
            {
                //this is all our new connections
                $all_new_sim++;
            }
            
            if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                if(strtotime('now') < strtotime("1 March 2022"))
                {
                    $all_new_data++;
                } else {
                    if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                        $all_new_data += floatval(fc_get_data_tariff_mrc($result->tariff));
                    } else {
                        $all_new_data += floatval(fc_get_tariff_mrc($result->tariff));
                    }
                }
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'handset' )
            {
                //this is all our new connections
                $all_upgrade_handset++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'simonly' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                //this is all our new connections
                $all_upgrade_sim++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
            {
                //this is all our new connections
                $all_regrades++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'homebroadband' )
            {
                if(strtotime($date) < strtotime("1 February 2022"))
                {
                    //find out if its a BT Tariff sold
                    if ( strpos( $result->tariff , 'BT' ) !== false ) 
                    {
                        $all_new_bt++;
                    }
                } else {
                    $all_new_bt++;
                }
            }
            
            if( $result->insurance == 'yes' )
            {
                $all_insurance++;
            }
            
            if( $result->hrc !== 'yes' )
            {
                if( $result->pobo == 'yes' )
                {
                    $profit = (80 / 100) * $result->total_profit;
                    $all_profit += $profit;
                }
                else
                {
                    $all_profit += $result->total_profit;
                }
            }
        }
        
        $new_handset_percentage = ceil( ( $all_new_handset / $advisor_new_handset ) * 100 );
        $new_sim_percentage = ceil( ( $all_new_sim / $advisor_new_sim ) * 100 );
        $new_data_percentage = ceil( ( $all_new_data / $advisor_new_data ) * 100 );
        $upgrade_handset_percentage = ceil( ( $all_upgrade_handset / $advisor_upgrade_handset ) * 100 );
        $upgrade_sim_percentage = ceil( ( $all_upgrade_sim / $advisor_upgrade_sim ) * 100 );
        $new_bt_percentage = ceil( ( $all_new_bt / $advisor_new_bt ) * 100 );
        $regrades_percentage = ceil( ( $all_regrades / $advisor_regrades ) * 100 );
        $insurance_percentage = ceil( ( $all_insurance / $advisor_insurance ) * 100 );
        $profit_percentage = ceil( ( $all_profit / $advisor_profit_target ) * 100 );
        ?>
        
        <div id="staff-review-info">
            <h4 class="text-center">Staff Review</h4>
            
            <br/>
            
            <p class="text-center">Date: <?php echo $startoutput; ?> - <?php echo $endoutput; ?></p>
            
            <br/>
            
            <table class="table spacer">
                <thead>
                    <tr></tr>
                    <tr>
                        <td class="text-center" colspan="4"><?php echo $advisor; ?></td>
                    </tr>
                    <tr>
                        <td class="blank-row" colspan="4"></td>
                    </tr>
                    <tr>
                        <th class="col-md-3">KPI</th>
                        <th class="col-md-3">Target</th>
                        <th class="col-md-3">Actual</th>
                        <th class="col-md-3">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>New Handset</td>
                        <td><?php echo $advisor_new_handset; ?></td>
                        <td><?php echo $all_new_handset; ?></td>
                        <td><?php echo $new_handset_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>New Sim</td>
                        <td><?php echo $advisor_new_sim; ?></td>
                        <td><?php echo $all_new_sim; ?></td>
                        <td><?php echo $new_sim_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Data Value</td>
                        <td><?php echo '£' . $advisor_new_data; ?></td>
                        <td><?php echo '£' . $all_new_data; ?></td>
                        <td><?php echo $new_data_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Upgrade Handset</td>
                        <td><?php echo $advisor_upgrade_handset; ?></td>
                        <td><?php echo $all_upgrade_handset; ?></td>
                        <td><?php echo $upgrade_handset_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Upgrade Sim / Other</td>
                        <td><?php echo $advisor_upgrade_sim; ?></td>
                        <td><?php echo $all_upgrade_sim; ?></td>
                        <td><?php echo $upgrade_sim_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>New HBB</td>
                        <td><?php echo $advisor_new_bt; ?></td>
                        <td><?php echo $all_new_bt; ?></td>
                        <td><?php echo $new_bt_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Regrades</td>
                        <td><?php echo $advisor_regrades; ?></td>
                        <td><?php echo $all_regrades; ?></td>
                        <td><?php echo $regrades_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Insurance Sales</td>
                        <td><?php echo $advisor_insurance; ?></td>
                        <td><?php echo $all_insurance; ?></td>
                        <td><?php echo $insurance_percentage . '%'; ?></td>
                    </tr>
                    <tr>
                        <td>Profit target</td>
                        <td><?php echo '£' . $advisor_profit_target; ?></td>
                        <td><?php echo '£' . $all_profit; ?></td>
                        <td><?php echo $profit_percentage . '%'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
        
        if( $range <= 7 )
        {
            $divide = 0.25;
        }
        elseif( $range > 7 && $range <= 14 )
        {
            $divide = 0.5;
        }
        elseif( $range > 14 && $range <= 21 )
        {
            $divide = 0.75;
        }
        elseif( $range > 21 )
        {
            $divide = 1;
        }
        
        $advisor_new_handset = ( $advisor_new_handset * $divide );
        
        $advisor_new_sim = ( $advisor_new_sim * $divide );
        
        $advisor_new_data = ( $advisor_new_data * $divide );
        
        $advisor_upgrade_handset = ( $advisor_upgrade_handset * $divide );
        
        $advisor_upgrade_sim = ( $advisor_upgrade_sim * $divide );
        
        $advisor_regrade = ( $advisor_regrades * $divide );
        
        $advisor_new_bt = ( $advisor_new_bt * $divide );
        
        $advisor_insurance = ( $advisor_insurance * $divide );
        
        $advisor_profit_target = ( $advisor_profit_target * $divide );
            
        $advisor_profit_target = ceil( $advisor_profit_target );
        
        $start = $start . ' 00:00:01';
        $end = $end . ' 23:59:59';
            
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '$advisor' AND sale_date >= '$start' AND sale_date <= '$end'" ) );
        
        $all_new_handset = 0;
        $all_new_sim = 0;
        $all_new_data = 0;
        $all_upgrade_handset = 0;
        $all_upgrade_sim = 0;
        $all_regrades = 0;
        $all_new_bt = 0;
        $all_insurance = 0;
        $all_profit = 0;
        
        foreach( $results as $result )
        {
            if( $result->type == 'new' && $result->product_type == 'handset' )
            {
                //this is all our new connections
                $all_new_handset++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'simonly' )
            {
                //this is all our new connections
                $all_new_sim++;
            }
            
            if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                if(strtotime('now') < strtotime("1 March 2022"))
                {
                    $all_new_data++;
                } else {
                    if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                        $all_new_data += floatval(fc_get_data_tariff_mrc($result->tariff));
                    } else {
                        $all_new_data += floatval(fc_get_tariff_mrc($result->tariff));
                    }
                }
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'handset' )
            {
                //this is all our new connections
                $all_upgrade_handset++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'simonly' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
            {
                //this is all our new connections
                $all_upgrade_sim++;
            }
            
            if( $result->type == 'upgrade' && $result->product_type == 'homebroadband' )
            {
                //this is all our new connections
                $all_regrades++;
            }
            
            if( $result->type == 'new' && $result->product_type == 'homebroadband' )
            {
                if(strtotime($date) < strtotime("1 February 2022"))
                {
                    //find out if its a BT Tariff sold
                    if ( strpos( $result->tariff , 'BT' ) !== false ) 
                    {
                        $all_new_bt++;
                    }
                } else {
                    $all_new_bt++;
                }
            }
            
            if( $result->insurance == 'yes' )
            {
                $all_insurance++;
            }
            
            if( $result->hrc !== 'yes' )
            {
                if( $result->pobo == 'yes' )
                {
                    $profit = (80 / 100) * $result->total_profit;
                    $all_profit += $profit;
                }
                else
                {
                    $all_profit += $result->total_profit;
                }
            }
        }
        ?>
        
        <h2 class="text-center">Weekly Sales Info</h2>

        <table class="table">
            <thead>
                <tr></tr>
                <tr>
                    <th class="col-md-3">KPI</th>
                    <th class="col-md-3">Target</th>
                    <th class="col-md-3">Actual</th>
                    <th class="col-md-3">Var</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>New Handset</td>
                    <td><?php echo $advisor_new_handset; ?></td>
                    <td><?php echo $all_new_handset; ?></td>
                    
                    <?php if($all_new_handset > $advisor_new_handset )
                    {
                        $var = $all_new_handset - $advisor_new_handset;
                        ?>
                        <td><?php echo '+' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_new_handset - $all_new_handset;
                        ?>
                        <td><?php echo '-' . $var; ?></td>
                        <?php
                    }
                    ?>
                    
                </tr>
                <tr>
                    <td>New Sim</td>
                    <td><?php echo $advisor_new_sim; ?></td>
                    <td><?php echo $all_new_sim; ?></td>
                    
                    <?php if($all_new_sim > $advisor_new_sim )
                    {
                        $var = $all_new_sim - $advisor_new_sim;
                        ?>
                        <td><?php echo '+' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_new_sim - $all_new_sim;
                        ?>
                        <td><?php echo '-' . $var; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>Data Value</td>
                    <td><?php echo '£' . $advisor_new_data; ?></td>
                    <td><?php echo '£' .  $all_new_data; ?></td>
                    
                    <?php if($all_new_data > $advisor_new_data )
                    {
                        $var = $all_new_data - $advisor_new_data;
                        ?>
                        <td><?php echo '+' . '£' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_new_data - $all_new_data;
                        ?>
                        <td><?php echo '-' . '£' .  $var; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>Upgrade Handset</td>
                    <td><?php echo $advisor_upgrade_handset; ?></td>
                    <td><?php echo $all_upgrade_handset; ?></td>
                    
                    <?php if($all_upgrade_handset > $advisor_upgrade_handset )
                    {
                        $var = $all_upgrade_handset - $advisor_upgrade_handset;
                        ?>
                        <td><?php echo '+' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_upgrade_handset - $all_upgrade_handset;
                        ?>
                        <td><?php echo '-' . $var; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>Upgrade Sim / Other</td>
                    <td><?php echo $advisor_upgrade_sim; ?></td>
                    <td><?php echo $all_upgrade_sim; ?></td>
                    
                    <?php if($all_upgrade_sim > $advisor_upgrade_sim )
                    {
                        $var = $all_upgrade_sim - $advisor_upgrade_sim;
                        ?>
                        <td><?php echo '+' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_upgrade_sim - $all_upgrade_sim;
                        ?>
                        <td><?php echo '-' . $var; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>Regrades</td>
                    <td><?php echo $advisor_regrades; ?></td>
                    <td><?php echo $all_regrades; ?></td>
                    
                    <?php if($all_regrades > $advisor_regrades )
                    {
                        $var = $all_regrades - $advisor_regrades;
                        ?>
                        <td><?php echo '+' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_regrades - $all_regrades;
                        ?>
                        <td><?php echo '-' . $var; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>New BT Sales</td>
                    <td><?php echo $advisor_new_bt; ?></td>
                    <td><?php echo $all_new_bt; ?></td>
                    
                    <?php if($all_new_bt > $advisor_new_bt )
                    {
                        $var = $all_new_bt - $advisor_new_bt;
                        ?>
                        <td><?php echo '+' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_new_bt - $all_new_bt;
                        ?>
                        <td><?php echo '-' . $var; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>Insurance Sales</td>
                    <td><?php echo $advisor_insurance; ?></td>
                    <td><?php echo $all_insurance; ?></td>
                    
                    <?php if($all_insurance > $advisor_insurance )
                    {
                        $var = $all_insurance - $advisor_insurance;
                        ?>
                        <td><?php echo '+' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_insurance - $all_insurance;
                        ?>
                        <td><?php echo '-' . $var; ?></td>
                        <?php
                    }
                    ?>                
                </tr>
                <tr>
                    <td>Profit target</td>
                    <td><?php echo '£' . $advisor_profit_target; ?></td>
                    <td><?php echo '£' . $all_profit; ?></td>
                    
                    <?php if($all_profit > $advisor_profit_target )
                    {
                        $var = $all_profit - $advisor_profit_target;
                        ?>
                        <td><?php echo '+ £' . $var; ?></td>
                        <?php
                    }
                    else 
                    {
                        $var = $advisor_profit_target - $all_profit;
                        ?>
                        <td><?php echo '- £' . $var; ?></td>
                        <?php
                    }
                    ?> 
                </tr>
            </tbody>
        </table>
            
        <label class="spacer" for="review-comment">Staff Review Comment:</label>
        
        <textarea class="spacer-bottom" id="reviewcomment" name="reviewcomment" rows="4" cols="50">
        </textarea>
        <?php
    }
    
    wp_die();
}

function get_unapproved_Sales_info() 
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
    
    $store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store = '$store' AND approve_sale = ''" ) );

    $dates = array();
    
    foreach ( $results as $result )
    {
        $date = $result->sale_date;

        $createDate = new DateTime( $date );
            
        $date = $createDate->format('Y-m-d');
            
        $today = date("Y-m-d");
            
        if( $date !== $today )
        {
            $dates[ $date ] = $date;
        }
    }

    if( ! empty( $dates ) )
    {
        usort( $dates , "date_sort" );
        
        $list = '';
        $list .= '<ul class="unapproved_dates">';
        
        foreach( $dates as $date )
        {
            $list .= '<li>' . $date . '</li>';
        }
        
        $list .= '</ul>';
        
        echo '<p>You are viewing the unapproved sales for ' . $store . '. We have found the following dates with unapproved sales</p>';
        
        echo $list;
        wp_die();
    } else {
        echo 'All sales have been approved for this store';
        wp_die();
    }
}

function get_sales_search() 
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
    
    $store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    $advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
    $start = ! empty( $data[ 'start' ] ) ? $data[ 'start' ] : '';
	$end = ! empty( $data[ 'end' ] ) ? $data[ 'end' ] : '';
    $id   = ! empty( $data[ 'id' ] ) ? $data[ 'id' ] : '';
    $saleType   = ! empty( $data[ 'saleType' ] ) ? $data[ 'saleType' ] : '';
    $productType   = ! empty( $data[ 'productType' ] ) ? $data[ 'productType' ] : '';
    $device   = ! empty( $data[ 'device' ] ) ? $data[ 'device' ] : '';
    $deviceDiscount   = ! empty( $data[ 'deviceDiscount' ] ) ? $data[ 'deviceDiscount' ] : '';
    $tariffType   = ! empty( $data[ 'tariffType' ] ) ? $data[ 'tariffType' ] : '';
    $tariff   = ! empty( $data[ 'tariff' ] ) ? $data[ 'tariff' ] : '';
    $tariffDiscount   = ! empty( $data[ 'tariffDiscount' ] ) ? $data[ 'tariffDiscount' ] : '';
    $accessory   = ! empty( $data[ 'accessory' ] ) ? $data[ 'accessory' ] : '';
    $insuranceType   = ! empty( $data[ 'insuranceType' ] ) ? $data[ 'insuranceType' ] : '';
    $insurance = ! empty( $data[ 'insurance' ] ) ? $data[ 'insurance' ] : '';
    $hrc   = ! empty( $data[ 'hrc' ] ) ? $data[ 'hrc' ] : '';
    $pobo   = ! empty( $data[ 'pobo' ] ) ? $data[ 'pobo' ] : '';
    
    $sales = [];
    $search = [];
    
    if($start !== '') {
         $start = date( 'Y-m-d' , strtotime( $start ) );
    }
    
    if($end !== '') {
        $end = date( 'Y-m-d' , strtotime( $end ) );
    }
    
    if($id !== '') {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE id = '$id'") );
        $sales = $results;
    } else {
        //if all is empty, get all sales
        if($store == '' && $start == '' && $end == '') {
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info") );
        }
        
        //search via store first
        if($store !== '' && $start == '' && $end == '') {
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store = '$store'") );
        }
        
        if($store !== '' && $start !== '' && $end !== '')
        {
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store = '$store' AND DATE( `sale_date` ) >= '" . $start . "' AND DATE( `sale_date` ) <= '" . $end . "'") );
            $dateSearch = true;
        }
        
        if($store == '' && $start !== '' && $end !== '')
        {
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) >= '" . $start . "' AND DATE( `sale_date` ) <= '" . $end . "'") );
        }
        
        if($advisor !== '') {
            foreach($results as $result) {
                if($result->advisor == $advisor) {
                    $sales[] = $result;
                }
            }
        } else {
            foreach($results as $result) {
                $sales[] = $result;
            }
        }
        
        if($saleType !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->type) != strtolower($saleType)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($productType !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->product_type) != strtolower($productType)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($device !== 'Choose a Device') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->device) != strtolower($device)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($deviceDiscount !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->device_discount_type) != strtolower($deviceDiscount)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($tariffType !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->tariff_type) != strtolower($tariffType)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($tariff !== 'Choose Tariff') {
            //check if its not a device tariff option
            if($tariff !== 'Choose Tariff Type to See Tariffs') {
                foreach($sales as $key => $sale)
                {
                    if(strtolower($sale->tariff) != strtolower($tariff)) {
                        unset($sales[$key]);
                    }
                }
            }
        }
        
        if($tariffDiscount !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->tariff_discount_type) != strtolower($tariffDiscount)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($accessory !== 'Choose Accessory') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->accessory) != strtolower($accessory)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($insuranceType !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->insurance_type) != strtolower($insuranceType)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($insurance !== 'Choose Insurance')
        {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->insurance_type) !== strtolower($insurance)) {
                    unset($sales[$key]);
                }
            }
        }
        
        if($hrc !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->hrc) != 'yes') {
                    unset($sales[$key]);
                }
            }
        }
        
        if($pobo !== '') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->pobo) != 'yes') {
                    unset($sales[$key]);
                }
            }
        }
    }
    
    if ( ! empty( $sales ) )
    {
        $i = 1; ?>
        <h3 style="margin-top:30px;">Sales Results</h3>
            
        <p style="margin-top:15px; margin-bottom:30px;">We found <?php echo count($sales); ?> <?php if(count($sales) == 1) { echo 'result'; } else { echo 'results'; } ?> for this search query</p>
        
        <?php
        foreach($sales as $sale)
        {
            ?>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:15px;">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#sale<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                
                                <?php 
                                if( $sale->product_type == 'homebroadband' )
                                {
                                    ?>
                                    <i class="fas fa-wifi sale-icon"></i> Home Broadband - <?php echo $sale->tariff;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'simonly' )
                                {
                                    ?>
                                    <i class="fas fa-sim-card sale-icon"></i> Sim Only - <?php echo $sale->tariff;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'handset' )
                                {
                                    ?>
                                    <i class="fas fa-mobile sale-icon"></i> Handset - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'tablet' )
                                {
                                    ?>
                                    <i class="fas fa-tablet-alt sale-icon"></i> Tablet - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'connected' )
                                {
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-watch sale-icon" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4 14.333v-1.86A5.985 5.985 0 0 1 2 8c0-1.777.772-3.374 2-4.472V1.667C4 .747 4.746 0 5.667 0h4.666C11.253 0 12 .746 12 1.667v1.86A5.985 5.985 0 0 1 14 8a5.985 5.985 0 0 1-2 4.472v1.861c0 .92-.746 1.667-1.667 1.667H5.667C4.747 16 4 15.254 4 14.333zM13 8A5 5 0 1 0 3 8a5 5 0 0 0 10 0z"/>
                                        <path d="M13.918 8.993A.502.502 0 0 0 14.5 8.5v-1a.5.5 0 0 0-.582-.493 6.044 6.044 0 0 1 0 1.986z"/>
                                        <path fill-rule="evenodd" d="M8 4.5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5H6a.5.5 0 0 1 0-1h1.5V5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    Connected - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'accessory' )
                                {
                                    ?>
                                    <i class="fas fa-headphones-alt sale-icon"></i> Accessory - <?php echo $sale->accessory;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'insurance' )
                                {
                                    ?>
                                   <i class="fas fa-file-alt sale-icon"></i> Insurance - <?php echo $sale->insurance_choice;
                                }
                                ?>
                            </a>
                        </h4>
                    </div>
                    <div id="sale<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                        <div class="panel-body">
                            <?php if( $sale->approve_sale == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-12 spacer">
                                        <p><strong class="color:red;">This sale has been approved</strong></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Sale ID</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo $sale->id; ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Sale Date and Time</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo $sale->sale_date; ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Store</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->store); ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Advisor</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->advisor); ?></p>
                                </div>
                            </div>
                              
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Sale Type</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->type); ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Product Sold</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->product_type); ?></p>
                                </div>
                            </div>
                            
                            <?php if( $sale->device !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Device</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->device); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Device Discount Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->device_discount_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'rm' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Regional Manager Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'franchise' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Franchise Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'both' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Regional Manager Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Franchise Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount_2; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->broadband_tv !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Broadband TV</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->broadband_tv); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_discount_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Discount Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff_discount_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_discount !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->tariff_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->accessory_needed !== 'no' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->accessory); ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory Cost</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->accessory_cost; ?></p>
                                    </div>
                                </div>
                                <?php
                                
                                if( $sale->accessory_discount !== 'no' )
                                {
                                    ?>
                                    <div class="row sale-row">
                                        <div class="col-xs-6">
                                            <p><strong>Accessory Discount</strong></p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p><?php echo '£' . $sale->accessory_discount_value; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            
                            <?php if( $sale->insurance !== 'no' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->insurance_type); ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->insurance_choice); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->hrc == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>HRC Sale</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->hrc); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->pobo == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>POBO Sale</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->pobo); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->profit_loss !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Profit / Loss</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'. $sale->profit_loss; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->total_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Total Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£' . $sale->total_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->accessory_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£' . $sale->accessory_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->insurance_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo $sale->insurance_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
    }
    else
    {
        ?>
        <p>No sales found for this search, this could be for the following reasons:</p><br/>
        <p>1. You have added the wrong sale ID</p>
        <p>2. You have added too many search parameters</p></p>
        <p>3. There has been an error while searching your sales</p><br/>
        <?php
    }
    
    wp_die();
}

function generate_sales_report() 
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
    
    $store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    $advisor = ! empty( $data[ 'advisor' ] ) ? $data[ 'advisor' ] : '';
    $start = ! empty( $data[ 'start' ] ) ? $data[ 'start' ] : '';
	$end = ! empty( $data[ 'end' ] ) ? $data[ 'end' ] : '';
    $saleType   = ! empty( $data[ 'saleType' ] ) ? $data[ 'saleType' ] : '';
    $productType   = ! empty( $data[ 'productType' ] ) ? $data[ 'productType' ] : '';
    $device   = ! empty( $data[ 'device' ] ) ? $data[ 'device' ] : '';
    $deviceDiscount   = ! empty( $data[ 'deviceDiscount' ] ) ? $data[ 'deviceDiscount' ] : '';
    $tariffType   = ! empty( $data[ 'tariffType' ] ) ? $data[ 'tariffType' ] : '';
    $tariffgroup   = ! empty( $data[ 'tariffgroup' ] ) ? $data[ 'tariffgroup' ] : '';
    $tariff   = ! empty( $data[ 'tariff' ] ) ? $data[ 'tariff' ] : '';
    $tariffDiscount   = ! empty( $data[ 'tariffDiscount' ] ) ? $data[ 'tariffDiscount' ] : '';
    $accessory   = ! empty( $data[ 'accessory' ] ) ? $data[ 'accessory' ] : '';
    $insuranceType   = ! empty( $data[ 'insuranceType' ] ) ? $data[ 'insuranceType' ] : '';
    $insurance = ! empty( $data[ 'insurance' ] ) ? $data[ 'insurance' ] : '';
    $hrc   = ! empty( $data[ 'hrc' ] ) ? $data[ 'hrc' ] : '';
    $pobo   = ! empty( $data[ 'pobo' ] ) ? $data[ 'pobo' ] : '';
    
    $sales = [];
    $search = [];
    
    if($start !== '') {
         $start = date( 'Y-m-d' , strtotime( $start ) );
    }
    
    if($end !== '') {
        $end = date( 'Y-m-d' , strtotime( $end ) );
    }
    
    //if all is empty, get all sales
    if($store == '' && $start == '' && $end == '') {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info") );
    }
    
    //search via store first
    if($store !== '' && $start == '' && $end == '') {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store = '$store'") );
    }
    
    if($store !== '' && $start !== '' && $end !== '')
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store = '$store' AND DATE( `sale_date` ) >= '" . $start . "' AND DATE( `sale_date` ) <= '" . $end . "'") );
    }
    
    if($store == '' && $start !== '' && $end !== '')
    {
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) >= '" . $start . "' AND DATE( `sale_date` ) <= '" . $end . "'") );
    }
    
    if($advisor !== '') {
        foreach($results as $result) {
            if($result->advisor == $advisor) {
                $sales[] = $result;
            }
        }
    } else {
        foreach($results as $result) {
            $sales[] = $result;
        }
    }
    
    if($saleType !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->type) != strtolower($saleType)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($productType !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->product_type) != strtolower($productType)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($device !== 'Choose a Device') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->device) != strtolower($device)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($deviceDiscount !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->device_discount_type) != strtolower($deviceDiscount)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($tariffType !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->tariff_type) != strtolower($tariffType)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($tariffgroup !== '') {
        foreach($sales as $key => $sale)
        {
            if(strpos(strtolower($sale->tariff), $tariffgroup) == false){
                unset($sales[$key]);
            }
        }
    }
    
    if($tariff !== 'Choose Tariff') {
        //check if its not a device tariff option
        if($tariff !== 'Choose Tariff Type to See Tariffs') {
            foreach($sales as $key => $sale)
            {
                if(strtolower($sale->tariff) != strtolower($tariff)) {
                    unset($sales[$key]);
                }
            }
        }
    }
    
    if($tariffDiscount !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->tariff_discount_type) != strtolower($tariffDiscount)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($accessory !== 'Choose Accessory') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->accessory) != strtolower($accessory)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($insuranceType !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->insurance_type) != strtolower($insuranceType)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($insurance !== 'Choose Insurance')
    {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->insurance_type) !== strtolower($insurance)) {
                unset($sales[$key]);
            }
        }
    }
    
    if($hrc !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->hrc) != 'yes') {
                unset($sales[$key]);
            }
        }
    }
    
    if($pobo !== '') {
        foreach($sales as $key => $sale)
        {
            if(strtolower($sale->pobo) != 'yes') {
                unset($sales[$key]);
            }
        }
    }
    
    if ( ! empty( $sales ) )
    {
        //load our charts files
        wp_enqueue_style( 'fc-charts' );

        $total_profit = 0;
        $total = count($sales);
        
        foreach($sales as $sale) {
            $total_profit += floatval($sale->total_profit);
        } ?>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5" style="margin:20px"><canvas id="sales_report" width="400" height="400"></canvas></div>
        
                <div class="col-md-5" style="margin:20px"><canvas id="profit_report" width="400" height="400"></canvas></div>
            </div>
        </div>
        
        <script>
            var salesreport = document.getElementById( 'sales_report' );
            var sales_report_chart = new Chart(salesreport, {
                type: 'bar',
                data: {
                    labels: [
                        'Number of Sales'
                    ],
                    datasets: [{
                        label: 'Sales Report',
                        data: [
                            '<?= $total; ?>'
                        ],
                        backgroundColor: [
                            'rgba(68, 108, 179, 1)',
                        ],
                        borderColor: [
                            'rgba(68, 108, 179, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    },
                    maintainAspectRatio: false,
                    responsive: true
                }
            });
            
            var profitreport = document.getElementById( 'profit_report' );
            var profit_report_chart = new Chart(profitreport, {
                type: 'bar',
                data: {
                    labels: [
                        'Total Profit'
                    ],
                    datasets: [{
                        label: 'Profit Report',
                        data: [
                            '<?= $total_profit; ?>'
                        ],
                        backgroundColor: [
                            'rgba(189, 195, 199, 1)',
                        ],
                        borderColor: [
                            'rgba(189, 195, 199, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 100
                            }
                        }]
                    },
                    maintainAspectRatio: false,
                    responsive: true
                }
            });
        </script>
        <?php die();
    } else {
        ?>
        <p>We were unable to generate your sales report, this could be for the following reasons:</p><br/>
        <p>1. There are no sales for the parameters you have chosen </p>
        <p>2. You have added too many report parameters</p></p>
        <p>3. There has been an error while generating your report</p><br/>
        <?php
    }
}

function manage_sales() 
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
    
    $store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    $date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    $sale_action   = ! empty( $data[ 'sale_action' ] ) ? $data[ 'sale_action' ] : '';
    
    $split = explode("-", $date );
    
    $monthNum = $split[1];
    
    $dateObj   = DateTime::createFromFormat( '!m', $monthNum );
    $month = $dateObj->format('F');
    
    $year = $split[0];
    
    $day = $split[2];
    
    $table = 'wp_fc_sales_info';
    
    if($sale_action == 'approve') 
    {
        $data_update = array('approve_Sale' => 'yes');
        $data_where = array('store' => $store, 'month' => $month, 'year' => $year,'day' => $day);
        
        $wpdb->update($table , $data_update, $data_where);
        
        wp_send_json_success('approved');
    } else if($sale_action == 'unapprove')
    {
        $data_update = array('approve_Sale' => '');
        $data_where = array('store' => $store, 'month' => $month, 'year' => $year,'day' => $day);
        
        $wpdb->update($table , $data_update, $data_where);
        
        wp_send_json_success('unapproved');
    } elseif($sale_action == 'delete')
    {
        //get all results for the day
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = '$date' AND store = '$store'") );
        
        foreach($results as $result)
        {
            $wpdb->query("DELETE FROM wp_fc_sales_info WHERE id IN($result->id)");
        }
        
        wp_send_json_success('deleted');
    }
}

function manage_month_sales() 
{
    check_ajax_referer('fc-nonce', 'nonce');
    
    global $wpdb;
    
    $data     = array();
    $success = array();
	$error = array();
	$count = 0;
	
	$data = $_POST;
    
    $store   = ! empty( $data[ 'store' ] ) ? $data[ 'store' ] : '';
    $date   = ! empty( $data[ 'date' ] ) ? $data[ 'date' ] : '';
    $sale_action   = ! empty( $data[ 'sale_action' ] ) ? $data[ 'sale_action' ] : '';
    
    $split = explode("-", $date );
    
    $monthNum = $split[1];
    
    $dateObj   = DateTime::createFromFormat( '!m', $monthNum );
    $month = $dateObj->format('F');
    
    $year = $split[0];
    
    $day = $split[2];
    
    $table = 'wp_fc_sales_info';
    
    if($sale_action == 'approve') 
    {
        $data_update = array('approve_Sale' => 'yes');
        $data_where = array('store' => $store, 'month' => $month, 'year' => $year);
        
        $wpdb->update($table , $data_update, $data_where);
        
        wp_send_json_success('approved');
    } else if($sale_action == 'unapprove')
    {
        $data_update = array('approve_Sale' => '');
        $data_where = array('store' => $store, 'month' => $month, 'year' => $year);
        
        $wpdb->update($table , $data_update, $data_where);
        
        wp_send_json_success('unapproved');
    } elseif($sale_action == 'delete')
    {
        //get all results for the day
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE month = '" . $month . "' AND year = '" . $year . "' AND store = '" . $store . "'") );
        
        foreach($results as $result)
        {
            $wpdb->query("DELETE FROM wp_fc_sales_info WHERE id IN($result->id)");
        }
        
        wp_send_json_success('deleted');
    }
}