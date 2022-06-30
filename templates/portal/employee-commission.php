<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

//get the name
$id = $user->ID;
$user_info = get_userdata( $id );
$first_name = $user_info->first_name;
$last_name = $user_info->last_name;

$full_name = $first_name . ' ' . $last_name;

//get footfall data
$store = esc_attr( get_user_meta( $user->ID, 'store_location' , true ) );

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
        }
    }
}

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

if( $store_footfall !== '' )
{
    $store_footfall = floatval( $store_footfall );
    $pastdays = floatval( $pastdays );
        
    $average_footfall = ( $store_footfall / $pastdays );
        
    $average_footfall = round( $average_footfall );
        
    //now get our predicted months footfall
    $predicted_footfall = ( $average_footfall * $days );
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

//update our targets for the advisors
$advisor_tnc = ceil( ( $tnc / $total ) * $hours );
$advisor_nhc = ceil( ( $nhc / $total ) * $hours );
$advisor_tuc = ceil( ( $tuc / $total ) * $hours );
$advisor_nhb = ceil( ( $nhb / $total ) * $hours );
$advisor_uhb = ceil( ( $uhb / $total ) * $hours );

//get our staffs sales for the current month
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE advisor = '" . $full_name . "' AND month  = '" . $month . "' AND year = '" . $year . "'" ) ); 

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

//get our KPI Scorecard
$kpi_scorecard = '';

//now lets get our profit target
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_kpi WHERE store = '" . $store . "'" ) );

foreach ($results as $result )
{
    if( $result->month == $month && $result->year == $year )
    {
        $kpi_scorecard = $result->kpi;
    }
}

//work out our commission percentage
$profit_percentage = ceil( ( $advisor_profit / $advisor_profit_target ) * 100 );

$advisor_tnc_commission = ceil( ( $all_new / $advisor_tnc ) * 100 );
$advisor_nhc_commission = ceil( ( $new_handsets / $advisor_nhc ) * 100 );
$advisor_tuc_commission = ceil( ( $all_upgrade / $advisor_tuc ) * 100 );
$advisor_nhb_commission = ceil( ( $new_broadband / $advisor_nhb ) * 100 );
$advisor_uhb_commission = ceil( ( $upgrade_broadband / $advisor_uhb ) * 100 );

//lock our commissions until they have been met
$uhb_commission = false;
$nhb_commission = false;
$tuc_commission = false;
$nhc_commission = false;
$tnc_commission = false;
$profit_target = false;

//lock our stage 2
$stage2 = false;

//lock our stage 2 targets
$bt_tv_commission = false;
$insurance_commission = false;
$kpi_commission = false;

?>
<?php

if( $store_footfall == '' || $hours == '' )
{
    echo '<p>Welcome ' . $user->display_name . '</p>';

    echo '<p>Your Manager has not filled in all the store information yet, please try again later</p>';
}
else
{
    ?>
    <h4 class="text-center spacer">Advisor Commission Scheme</h4>
    
    <p>Welcome <?php echo $user->display_name; ?></p>

    <p>Your commisson is split into two stages, in order to unlock commission for Stage 2 you need to complete all of the requirements in Stage 1</p>
    <p>In order to get the commission in Stage 1, all targets in stage 1 must be met, and all requirements in Stage 2 must be met in order to get Stage 2 commission.</p>
    
    <h4 class="text-center spacer-bottom">Stage 1</h4>
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        	  <th class="col-md-6 text-nowrap">% Total New Target</th>
                        	  <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>140%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>120%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>110%</td>
                          	<td>0.75%</td>
                      	</tr>
                      	<tr>
                          	<td>100%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-md-6 text-nowrap">% New Handset Target</th>
                        	<th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>140%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>120%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>110%</td>
                          	<td>0.75%</td>
                      	</tr>
                      	<tr>
                          	<td>100%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        	 <th class="col-md-6 text-nowrap">% Upgrade Target <nl></th>
                        	 <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>140%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>120%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>110%</td>
                          	<td>0.75%</td>
                      	</tr>
                      	<tr>
                          	<td>100%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        	  <th class="col-md-6 text-nowrap">% New HBB Target</th>
                        	  <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>140%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>120%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>110%</td>
                          	<td>0.75%</td>
                      	</tr>
                      	<tr>
                          	<td>100%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        	  <th class="col-md-6 text-nowrap">% Regrade Target</th>
                        	  <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>140%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>120%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>110%</td>
                          	<td>0.75%</td>
                      	</tr>
                      	<tr>
                          	<td>100%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        	  <th class="col-md-6 text-nowrap">Firstname</th>
                        	  <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>140%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>120%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>110%</td>
                          	<td>0.75%</td>
                      	</tr>
                      	<tr>
                          	<td>100%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
        </div>
    </div>
    
    <h4 class="text-center spacer">Stage 2</h4>
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        	  <th class="col-md-6 text-nowrap">KPI Scorecard Total Score</th>
                        	  <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>3.8</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>3.7</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>3.5</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                         <tr>
                        	  <th class="col-md-6 text-nowrap">Insurance Strike Rate</th>
                        	  <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>40%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>35%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>30%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        	  <th class="col-md-6 text-nowrap">BT TV Sales</th>
                        	  <th class="col-md-6 text-nowrap">% of GP</th>
                      	</tr>
                    </thead>
                    <tbody>
                      	<tr>
                          	<td>40%</td>
                          	<td>1.25%</td>
                      	</tr>
                     	<tr>
                          	<td>35%</td>
                          	<td>1%</td>
                      	</tr>
                      	<tr>
                          	<td>30%</td>
                          	<td>0.5%</td>
                      	</tr>
                  	</tbody>
              	</table>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 spacer">
        <div class="row">
            <h4 class="text-center"><?php echo $month ?> Commission</h4>
            
            <p>You need to ensure you meet the profit target before you can unlock your commission, the commission you gain is a percentage of your profit total</p>
            
            <div class="table-responsive">
                <table class="table spacer">
                    <thead>
                        <tr>
                            <th>Profit Target</th>
                            <th>Actual profit</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo '£' . $advisor_profit_target; ?></td>
                            <td><?php echo '£' . $advisor_profit; ?></td>
                            <?php 
                            if ( $profit_percentage < 90 )
                            {
                                echo '<td><span class="commission-minus">' . $profit_percentage . '%</span></td>';
                            }
                            elseif ( $profit_percentage > 90 && $profit_percentage < 100 )
                            {
                                echo '<td><span class="commission-neutral">' . $profit_percentage . '%</span></td>';
                            }
                            elseif ( $profit_percentage > 100 )
                            {
                                echo '<td><span class="commission-plus">' . $profit_percentage . '%</span></td>';
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
                
                <?php
                
                if( $advisor_profit > $advisor_profit_target )
                {
                    $profit_target = true;
                }
                
                echo '<h4 class="text-center spacer">Stage 1</h4>';
                
                ?>
            
            <div class="table-responsive">
                <table class="table spacer">
                    <thead>
                        <tr>
                            <th class="col-md-3">KPI</th>
                            <th class="col-md-3">Percentage</th>
                            <th class="col-md-3">Achieved</th>
                            <th class="col-md-3">Commission %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total New Connections</td>
                            <?php
                            
                            if( $advisor_tnc_commission < 90 )
                            {
                                echo '<td><span class="commission-minus">' . $advisor_tnc_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_tnc_commission >= 90 && $advisor_tnc_commission < 100 )
                            {
                                echo '<td><span class="commission-neutral">' . $advisor_tnc_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_tnc_commission >= 100 )
                            {
                                $tnc_commission = true;
                                echo '<td><span class="commission-plus">' . $advisor_tnc_commission . '%</span></td>';
                                echo '<td>Yes</td>';
                            }
                            
                            if( $advisor_tnc_commission >= 100 && $advisor_tnc_commission < 110 )
                            {
                                $percentage = 0.5;
                            }
                            elseif( $advisor_tnc_commission >= 110 && $advisor_tnc_commission < 120 )
                            {
                                $percentage = 0.75;
                            }
                            elseif( $advisor_tnc_commission >= 120 && $advisor_tnc_commission < 140 )
                            {
                                $percentage = 1.5;
                            }
                            elseif( $advisor_tnc_commission >= 140 )
                            {
                                $percentage = 2;
                            }
                            else
                            {
                                $percentage = 0;
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                            ?>
                        </tr>
                    
                        <tr>
                            <td>New Handset Connections</td>
                            <?php
                            
                            if( $advisor_nhc_commission < 90 )
                            {
                                echo '<td><span class="commission-minus">' . $advisor_nhc_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_nhc_commission >= 90 && $advisor_nhc_commission < 100 )
                            {
                                echo '<td><span class="commission-neutral>' . $advisor_nhc_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_nhc_commission >= 100 )
                            {
                                $nhc_commission = true;
                                echo '<td><span class="commission-plus">' . $advisor_nhc_commission . '%</span></td>';
                                echo '<td>Yes</td>';
                            }
                            
                            if( $advisor_nhc_commission >= 100 && $advisor_nhc_commission < 110 )
                            {
                                $percentage = 0.5;
                            }
                            elseif( $advisor_nhc_commission >= 110 && $advisor_nhc_commission < 120 )
                            {
                                $percentage = 0.75;
                            }
                            elseif( $advisor_nhc_commission >= 120 && $advisor_nhc_commission < 140 )
                            {
                                $percentage = 1.5;
                            }
                            elseif( $advisor_nhc_commission >= 140 )
                            {
                                $percentage = 2;
                            }
                            else
                            {
                                $percentage = 0;
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                        ?>
                        </tr>
                        
                        <tr>
                            <td>Total Upgrade Connections</td>
                            <?php
                            
                            if( $advisor_tuc_commission < 90 )
                            {
                                echo '<td><span class="commission-minus">' . $advisor_tuc_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_tuc_commission >= 90 && $advisor_tuc_commission < 100 )
                            {
                                echo '<td><span class="commission-neutral">' . $advisor_tuc_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_tuc_commission >= 100 )
                            {
                                $tuc_commission = true;
                                echo '<td><span class="commission-plus">' . $advisor_tuc_commission . '%</span></td>';
                                echo '<td>Yes</td>';
                            }
                            
                            if( $advisor_tuc_commission >= 100 && $advisor_tuc_commission < 110 )
                            {
                                $percentage = 0.5;
                            }
                            elseif( $advisor_tuc_commission >= 110 && $advisor_tuc_commission < 120 )
                            {
                                $percentage = 0.75;
                            }
                            elseif( $advisor_tuc_commission >= 120 && $advisor_tuc_commission < 140 )
                            {
                                $percentage = 1.5;
                            }
                            elseif( $advisor_tuc_commission >= 140 )
                            {
                                $percentage = 2;
                            }
                            else
                            {
                                $percentage = 0;
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                        ?>
                        </tr>
                        
                        <tr>
                            <td>New Home Broadband</td>
                            <?php
                            
                            if( $advisor_nhb_commission < 90 )
                            {
                                echo '<td><span class="commission-minus">' . $advisor_nhb_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_nhb_commission >= 90 && $advisor_nhb_commission < 100 )
                            {
                                echo '<td><span class="commission-neutral">' . $advisor_nhb_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_nhb_commission >= 100 )
                            {
                                $nhb_commission = true;
                                echo '<td><span class="commission-plus">' . $advisor_nhb_commission . '%</span></td>';
                                echo '<td>Yes</td>';
                            }
                            
                            if( $advisor_nhb_commission >= 100 && $advisor_nhb_commission < 110 )
                            {
                                $percentage = 0.5;
                            }
                            elseif( $advisor_nhb_commission >= 110 && $advisor_nhb_commission < 120 )
                            {
                                $percentage = 0.75;
                            }
                            elseif( $advisor_nhb_commission >= 120 && $advisor_nhb_commission < 140 )
                            {
                                $percentage = 1.5;
                            }
                            elseif( $advisor_nhb_commission >= 140 )
                            {
                                $percentage = 2;
                            }
                            else
                            {
                                $percentage = 0;
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                        ?>
                        </tr>
                        
                        <tr>
                            <td>Home Broadband Upgrades</td>
                            <?php
                            
                            if( $advisor_uhb_commission < 90 )
                            {
                                echo '<td><span class="commission-minus">' . $advisor_uhb_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_uhb_commission >= 90 && $advisor_uhb_commission < 100 )
                            {
                                echo '<td><span class="commission-neutral">' . $advisor_uhb_commission . '%</span></td>';
                                echo '<td>No</td>';
                            }
                            else if( $advisor_uhb_commission >= 100 )
                            {
                                $uhb_commission = true;
                                echo '<td><span class="commission-plus">' . $advisor_uhb_commission . '%</span></td>';
                                echo '<td>Yes</td>';
                            }
                            
                            if( $advisor_uhb_commission >= 100 && $advisor_uhb_commission < 110 )
                            {
                                $percentage = 0.5;
                            }
                            elseif( $advisor_uhb_commission >= 110 && $advisor_uhb_commission < 120 )
                            {
                                $percentage = 0.75;
                            }
                            elseif( $advisor_uhb_commission >= 120 && $advisor_uhb_commission < 140 )
                            {
                                $percentage = 1.5;
                            }
                            elseif( $advisor_uhb_commission >= 140 )
                            {
                                $percentage = 2;
                            }
                            else
                            {
                                $percentage = 0;
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                        ?>
                        </tr>
                    <tbody>
                </table>
            </div>
                
                <?php
                
                echo '<h4 class="text-center spacer">Stage 2</h4>';
                
                ?>
            
            <div class="table-responsive">
                <table class="table spacer">
                    <thead>
                        <tr>
                            <th class="col-md-3">KPI</th>
                            <th class="col-md-3">Score</th>
                            <th class="col-md-3">Achieved</th>
                            <th class="col-md-3">Commission %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>KPI Scorecard</td>
                            <?php
                    
                            if( $kpi_scorecard !== '' )
                            {
                                $kpi_scorecard = floatval( $kpi_scorecard );
                                
                                if( $kpi_scorecard < 3.0 )
                                {
                                    echo '<td><span class="commission-minus">' . $kpi_scorecard . '</span></td>';
                                    echo '<td>Yes</td>';
                                }
                                else if( $kpi_scorecard >= 3.0 && $kpi_scorecard < 3.5 )
                                {
                                    echo '<td><span class="commission-neutral">' . $kpi_scorecard . '</span></td>';
                                    echo '<td>Yes</td>';
                                }
                                else if( $kpi_scorecard >= 3.5 )
                                {
                                    $kpi_commission = true;
                                    
                                    echo '<td><span class="commission-plus">' . $kpi_scorecard . '</span></td>';
                                    echo '<td>Yes</td>';
                                }

                                if( $kpi_scorecard >= 3.5 && $kpi_scorecard < 3.7 )
                                {
                                    $percentage = 1;
                                }
                                
                                if( $kpi_scorecard == 3.7 )
                                {
                                    $percentage = 1.5;
                                }
                                
                                if( $kpi_scorecard >= 3.8 )
                                {
                                    $percentage = 2;
                                }
                            }
                            else
                            {
                                $kpi_scorecard = 'No Score yet';
                                echo '<td>' . $kpi_scorecard . '</td>';
                                echo '<td>No Score yet</td>';
                                
                                $percentage = 'No Score Yet';
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-responsive">
                <table class="table spacer">
                    <thead>
                        <tr>
                            <th class="col-md-3">KPI</th>
                            <th class="col-md-3">Percentage</th>
                            <th class="col-md-3">Achieved</th>
                            <th class="col-md-3">Commission %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total Insurance Sales</td>
                            <?php
                            
                            if( $insurance_percentage < 25 )
                            {
                                echo '<td><span class="commission-minus">' . $insurance_percentage . '%</td>';
                                echo '<td>No</td>';
                            }
                            else if( $insurance_percentage >= 25 && $insurance_percentage < 30 )
                            {
                                echo '<td><span class="commission-neutral">' . $insurance_percentage . '%</td>';
                                echo '<td>No</td>';
                            }
                            else if( $insurance_percentage >= 30 )
                            {
                                $insurance_commission = true;
                                
                                echo '<td><span class="commission-plus">' . $insurance_percentage . '%</td>';
                                echo '<td>Yes</td>';
                            }
                            
                            if( $insurance_percentage >= 30 && $insurance_percentage < 35 )
                            {
                                $percentage = 1;
                            }
                                
                            if( $insurance_percentage >= 35 && $insurance_percentage < 40 )
                            {
                                $percentage = 1.5;
                            }
                                
                            if( $insurance_percentage >= 40 )
                            {
                                $percentage = 2;
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                        echo '</tr>';
                        
                        ?>
                        <tr>
                            <td>Total BT TV Sold</td>
                            <?php
                            
                            if( $bt_tv_percentage < 25 )
                            {
                                echo '<td><span class="commission-minus">' . $bt_tv_percentage . '%</td>';
                                echo '<td>No</td>';
                            }
                            else if( $bt_tv_percentage >= 25 && $bt_tv_percentage < 30 )
                            {
                                echo '<td><span class="commission-neutral">' . $bt_tv_percentage . '%</td>';
                                echo '<td>No</td>';
                            }
                            else if( $bt_tv_percentage >= 30 )
                            {
                                $bt_tv_commission = true;
                                
                                echo '<td><span class="commission-plus">' . $bt_tv_percentage . '%</td>';
                                echo '<td>Yes</td>';
                            }
                            
                            if( $bt_tv_percentage >= 30 && $bt_tv_percentage < 35 )
                            {
                                $percentage = 1;
                            }
                                
                            if( $bt_tv_percentage >= 35 && $bt_tv_percentage < 40 )
                            {
                                $percentage = 1.5;
                            }
                                
                            if( $bt_tv_percentage >= 40 )
                            {
                                $percentage = 2;
                            }
                            
                            echo '<td>' . $percentage . '%</td>';
                        echo '</tr>';
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 spacer">
        <div class="row">
            <h4 class="text-center">Commission Earned</h4>
                <?php
                
                echo '<h5 class="text-center spacer">Stage 1</h5>';
                
                if( $uhb_commission && $nhb_commission && $tuc_commission && $nhc_commission && $tnc_commission && $profit_target )
                {
                    $stage2 = true;
                    ?>
                        <p>You have achieved all the Stage 1 criteria</p>
                        
                        <div class="table-responsive">
                        <table class="table spacer">
                            <thead>
                                <tr>
                                    <th class="col-md-6">KPI</th>
                                    <th class="col-md-6">Commission Earned</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total New Connections</td>
                                    <?php
                                    
                                    //work out total new connection commission
                                    if( $advisor_tnc_commission >= 100 && $advisor_tnc_commission < 110 )
                                    {
                                        $tnc_commission_achieved = 0;
                                        $percentage = 0.5;
                                        $tnc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $tnc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_tnc_commission >= 110 && $advisor_tnc_commission < 120 )
                                    {
                                        $tnc_commission_achieved = 0;
                                        $percentage = 0.75;
                                        $tnc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $tnc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_tnc_commission >= 120 && $advisor_tnc_commission < 140 )
                                    {
                                        $tnc_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $tnc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $tnc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_tnc_commission >= 140 )
                                    {
                                        $tnc_commission_achieved = 0;
                                        $percentage = 2;
                                        $tnc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $tnc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else
                                    {
                                        echo '<td></td>';
                                    }
                                echo '</tr>';
                                echo '<tr>';
                                    echo '<td>New Handset Connections</td>';
                        
                                    //work out new handset commission
                                    if( $advisor_nhc_commission >= 100 && $advisor_nhc_commission < 110 )
                                    {
                                        $nhc_commission_achieved = 0;
                                        $percentage = 0.5;
                                        $nhc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $nhc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_nhc_commission >= 110 && $advisor_nhc_commission < 120 )
                                    {
                                        $nhc_commission_achieved = 0;
                                        $percentage = 0.75;
                                        $nhc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $nhc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_nhc_commission >= 120 && $advisor_nhc_commission < 140 )
                                    {
                                        $nhc_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $nhc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $nhc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_nhc_commission > 140 )
                                    {
                                        $nhc_commission_achieved = 0;
                                        $percentage = 2;
                                        $nhc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $nhc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else
                                    {
                                        echo '<td></td>';
                                    }
                                    
                                echo '</tr>';
                                    
                                echo '<tr>';
                                    
                                        echo '<td>Total Upgrade Connections</td>';

                                    //work out our upgrades commission
                                    if( $advisor_tuc_commission >= 100 && $advisor_tuc_commission < 110 )
                                    {
                                        $tuc_commission_achieved = 0;
                                        $percentage = 0.5;
                                        $tuc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $tuc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_tuc_commission >= 110 && $advisor_tuc_commission < 120 )
                                    {
                                        $tuc_commission_achieved = 0;
                                        $percentage = 0.75;
                                        $tuc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $tuc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_tuc_commission >= 120 && $advisor_tuc_commission < 140 )
                                    {
                                        $tuc_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $tuc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $tuc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_tuc_commission >= 140 )
                                    {
                                        $tuc_commission_achieved = 0;
                                        $percentage = 2;
                                        $tuc_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $tuc_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else
                                    {
                                        echo '<td></td>';
                                    }

                                echo '</tr>';

                                echo '<tr>';

                                    echo '<td>New Home Broadband</td>';

                                    //work our out new home broadband commission
                                    if( $advisor_nhb_commission >= 100 && $advisor_nhb_commission < 110 )
                                    {
                                        $nhb_commission_achieved = 0;
                                        $percentage = 0.5;
                                        $nhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $nhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_nhb_commission >= 110 && $advisor_nhb_commission < 120 )
                                    {
                                        $nhb_commission_achieved = 0;
                                        $percentage = 0.75;
                                        $nhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $nhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_nhb_commission >= 120 && $advisor_nhb_commission < 140 )
                                    {
                                        $nhb_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $nhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $nhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_nhb_commission >= 140 )
                                    {
                                        $nhb_commission_achieved = 0;
                                        $percentage = 2;
                                        $nhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $nhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else
                                    {
                                        echo '<td></td>';
                                    }
                                echo '</tr>';

                                echo '<tr>';
                                    echo '<td>Home Broadband Upgrades</td>';

                                    //work out our upgrade broadband commission
                                    if( $advisor_uhb_commission >= 100 && $advisor_uhb_commission < 110 )
                                    {
                                        $uhb_commission_achieved = 0;
                                        $percentage = 0.5;
                                        $uhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $uhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_uhb_commission >= 110 && $advisor_uhb_commission < 120 )
                                    {
                                        $uhb_commission_achieved = 0;
                                        $percentage = 0.75;
                                        $uhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $uhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_uhb_commission >= 120 && $advisor_uhb_commission < 140 )
                                    {
                                        $uhb_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $uhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $uhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $advisor_uhb_commission >= 140 )
                                    {
                                        $uhb_commission_achieved = 0;
                                        $percentage = 2;
                                        $uhb_commission_achieved = ( $advisor_profit / 100 ) * $percentage;

                                        echo '<td>£' . number_format( (float) $uhb_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else
                                    {
                                        echo '<td></td>';
                                    }
                            echo '</tr>';
                        echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                                
                    $total_stage1_commission = 0;
                                
                    $total_stage1_commission = $uhb_commission_achieved + $nhb_commission_achieved + $tuc_commission_achieved + $nhc_commission_achieved + $tnc_commission_achieved;
                                
                    echo '<p>Total Stage 1 Commission: £' . number_format( (float) $total_stage1_commission , 2 , '.' , '' ) . '</td>';
                }
                else if( $uhb_commission && $nhb_commission && $tuc_commission && $nhc_commission && $tnc_commission && ! $profit_target )
                {
                    $stage2 = false;
                    ?>
                    
                    <p>You have met all the Stage 1 criteria but your profit target has not been achieved yet.</p>
                    <?php
                }
                else if( ! $uhb_commission && ! $nhb_commission && ! $tuc_commission && ! $nhc_commission && ! $tnc_commission && $profit_target )
                {
                    $stage2 = false;
                    ?>
                        <p>You have achieved your profit target, but not the stage 1 criteria yet</p>
                    <?php
                }
                else 
                {
                    $stage2 = false;
                    ?>
                        <p>You have not achieved your profit target, or the stage 1 criteria yet</p>
                    <?php
                }
                
                if( $stage2 )
                {
                    echo '<h5 class="text-center spacer">Stage 2</h5>';
                    
                    if( $bt_tv_commission && $insurance_commission && $kpi_commission )
                    {
                        ?>
                            <p>You have unlocked Stage 2 Commission and met all the criteria</p>
                        
                        <div class="table-responsive">
                        <table class="table spacer">
                            <thead>
                                <tr>
                                    <th class="col-md-6">KPI</th>
                                    <th class="col-md-6">Commission Earned</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>KPI Scoreboard Commission</td>
                                <?php
                        
                                    //work out our KPI Commission
                                    if( $kpi_scorecard >= 3.5 && $kpi_scorecard < 3.7 )
                                    {
                                        $kpi_commission_achieved = 0;
                                        $percentage = 1;
                                        $kpi_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $kpi_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $kpi_scorecard == 3.7 )
                                    {
                                        $kpi_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $kpi_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $kpi_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $kpi_scorecard > 3.8 )
                                    {
                                        $kp_commission_achieved = 0;
                                        $percentage = 2;
                                        $kpi_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $kpi_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                
                                echo '</tr>';
                                
                                echo '<tr>';
                                    echo '<td>Insurance Sales</td>';
                        
                                    //work out our Insurance Commission
                                    if( $insurance_percentage > 30 && $insurance_percentage < 35 )
                                    {
                                        $insurance_commission_achieved = 0;
                                        $percentage = 1;
                                        $insurance_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $insurance_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $insurance_percentage > 35 && $insurance_percentage < 40 )
                                    {
                                        $insurance_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $insurance_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $insurance_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $insurance_percentage > 40 )
                                    {
                                        $insurance_commission_achieved = 0;
                                        $percentage = 2;
                                        $insurance_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $insurance_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                echo '</tr>';
                                
                                echo '<tr>';
                                    echo '<td>BT TV Sales</td>';
                        
                                    //work out our BT TV Commission
                                    if( $bt_tv_percentage > 30 && $bt_tv_percentage < 35 )
                                    {
                                        $bt_commission_achieved = 0;
                                        $percentage = 1;
                                        $bt_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $bt_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $bt_tv_percentage > 35 && $bt_tv_percentage < 40 )
                                    {
                                        $bt_commission_achieved = 0;
                                        $percentage = 1.5;
                                        $bt_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $bt_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                    else if( $bt_tv_percentage > 40 )
                                    {
                                        $bt_commission_achieved = 0;
                                        $percentage = 2;
                                        $bt_commission_achieved = ( $advisor_profit / 100 ) * $percentage;
                                        
                                        echo '<td>£' . number_format( (float) $bt_commission_achieved , 2 , '.' , '' ) . '</td>';
                                    }
                                echo '</tr>';
                            echo '</tbody>';
                        echo '</table>';
                        
                        echo '</div>';
                        
                        $total_stage2_commission = 0;
                        
                        $total_stage2_commission = $kpi_commission_achieved + $insurance_commission_achieved + $bt_commission_achieved;
                        
                        echo '<p>Total Stage 2 Commission: £' . number_format( (float) $total_stage2_commission , 2 , '.' , '' ) . '</p>';
                    }
                    else
                    {
                        ?>
                        <p>You have unlocked Stage 2 Commission but have not met all the criteria yet</p>
                        <?php
                    }
                }
                ?>
        </div>
    </div>
    <?php
}
