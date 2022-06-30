<?php

function fc_get_users() 
{
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
    
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
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
    
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
        }
    }
    
    //now add our managers
    $user = wp_get_current_user();
    $id = $user->ID;
    $user_info = get_userdata( $id );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    
    $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
    
    return $employees;
}

function fc_get_sale_users() 
{
    global $wpdb;
    
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
                
                $advisor = $first_name . ' ' . $last_name;
                
                $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE() AND approve_sale = ''" ) );
                
                foreach( $results as $result )
                {
                    if( $result->advisor == $advisor )
                    {
                        $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
                    }
                }
            }
        }
        else
        {
            $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE() AND approve_sale = ''" ) );
            
            $id = $user->ID;
            $user_info = get_userdata( $id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
                    
            $advisor = $first_name . ' ' . $last_name;
            
            foreach( $results as $result )
            {
                if( strtolower( $result->store ) === $store && $result->advisor == $advisor)
                {
                    $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
                }
            }
        }
    }
    
    //now add our managers
    $user = wp_get_current_user();
    $id = $user->ID;
    $user_info = get_userdata( $id );
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    
    $advisor = $first_name . ' ' . $last_name;
    
    foreach( $results as $result )
    {
        if( strtolower( $result->store ) === $store && $result->advisor == $advisor)
        {
            $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        }
    }
    
    return $employees;
}

function fc_get_average_users( $location )
{
    $store = $location;
    
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
    
    return $employees;
}

function fc_get_tariff_mrc($tariff) {
    global $wpdb;
    
    $tariffs = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_multiplier_tariffs WHERE tariff = '" . $tariff . "'" ) );
    
    foreach($tariffs as $tariff) {
        $mrc = $tariff->new_price;
    }
    
    return $mrc;
}

function fc_get_data_tariff_mrc($tariff) {
    global $wpdb;
    
    $tariffs = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_tariffs WHERE tariff = '" . $tariff . "'" ) );
    
    foreach($tariffs as $tariff) {
        $mrc = $tariff->mrc;
    }
    
    return $mrc;
}