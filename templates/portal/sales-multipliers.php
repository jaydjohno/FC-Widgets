<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

$multipliers = [
    'consumer_new_handset_multiplier',
    'consumer_upgrade_handset_multiplier',
    'consumer_new_sim_multiplier',
    'consumer_upgrade_sim_multiplier',
    'consumer_handset_above_amount',
    'consumer_tier_1_amount',
    'consumer_tier_1_multiplier',
    'consumer_tier_2_amount',
    'consumer_tier_2_multiplier',
    'consumer_tier_3_amount',
    'consumer_tier_3_multiplier',
    'consumer_tier_4_amount',
    'consumer_tier_4_multiplier',
    'consumer_tier_5_amount',
    'consumer_tier_5_multiplier',
    'business_new_handset_multiplier',
    'business_upgrade_handset_multiplier',
    'business_new_sim_multiplier',
    'business_upgrade_sim_multiplier',
    'business_handset_above_amount',
    'business_tier_1_amount',
    'business_tier_1_multiplier',
    'business_tier_2_amount',
    'business_tier_2_multiplier',
    'business_tier_3_amount',
    'business_tier_3_multiplier',
    'business_tier_4_amount',
    'business_tier_4_multiplier',
    'business_tier_5_amount',
    'business_tier_5_multiplier'
];

$multiplier_names = [
    'consumer_new_handset_multiplier' => 'New Handset Multiplier',
    'consumer_upgrade_handset_multiplier' => 'Upgrade Handset Multiplier',
    'consumer_new_sim_multiplier' => 'New Sim Multiplier',
    'consumer_upgrade_sim_multiplier' => 'Upgrade Sim Multiplier',
    'consumer_handset_above_amount' => 'Handset Above Amount (ex. 629.95)',
    'consumer_tier_1_amount' => 'Tier 1 Amount',
    'consumer_tier_1_multiplier' => 'Tier 1 Multiplier',
    'consumer_tier_2_amount' => 'Tier 2 Amount',
    'consumer_tier_2_multiplier' => 'Tier 2 Multiplier',
    'consumer_tier_3_amount' => 'Tier 3 Amount',
    'consumer_tier_3_multiplier' => 'Tier 3 Multiplier',
    'consumer_tier_4_amount' => 'Tier 4 Amount',
    'consumer_tier_4_multiplier' => 'Tier 4 Multiplier',
    'consumer_tier_5_amount' => 'Tier 5 Amount',
    'consumer_tier_5_multiplier' => 'Tier 5 Multiplier',
    'business_handset_above_multiplier' => 'Handset Above Amount Multiplier',
    'business_new_handset_multiplier' => 'New Handset Multiplier',
    'business_upgrade_handset_multiplier' => 'Upgrade Handset Multiplier',
    'business_new_sim_multiplier' => 'New Sim Multiplier',
    'business_upgrade_sim_multiplier' => 'Upgrade Sim Multiplier',
    'business_handset_above_amount' => 'Handset Above Amount (ex. 629)',
    'business_tier_1_amount' => 'Tier 1 Amount',
    'business_tier_1_multiplier' => 'Tier 1 Multiplier',
    'business_tier_2_amount' => 'Tier 2 Amount',
    'business_tier_2_multiplier' => 'Tier 2 Multiplier',
    'business_tier_3_amount' => 'Tier 3 Amount',
    'business_tier_3_multiplier' => 'Tier 3 Multiplier',
    'business_tier_4_amount' => 'Tier 4 Amount',
    'business_tier_4_multiplier' => 'Tier 4 Multiplier',
    'business_tier_5_amount' => 'Tier 5 Amount',
    'business_tier_5_multiplier' => 'Tier 5 Multiplier',
];

$multiplier_values = [];

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_multipliers" ) );

$today = strtotime(date("Y-m-d"));

foreach($results as $result) {
    $multiplier_values[$result->multiplier] = $result->multiplier_value;
}

$table = 'wp_fc_multiplier_tariffs';

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_tariffs" ) );

foreach($results as $result) {
    if($result->type == 'Standard' || $result->type == 'SIMO' || $result->type == 'Business') {
        // Check record already exists or not
        $cntSQL = "SELECT count(*) as count FROM {$table} where tariff='". $result->tariff . "'" . "AND type='" . $result->type . "'";
        $record = $wpdb->get_results( $cntSQL, OBJECT );
        
        $pos = strpos($result->tariff, '£');
        $newstring = substr($result->tariff, $pos);
        $dotpos = strpos($result->tariff, '.');
        
        if($dotpos) {
            $yourfinalstring = substr($result->tariff, $pos, $dotpos + 2);
        } else {
            $yourfinalstring = $newstring;
        }
        
        $value = filter_var($yourfinalstring, FILTER_SANITIZE_NUMBER_FLOAT);
        
        if( $record[0]->count == 0 )
        {
            // Insert Record
            $wpdb->insert( $table , array(
                'type' => $result->type,
                'tariff' => $result->tariff,
                'value' => $value,
                'tariff_active' => $result->tariff_active
            ));
        } else {
            $data_update = array( 
                'type' => $result->type,
                'tariff' => $result->tariff,
                'value' => $value,
                'tariff_active' => $result->tariff_active
            );
            
            $data_where = array( 'type' => $result->type, 'tariff' => $result->tariff);
            
            //we have info lets run the query
            $wpdb->update( $table , $data_update, $data_where );
        }
    }
}

?>

<div class="multipliers-outcome" style="display:none"></div>

<p>Welcome <?php echo $user->display_name; ?></p>

<p>Please enter the sales multipliers that are used by the sales forms to work out profit</p>

<div class="rota-button-container" style="margin-bottom:20px; width:100%; text-align:right;">
    <p>
        <button type="submit" id="save-targets" class="woocommerce-Button button" style="margin-top:20px" name="save_targets" value="<?php esc_attr_e( 'Save Multipliers', 'woocommerce' ); ?>"><?php esc_html_e( 'Save Multipliers', 'woocommerce' ); ?></button>
    </p>
</div>

<h3 class="consumer-info-title">Consumer Information</h3>

<div class="table-container">
    <table class="table spacer">
        <thead>
            <tr>
                <th class="col-xs-6" scope="col"></th>
                <th class="col-xs-6" scope="col">Multiplier Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($multipliers as $multiplier) {
                if (strpos($multiplier, 'consumer') !== false) { 
                    $value = $multiplier_values[$multiplier];
                    $title = $multiplier_names[$multiplier];
                    
                    echo '<tr class="multipliers">';
                    echo '<th scope="col" multiplier="' . $multiplier . '">' . $title . '</th>';
                    echo '<td contenteditable="true">' . $value . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>

<br/>

<h3 class="consumer-info-title">Business Information</h3>

<div class="table-container">
    <table class="table spacer">
        <thead>
            <tr>
                <th class="col-xs-6" scope="col"></th>
                <th class="col-xs-6" scope="col">Multiplier Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($multipliers as $multiplier) {
                if (strpos($multiplier, 'business') !== false) { 
                    $value = $multiplier_values[$multiplier];
                    $title = $multiplier_names[$multiplier];
                    
                    echo '<tr class="multipliers">';
                    echo '<th scope="col" multiplier="' . $multiplier . '">' . $title . '</th>';
                    echo '<td contenteditable="true">' . $value . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    jQuery('#save-targets').click(function()
    {
        jQuery( ".multipliers-outcome" ).hide();
        jQuery( ".multipliers-outcome" ).text( '' );

        var multipliers = [];
        
        jQuery( '.multipliers' ).each(function( index, tr ) 
        {
            var values = jQuery( 'td', tr ).map(function( index, td ) 
            {
                return jQuery( td ).text();
            });
            
            var headings = jQuery( 'th', tr ).map(function( index, th ) 
            {
                return jQuery( th ).attr("multiplier");
            });
            
            var obj = { "multiplier": headings[0] , "value": values[0] };
            
            console.log(obj);
            
            multipliers.push( obj );
        })
        
        var data = {};
    
        data['action'] = 'fc_save_multipliers';
        data['nonce'] = fc_nonce;
        data['multipliers'] = multipliers;
        
        jQuery.ajax({
            type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {   
                if( data.success == true )
                {
                    jQuery( ".multipliers-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Sales Multipliers have been updated successfully.</div></div>' );
                    
                    jQuery( ".multipliers-outcome" ).show();
                    
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                }
                else
                {
                    jQuery( ".multipliers-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="rota-error">There has been an error while updating your multipliers, please try again.</li></ul></div>' );
                    
                    jQuery( ".multipliers-outcome" ).show();
                    
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                }
            },
        });
    });
</script>