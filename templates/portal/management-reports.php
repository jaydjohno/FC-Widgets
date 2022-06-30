<?php

global $wpdb;

$locations = array();

$month = date('F');
                    
$year = date('Y');
    
$day = date("d");

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

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

if( $user && in_array( 'store_manager', $user->roles ) )
{
    $store_location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
}
if( $user && in_array( 'senior_advisor', $user->roles ) )
{
    $store_location = esc_attr( get_user_meta( $user->ID, 'store_location' , true ) );
}

//get our profit info
        
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE()" ) );

foreach ( $results as $result )
{
    foreach ( $locations as $location )
    {
        if( $result->store == $location )
        {
            $store_day_profit = floatval( $store_day_profit ) + floatval( $result->total_profit );
            $profit_day[ $location ] = $store_day_profit;
        }
    }
}

//get all our top sales
if( $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) )
{
    $top_devices = $wpdb->get_results( $wpdb->prepare( "SELECT device, COUNT(*) as `counter` FROM wp_fc_sales_info WHERE device <> '' AND device IS NOT NULL AND store = '" . $store_location . "' AND month = '" . $month . "' AND year = '" . $year . "' GROUP BY device ORDER BY count(*) DESC LIMIT 5 " ) ); 

    $top_tariffs = $wpdb->get_results( $wpdb->prepare( "SELECT tariff, COUNT(*) as `counter` FROM wp_fc_sales_info WHERE tariff <> '' AND tariff IS NOT NULL AND store = '" . $store_location . "' AND month = '" . $month . "' AND year = '" . $year . "' GROUP BY tariff ORDER BY count(*) DESC LIMIT 5 " ) ); 

    $top_accessories = $wpdb->get_results( $wpdb->prepare( "SELECT accessory, COUNT(*) as `counter` FROM wp_fc_sales_info WHERE accessory <> '' AND accessory IS NOT NULL AND store = '" . $store_location . "' AND month = '" . $month . "' AND year = '" . $year . "'  GROUP BY accessory ORDER BY count(*) DESC LIMIT 5 " ) );
}
elseif( $user && in_array( 'multi_manager', $user->roles ) )
{
    foreach ( $multi_locations as $location )
    {
        $device_result = $wpdb->get_results( $wpdb->prepare( "SELECT device, COUNT(*) as `counter` FROM wp_fc_sales_info WHERE device <> '' AND device IS NOT NULL AND store = '" . $location . "' AND month = '" . $month . "' AND year = '" . $year . "' GROUP BY device ORDER BY count(*) DESC LIMIT 5 " ) );
        $top_devices[ $location ] = $device_result;
        
        $tariff_result = $wpdb->get_results( $wpdb->prepare( "SELECT tariff, COUNT(*) as `counter` FROM wp_fc_sales_info WHERE tariff <> '' AND tariff IS NOT NULL AND store = '" . $location . "' AND month = '" . $month . "' AND year = '" . $year . "' GROUP BY tariff ORDER BY count(*) DESC LIMIT 5 " , $location ) );
        $top_tariffs[ $location ] = $tariff_result;

        $accessory_result = $wpdb->get_results( $wpdb->prepare( "SELECT accessory, COUNT(*) as `counter` FROM wp_fc_sales_info WHERE accessory <> '' AND accessory IS NOT NULL AND store = '" . $location . "' AND month = '" . $month . "' AND year = '" . $year . "' GROUP BY accessory ORDER BY count(*) DESC LIMIT 5 " , $location ) );
        $top_accessories[ $location ] = $accessory_result;
    }
}

//get our monthly info
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

//get our daily info
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE()" ) );

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

//get our totals

$daily_profit_total = 0;
$daily_accessory_total = 0;

$month_profit_total = 0;
$month_projected_total = 0;
$month_accessory_total = 0;

$total_profit_target = 0;

foreach ( $locations as $location )
{
    //daily first
    $daily_profit_total = floatval( $daily_profit_total ) + floatval( $profit_daily[ $location ] );
    $daily_accessory_total = floatval( $daily_accessory_total ) + floatval( $accessory_profit_daily[ $location ] );
    
    //now monthly     
    $month_profit_total = floatval( $month_profit_total ) + floatval( $profit_month[ $location ] );
    
    $month_accessory_total = floatval( $month_accessory_total ) + floatval( $accessory_profit_month[ $location ] );
    
    //get our total profit target
    $total_profit_target = floatval( $total_profit_target ) + $store_profit_target[ $location ];
}

//get our sales info

$all_new_total = 0;
$all_upgrade_total = 0;
$new_handsets_total = 0;
$new_broadband_total = 0;
$upgrade_broadband_total = 0;
$insurance_total = 0;
$new_simo_total = 0;
$hrc_total = 0;

//daily first
foreach( $locations as $location )
{
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store='" . $location . "'" . " AND DATE( `sale_date` ) = CURDATE() " ) );
    
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
            if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                $hrc += floatval(fc_get_data_tariff_mrc($result->tariff));
                $hrc_total += floatval(fc_get_data_tariff_mrc($result->tariff));
            } else {
                $hrc += floatval(fc_get_tariff_mrc($result->tariff));
                $hrc_total += floatval(fc_get_tariff_mrc($result->tariff));
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

//now our monthly
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
        
        if( $result->type == 'new' && $result->product_type == 'homebroadband')
        {
            //this is all our home broadband upgrades
            $new_bt++;
            
            //our profits
            $new_bt_profit_store += $result->total_profit;
        }
        
        if( $result->type == 'new' && $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' )
        {
            //this is all our new simonly connections
            $new_connected++;
            
            //our profits
            $new_data_profit_store += $result->total_profit;
        }
        
        if( $result->product_type == 'connected' || $result->type == 'new' && $result->product_type == 'tablet' || $result->type == 'upgrade' && $result->product_type == 'connected' || $result->type == 'upgrade' && $result->product_type == 'tablet' )
        {
            if($result->product_type == 'connected' || $result->product_type == 'tablet' ) {
                $hrc += floatval(fc_get_data_tariff_mrc($result->tariff));
                $hrc_total += floatval(fc_get_data_tariff_mrc($result->tariff));
            } else {
                $hrc += floatval(fc_get_tariff_mrc($result->tariff));
                $hrc_total += floatval(fc_get_tariff_mrc($result->tariff));
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

$total_monthly_all_new_sales = $all_new_total;    
$total_monthly_all_upgrade_sales = $all_upgrade_total;
$total_monthly_new_handset_sales = $new_handsets_total;
$total_monthly_new_broadband_sales = $new_broadband_total;
$total_monthly_upgrade_broadband_sales = $upgrade_broadband_total;
$total_monthly_insurance_sales = $insurance_total;
$total_monthly_new_simo_sales = $new_simo_total;
$total_monthly_hrc_sales = $hrc_total;

//get our staff average profits
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
            
            if( $result->type == 'new' && $result->product_type == 'homebroadband')
            {
                //this is all our new BT
                $new_bt++;
                
                //our profits
                $new_bt_profit_employee += $result->total_profit;
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

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info LIMIT 1" ) );

foreach ( $results as $result )
{
    $date = $result->sale_date;
}

//get our start point based on our first sale and get first day of month
$start = new DateTime( $date );
$start->modify( 'first day of this month' );

//get our current date and the first date of this month
$end = new DateTime( 'now' );
$end->modify( 'last day of this month' );

//now set our parameters
$interval = DateInterval::createFromDateString( '1 month' );
$period   = new DatePeriod( $start , $interval , $end );

$time = new DateTime('now');
$today = $time->format('Y-m-d');
$min = $start->format('Y-m-d');

//load our charts files
wp_enqueue_style( 'fc-charts' );

$data = implode( "," , $locations );

if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) || $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) )
{
    ?>
    <h3 class="spacer text-center">Store Daily Information</h3>
    
    <p class="form-row validate-required spacer" id="daily_info_date_field" data-priority="">
        <label for="daily_info_date" class="">Choose Day&nbsp;<abbr class="required" title="required">*</abbr></label>
        <span class="woocommerce-input-wrapper">
            <input type="date" class="input-text " name="daily_info_date" id="daily_info_date" placeholder="" value="<?php echo esc_attr( $today ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $today ); ?>" aria-describedby="daily-sale-chart-description" autocomplete="off">
        </span>
    </p>
    
    <script>
        jQuery( '#daily_info_date' ).blur( function() 
        {
            var date = jQuery( this ).val();
            
            var data = {};
        
            data['action'] = 'fc_get_daily_chart';
            data['nonce'] = fc_nonce;
            data[ 'date' ] = date;
        
            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                        
                },
            });
        });
    
        jQuery( '#daily_info_date' ).change( function() 
        {
            var date = jQuery( this ).val();
            
            if( date !== '' )
            {
                var data = {};
            
                data['action'] = 'fc_get_daily_chart';
                data['nonce'] = fc_nonce;
                data[ 'date' ] = date;
            
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( '.daily-sales-chart' ).html( data );
                    },
                });
            }
        });
    </script>

    <div class="col-md-12 daily-sales-chart table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-md-1">Store</th>
                    <th class="col-md-1">Total New</th>
                    <th class="col-md-1">New H/S</th>
                    <th class="col-md-1">Upgrades</th>
                    <th class="col-md-1">New HBB</th>
                    <th class="col-md-1">Regrade HBB</th>
                    <th class="col-md-1">SIMO New</th>
                    <th class="col-md-1">Insurance</th>
                    <th class="col-md-1">Data Value</th>
                    <th class="col-md-1">ACC Profit</th>
                    <th class="col-md-1">Total Profit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ( $locations as $location )
                {
                    ?>
                    <tr>
                    <td><?php echo $location; ?></td>
                    <td><?php echo $daily_all_new_sales[ $location ]; ?></td>
                    <td><?php echo $daily_new_handset_sales[ $location ]; ?></td>
                    <td><?php echo $daily_all_upgrade_sales[ $location ]; ?></td>
                    <td><?php echo $daily_new_broadband_sales[ $location ]; ?></td>
                    <td><?php echo $daily_upgrade_broadband_sales[ $location ]; ?></td>
                    <td><?php echo $daily_new_simo_sales[ $location ]; ?></td>
                    <td><?php echo $daily_insurance_sales[ $location ]; ?></td>
                    <td><?php echo '£' . $daily_hrc_sales[ $location ]; ?></td>
                    
                    <?php
                    if( $accessory_profit_daily[ $location ] == '' )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $accessory_profit_daily[ $location ] , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php
                    if( $profit_daily[ $location ] == '' )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $profit_daily[ $location ] , 2, '.', ',') . '</td>';
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
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td><?php echo $total_daily_all_new_sales; ?></td>
                    <td><?php echo $total_daily_new_handset_sales; ?></td>
                    <td><?php echo $total_daily_all_upgrade_sales; ?></td>
                    <td><?php echo $total_daily_new_broadband_sales; ?></td>
                    <td><?php echo $total_daily_upgrade_broadband_sales; ?></td>
                    <td><?php echo $total_daily_new_simo_sales; ?></td>
                    <td><?php echo $total_daily_insurance_sales; ?></td>
                    <td><?php echo $total_daily_hrc_sales; ?></td>
                    
                    <?php 
                    if( $daily_accessory_total == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $daily_accessory_total , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php 
                    if( $daily_profit_total == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $daily_profit_total , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                </tr>
            </tbody>
        </table>
    </div>
    
    <h3 class="spacer text-center">Store Monthly Information</h3>
    
    <p class="form-row wps-drop spacer" id="info_date" data-priority="" ><label for="info_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="info_dates" class="info_dates" autocomplete="off" required>
                <option value="">Select Date to View Other Months Reports</option>
                <?php
                    foreach ( $period as $dt ) 
                    {       
                        ?>
                        <option value="<?php echo $dt->format("F Y"); ?>"><?php echo $dt->format("F Y"); ?></option>';
                        <?php
                    }
                ?>
            </select>
        </span>
    </p>
    
    <script>
        jQuery( document ).ready(function() 
        {
            jQuery(".info_dates").select2(
    		{
                width: '100%',
            });
            
            jQuery( '.info_dates' ).val( '<?php echo $end->format("F Y"); ?>' ); 
            jQuery( '#info_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
            jQuery( '#info_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
        });
        
        jQuery( '.info_dates' ).change(function() 
        {
            var date = jQuery( this ).val();
            
            if( date !== '' )
            {
                var data = {};
            
                data['action'] = 'fc_get_monthly_chart';
                data['nonce'] = fc_nonce;
                data[ 'date' ] = date;
            
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( '.monthly-sales-chart' ).html( data );
                    },
                });
            }
        });
    </script>
    
    <div class="col-md-12 monthly-sales-chart table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-md-1">Store</th>
                    <th class="col-md-1">Total New</th>
                    <th class="col-md-1">New H/S</th>
                    <th class="col-md-1">Upgrades</th>
                    <th class="col-md-1">New HBB</th>
                    <th class="col-md-1">Regrade HBB</th>
                    <th class="col-md-1">SIMO New</th>
                    <th class="col-md-1">Insurance</th>
                    <th class="col-md-1">Data Value</th>
                    <th class="col-md-1">ACC Profit</th>
                    <th class="col-md-1">Total Profit</th>
                    <th class="col-md-1">Projected Monthly Profit</th>
                    <th class="col-md-1">Profit Target</th>
                    <th class="col-md-1">Variation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ( $locations as $location )
                {
                    ?>
                    <tr>
                    <td><?php echo $location; ?></td>
                    <td><?php echo $monthly_all_new_sales[ $location ]; ?></td>
                    <td><?php echo $monthly_new_handset_sales[ $location ]; ?></td>
                    <td><?php echo $monthly_all_upgrade_sales[ $location ]; ?></td>
                    <td><?php echo $monthly_new_broadband_sales[ $location ]; ?></td>
                    <td><?php echo $monthly_upgrade_broadband_sales[ $location ]; ?></td>
                    <td><?php echo $monthly_new_simo_sales[ $location ]; ?></td>
                    <td><?php echo $monthly_insurance_sales[ $location ]; ?></td>
                    <td><?php echo '£' . $monthly_hrc_sales[ $location ]; ?></td>
                    
                    <?php
                    if( $accessory_profit_month[ $location ] == '' )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $accessory_profit_month[ $location ] , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php
                    if( $profit_month[ $location ] == '' )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $profit_month[ $location ] , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php
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
                    ?>
                    
                    <?php
                    if( $store_profit_target[ $location ] == '' )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $store_profit_target[ $location ] , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php
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
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                    <td class="blank-row"></td>
                </tr>
                
                <tr>
                    <th>Total</th>
                    <td><?php echo $total_monthly_all_new_sales; ?></td>
                    <td><?php echo $total_monthly_new_handset_sales; ?></td>
                    <td><?php echo $total_monthly_all_upgrade_sales; ?></td>
                    <td><?php echo $total_monthly_new_broadband_sales; ?></td>
                    <td><?php echo $total_monthly_upgrade_broadband_sales; ?></td>
                    <td><?php echo $total_monthly_new_simo_sales; ?></td>
                    <td><?php echo $total_monthly_insurance_sales; ?></td>
                    <td><?php echo $total_monthly_hrc_sales; ?></td>
                    
                    <?php 
                    if( $month_accessory_total == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $month_accessory_total , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php 
                    if( $month_profit_total == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $month_profit_total , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php 
                    if( $month_projected_total == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $month_projected_total , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    
                    <?php 
                    if( $total_profit_target == 0 )
                    {
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td>£' . number_format( $total_profit_target , 2, '.', ',') . '</td>';
                    }
                    ?>
                    
                    <?php
                    
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
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
    
    <?php
}

if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) || $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) )
{
?>
    <div class="col-md-12 spacer">
        <div class="row">
            <h3 class="text-center">Store Profits</h3>
            <div class="col-md-6"><canvas id="daily_profits" width="400" height="400"></canvas></div>
    
            <div class="col-md-6"><canvas id="monthly_profits" width="400" height="400"></canvas></div>
            
            <div class = "col-md-12">
                <h3 class="spacer text-center">Average Profits</h3>
                
                <p class="form-row wps-drop spacer" id="average_date" data-priority="" ><label for="average_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
                    <span class="woocommerce-input-wrapper">
                        <select name="average_dates" class="average_dates" autocomplete="off" required>
                            <option value="">Select Date to View Other Months Averages</option>
                            <?php
                                foreach ( $period as $dt ) 
                                {       
                                    ?>
                                    <option value="<?php echo $dt->format("F Y"); ?>"><?php echo $dt->format("F Y"); ?></option>';
                                    <?php
                                }
                            ?>
                        </select>
                    </span>
                </p>
        
                <script>
                    jQuery( document ).ready(function() 
                    {
                        jQuery(".average_dates").select2(
                		{
                            width: '100%',
                        });
                        
                        jQuery( '.average_dates' ).val( '<?php echo $end->format("F Y"); ?>' ); 
                        jQuery( '#average_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
                        jQuery( '#average_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
                    });
                    
                    jQuery( '.average_dates' ).change(function() 
                    {
                        var date = jQuery( this ).val();
                        
                        if( date !== '' )
                        {
                            var data = {};
                        
                            data['action'] = 'fc_get_average_profits';
                            data['nonce'] = fc_nonce;
                            data[ 'date' ] = date;
                            
                            <?php
                            if( $user && in_array( 'senior_manager', $user->roles ) )
                            {
                            ?>
                                data[ 'type' ] = 'senior';
                            <?php
                            }
                            elseif( $user && in_array( 'multi_manager', $user->roles ) )
                            {
                            ?>
                                data[ 'type' ] = 'senior';
                            <?php
                            }
                            else
                            {
                            ?>
                                data[ 'type' ] = 'senior';
                            <?php
                            }
                            ?>
                        
                            jQuery.ajax({
                                type: 'POST',
                                url: fc_ajax_url,
                                data: data,
                                success: function( data ) 
                                {   
                                    jQuery( '.average-dates-chart' ).html( data );
                                },
                            });
                        }
                    });
                </script>
                
                <div class="col-md-12 average-dates-chart table-responsive">
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
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <?php
            if( $user && in_array( 'multi_manager', $user->roles ) || $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) )
            {
                ?>
                <div class = "col-md-12">
                    <h3 class="spacer text-center">Staff Average Profits</h3>
                    
                    <p class="form-row wps-drop spacer" id="staff_average_date" data-priority="" ><label for="staff_average_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
                        <span class="woocommerce-input-wrapper">
                            <select name="staff_average_dates" class="staff_average_dates" autocomplete="off" required>
                                <option value="">Select Date to View Other Months Averages</option>
                                <?php
                                    foreach ( $period as $dt ) 
                                    {       
                                        ?>
                                        <option value="<?php echo $dt->format("F Y"); ?>"><?php echo $dt->format("F Y"); ?></option>';
                                        <?php
                                    }
                                ?>
                            </select>
                        </span>
                    </p>
            
                    <script>
                        jQuery( document ).ready(function() 
                        {
                            jQuery(".staff_average_dates").select2(
                    		{
                                width: '100%',
                            });
                            
                            jQuery( '.staff_average_dates' ).val( '<?php echo $end->format("F Y"); ?>' ); 
                            jQuery( '#staff_average_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
                            jQuery( '#staff_average_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
                        });
                        
                        jQuery( '.staff_average_dates' ).change(function() 
                        {
                            var date = jQuery( this ).val();
                            
                            if( date !== '' )
                            {
                                var data = {};
                            
                                data['action'] = 'fc_get_staff_average_profits';
                                data['nonce'] = fc_nonce;
                                data[ 'date' ] = date;
                                
                                <?php
                                if( $user && in_array( 'multi_manager', $user->roles ) )
                                {
                                ?>
                                    data[ 'type' ] = 'multi';
                                <?php
                                }
                                else
                                {
                                ?>
                                    data[ 'type' ] = 'store';
                                <?php
                                }
                                ?>
                            
                                jQuery.ajax({
                                    type: 'POST',
                                    url: fc_ajax_url,
                                    data: data,
                                    success: function( data ) 
                                    {   
                                        jQuery( '.staff-average-dates-chart' ).html( data );
                                    },
                                });
                            }
                        });
                    </script>
                    
                    <div class="col-md-12 staff-average-dates-chart table-responsive">
                        <?php
                        if( $user && in_array( 'multi_manager', $user->roles ) )
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
                        elseif( $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) )
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
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    
    <h3 class="text-center">Discount Pots</h3>
    
    <p class="form-row wps-drop spacer" id="discount_date" data-priority="" ><label for="discount_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
    	<span class="woocommerce-input-wrapper">
    		<select name="discount_dates" class="discount_dates" autocomplete="off" required>
    			<option value="">Select Date to View Other Months Discount Pots</option>
    			<?php
    				foreach ( $period as $dt ) 
    				{       
    					?>
    					<option value="<?php echo $dt->format("F Y"); ?>"><?php echo $dt->format("F Y"); ?></option>';
    					<?php
    				}
    			?>
    		</select>
    	</span>
    </p>
    
    <script>
    	jQuery( document ).ready(function() 
    	{
    		jQuery(".discount_dates").select2(
    		{
    			width: '100%',
    		});
    		
    		jQuery( '.discount_dates' ).val( '<?php echo $end->format("F Y"); ?>' ); 
    		jQuery( '#discount_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
    		jQuery( '#discount_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
    	});
    	
    	jQuery( '.discount_dates' ).change(function() 
    	{
    		var date = jQuery( this ).val();
    		
    		if( date !== '' )
    		{
    			var data = {};
    		
    			data['action'] = 'fc_get_discount_pot_table';
    			data['nonce'] = fc_nonce;
    			data[ 'date' ] = date;
    		
    			jQuery.ajax({
    				type: 'POST',
    				url: fc_ajax_url,
    				data: data,
    				success: function( data ) 
    				{   
    					jQuery( '.discount-pots' ).html( data );
    				},
    			});
    		}
    	});
    </script>
    
    <div class="col-md-12 spacer discount-pots table-responsive">
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
    </div>
    
    <?php
    if( $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) )
    {
        ?>
        <div class="col-md-12 spacer">
            <div class="row">
                <h3 class="text-center">Top Products</h3>
                <div class="col-md-12" style="margin:20px"><canvas id="top_devices" width="400" height="400"></canvas></div>
        
                <div class="col-md-12" style="margin:20px"><canvas id="top_tariffs" width="400" height="400"></canvas></div>
                
                <div class="col-md-12" style="margin:20px"><canvas id="top_accessories" width="400" height="400"></canvas></div>
            </div>
        </div>
        <?php
    }
    elseif( $user && in_array( 'multi_manager', $user->roles ) )
    {
        foreach ( $multi_locations as $location )
        {
            ?>
            <div class="col-md-12 spacer">
                <div class="row">
                    <h3 class="text-center"><?php echo $location; ?> Top Products</h3>
                    <?php $location = strtolower( $location ); ?>
                    
                    <div class="col-md-12" style="margin:20px"><canvas id="<?php echo $location; ?>_top_devices" width="400" height="400"></canvas></div>
            
                    <div class="col-md-12" style="margin:20px"><canvas id="<?php echo $location; ?>_top_tariffs" width="400" height="400"></canvas></div>
                    
                    <div class="col-md-12" style="margin:20px"><canvas id="<?php echo $location; ?>_top_accessories" width="400" height="400"></canvas></div>
                </div>
            </div>
        <?php
        }
    }
    ?>
    
    <script>
        var dpc = document.getElementById( 'daily_profits' );
        var daily_profit_chart = new Chart(dpc, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    foreach ( $locations as $location )
                    {
                        echo "'" . $location . "',";
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Store Daily Profit',
                    data: [
                        <?php
                        foreach ( $locations as $location )
                        {
                            $key = $location;
                            echo "'" . $profit_daily[ $key ] . "',";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 0, 0, 0.2)',
                        'rgba(255, 165, 0, 0.2)',
                        'rgba(255, 255, 0, 0.2)',
                        'rgba(0, 128, 0, 0.2)',
                        'rgba(0, 0, 255, 0.2)',
                        'rgba(75, 0, 130, 0.2)',
                        'rgba(238, 130, 238, 0.2)',
                        'rgba(47, 203, 231, 0.2)',
                        'rgba(115, 131, 186, 0.2)',
                        'rgba(224, 120, 62, 0.2)',
                        'rgba(230, 109, 136, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 0, 0, 1)',
                        'rgba(255, 165, 0, 1)',
                        'rgba(255, 255, 0, 1)',
                        'rgba(0, 128, 0, 1)',
                        'rgba(0, 0, 255, 1)',
                        'rgba(75, 0, 130, 1)',
                        'rgba(238, 130, 238, 1)',
                        'rgba(47, 203, 231, 1)',
                        'rgba(115, 131, 186, 1)',
                        'rgba(224, 120, 62, 1)',
                        'rgba(230, 109, 136, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                maintainAspectRatio: true,
                responsive: true
            }
        });
        
        var mpc = document.getElementById( 'monthly_profits' );
        var monthly_profit_chart = new Chart(mpc, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    foreach ( $locations as $location )
                    {
                        echo "'" . $location . "',";
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Store Monthly Profit',
                    data: [
                        <?php
                        foreach ( $locations as $location )
                        {
                            $key = $location;
                            echo "'" . $profit_month[$key] . "',";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 0, 0, 0.2)',
                        'rgba(255, 165, 0, 0.2)',
                        'rgba(255, 255, 0, 0.2)',
                        'rgba(0, 128, 0, 0.2)',
                        'rgba(0, 0, 255, 0.2)',
                        'rgba(75, 0, 130, 0.2)',
                        'rgba(238, 130, 238, 0.2)',
                        'rgba(47, 203, 231, 0.2)',
                        'rgba(115, 131, 186, 0.2)',
                        'rgba(224, 120, 62, 0.2)',
                        'rgba(230, 109, 136, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 0, 0, 1)',
                        'rgba(255, 165, 0, 1)',
                        'rgba(255, 255, 0, 1)',
                        'rgba(0, 128, 0, 1)',
                        'rgba(0, 0, 255, 1)',
                        'rgba(75, 0, 130, 1)',
                        'rgba(238, 130, 238, 1)',
                        'rgba(47, 203, 231, 1)',
                        'rgba(115, 131, 186, 1)',
                        'rgba(224, 120, 62, 1)',
                        'rgba(230, 109, 136, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                maintainAspectRatio: true,
                responsive: true
            }
        });
    </script>
    
    <?php
    if( $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'senior_advisor', $user->roles ) )
    {
        ?>
        <script>
            var topdevice = document.getElementById( 'top_devices' );
            var top_device_chart = new Chart(topdevice, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        foreach( $top_devices as $result ) 
                        {
                            echo "'" . $result->device . "',";
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'Most Sold Devices',
                        data: [
                            <?php
                            foreach( $top_devices as $result ) 
                            {
                                echo "'" . $result->counter . "',";
                            }
                            ?>
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
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
            
            var toptariff = document.getElementById( 'top_tariffs' );
            var top_tariff_chart = new Chart(toptariff, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        foreach( $top_tariffs as $result ) 
                        {
                            echo "'" . $result->tariff . "',";
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'Most Sold Tariffs',
                        data: [
                            <?php
                            foreach( $top_tariffs as $result ) 
                            {
                                echo "'" . $result->counter . "',";
                            }
                            ?>
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
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
            
            var topaccessory = document.getElementById( 'top_accessories' );
            var top_accessory_chart = new Chart(topaccessory, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        foreach( $top_accessories as $result ) 
                        {
                            echo "'" . $result->accessory . "',";
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'Most Sold Accessories',
                        data: [
                            <?php
                            foreach( $top_accessories as $result ) 
                            {
                                echo "'" . $result->counter . "',";
                            }
                            ?>
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
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
        </script>
        <?php
    }
    elseif( $user && in_array( 'multi_manager', $user->roles ) )
    {
        foreach ( $multi_locations as $location )
        {
            $data = $location;
            $location = strtolower( $location );
            ?>
            <script>
                var <?php echo $location;?>topdevice = document.getElementById( '<?php echo $location; ?>_top_devices' );
                var <?php echo $location; ?>_top_device_chart = new Chart(<?php echo $location; ?>topdevice, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php
                            $device = array();
        
                            $device = $top_devices[ $data ];
                            
                            foreach ( $device as $d )
                            {
                                echo "'" . $d->device . "',";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Most Sold Devices',
                            data: [
                                <?php
                                $count = array();
        
                                $count = $top_devices[ $data ];
                                
                                foreach ( $count as $c )
                                {
                                    echo "'" . $c->counter . "',";
                                }
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                
                var <?php echo $location; ?>toptariff = document.getElementById( '<?php echo $location; ?>_top_tariffs' );
                var <?php echo $location; ?>_top_tariff_chart = new Chart(<?php echo $location; ?>toptariff, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php
                            $tariff = array();
        
                            $tariff = $top_tariffs[ $data ];
                            
                            foreach ( $tariff as $t )
                            {
                                echo "'" . $t->tariff . "',";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Most Sold Tariffs',
                            data: [
                                <?php
                                $count = array();
        
                                $count = $top_tariffs[ $data ];
                                
                                foreach ( $count as $c )
                                {
                                    echo "'" . $c->counter . "',";
                                }
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                
                var <?php echo $location; ?>topaccessory = document.getElementById( '<?php echo $location; ?>_top_accessories' );
                var <?php echo $location; ?>_top_accessory_chart = new Chart(<?php echo $location; ?>topaccessory, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php
                            $accessory = array();
        
                            $accessory = $top_accessories[ $data ];
                            
                            foreach ( $accessory as $a )
                            {
                                echo "'" . $a->accessory . "',";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Most Sold Accessories',
                            data: [
                                <?php
                                $count = array();
        
                                $count = $top_accessories[ $data ];
                                
                                foreach ( $count as $c )
                                {
                                    echo "'" . $c->counter . "',";
                                }
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
            </script>
        <?php
        }
    }
}
