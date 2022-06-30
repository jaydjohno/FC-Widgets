<?php

function add_custom_my_account_endpoints() 
{
    //create our user endpoints
    add_rewrite_endpoint( 'sales-targets', EP_PAGES );
    add_rewrite_endpoint( 'employee-details', EP_PAGES );
    add_rewrite_endpoint( 'your-shifts', EP_PAGES );
    add_rewrite_endpoint( 'your-commission', EP_PAGES );
    add_rewrite_endpoint( 'sales-input', EP_PAGES );
    add_rewrite_endpoint( 'employee-sales', EP_PAGES );
    
    //create our store manager endpoints
    add_rewrite_endpoint( 'manage-users', EP_PAGES );
    add_rewrite_endpoint( 'reports', EP_PAGES );
    add_rewrite_endpoint( 'manage-sales', EP_PAGES );
    add_rewrite_endpoint( 'manage-assets', EP_PAGES );
    add_rewrite_endpoint( 'store-targets', EP_PAGES );
    add_rewrite_endpoint( 'store-commission', EP_PAGES );
    add_rewrite_endpoint( 'store-cover', EP_PAGES );
	add_rewrite_endpoint( 'input-targets', EP_PAGES );
	add_rewrite_endpoint( 'input-banking', EP_PAGES );
	add_rewrite_endpoint( 'view-banking', EP_PAGES );
	add_rewrite_endpoint( 'unapproved-sales', EP_PAGES );
	add_rewrite_endpoint( 'search-sales', EP_PAGES );
	add_rewrite_endpoint( 'sales-multipliers', EP_PAGES );
	add_rewrite_endpoint( 'sales-reports', EP_PAGES );
	add_rewrite_endpoint( 'advisor-nps', EP_PAGES );
}

add_action( 'init', 'add_custom_my_account_endpoints' );

//start our employee content

function add_sales_targets_endpoint_content()
{
    require fc_dir . 'templates/portal/sales-targets.php';
}

add_action( 'woocommerce_account_sales-targets_endpoint', 'add_sales_targets_endpoint_content' );

function add_employee_details_endpoint_content()
{
    require fc_dir . 'templates/portal/employee-details.php';
}

add_action( 'woocommerce_account_employee-details_endpoint', 'add_employee_details_endpoint_content' );

function add_your_commission_endpoint_content()
{
    //require fc_dir . 'templates/portal/employee-commission.php';
}

add_action( 'woocommerce_account_your-commission_endpoint', 'add_your_commission_endpoint_content' );

function add_sales_input_content()
{
    require fc_dir . 'templates/portal/sales-input.php';
}

add_action( 'woocommerce_account_sales-input_endpoint', 'add_sales_input_content' );

function add_employee_sales_content()
{
    require fc_dir . 'templates/portal/employee-sales.php';
}

add_action( 'woocommerce_account_employee-sales_endpoint', 'add_employee_sales_content' );

//start our store management content

function add_reports_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/management-reports.php';
}

add_action( 'woocommerce_account_reports_endpoint', 'add_reports_endpoint_content' );

function add_manage_sales_input_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) ) 
    {
        return;
    }
    
    if( $user && in_array( 'senior_manager', $user->roles ) ) 
    {
        require fc_dir . 'templates/portal/manage-sales-senior.php';
    }
    else
    {
        require fc_dir . 'templates/portal/manage-sales.php';
    }
}

add_action( 'woocommerce_account_manage-sales_endpoint', 'add_manage_sales_input_content' );

function add_dprice_manage_assets_content()
{
    $user = wp_get_current_user();
    
    if( $user && isset( $user->user_login ) && 'dprice' == $user->user_login || $user && in_array( 'senior_manager', $user->roles )) 
    {
        //do nothing
    }
    else
    {
        return;
    }
    
    require fc_dir . 'templates/portal/manage-assets.php';
}

add_action( 'woocommerce_account_manage-assets_endpoint', 'add_dprice_manage_assets_content' );

function add_store_targets_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) ) 
    {
        require fc_dir . 'templates/portal/employee-store-targets.php';
    }
    else
    {
        require fc_dir . 'templates/portal/store-targets.php';
    }
}

add_action( 'woocommerce_account_store-targets_endpoint', 'add_store_targets_content' );

function add_store_commission_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/store-commission.php';
}

add_action( 'woocommerce_account_store-commission_endpoint', 'add_store_commission_content' );

function add_input_targets_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/input-targets.php';
}

add_action( 'woocommerce_account_input-targets_endpoint', 'add_input_targets_content' );

function add_store_cover_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/store-cover.php';
}

add_action( 'woocommerce_account_store-cover_endpoint', 'add_store_cover_content' );

function add_manage_users_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/manage-users.php';
}

add_action( 'woocommerce_account_manage-users_endpoint', 'add_manage_users_endpoint_content' );

//start our senior management content

function add_sales_view_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/sales-view.php';
}

add_action( 'woocommerce_account_sales-view_endpoint', 'add_sales_view_endpoint_content' );

function add_commission_view_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/commission-view.php';
}

add_action( 'woocommerce_account_commission-view_endpoint', 'add_commission_view_endpoint_content' );

function add_banking_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/input-banking.php';
}

add_action( 'woocommerce_account_input-banking_endpoint', 'add_banking_endpoint_content' );

function add_view_banking_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/view-banking.php';
}

add_action( 'woocommerce_account_view-banking_endpoint', 'add_view_banking_endpoint_content' );

function add_unapproved_sales_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/unapproved-sales.php';
}

add_action( 'woocommerce_account_unapproved-sales_endpoint', 'add_unapproved_sales_endpoint_content' );

function add_search_sales_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/search-sales.php';
}

add_action( 'woocommerce_account_search-sales_endpoint', 'add_search_sales_endpoint_content' );

function add_sales_multipliers_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/sales-multipliers.php';
}

add_action( 'woocommerce_account_sales-multipliers_endpoint', 'add_sales_multipliers_endpoint_content' );

function add_sales_reports_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && ! in_array( 'senior_manager', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/sales-reports.php';
}

add_action( 'woocommerce_account_sales-reports_endpoint', 'add_sales_reports_endpoint_content' );

function add_advisor_nps_endpoint_content()
{
    $user = wp_get_current_user();
    
    if( $user && in_array( 'employee', $user->roles ) ) 
    {
        return;
    }
    
    require fc_dir . 'templates/portal/advisor-nps.php';
}

add_action( 'woocommerce_account_advisor-nps_endpoint', 'add_advisor_nps_endpoint_content' );
