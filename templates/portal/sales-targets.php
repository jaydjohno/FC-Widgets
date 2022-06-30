<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$days = date('t');

$currentDay = intval( date( 'd' ) );

$user = wp_get_current_user();

$id = $user->ID;
$user_info = get_userdata( $id );
$first_name = $user_info->first_name;
$last_name = $user_info->last_name;
$full_name = $first_name . ' ' . $last_name;

//get footfall data
$store = esc_attr( get_user_meta( $user->ID, 'store_location' , true ) );

if(strtotime("now") < strtotime("1 May 2021"))
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
                $store_footfall = $result->footfall;
                $average_footfall = $result->average_footfall;
                $predicted_footfall = $result->predicted_footfall;
            }
        }
    }
    
    //get our targets
    $tnc = ( 6 / 100 ) * $predicted_footfall;
    $nhc = ( 3 / 100 ) * $predicted_footfall;
    $tuc = ( 11 / 100 ) * $predicted_footfall;
    $nhb = ( 1 / 100 ) * $predicted_footfall;
    $uhb = ( 1 / 100 ) * $predicted_footfall;
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

//get our staffs sales for the current month
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $full_name . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) ); 

if(strtotime("now") < strtotime("1 May 2021"))
{
    //update our targets for the advisors
    $advisor_tnc = ceil( ( $tnc / $total ) * $hours );
    $advisor_nhc = ceil( ( $nhc / $total ) * $hours );
    $advisor_tuc = ceil( ( $tuc / $total ) * $hours );
    $advisor_nhb = ceil( ( $nhb / $total ) * $hours );
    $advisor_uhb = ceil( ( $uhb / $total ) * $hours );
    
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
            $total_broadband_sales++;
            
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
            
            $accessories_profit = floatval( $accessories_profit ) + floatval( $result->accessory_profit );
        }
        
        $advisor_profit = floatval( $advisor_profit ) + floatval( $result->total_profit );
    }
    
    $insurance_percentage = ( intval( $insurance_sale ) / intval( $total_insurance_sales ) ) * 100;
    
    $bt_tv_percentage = ( intval( $bt_tv_sales ) / intval( $total_broadband_sales ) ) * 100;
    
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
    
    $profit_percentage = ceil( ( $advisor_profit / $advisor_profit_target ) * 100 );
    $tnc_percentage = ceil( ( $all_new / $advisor_tnc ) * 100 );
    $nhc_percentage = ceil( ( $new_handsets / $advisor_nhc ) * 100 );
    $tuc_percentage = ceil( ( $all_upgrade / $advisor_tuc ) * 100 );
    $nhb_percentage = ceil( ( $new_broadband / $advisor_nhb ) * 100 );
    $uhb_percentage = ceil( ( $upgrade_broadband / $advisor_uhb ) * 100 );
}
else
{
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
}
?>

<p>Welcome <?php echo $user->display_name; ?></p>

<p>On this page you will see the sales targets that your manager has set for you and also how close you are to your current target.</p>

<?php

if( $hours == '' )
{
    echo '<br/><p style="color:red;">Your Manager has not entered your monthly hours, these are required to see your store targets, please try again later</p>';
}
else
{
    if(strtotime("now") < strtotime("1 May 2021"))
    {
    ?>
        <div class="col-md-12 spacer table-responsive">
            <div class="row">
                <h4 class="text-center"><?php echo $month ?> Targets</h4>
                
                <table class="table spacer">
                    <thead>
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
                            <td><?php echo $bt_tv_percentage . '%'; ?></td>
                        </tr>
                        <tr>
                            <td>Total Insurance Sales</td>
                            <td>30%</td>
                            <td><?php echo $insurance_percentage . '%'; ?></td>
                            <td><?php echo $insurance_percentage . '%'; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
    else 
    {
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
            
            if(!$nps_met && !overrideNPS) {
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
                $avdisor_profit_colour = 'green';
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
                
                if(!$nps_met && !overrideNPS) {
                    $advisor_profit_bonus = number_format( (60 / 100 ) * $advisor_profit_bonus, 2, '.', '');
                }
            }
        }
    } 
    ?>
    <h4 class="text-center"><?php echo $month ?> Targets</h4>
    
    <div class="container-fluid spacer table-responsive">
        <div class="row">
            <?php if(strtotime("now") < strtotime("1 July 2021"))
            { ?>
                <table class="table spacer">
                    <thead>
                        <tr>
                            <th class="col-md-1 blank-row"></th>
                            <th class="col-md-2"></th>
                            <th class="col-md-1">New Handset</th>
                            <th class="col-md-1">New Sim</th>
                            <th class="col-md-1">New / Upgrade Data</th>';
                            <th class="col-md-1">Upgrade Handset</th>
                            <th class="col-md-1">Upgrade Sim / other</th>';
                            <th class="col-md-1">New HBB</th>
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
                            <td style="background-color:<?php echo $new_data_colour; ?>; color:<?php echo $new_data_text; ?>"><?php echo $all_new_data; ?></td>
                            <td style="background-color:<?php echo $upgrade_handset_colour; ?>; color:<?php echo $upgrade_handset_text; ?>"><?php echo $all_upgrade_handset; ?></td>
                            <td style="background-color:<?php echo $upgrade_sim_colour; ?>; color:<?php echo $upgrade_sim_text; ?>"><?php echo $all_upgrade_sim; ?></td>
                            <td style="background-color:<?php echo $bt_colour; ?>; color:<?php echo $bt_text; ?>"><?php echo $all_new_bt; ?></td>
                            <td style="background-color:<?php echo $insurance_colour; ?>; color:<?php echo $insurance_text; ?>"><?php echo $all_insurance; ?></td>
                            <td style="background-color:<?php echo $potential_colour; ?>; color:<?php echo $potential_text; ?>"><?php echo '£' . number_format($all_profit, 2, '.', ''); ?></td>
                            <td class="blank-row"></td>
                        </tr>
                        <tr>
                            <td class="blank-row"></td>
                            <td>Projected</td>
                            <td><?php echo $potential_new_handset; ?></td>
                            <td><?php echo $potential_new_sim; ?></td>
                            <td><?php echo $potential_new_data; ?></td>
                            <td><?php echo $potential_upgrade_handset; ?></td>
                            <td><?php echo $potential_upgrade_sim; ?></td>
                            <td><?php echo $potential_new_bt; ?></td>
                            <td><?php echo $potential_insurance; ?></td>
                            <td><?php echo '£' . number_format($potential_profit_target, 2, '.', ''); ?></td>
                            <td class="blank-row"></td>
                        </tr>
                        <tr>
                            <td class="blank-row"></td>
                            <td>Target</td>
                            <td><?php echo $advisor_new_handset; ?></td>
                            <td><?php echo $advisor_new_sim; ?></td>
                            <td><?php echo $advisor_new_data; ?></td>
                            <td><?php echo $advisor_upgrade_handset; ?></td>
                            <td><?php echo $advisor_upgrade_sim; ?></td>
                            <td><?php echo $advisor_new_bt; ?></td>
                            <td><?php echo $advisor_insurance; ?></td>
                            <td><?php echo '£' . number_format($advisor_profit_target, 2, '.', ''); ?></td>
                            <td class="blank-row"></td>
                        </tr>
                    </tbody>
                </table>
            <?php } else { ?>
                <table class="table spacer">
                    <thead>
                        <tr>
                            <th class="col-md-1 blank-row"></th>
                            <th class="col-md-2"></th>
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
                            <td style="background-color:<?php echo $new_data_colour; ?>; color:<?php echo $new_data_text; ?>">
                                <?php if(strtotime('now') < strtotime("1 March 2022")) {
                                    echo $all_new_data;
                                } else {
                                    echo '£' . $all_new_data;
                                }
                                ?>
                            </td>
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
            </php } ?>
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
                        <td class="col-md-2" style="background-color:<?php echo $avdisor_profit_colour; ?>; color:<?php echo $avdisor_profit_text; ?>"><?php echo '£' . number_format($advisor_profit_bonus, 2, '.', ''); ?></td>
                        <td class="col-md-5 blank-row"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    }
}
?>
