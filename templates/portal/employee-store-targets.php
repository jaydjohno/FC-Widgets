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

$user = wp_get_current_user();

//daily first
foreach( $locations as $location )
{
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store='" . $location . "'" . " AND DATE( `sale_date` ) = CURDATE() " ) );
    
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

//get our start point based on our first sale and get first day of month
$start = new DateTime( $date );
$start->modify( 'first day of this month' );

$time = new DateTime('now');
$today = $time->format('Y-m-d');
$min = $start->format('Y-m-d');

$data = implode( "," , $locations );

$employee_location = get_user_meta( $user->ID, 'store_location' , true );
?>

<h3 class="spacer text-center">Store Daily Information</h3>

<p class="form-row validate-required spacer" id="daily_info_date_field" data-priority="">
    <label for="daily_info_date" class="">Choose Day&nbsp;<abbr class="required" title="required">*</abbr></label>
    <span class="woocommerce-input-wrapper">
        <input type="date" class="input-text " name="daily_info_date" id="daily_info_date" placeholder="" value="<?php echo esc_attr( $today ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $today ); ?>" aria-describedby="daily-sale-chart-description" autocomplete="off">
    </span>
</p>

<script>
    jQuery( '#daily_info_date' ).change( function() 
    {
        var date = jQuery( this ).val();

        if( date !== '' )
        {
            jQuery( '.daily-sales-chart' ).empty();
            
            var data = {};

            data['action'] = 'fc_get_employee_daily_chart';
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
</div>

<?php
