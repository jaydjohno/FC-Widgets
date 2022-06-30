<?php

defined( 'ABSPATH' ) || exit;

global $wpdb;

$user = wp_get_current_user();

$cover = esc_attr( get_user_meta( $user->ID, 'store_cover' , true ) );

//get users full name
$last_name = get_user_meta( $user->ID, 'last_name', true );
$first_name = get_user_meta( $user->ID, 'first_name', true );

$full_name = $first_name . ' ' . $last_name;

if( $cover == 'yes' )
{
    $location = esc_attr( get_user_meta( $user->ID, 'cover_store' , true ) );
}
else
{
    $location = esc_attr( get_user_meta( $user->ID, 'store_location' , true ) );
}

//get all our devices info and store them.

$payg = array();
$handsets = array();
$tablets = array();
$connected = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_devices" ) );

foreach ( $results as $result )
{
    if( $result->type == 'Handsets' )
    {
        $handsets[ $result->device ] = $result->cost;
    }
    elseif( $result->type == 'PayG Handsets' )
    {
        $payg[ $result->device ] = $result->cost;
    }
    elseif( $result->type == 'Tablets' )
    {
        $tablets[ $result->device ] = $result->cost;
    }
    elseif( $result->type == 'connected' )
    {
        $connected[ $result->device ] = $result->cost;
    }
}

//get our tariff info

//we need the standard tariffs
$standardtariff = array();

//we need the business tariffs
$businesstariff = array();

//we need our HSM tariffs
$hsmtariff_new = array();
$hsmtariff_upgrade = array();

//we need our TLO Tariffs
$tlotariff_new = array();
$tlotariff_upgrade = array();

//get our sim only triffs
$simOnly_standard = array();
$simOnly_business = array();

//get our connected tariffs
$connected_new = array();
$connected_upgrade = array();

//get our tablet tariffs
$tablet_new = array();
$tablet_upgrade = array();

//get our broadband tariffs
$broadband_new = array();
$broadband_upgrade = array();

//get our insurance tariffs
$damage_insurance = array();
$full_insurance = array();

//get our tariffs info
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_tariffs" ) );

foreach ( $results as $result )
{
    if ( $result->type == 'HSM' && strtolower($result->tariff_active) == 'yes' )
    {
        $hsmtariff_new[ $result->tariff ] = $result->new_price;
        $hsmtariff_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'TLO' && strtolower($result->tariff_active) == 'yes' )
    {
        $tlotariff_new[ $result->tariff ] = $result->new_price;
        $tlotariff_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'Connected' && strtolower($result->tariff_active) == 'yes' )
    {
        if ( strpos( $result->tariff , 'Tablet' ) !== false) 
        {
            $tablet_new[ $result->tariff ] = $result->new_price;
            $tablet_upgrade[ $result->tariff ] = $result->upgrade_price;
        }
        else
        {
            $connected_new[ $result->tariff ] = $result->new_price;
            $connected_upgrade[ $result->tariff ] = $result->upgrade_price;
        }
    }
    if ( $result->type == 'Tablet' && strtolower($result->tariff_active) == 'yes' )
    {
        $tablet_new[ $result->tariff ] = $result->new_price;
        $tablet_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'Home Broadband' && strtolower($result->tariff_active) == 'yes' )
    {
        $broadband_new[ $result->tariff ] = $result->new_price;
        $broadband_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'Insurance' && strtolower($result->tariff_active) == 'yes' )
    {
        if ( strpos( $result->tariff , 'Full' ) !== false) 
        {
            $full_insurance[ $result->tariff ] = $result->new_price;
        }
        elseif ( strpos( $result->tariff , 'Damage' ) !== false) 
        {
            $damage_insurance[ $result->tariff ] = $result->new_price;
        }
    }
}

//our standard, business and simonly tariffs are multiplier tariffs now
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_multiplier_tariffs" ) );

foreach ( $results as $result )
{
    if ( $result->type == 'Standard' && strtolower($result->tariff_active) == 'yes' )
    {
        $standardtariff[ $result->tariff ] = $result->value;
    }
    if ( $result->type == 'Business' && strtolower($result->tariff_active) == 'yes' )
    {
        $businesstariff[ $result->tariff ] = $result->value;
    }
    if ( $result->type == 'SIMO' && strtolower($result->tariff_active) == 'yes' )
    {
        $simOnly_standard[ $result->tariff ] = $result->value;
    }
    if ( $result->type == 'BSIMO' && strtolower($result->tariff_active) == 'yes' )
    {
        $simOnly_business[ $result->tariff ] = $result->value;
    }
}

$accessories = array();
$accessorycost = array();

//get our accessories list
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_accessories" ) );

foreach ( $results as $result )
{
    $accessories[ $result->accessory ] = $result->rrp;
    $accessorycost[ $result->accessory ] = $result->cost;
}

//get our multiplier info
$multiplier_values = [];

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_multipliers" ) );

foreach($results as $result) {
    $multiplier_values[$result->multiplier] = $result->multiplier_value;
}

//lets find out how many sales our advisor has already made
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE() AND advisor = '$full_name'" ) );

//get our number of sales for today
$sales = $wpdb->num_rows;

//add 1 to get our next sale number
$nextsale = $sales;

$rm_discount = array();
$fran_discount = array();

$month = date('F');
                    
$year = date('Y');
    
$day = date("d");

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE device_discount_type = 'rm' OR device_discount_type = 'both'" ) );

//get our RM info
$all_rm = 0;
    
foreach ( $results as $result )
{
    if( $result->store == $location and $result->month == $month and $result->year == $year )
    {
        $all_rm = floatval( $all_rm ) + floatval( $result->device_discount );
            
        $rm_discount_used = $all_rm;
    }
}

//now franchise
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE device_discount_type = 'franchise' OR device_discount_type = 'both'" ) );

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
            
        $fran_discount_used = $all_fran;
    }
}

//work out whats left
//get our discount pot info
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_pots" ) );

foreach ( $results as $result )
{
    if( $result->store == $location && $result->month == $month && $result->year == $year )
    {
        $rm_discount_pot = $result->regionalManager;
        $fran_discount_pot = $result->franchise;
    }
}

$rm_discount = floatval( $rm_discount_pot ) - floatval( $rm_discount_used );
$fran_discount = floatval( $fran_discount_pot ) - floatval( $fran_discount_used );

$rm_discount = number_format( ( float )$rm_discount , 2 , '.',  '' );

$fran_discount = number_format( ( float )$fran_discount , 2 , '.',  '' );

?>

<script>
    var percentage = 0;
    var amount = 0;
    var mrc = 0;
    var multiplier = 0;
    <?php
        echo 'var rm_discount = "' . $rm_discount .'";';
        echo 'var franchise_discount = "' . $fran_discount .'";';
    ?>
    
    var tariff_profit = 0;
    var handset_cost = 0;
    var device_profit = 0;
    var accessories_profit = 0;
    var insurance_profit = 0;
    var accessory_discount = 0;
    var total = 0;
    var total_profit = 0;
    
    //our tariff values
    var saletype = '';
    var tarifftype = '';
    
    var tariff_old = 0;
    
    function percent(num, per)
    {
      return (num/100)*per;
    }
    
    function percent_profit_loss()
    {
        calculate_total_profit();
    }
    
    function calculate_total_profit()
    {
        total_profit = 0;
        
        if( tariff_profit > 0 )
        {
            //lets work out our profit and loss first
            total_profit = parseFloat( tariff_profit ) + parseFloat( device_profit );
        }
        else
        {
            total_profit = 0;
        }
        
        if( total_profit == 0 )
        {
            jQuery( '.profit-loss' ).text('');
            jQuery( '.pl' ).text('');
        }
        else
        {
            total_profit = parseFloat( total_profit );
            total_profit = total_profit.toFixed( 2 );
            
            jQuery( '.profit-loss' ).text( 'Profit / Loss: £' + total_profit );
            jQuery( '.pl' ).val( total_profit );
        }
        
        //now lets add our accessories profit and insurance profit
        if( accessories_profit > 0 )
        {
            total_profit = parseFloat( total_profit ) + parseFloat( accessories_profit );
        }
        
        if( insurance_profit > 0 )
        {
            total_profit = parseFloat( total_profit ) + parseFloat( insurance_profit )
        }
        
        if( accessory_discount > 0 )
        {
            total_profit = parseFloat( total_profit ) - parseFloat( accessory_discount );
        }
        
        total_profit = parseFloat( total_profit );
        total_profit = total_profit.toFixed( 2 );

        if( total_profit > 0 )
        {
            jQuery( '.total-profit' ).text( 'Total Profit: £' + total_profit );
            jQuery( '.tp' ).val( total_profit );
            jQuery( '.dp' ).val( total_profit );
            jQuery( '.old' ).val( total_profit );
        }
        else
        {
            jQuery( '.total-profit' ).text( '' );
            jQuery( '.tp' ).val('');
            jQuery( '.dp' ).val('');
            jQuery( '.old' ).val('');
            jQuery( '.pl' ).val('');
        }
    }
</script>

<div class="sales-errors" style="display:none"></div>

<p>Welcome <?php echo $user->display_name; ?></p>

<div id="input-sales" class="tab-pane fade in">
    
    <form class="stilesAddSalesForm add-sales" id="staff-sales-input-form" action="" method="post" style="margin-top:20px;" store="<?php echo $location; ?>" role="employee" employee="<?php echo $full_name; ?>" sale="<?php echo $nextsale ?>" date="<?php echo date("Y-m-d"); ?>">
        <div class="row">
            <div class="col-md-12">
                <fieldset class="sales-type">
                    <legend class="sales-legend" style="display:none; margin-top:20px;"><?php esc_html_e( 'Sales', 'woocommerce' ); ?>
                    </legend>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name">
                        <label for="upgrade_type"><?php esc_html_e( 'Choose Sale Type', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <select name="type" class="type" autocomplete="off" >
                            <option value="">Sales Type</option>';
                            <option value="new" selected>New</option>';
                            <option value="upgrade">Upgrade</option>';
                        </select>
                    </p>
                <fieldset>
            </div>
        </div>

        <div class="type-error" style="display:none"></div>

        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name product-type">
                    <label for="product_type"><?php esc_html_e( 'Choose Product Type', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                    </label>
                    <select name="product_type" class="product_type" autocomplete="off" >
                        <option value="">Product Type</option>;
                        <option value="homebroadband">Home Broadband</option>;
                        <option value="simonly">Sim Only</option>;
                        <option value="handset">Handsets</option>;
                        <option value="tablet">Tablets</option>;
                        <option value="connected">Connected</option>;
                        <option value="accessory">Accessory</option>;
                        <option value="insurance">Insurance</option>;
                    </select>
                </p>
            </div>
        </div>

        <div class="product-type-error" style="display:none"></div>

        <fieldset class="product-fieldset" style="display:none">
            <legend class="products-legend" style="display:none; margin-top:20px;"><?php esc_html_e( 'Products', 'woocommerce' ); ?>
            </legend>
            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name device_container" style="display:none">
                        <label for="device"><?php esc_html_e( 'Choose Device', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <select name="device" class="device" autocomplete="off" disabled>
                            <option value="">Choose Device</option>
                        </select>
                    </p>
                </div>
            </div>

            <div class="device-error" style="display:none"></div>

            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name product-discount-select" style="display:none;">
                        <label for="tariff"><?php esc_html_e( 'Device Discount', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <select name="discount-type" class="discount-type" autocomplete="off" disabled >
                            <option value="">Choose Device Discount</option>
                        </select>
                    </p>
                </div>
            </div>

            <div class="discount-type-error" style="display:none"></div>

            <script>
                jQuery( '.discount-type' ).change(function() 
                {
                    //get the current option
                    var option = jQuery( this ).find('option:selected');

                    //get the value from the option
                    var value = option.val();

                    if( value == '' )
                    {
                        jQuery( ".product_discount" ).prop( "disabled", true );
                        jQuery( '.product-discount' ).hide();
                        jQuery( ".product_discount_2" ).prop( "disabled", true );
                        jQuery( '.product-discount_2' ).hide();
                                        
                        jQuery( ".product-discount-left" ).text( '' );
                        jQuery( ".product-discount-left" ).hide();
                        jQuery( ".product-discount-2-left" ).text( '' );
                        jQuery( ".product-discount-2-left" ).hide();
                        jQuery( '.product_discount' ).val('');
                        jQuery( '.product_discount' ).hide();
                        jQuery( '.product_discount_2' ).val('');
                        jQuery( '.product_discount_2' ).hide();
                    }
                    if( value == 'none' )
                    {
                        jQuery( ".product_discount" ).prop( "disabled", true );
                        jQuery( '.product-discount' ).hide();
                        jQuery( ".product-discount-left" ).text( '' );
                        jQuery( ".product-discount-left" ).hide();
                        
                        jQuery( '.discount-type-error' ).hide();
                        jQuery( '.discount-type-error' ).text('');
                    }
                    if( value == 'none' )
                                    {
                        jQuery( ".product_discount" ).prop( "disabled", true );
                        jQuery( '.product-discount' ).hide();
                        jQuery( ".product_discount_2" ).prop( "disabled", true );
                        jQuery( '.product-discount_2' ).hide();

                        jQuery( ".product-discount-left" ).text( '' );
                        jQuery( ".product-discount-left" ).hide();
                        jQuery( ".product-discount-2-left" ).text( '' );
                        jQuery( ".product-discount-2-left" ).hide();
                        jQuery( '.product_discount' ).val('');
                        jQuery( '.product_discount' ).hide();
                        jQuery( '.product_discount_2' ).val('');
                        jQuery( '.product_discount_2' ).hide();
                    }
                    else if( value == 'rm' )
                    {
                        jQuery( '.product_discount' ).attr( 'discount' , 'regional' );
                        jQuery( ".product_discount" ).prop( "disabled", false );
                        jQuery( '.product_discount_label' ).text( 'Enter Regional Managers Discount');
                        jQuery( '.product_discount_label' ).append( '&nbsp; <span class="required">*</span>');

                        jQuery( ".product-discount-left" ).text( 'You have £' + rm_discount + ' discount available to use' );
                        jQuery( ".product-discount-left" ).show();

                        jQuery( '.product-discount' ).show();
                        jQuery( '.product_discount' ).show();

                        jQuery( '.discount-type-error' ).hide();
                        jQuery( '.discount-type-error' ).text('');

                        //hide our second discount
                        jQuery( ".product-discount-2-left" ).text( '' );
                        jQuery( ".product-discount-2-left" ).hide();

                        jQuery( ".product_discount_2" ).prop( "disabled", true );
                        jQuery( '.product-discount_2' ).hide();

                        jQuery( '.product_discount_2' ).val('');
                        jQuery( '.product_discount_2' ).hide();
                    }
                    else if( value == 'franchise' )
                    {
                        jQuery( '.product_discount' ).attr( 'discount' , 'franchise' );
                        jQuery( ".product_discount" ).prop( "disabled", false );
                        jQuery( '.product_discount_label' ).text( 'Enter Franchise Discount');
                        jQuery( '.product_discount_label' ).append( '&nbsp; <span class="required">*</span>');

                        jQuery( ".product-discount-left" ).text( 'You have £' + franchise_discount + ' discount available to use' );
                        jQuery( ".product-discount-left" ).show();

                        jQuery( '.product-discount' ).show();
                        jQuery( '.product_discount' ).show();

                        jQuery( '.discount-type-error' ).hide();
                        jQuery( '.discount-type-error' ).text('');

                        //hide our second discount
                        jQuery( ".product-discount-2-left" ).text( '' );
                        jQuery( ".product-discount-2-left" ).hide();

                        jQuery( ".product_discount_2" ).prop( "disabled", true );
                        jQuery( '.product-discount_2' ).hide();

                        jQuery( '.product_discount_2' ).val('');
                        jQuery( '.product_discount_2' ).hide();
                    }
                    else if( value == 'both' )
                    {
                        jQuery( '.product_discount' ).attr( 'discount' , 'regional' );
                        jQuery( ".product_discount" ).prop( "disabled", false );
                        jQuery( '.product_discount_label' ).text( 'Enter Regional Managers Discount');
                        jQuery( '.product_discount_label' ).append( '&nbsp; <span class="required">*</span>');

                        jQuery( '.product_discount_2' ).attr( 'discount' , 'franchise' );
                        jQuery( ".product_discount_2" ).prop( "disabled", false );
                        jQuery( '.product_discount_2_label' ).text( 'Enter Franchise Discount');
                        jQuery( '.product_discount_2_label' ).append( '&nbsp; <span class="required">*</span>');

                        jQuery( ".product-discount-left" ).text( 'You have £' + rm_discount + ' discount available to use' );
                        jQuery( ".product-discount-left" ).show();
                        jQuery( ".product-discount-2-left" ).text( 'You have £' + franchise_discount + ' discount available to use' );
                        jQuery( ".product-discount-2-left" ).show();

                        jQuery( '.product-discount' ).show();
                        jQuery( '.product_discount' ).show();
                        jQuery( '.product-discount-2' ).show();
                        jQuery( '.product_discount_2' ).show();

                        jQuery( '.discount-type-error' ).hide();
                        jQuery( '.discount-type-error' ).text('');
                    }
                });
            </script>
        </fieldset>

        <fieldset class="tariff-fieldset" style="display:none">
            <legend class="tariff-legend" style="display:none; margin-top:20px;"><?php esc_html_e( 'Tariffs', 'woocommerce' ); ?>
            </legend>

            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name tariff-type" style="display:none">
                        <label for="tariff_type"><?php esc_html_e( 'Choose Tariff Type', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <select name="tariff_type" class="tariff_type_select" autocomplete="off"  disabled >
                            <option value="">Tariff Type</option>
                            <option value="standard">Standard Tariffs</option>
                            <option value="business">Business Tariffs</option>
                            <option value="hsm">High Street Match Tariffs</option>
                            <option value="tlo">Time Limited Offers</option>
                        </select>
                    </p>
                </div>
            </div>

            <div class="tariff-type-error" style="display:none"></div>

            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name tariff_container" style="display:none">
                        <label for="tariff"><?php esc_html_e( 'Select Tariff Type', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <select name="tariff" class="tariff" autocomplete="off" disabled >
                            <option value="">Choose Tariff</option>';
                        </select>
                    </p>
                </div>
            </div>

            <div class="tariff-error" style="display:none"></div>

            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name tariff-discount-select" style="display:none">
                        <label for="tariff"><?php esc_html_e( 'Tariff Discount', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <select name="tariff-discount-type" class="tariff-discount-type" autocomplete="off" disabled >
                            <option value="">Choose Tariff Discount</option>;
                            <option value="none">No Discount</option>;
                            <option value="staff">Friends and Family</option>;
                            <option value="pre2post">Pre 2 Post</option>;
                            <option value="addline">AddLine / BOB</option>;
                            <option value="perk">Perk</option>;
                            <option value="compass">Compass</option>;
                            <option value="mrc">MRC Discount</option>;
                        </select>
                    </p>
                </div>
            </div>
            
            <script>
            jQuery( '.tariff-discount-type' ).change(function() 
            {
                //get the current option
                var option = jQuery( this ).find('option:selected');

                //get the value from the option
                var value = option.val();
                
                //get the tariff option
                var tariff_option = jQuery( '.tariff' ).find('option:selected');
            
                //get the value from the option
                var tariff = tariff_option.text();
                
                //reset our profit
                tariff_profit = jQuery('.tp-old').val();
                
                if(tariff == 'Choose Tariff') {
                    jQuery('.tariff-discount-error').html('You need to choose your tariff before setting the discount').css("color", "red");
                    jQuery('.tariff-discount-error').show();
                    
                    jQuery( '.tariff-discount-type' ).val( '' ).trigger('change');
                    
                    jQuery( ".tariff_discount" ).prop( "disabled", true );
                    jQuery( '.tariff_discount_label' ).text( '');
                    jQuery( '.tariff-discount' ).hide();
                    jQuery( ".tariff-discount-left" ).hide();
                } else {
                    jQuery('.tariff-discount-error').html('');
                    jQuery('.tariff-discount-error').hide();
                    
                    if( value !== 'perk' || value !== 'compass' || value !== 'mrc' || value == '' )
                    {
                        jQuery( ".tariff_discount" ).prop( "disabled", true );
                        jQuery( '.tariff_discount_label' ).text( '');
                        jQuery( '.tariff-discount' ).hide();
                        jQuery( ".tariff-discount-left" ).hide();
                        
                        percentage = 0;
                    }
                    
                    if( value == 'none' )
                    {
                        jQuery( '.tariff-discount-error' ).html('');
                        jQuery( '.tariff-discount-error' ).hide();
                        
                        percentage = 0;
                    
                        percent_profit_loss();
                        
                        jQuery( ".tariff_discount" ).prop( "disabled", true );
                        jQuery( '.tariff-discount' ).hide();
                        jQuery( ".tariff-discount-left" ).text( '' );
                        jQuery( ".tariff-discount-left" ).hide();
                        jQuery( ".tariff_discount" ).val('');
                    }
                    else if( value == 'perk' || value == 'compass' || value == 'mrc')
                    {
                        jQuery( '.tariff-discount-error' ).html('');
                        jQuery( '.tariff-discount-error' ).hide();
                        
                        tariff_profit = tariff_profit;
                    
                        percent_profit_loss();
                        
                        jQuery( ".tariff_discount" ).prop( "disabled", false );
                        
                        if(value == 'perk') {
                            jQuery( '.tariff_discount_label' ).text( 'Enter Percentage For Perk Discount');
                        } else if(value == 'compass') {
                            jQuery( '.tariff_discount_label' ).text( 'Enter Percentage For Compass Discount');
                        } else {
                            jQuery( '.tariff_discount_label' ).text( 'Enter your MRC discount amount');
                        }
                        
                        jQuery( '.tariff_discount_label' ).append( '&nbsp; <span class="required">*</span>');
                        jQuery( '.tariff-discount' ).show();
                        jQuery( ".tariff-discount-left" ).show();
                    }
                    else if( value == 'staff' )
                    {
                        jQuery( '.tariff-discount-error' ).html('');
                        jQuery( '.tariff-discount-error' ).hide();
                        
                        percentage = 30;
                        
                        if( tariff_profit > 0 )
                        {
                            var reduce = percent( tariff_profit, percentage );
                            reduce = parseFloat( reduce );
                            reduce = reduce.toFixed( 2 );
                            
                            tariff_profit = tariff_profit - reduce;
                        }
                        
                        percent_profit_loss();
                    }
                    else if( value == 'pre2post' )
                    {
                        jQuery( '.tariff-discount-error' ).html('');
                        jQuery( '.tariff-discount-error' ).hide();
                        
                        percentage = 20;
                        
                        if( tariff_profit > 0 )
                        {
                            var reduce = percent( tariff_profit, percentage );
                            reduce = parseFloat( reduce );
                            reduce = reduce.toFixed( 2 );
                            
                            tariff_profit = tariff_profit - reduce;
                        }
                        
                        percent_profit_loss();
                    }
                    else if( value == 'addline' )
                    {
                        jQuery( '.tariff-discount-error' ).html('');
                        jQuery( '.tariff-discount-error' ).hide();
                        
                        percentage = 10;
                        
                        if( tariff_profit > 0 )
                        {
                            var reduce = percent( tariff_profit, percentage );
                            reduce = parseFloat( reduce );
                            reduce = reduce.toFixed( 2 );
                            
                            tariff_profit = tariff_profit - reduce;
                        }
                        
                        percent_profit_loss();
                    }
                }
            });
            </script>

            <div class="tariff-discount-error" style="display:none"></div>
            
            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name broadband-tv-select" style="display:none">
                        <label for="tariff"><?php esc_html_e( 'Choose Broadband TV', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <select name="broadband-tv-type" class="broadband-tv-type" autocomplete="off" disabled >
                            <option value="">Choose Broadband TV</option>;
                            <option value="none">No TV</option>;
                            <option value="bt">BT TV</option>;
                            <option value="ee">EE TV</option>;
                            <option value="apple">Apple TV</option>;
                        </select>
                    </p>
                </div>
            </div>

            <div class="broadband-tv-error" style="display:none"></div>

            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name tariff-discount" style="display:none;">
                        <label class="tariff_discount_label" for="tariff_discount"><?php esc_html_e( 'Enter Tariff Discount', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                        </label>
                        <input type="number" class="tariff_discount" name="tariff_discount" autocomplete="off" disabled>
                    </p>
                </div>
            </div>

            <p class="tariff-discount-left"></p>
        </fieldset>

        <div class="row">
            <div class="col-md-12 accessory-needed">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <p><?php esc_html_e( 'Accessory', 'woocommerce' ); ?></p>
                    <label class="radio-inline">
                        <input class="accessory-radio accessory-no" type="radio" name="accessory" value="no" autocomplete="off" checked >No
                    </label>
                    <label class="radio-inline">
                        <input class="accessory-radio accessory-yes" type="radio" name="accessory"value="yes" autocomplete="off" >Yes
                    </label>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name choose-accessory" style="display:none;">
                    <label for="accessories"><?php esc_html_e( 'Choose Accessories', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                    </label>
                    <select name="accessories" class="accessories" autocomplete="off" disabled >
                        <option value="">Choose Accessories</option>';
                        <?php
                        foreach( $accessories as $accessory => $price )
                        {
                            ?>
                            <option value="<?php echo $price; ?>"><?php echo $accessory; ?></option>`); 
                            <?php
                        }
                        ?>
                    </select>
                </p>
            </div>
        </div>

        <div class="accessories-error" style="display:none"></div>

        <div class="row">
            <div class="col-md-12 accessory-discount" style="display:none">
                <p><?php esc_html_e( 'Accessory Discount', 'woocommerce' ); ?></p>
                <label class="radio-inline">
                    <input class="accessory-discount-radio accessory-discount-no" type="radio" name="accessory-discount" value="no" autocomplete="off" checked >No
                </label>
                <label class="radio-inline">
                    <input class="accessory-discount-radio accessory-discount-yes" type="radio" name="accessory-discount" value="yes" autocomplete="off">Yes
                </label>
            </div>
        </div>

        <div class="accessory-discount-error" style="display:none"></div>

        <script>
            jQuery('.accessory-discount input').on('change', function() 
            {
                if( jQuery( this ).is( ":checked" ) )
                { 
                    var val = jQuery( this ).val(); 

                    if( val == 'yes' )
                    {
                        var option = jQuery( '.accessories' ).find('option:selected');

                        if ( option.val() !== '' )
                        {
                            jQuery( ".accessory_discount" ).prop( "disabled", false );
                            jQuery( '.accessory_discount_input' ).show();
                            jQuery( '.accessory-discount-left' ).show();
                            accessory_discount = 0;
                        }
                    }
                    else
                    {
                        jQuery( ".accessory_discount" ).prop( "disabled", true );
                        jQuery( '.accessory_discount_input' ).hide();
                        jQuery( '.accessory-discount-left' ).hide();
                    }
                }
            });
        </script>

        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name accessory_discount_input" style="display:none;">
                    <label for="accessory-discount"><?php esc_html_e( 'Accessory Discount', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                    </label>
                    <input type="number" class="accessory_discount" name="accessory_discount" autocomplete="off" disabled>
                </p>
            </div>
        </div>

        <p class="accessory-discount-left" style="display:none"></p>

        <div class="row" style="margin-top:20px;">
            <div class="col-md-12 insurance">
                <p><?php esc_html_e( 'Insurance', 'woocommerce' ); ?></p>
                <label class="radio-inline">
                    <input class="insurance-radio insurance-no" type="radio" name="insurance" value="no" autocomplete="off" checked >No
                </label>
                <label class="radio-inline">
                    <input class="insurance-radio insurance-yes" type="radio" name="insurance"value="yes" autocomplete="off" >Yes
                </label>
            </div>
        </div>

        <script>
            jQuery('.insurance input').on('change', function() 
            {
                if( jQuery( this ).is( ":checked" ) )
                { 
                    var val = jQuery( this ).val(); 

                    if( val == 'yes' )
                    {
                        jQuery( ".insurance_type" ).prop( "disabled", false );
                        jQuery( '.insurance-type').show();
                    }
                    else
                    {
                        jQuery( ".insurance_type" ).prop( "disabled", true );
                        jQuery( ".insurance_type" ).val( "" ).trigger('change');
                        jQuery( '.insurance-type').hide();
                        jQuery( ".insurance_choices" ).prop( "disabled", true );
                        jQuery( '.insurance-choice').hide();
                        jQuery( ".save-sales" ).prop( "disabled", false );
                    }
                }
            });
        </script>

        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name insurance-type" style="display:none;">
                    <label for="insurance_type"><?php esc_html_e( 'Insurance Type', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                    </label>
                    <select name="insurance_type" class="insurance_type" autocomplete="off" disabled >
                        <option value="">Insurance Type</option>';
                        <option value="damage">Damage</option>';
                        <option value="full">Full</option>';
                    </select>
                </p>
            </div>
        </div>

        <div class="insurance-type-error" style="display:none"></div>
        
        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name insurance-choice" style="display:none;">
                    <label for="insurance_choice"><?php esc_html_e( 'Choose Insurance', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                    </label>
                    <select name="insurance_choices" class="insurance_choices" autocomplete="off" disabled >
                        <option value="">Choose Insurance</option>';
                    </select>
                </p>
            </div>
        </div>

        <div class="insurance-choice-error" style="display:none"></div>
        
        <script>
            jQuery( '.insurance_type' ).change(function() 
            {
                //get the current option
                var option = jQuery( this ).find('option:selected');
        
                //get the value from the option
                var value = option.val();
                
                if( value == '' )
                {
                    jQuery( '.insurance-type-error' ).hide();
                    jQuery( '.insurance-type-error' ).text('');
                    
                    jQuery( '.insurance_choices' ).val( '' ).trigger( 'change' );
                    jQuery( '.insurance_choice ' ).hide();
                    jQuery( ".insurance_choices" ).prop( "disabled", true );
                }
                
                if( value == 'damage' )
                {
                    jQuery( '.insurance-profit' ).text('');
                    jQuery( '.inp' ).val('');
                    
                    insurance_profit = 0;
                    calculate_total_profit();
                    
                    jQuery( '.insurance_choices' )
                        .empty()
                        .append('<option value="">Choose Insurance</option>');
                        
                    jQuery( '.insurance-type-error' ).hide();
                    jQuery( '.insurance-type-error' ).text('');
                    
                    //load our insurance choices
                    jQuery( ".insurance_choices" ).prop( "disabled", false );
                    <?php
                    foreach( $damage_insurance as $insurance => $price )
                    {
                        ?>
                        jQuery( '.insurance_choices' )
                            .append('<option value="<?php echo $price; ?>"><?php echo $insurance; ?></option>');
                        <?php
                    }
                    ?>
                    
                    jQuery( '.insurance-choice ' ).show();
                }
                
                if( value == 'full' )
                {
                    jQuery( '.insurance-profit' ).text('');
                    jQuery( '.inp' ).val('');
                    
                    insurance_profit = 0;
                    calculate_total_profit();
                    
                    jQuery( '.insurance_choices' )
                        .empty()
                        .append('<option value="">Choose Insurance</option>');
                        
                    jQuery( '.insurance-type-error' ).hide();
                    jQuery( '.insurance-type-error' ).text('');
                    
                    //load our insurance choices
                    jQuery( ".insurance_choices" ).prop( "disabled", false );

                    <?php
                    foreach( $full_insurance as $insurance => $price )
                    {
                        ?>
                        jQuery( '.insurance_choices' )
                            .append('<option value="<?php echo $price; ?>"><?php echo $insurance; ?></option>');
                        <?php
                    }
                    ?>
                    jQuery( '.insurance-choice' ).show();
                }
            });
            
            jQuery( '.insurance_choices' ).change(function() 
            {
                insurance_profit = 0;
                
                //get the current option
                var option = jQuery( this ).find('option:selected');
        
                //get the value from the option
                var value = option.val();
                
                if( value == '' )
                {
                    jQuery( '.insurance-profit' ).text( '' );
                    jQuery( '.inp' ).val( '' );
                    
                    insurance_profit = 0;
                    
                    calculate_total_profit();
                }
                else
                {
                    insurance_profit = value;
                    
                    jQuery( '.insurance-profit' ).text( 'Insurance Profit: £' + insurance_profit );
                    jQuery( '.inp' ).val( insurance_profit );
                    
                    jQuery( '.insurance-choice-error' ).hide();
                    jQuery( '.insurance-choice-error' ).html('');
                    
                    calculate_total_profit();
                }
            });
        </script>
        
        <!-- <div class="row" style="margin-top:20px;">
            <div class="col-md-12 hrc">
                <p><?php //esc_html_e( 'Is This a HRC Sale?', 'woocommerce' ); ?></p>
                <label class="radio-inline">
                    <input class="hrc-radio hrc-no" type="radio" name="hrc" value="no" autocomplete="off" checked >No
                </label>
                <label class="radio-inline">
                    <input class="hrc-radio hrc-yes" type="radio" name="hrc"value="yes" autocomplete="off" >Yes
                </label>
            </div>
        </div> -->

        <script>
            jQuery('.hrc input').on('change', function() 
            {
                if( jQuery( this ).is( ":checked" ) )
                { 
                    var val = jQuery( this ).val(); 

                    if( val == 'yes' )
                    {
                        jQuery(".pobo-no").prop("checked", true).trigger('change');
                        jQuery('input[name=pobo]').prop('disabled', true);
                        
                        jQuery('.sales-notice').html('<p>Notice: You will receive no profilt for this sale</p>');
                        jQuery('.sales-notice').show();
                    }
                    else
                    {
                        jQuery('input[name=pobo]').prop('disabled', false);
                        
                        jQuery('.sales-notice').html('');
                        jQuery('.sales-notice').hide();
                    }
                }
            });
        </script>
        
        <!-- <div class="row">
            <div class="col-md-12 pobo">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name">
                    <p><?php //esc_html_e( 'Is This a POBO Sale?', 'woocommerce' ); ?></p>
                    <label class="radio-inline">
                        <input class="pobo-radio pobo-no" type="radio" name="pobo" value="no" autocomplete="off" checked >No
                    </label>
                    <label class="radio-inline">
                        <input class="pobo-radio pobo-yes" type="radio" name="pobo"value="yes" autocomplete="off" >Yes
                    </label>
                </p>
            </div>
        </div> -->
        
        <script>
            jQuery('.pobo input').on('change', function() 
            {
                if( jQuery( this ).is( ":checked" ) )
                { 
                    var val = jQuery( this ).val(); 

                    if( val == 'yes' )
                    {
                        jQuery(".hrc-no").prop("checked", true).trigger('change');
                        jQuery('input[name=hrc]').prop('disabled', true);
                        
                        jQuery('.sales-notice').html('<p>Noitce: You will receive 80% profilt for this sale</p>');
                        jQuery('.sales-notice').show();
                    }
                    else
                    {
                        jQuery('input[name=hrc]').prop('disabled', false);
                        
                        jQuery('.sales-notice').html('');
                        jQuery('.sales-notice').hide();
                    }
                }
            });
        </script>
        
        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name product-discount" style="display:none;">
                    <label for="product_discount" class="product_discount_label"><?php esc_html_e( 'Enter Product Discount', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                    </label>
                    <input type="number" class="product_discount" name="product_discount" autocomplete="off" disabled >
                </p>
            </div>
        </div>

        <p class="product-discount-left"></p>
        
        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name product-discount-2" style="display:none;">
                    <label for="product_discount" class="product_discount_2_label"><?php esc_html_e( 'Enter Product Discount', 'woocommerce' ); ?>&nbsp;
                        <span class="required">*</span>
                    </label>
                    <input type="number" class="product_discount_2" name="product_discount_2" autocomplete="off" disabled >
                </p>
            </div>
        </div>
                            
        <p class="product-discount-2-left"></p>

        <div class="row">
            <div class="col-md-12">
                <h4 class="pl-title"></h4>

                <p class="profit-loss"></p>
                <input type="hidden" class="pl" name="pl" value=""> 

                <p class="accessory-profit"></p>
                <input type="hidden" class="ap" name="ap" value="">
                <input type="hidden" class="ap-old" name="ap" value="">

                <p class="insurance-profit"></p>
                <input type="hidden" class="inp" name="inp" value=""> 

                <p class="total-profit"></p>
                <input type="hidden" class="tp" name="tp" value=""> 
                <input type="hidden" class="tp-old" name="tp-old" value=""> 
                <input type="hidden" class="dp" name="dp" value="">
                <input type="hidden" class="old" name="old" value="">
            </div>
        </div>

        <p>
            <button type="submit" class="save-sales woocommerce-Button button" style="margin-top:20px" name="save_account_details" value="<?php esc_attr_e( 'Save Sales', 'woocommerce' ); ?>"><?php esc_html_e( 'Save Sales', 'woocommerce' ); ?>
            </button>
        </p>
        
        <div class="col-md-12 sales-notice" style="display:none; margin-top:15px;"></div>
    </form>
</div>

<script>
    jQuery(document).ready(function() 
    {
        //enable our select2's
        enable_select2();
        
        //clear our profit values
        jQuery( '.tp' ).val('');
        jQuery( '.dp' ).val('');
        jQuery( '.old' ).val('');
        jQuery( '.pl' ).val('');
        jQuery( '.inp' ).val('');
        jQuery( '.ap' ).val('');
        jQuery( '.ap-old' ).val('');
    });
    
    function enable_select2()
    {
        jQuery(".advisor").select2(
        {
            width: '100%',
        });
        
        jQuery(".accessories").select2(
        {
            width: '100%',
        });
        
        jQuery(".type").select2(
        {
            width: '100%',
        });
        
        jQuery(".product_type").select2(
        {
            width: '100%',
        });
        
        jQuery(".tariff-discount-type").select2(
        {
            width: '100%',
        });
        
        jQuery(".discount-type").select2(
        {
            width: '100%',
        });
        
        jQuery(".insurance_type").select2(
        {
            width: '100%',
        });
        
        jQuery(".tariff_type_select").select2(
        {
            width: '100%',
        });
        
        jQuery(".insurance_choices").select2(
        {
            width: '100%',
        });
        
        //disable the options we dont want
        
        jQuery(".discount-type option[value='compass']").prop("disabled",true);
    }
</script>

<script>
    //our profit values
    var profit = 0;
    var tprofit = 0;
    var dprofit = 0;
    var aprofit = 0;
    var iprofit = 0;
    var loss = 0;
    var total = 0;
    
    jQuery( document ).ready(function() 
    {
        var toption = jQuery( '.type' ).find('option:selected');
        saletype = toption.val();
    });
    
    jQuery('.accessory-needed input').on('change', function() 
    {
        if( jQuery( this ).is( ":checked" ) )
        { 
            var val = jQuery( this ).val();
                                    
            if( val == 'yes' )
            {
                jQuery( ".accessories" ).prop( "disabled", false );
                jQuery( '.choose-accessory' ).show();
            }
            else
            {
                jQuery( ".save-sales" ).prop( "disabled", false );
                jQuery( ".accessories" ).prop( "disabled", true );
                jQuery( '.accessory-discount-no' ).prop( 'checked' , true) ;
                jQuery( ".accessories" ).val( "" ).trigger('change');
                jQuery( '.accessory-discount' ).hide();
                                        
                //make sure you remove the discount in case they forgot
                jQuery( ".accessory_discount" ).prop( "disabled", true );
                jQuery( '.accessory_discount_input' ).hide();
                jQuery( '.choose-accessory' ).hide();
                jQuery( '.accessory-profit' ).text('');
                jQuery( '.accessory-discount-left' ).text('');
                jQuery( '.accessory-discount-left' ).hide();
                
                accessories_profit = 0;
                
                jQuery( '.ap' ).val('');
                
                calculate_total_profit();
            }
        }
    });
    
    jQuery( '.type' ).change(function() 
    {
        jQuery( '.profit-loss' ).text( '' );
        jQuery( '.total-profit' ).text( '' );
        
        jQuery( '.product_type' ).val( '' ).trigger('change');
        jQuery( '.product_type' ).val( '' ).trigger('change');

        tprofit = 0;
        
        //get the current option
        var toption = jQuery( this ).find('option:selected');

        //get the value from the option
        var tvalue = toption.val();

        saletype = tvalue;
        
        //find out our product type
        var poption = jQuery( '.product_type' ).find('option:selected');

        //get the value from the option
        var pvalue = poption.val();
        
        var producttype = pvalue;
        
        if ( tarifftype == '' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');
        }
        
        if( tarifftype == 'standard' || tarifftype =='business' )
        {
            jQuery( '.tariff-discount-select' ).show();
        }
        else
        {
            jQuery( '.tariff-discount-select' ).hide();
        }
        
        if( producttype == 'homebroadband' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $broadband_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if( producttype == 'homebroadband' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $broadband_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="0"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if( producttype == 'simonly' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $simOnly as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if( producttype == 'simonly' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $simOnly as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if( producttype == 'connected' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $connected_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if( producttype == 'connected' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $connected_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if( producttype == 'tablet' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $tablet_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if( producttype == 'tablet' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $tablet_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if ( tarifftype == 'standard' && saletype == 'new'  )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $standardtariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if ( tarifftype == 'standard' && saletype == 'upgrade'  )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');
            
            <?php

            foreach( $standardtariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'business' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $businesstariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'business' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $businesstariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'hsm' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $hsmtariff_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'hsm' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $hsmtariff_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        
        if ( tarifftype == 'tlo' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $tlotariff_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'tlo' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $tlotariff_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
    });

    jQuery( '.tariff_type_select' ).change(function() 
    {
        //get the current option
        var option = jQuery( this ).find('option:selected');

        //get the value from the option
        var value = option.val();
        
        var productoption = jQuery( '.product_type').find('option:selected');
        var product_type = productoption.val();
        
        tarifftype = value;

        if ( tarifftype == '' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');
            
            jQuery( '.tariff-discount-type' ).val('').trigger('change');
            jQuery( '.tariff' ).val('').trigger('change');
        }
        
        if( tarifftype == 'standard' || tarifftype =='business' )
        {
            jQuery( '.tariff-discount-select' ).show();
        }
        else
        {
            jQuery( '.tariff-discount-select' ).hide();
        }
        
        if ( tarifftype == 'standard' && saletype == 'new' && product_type !== 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $standardtariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'standard' && saletype == 'upgrade' && product_type !== 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');
            
            <?php

            foreach( $standardtariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'standard' && saletype == 'new' && product_type == 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $simOnly_standard as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'standard' && saletype == 'upgrade' && product_type == 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');
            
            <?php

            foreach( $simOnly_standard as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'business' && saletype == 'new' && product_type !== 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $businesstariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'business' && saletype == 'upgrade' && product_type !== 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $businesstariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'business' && saletype == 'new' && product_type == 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $simOnly_business as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'business' && saletype == 'upgrade' && product_type == 'simonly' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $simOnly_business as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'tlo' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $tlotariff_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'tlo' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $tlotariff_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'hsm' && saletype == 'new' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $hsmtariff_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
        if ( tarifftype == 'hsm' && saletype == 'upgrade' )
        {
            jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');

            <?php

            foreach( $hsmtariff_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
            }

            ?>
            
            //clear our error messages
            jQuery( '.type-error' ).hide();
            jQuery( '.type-error' ).text('');
            jQuery( '.tariff-type-error' ).hide();
            jQuery( '.tariff-type-error' ).text('');
        }
    });
    
    jQuery( '.product_type' ).change(function() 
    {
        //get the current option
        var option = jQuery( this ).find('option:selected');

        //get the value from the option
        var value = option.val();
        
        //reset our tariff too
        jQuery('.tariff').val('').trigger('change');
        
        jQuery('.device')
            .empty()
            .append('<option selected="selected" value="">Choose Device</option>');
            
        jQuery('.device').val('');
        
        jQuery('.tariff')
            .empty()
            .append('<option selected="selected" value="">Choose Tariff</option>');
            
        jQuery('.tariff_type_select').val('');

        if ( value == '' )
        {
            jQuery( '.device_container' ).hide();
            jQuery( '.tariff_container' ).hide();
            jQuery( '.tariff-discount-select' ).hide();
            jQuery( '.product-discount-select' ).hide();
            jQuery( '.tariff-type' ).hide();
            jQuery( '.products-legend' ).hide();
            jQuery( '.product-fieldset' ).hide();
            jQuery( '.tariff-legend' ).hide();
            jQuery( '.tariff-fieldset' ).hide();

            //disable all our fields
            jQuery( ".tariff_type_select" ).prop( "disabled", true );
            jQuery( ".tariff" ).prop( "disabled", true );
            jQuery( ".tariff-discount-type" ).prop( "disabled", true );
            jQuery( ".device" ).prop( "disabled", true );
            jQuery( ".discount-type" ).prop( "disabled", true );
            jQuery( ".product_discount" ).prop( "disabled", true );
        }
        
        if( value !== 'accessory' )
        {
            jQuery( '.accessory-yes' ).prop( 'checked' , false ).trigger('change'); 
            jQuery( '.accessory-no' ).prop( 'checked' , true ).trigger('change');
        }
        
        if( value !== 'insurance' )
        {
            jQuery( '.insurance-yes' ).prop( 'checked' , false ).trigger('change'); 
            jQuery( '.insurance-no' ).prop( 'checked' , true ).trigger('change');
            jQuery( ".insurance-yes" ).prop( "disabled", true );
            jQuery( ".insurance-no" ).prop( "disabled", true );
        }
        else if( value !== 'insurance' || value !== 'handset' || value !== 'connected' || value !== 'tablet' )
        {
            jQuery( ".insurance-yes" ).prop( "disabled", true );
            jQuery( ".insurance-no" ).prop( "disabled", true );
        }
        else
        {
            jQuery( ".insurance-yes" ).prop( "disabled", false );
            jQuery( ".insurance-no" ).prop( "disabled", false );
        }
        
        if( value == 'insurance' || value == 'handset' || value == 'connected' || value == 'tablet' )
        {
            jQuery( ".insurance-yes" ).prop( "disabled", false );
            jQuery( ".insurance-no" ).prop( "disabled", false );
        }
        else
        {
            jQuery( ".insurance-yes" ).prop( "disabled", true );
            jQuery( ".insurance-no" ).prop( "disabled", true );
        }
        
        if ( value == 'homebroadband' )
        {
            //get the current option
            var toption = jQuery( '.type' ).find('option:selected');
    
            //get the value from the option
            var tvalue = toption.val();
    
            saletype = tvalue;
            
            if ( tarifftype == '' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
            }
            
            if( tarifftype == 'standard' || tarifftype =='business' )
            {
                jQuery( '.tariff-discount-select' ).show();
            }
            else
            {
                jQuery( '.tariff-discount-select' ).hide();
            }
            
            if( saletype == 'new' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $broadband_new as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
            if( saletype == 'upgrade' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $broadband_upgrade as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="0"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
            
            jQuery( '.device_container' ).hide();
            jQuery( '.tariff_container' ).show();
            jQuery( '.tariff-discount-select' ).hide();
            jQuery( '.product-discount-select' ).hide();
            jQuery( '.tariff-type' ).hide();
            jQuery( '.products-legend' ).hide();
            jQuery( '.product-fieldset' ).hide();
            jQuery( '.tariff-legend' ).show();
            jQuery( '.tariff-fieldset' ).show();
            
            //remove our error message
            jQuery( '.product-type-error' ).hide();
            jQuery( '.product-type-error' ).html( '' );

            //undisable all required fields
            jQuery( ".tariff_type_select" ).prop( "disabled", true );
            jQuery( ".tariff" ).prop( "disabled", false );
            

            //disable all other fields
            jQuery( ".device" ).prop( "disabled", true );
            jQuery( ".discount-type" ).prop( "disabled", true );
            jQuery( ".product_discount" ).prop( "disabled", true );
            jQuery( ".tariff-discount-type" ).prop( "disabled", true );

            device_profit= '0';
        }
        if ( value == 'handset' )
        {
            //add our discount options
            jQuery( '.tariff_type_select' )
                .empty()
                .append('<option value="">Tariff Type</option>')
                .append('<option value="standard">Standard Tariffs</option>')
                .append('<option value="business">Business Tariffs</option>')
                .append('<option value="hsm">High Street Match Tariffs</option>')
                .append('<option value="tlo">Time Limited Offers</option>')
                
            <?php
            
            $count = 1;

            foreach( $handsets as $device => $price )
            {
                ?>
                jQuery( '.device' )
                    .append('<option value="<?php echo $price ?>"><?php echo $device; ?></option>');
                <?php
                $count++;
            }

            ?>
            
            //add our discount options
            jQuery( '.discount-type' )
                    .empty()
                    .append('<option value="">Choose Device Discount</option>')
                    .append('<option value="none">No Discount</option>')
                    .append('<option value="rm">Regional Manager</option>')
                    .append('<option value="franchise">Franchise Discount</option>')
                    .append('<option value="both">Franchise and RM Discount</option>');
                    
            jQuery( '.device_container' ).show();
            jQuery( '.tariff_container' ).show();
            jQuery( '.tariff-discount-select' ).show();
            jQuery( '.product-discount-select' ).show();
            jQuery( '.tariff-type' ).show();
            jQuery( '.products-legend' ).show();
            jQuery( '.product-fieldset' ).show();
            jQuery( '.tariff-legend' ).show();
            jQuery( '.tariff-fieldset' ).show();
            
            jQuery( '.product-type-error' ).hide();
            jQuery( '.product-type-error' ).html( '' );

            //undisable all our fields
            jQuery( ".tariff_type_select" ).prop( "disabled", false );
            jQuery( ".tariff" ).prop( "disabled", false );

            jQuery( ".device" ).prop( "disabled", false );
            
            //disable our discount type
            jQuery( ".discount-type" ).prop( "disabled", true );
        }
        if ( value == 'tablet' )
        {
            <?php
            $count = 1;
            foreach( $tablets as $device => $price )
            {
                ?>
                jQuery( '.device' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $device; ?></option>');
                <?php
                $count++;
            }

            ?>
            
            //add our discount options
            jQuery( '.discount-type' )
                    .empty()
                    .append('<option value="">Choose Device Discount</option>')
                    .append('<option value="none">No Discount</option>')
                    .append('<option value="franchise">Franchise Discount</option>');
            
            //get the current option
            var toption = jQuery( '.type' ).find('option:selected');
    
            //get the value from the option
            var tvalue = toption.val();
    
            saletype = tvalue;
            
            //find out our product type
            var poption = jQuery( '.product_type' ).find('option:selected');
    
            //get the value from the option
            var pvalue = poption.val();
            
            var producttype = pvalue;
            
            if ( tarifftype == '' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
            }
            
            if( tarifftype == 'standard' || tarifftype =='business' )
            {
                jQuery( '.tariff-discount-select' ).show();
            }
            else
            {
                jQuery( '.tariff-discount-select' ).hide();
            }
            
            if( producttype == 'tablet' && saletype == 'new' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $tablet_new as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
            if( producttype == 'tablet' && saletype == 'upgrade' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $tablet_upgrade as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }

            jQuery( '.device_container' ).show();
            jQuery( '.tariff_container' ).show();
            jQuery( '.tariff-discount-select' ).show();
            jQuery( '.product-discount-select' ).show();
            jQuery( '.tariff-type' ).hide();
            jQuery( '.products-legend' ).show();
            jQuery( '.product-fieldset' ).show();
            jQuery( '.tariff-legend' ).show();
            jQuery( '.tariff-fieldset' ).show();
            
            jQuery( '.product-type-error' ).hide();
            jQuery( '.product-type-error' ).html( '' );

            //undisable all our fields
            jQuery( ".tariff_type_select" ).prop( "disabled", true );
            jQuery( ".tariff" ).prop( "disabled", false );

            jQuery( ".device" ).prop( "disabled", false );
            
            //disable our discount type
            jQuery( ".discount-type" ).prop( "disabled", true );
        }
        if ( value == 'connected' )
        {
            <?php
            $count = 1;
            foreach( $connected as $device => $price )
            {
                ?>
                jQuery( '.device' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $device; ?></option>');
                <?php
                $count++;
            }

            ?>
            
            //add our discount options
            jQuery( '.discount-type' )
                    .empty()
                    .append('<option value="">Choose Device Discount</option>')
                    .append('<option value="none">No Discount</option>')
                    .append('<option value="franchise">Franchise Discount</option>');
            
            //get the current option
            var toption = jQuery( '.type' ).find('option:selected');
    
            //get the value from the option
            var tvalue = toption.val();
    
            saletype = tvalue;
            
            //find out our product type
            var poption = jQuery( '.product_type' ).find('option:selected');
    
            //get the value from the option
            var pvalue = poption.val();
            
            var producttype = pvalue;
            
            if ( tarifftype == '' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
            }
            
            if( tarifftype == 'standard' || tarifftype =='business' )
            {
                jQuery( '.tariff-discount-select' ).show();
            }
            else
            {
                jQuery( '.tariff-discount-select' ).hide();
            }
            
            if( producttype == 'connected' && saletype == 'new' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $connected_new as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
            if( producttype == 'connected' && saletype == 'upgrade' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $connected_upgrade as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }

            jQuery( '.device_container' ).show();
            jQuery( '.tariff_container' ).show();
            jQuery( '.tariff-discount-select' ).show();
            jQuery( '.product-discount-select' ).show();
            jQuery( '.tariff-type' ).hide();
            jQuery( '.products-legend' ).show();
            jQuery( '.product-fieldset' ).show();
            jQuery( '.tariff-legend' ).show();
            jQuery( '.tariff-fieldset' ).show();
            
            jQuery( '.product-type-error' ).hide();
            jQuery( '.product-type-error' ).html( '' );

            //undisable all our fields
            jQuery( ".tariff_type_select" ).prop( "disabled", true );
            jQuery( ".tariff" ).prop( "disabled", false );

            jQuery( ".device" ).prop( "disabled", false );
            
            //disable our discount type
            jQuery( ".discount-type" ).prop( "disabled", true );
        }
        if ( value == 'accessory' )
        {
            jQuery( '.device_container' ).hide();
            jQuery( '.tariff_container' ).hide();
            jQuery( '.tariff-discount-select' ).hide();
            jQuery( '.product-discount-select' ).hide();
            jQuery( '.tariff-type' ).hide();
            jQuery( '.products-legend' ).hide();
            jQuery( '.product-fieldset' ).hide();
            jQuery( '.tariff-legend' ).hide();
            jQuery( '.tariff-fieldset' ).hide();
            
            jQuery( '.product-type-error' ).hide();
            jQuery( '.product-type-error' ).html( '' );

            //undisable all our fields
            jQuery( ".tariff_type_select" ).prop( "disabled", true );
            jQuery( ".tariff" ).prop( "disabled", true );

            jQuery( ".device" ).prop( "disabled", true );
            
            //disable our discount type
            jQuery( ".discount-type" ).prop( "disabled", true );
            
            //set our accessory radio
            jQuery( '.accessory-yes' ).prop( 'checked' , true ).trigger('change'); 
            jQuery( '.accessory-no' ).prop( 'checked' , false ).trigger('change');
        }
        if ( value == 'insurance' )
        {
            jQuery( '.device_container' ).hide();
            jQuery( '.tariff_container' ).hide();
            jQuery( '.tariff-discount-select' ).hide();
            jQuery( '.product-discount-select' ).hide();
            jQuery( '.tariff-type' ).hide();
            jQuery( '.products-legend' ).hide();
            jQuery( '.product-fieldset' ).hide();
            jQuery( '.tariff-legend' ).hide();
            jQuery( '.tariff-fieldset' ).hide();
            
            jQuery( '.product-type-error' ).hide();
            jQuery( '.product-type-error' ).html( '' );

            //undisable all our fields
            jQuery( ".tariff_type_select" ).prop( "disabled", true );
            jQuery( ".tariff" ).prop( "disabled", true );

            jQuery( ".device" ).prop( "disabled", true );
            
            //disable our discount type
            jQuery( ".discount-type" ).prop( "disabled", true );
            
            //set our accessory radio
            jQuery( '.insurance-yes' ).prop( 'checked' , true ).trigger('change'); 
            jQuery( '.insurance-no' ).prop( 'checked' , false ).trigger('change');
        }
        if ( value == 'simonly' )
        {
            //get the current option
            var toption = jQuery( '.type' ).find('option:selected');
    
            //get the value from the option
            var tvalue = toption.val();
    
            saletype = tvalue;
            
            //find out our product type
            var poption = jQuery( '.product_type' ).find('option:selected');
    
            //get the value from the option
            var pvalue = poption.val();
            
            var producttype = pvalue;
            
            if ( tarifftype == '' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
            }
            
            if( tarifftype == 'standard' || tarifftype =='business' )
            {
                jQuery( '.tariff-discount-select' ).show();
            }
            else
            {
                jQuery( '.tariff-discount-select' ).hide();
            }
            
            if( producttype == 'simonly' && saletype == 'new' && tarifftype == 'standard' )
            {
                jQuery( '.tariff-type' ).show();
                jQuery( ".tariff_type_select" ).prop( "disabled", false );

                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $simOnly_standard as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
            if( producttype == 'simonly' && saletype == 'upgrade'  && tarifftype == 'standard')
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $simOnly_standard as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
            if( producttype == 'simonly' && saletype == 'new' && tarifftype == 'business' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $simOnly_standard as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
            if( producttype == 'simonly' && saletype == 'upgrade'  && tarifftype == 'business')
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
    
                foreach( $simOnly_standard as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                    <?php
                }
    
                ?>
                
                //clear our error messages
                jQuery( '.type-error' ).hide();
                jQuery( '.type-error' ).text('');
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-type-error' ).text('');
            }
        
            jQuery( '.device_container' ).hide();
            jQuery( '.tariff_container' ).show();
            jQuery( '.tariff-discount-select' ).show();
            jQuery( '.product-discount-select' ).hide();
            jQuery( '.tariff-type' ).show();
            jQuery( '.products-legend' ).hide();
            jQuery( '.product-fieldset' ).hide();
            jQuery( '.tariff-legend' ).show();
            jQuery( '.tariff-fieldset' ).show();
            
            jQuery( '.product-type-error' ).hide();
            jQuery( '.product-type-error' ).html( '' );

            //undisable all our fields
            jQuery( ".tariff_type_select" ).prop( "disabled", false );
            jQuery( ".tariff" ).prop( "disabled", false );

            jQuery( ".device" ).prop( "disabled", true );
            jQuery( ".product-discount-select" ).prop( "disabled", true );
            jQuery( ".discount-type" ).prop( "disabled", true );
            
            //add our discount options
            jQuery( '.tariff_type_select' )
                .empty()
                .append('<option value="">Tariff Type</option>')
                .append('<option value="standard">Standard Tariffs</option>')
                .append('<option value="business">Business Tariffs</option>');
        }

        jQuery(".device").select2(
        {
            width: '100%',
        });

        jQuery(".tariff").select2(
        {
            width: '100%',
        });
    });
    
    jQuery( '.broadband-tv-type' ).change(function() 
    {
        jQuery( '.broadband-tv-error' ).text('');
    });
    
    //our profit functions now
    jQuery( '.tariff' ).change(function() 
    {
        tariff_profit = 0;
        tariff_old = 0;
        
        var productoption = jQuery( '.product_type' ).find('option:selected');
        var producttype = productoption.val();
        var handsetoption = jQuery( '.device' ).find('option:selected');
        var handset = handsetoption.text();
        var saleoption = jQuery( '.type' ).find('option:selected');
        var sale_type = saleoption.val();
        var tariffoption = jQuery( '.tariff_type_select' ).find('option:selected');
        var tariff_type = tariffoption.val();
        mrc = jQuery(this).val();
        
        //get the current option
        var option = jQuery( this ).find('option:selected');

        //get the tariff from the option
        var tariff = option.text();
        var value = option.text();
        
        if( value == 'Choose Tariff' )
        {
            jQuery( '.pl' ).val('');
            jQuery( ".tariff-discount-type" ).prop( "disabled", true );
            
            jQuery( '.broadband-tv-select' ).hide();
            jQuery( ".broadband-tv-type" ).prop( "disabled", true );
        }
        else
        {
            
            jQuery( '.broadband-tv-error' ).hide();
            jQuery( '.broadband-tv-error' ).text('');
            
            //if( saletype == 'upgrade' && tarifftype == 'hsm' )
            //{
            //    tariff_profit += 0;
            //    tariff_old += 0;
            //}
            //else
            //{
            
            if(producttype == 'handset' && handset == 'Choose Device')
            {
                jQuery('.tariff').val("").trigger('change');
                jQuery('.tariff-error').html('Please choose your device before choosing tariff').css("color", "red");
                jQuery('.tariff-error').show();
            }else if(producttype == 'handset') {
                console.log('handset');
                
                jQuery('.tariff-error').html('');
                jQuery('.tariff-error').hide();
                
                handset_cost = parseFloat(handsetoption.val());
                //set up our multiplier
                multiplier = 0;
                
                if(handset_cost >= <?= floatval($multiplier_values['business_handset_above_amount']); ?> && tariff_type == 'business')
                {
                    <?php
                    $tier1 = explode("-", $multiplier_values['business_tier_1_amount']);
                    $tier2 = explode("-", $multiplier_values['business_tier_2_amount']);
                    $tier3 = explode("-", $multiplier_values['business_tier_3_amount']);
                    $tier4 = explode("-", $multiplier_values['business_tier_4_amount']);
                    $tier5 = str_replace("+", "", $multiplier_values['business_tier_5_amount']);
                    
                    $tier1Lower = str_replace(' ','',$tier1[0]);
                    $tier1Higher = str_replace(' ','',$tier1[1]);
                    $tier2Lower = str_replace(' ','',$tier2[0]);
                    $tier2Higher = str_replace(' ','',$tier2[1]);
                    $tier3Lower = str_replace(' ','',$tier3[0]);
                    $tier3Higher = str_replace(' ','',$tier3[1]);
                    $tier4Lower = str_replace(' ','',$tier4[0]);
                    $tier4Higher = str_replace(' ','',$tier4[1]);
                    $tier5Value = str_replace(' ','',$tier5);
                    ?>
                    
                    if(mrc > <?= $tier1Lower; ?> && mrc <= <?= $tier1Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['business_tier_1_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier2Lower; ?> && mrc <= <?= $tier2Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['business_tier_2_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier3Lower; ?> && mrc <= <?= $tier3Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['business_tier_3_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier4Lower; ?> && mrc <= <?= $tier4Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['business_tier_4_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier5Value; ?>)
                    {
                        multiplier = <?= $multiplier_values['business_tier_5_multiplier']; ?>;
                    }
                } 
                else if(handset_cost >= <?= floatval($multiplier_values['consumer_handset_above_amount']); ?> && tariff_type == 'standard')
                {
                    <?php
                    $tier1 = explode("-", $multiplier_values['consumer_tier_1_amount']);
                    $tier2 = explode("-", $multiplier_values['consumer_tier_2_amount']);
                    $tier3 = explode("-", $multiplier_values['consumer_tier_3_amount']);
                    $tier4 = explode("-", $multiplier_values['consumer_tier_4_amount']);
                    $tier5 = str_replace("+", "", $multiplier_values['consumer_tier_5_amount']);
                    
                    $tier1Lower = str_replace(' ','',$tier1[0]);
                    $tier1Higher = str_replace(' ','',$tier1[1]);
                    $tier2Lower = str_replace(' ','',$tier2[0]);
                    $tier2Higher = str_replace(' ','',$tier2[1]);
                    $tier3Lower = str_replace(' ','',$tier3[0]);
                    $tier3Higher = str_replace(' ','',$tier3[1]);
                    $tier4Lower = str_replace(' ','',$tier4[0]);
                    $tier4Higher = str_replace(' ','',$tier4[1]);
                    $tier5Value = str_replace(' ','',$tier5);
                    ?>
                    
                    if(mrc > <?= $tier1Lower; ?> && mrc <= <?= $tier1Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['consumer_tier_1_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier2Lower; ?> && mrc <= <?= $tier2Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['consumer_tier_2_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier3Lower; ?> && mrc <= <?= $tier3Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['consumer_tier_3_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier4Lower; ?> && mrc <= <?= $tier4Higher; ?>)
                    {
                        multiplier = <?= $multiplier_values['consumer_tier_4_multiplier']; ?>;
                    }
                    else if(mrc >= <?= $tier5Value; ?>)
                    {
                        multiplier = <?= $multiplier_values['consumer_tier_5_multiplier']; ?>;
                    }
                } 
                else if(tariff_type == 'business')
                {
                    if( sale_type == 'new') {
                        multiplier = <?= $multiplier_values['business_new_handset_multiplier']; ?>
                    }else if( sale_type == 'upgrade') {
                        multiplier = <?= $multiplier_values['business_upgrade_handset_multiplier']; ?>
                    }
                }
                else if(tariff_type == 'standard')
                {
                    if( sale_type == 'new') {
                        multiplier = <?= $multiplier_values['consumer_new_handset_multiplier']; ?>
                    }else if( sale_type == 'upgrade') {
                        multiplier = <?= $multiplier_values['consumer_upgrade_handset_multiplier']; ?>
                    }
                } else {
                    //this is our other tariff types, these can be worked out normally
                            
                    tariff_profit = mrc;
                    tariff_old = mrc;
                    
                    if( Number.isNaN( tariff_profit ) )
                    {
                        tariff_profit = 0;
                        tariff_old = 0;
                    }
                    
                    if( percentage > 0 )
                    {
                        var reduce = percent( tariff_profit, percentage );
                        reduce = parseFloat( reduce );
                        reduce = reduce.toFixed( 2 );
                            
                        tariff_profit = tariff_profit - reduce;
                        tariff_old = tariff_profit - reduce;
                    }
                    
                    jQuery('.tp-old').val(tariff_profit);
                    
                    calculate_total_profit();
                }
                
                //work out our profits
                if(tariff_type == 'business')
                {
                    tariff_profit = parseFloat(mrc) * parseFloat(multiplier);
                    tariff_old += parseFloat(mrc) * parseFloat(multiplier);
                }
                if(tariff_type == 'standard')
                {
                    tariff_profit = parseFloat(mrc) * 0.83 * parseFloat(multiplier);
                    tariff_old += parseFloat(mrc) * 0.83 * parseFloat(multiplier);
                }
                
                if( Number.isNaN( tariff_profit ) )
                {
                    tariff_profit = 0;
                    tariff_old = 0;
                }
                
                if( percentage > 0 )
                {
                    var reduce = percent( tariff_profit, percentage );
                    reduce = parseFloat( reduce );
                    reduce = reduce.toFixed( 2 );
                        
                    tariff_profit = tariff_profit - reduce;
                    tariff_old = tariff_profit - reduce;
                }
                
                jQuery('.tp-old').val(tariff_profit);
                
                calculate_total_profit();
            } else if(producttype == 'simonly') {
                multiplier = 0;
                
                if(tariff_type == 'business')
                {
                    if( sale_type == 'new') {
                        multiplier = <?= $multiplier_values['business_new_sim_multiplier']; ?>;
                    }else if( sale_type == 'upgrade') {
                        multiplier = <?= $multiplier_values['business_upgrade_sim_multiplier']; ?>;
                    }
                    
                    tariff_profit = parseFloat(mrc) * parseFloat(multiplier);
                    tariff_old += parseFloat(mrc) * parseFloat(multiplier);
                }
                if(tariff_type == 'standard')
                {
                    if( sale_type == 'new') {
                        multiplier = <?= $multiplier_values['consumer_new_sim_multiplier']; ?>;
                    }else if( sale_type == 'upgrade') {
                        multiplier = <?= $multiplier_values['consumer_upgrade_sim_multiplier']; ?>;
                    }
                    
                    tariff_profit = parseFloat(mrc) * 0.83 * parseFloat(multiplier);
                    tariff_old += parseFloat(mrc) * 0.83 * parseFloat(multiplier);
                }
                
                if( Number.isNaN( tariff_profit ) )
                {
                    tariff_profit = 0;
                    tariff_old = 0;
                }
                
                if( percentage > 0 )
                {
                    var reduce = percent( tariff_profit, percentage );
                    reduce = parseFloat( reduce );
                    reduce = reduce.toFixed( 2 );
                        
                    tariff_profit = tariff_profit - reduce;
                    tariff_old = tariff_profit - reduce;
                }
                
                jQuery('.tp-old').val(tariff_profit);
                
                calculate_total_profit();
            } else {
                tariff_profit = mrc;
                tariff_old = mrc;
                
                if( Number.isNaN( tariff_profit ) )
                {
                    tariff_profit = 0;
                    tariff_old = 0;
                }
                
                if( percentage > 0 )
                {
                    var reduce = percent( tariff_profit, percentage );
                    reduce = parseFloat( reduce );
                    reduce = reduce.toFixed( 2 );
                        
                    tariff_profit = tariff_profit - reduce;
                    tariff_old = tariff_profit - reduce;
                }
                
                jQuery('.tp-old').val(tariff_profit);
                
                calculate_total_profit();
            }
    
            //}
            
            //get the current option
            var option = jQuery( '.product_type' ).find('option:selected');
    
            //get the value from the option
            var value = option.val();
            
            if( value !== 'homebroadband' )
            {
                if( tarifftype == 'hsm' )
                {
                    jQuery( ".tariff-discount-select" ).hide();

                    jQuery( ".tariff-discount-type" ).prop( "disabled", true );
                }
                else
                {
                    jQuery( ".tariff-discount-type" ).prop( "disabled", false );
                    jQuery( ".tariff-discount-select" ).show();
                }
                
                //hide our tv options
                jQuery( '.broadband-tv-select' ).hide();
                jQuery( ".broadband-tv-type" ).prop( "disabled", true );
            }
            else
            {
                jQuery( '.broadband-tv-select' ).show();
                jQuery( ".broadband-tv-type" ).prop( "disabled", false );
                
                jQuery( ".broadband-tv-type" ).select2(
                {
                    width: '100%',
                });
            }
        }
    });
    
    jQuery( '.device' ).change(function() 
    {
        device_profit = 0;
        
        //get the current option
        var option = jQuery( this ).find('option:selected');

        //get the value from the option
        var value = option.val();
        
        jQuery('.tariff').val('').trigger('change');
        
        if( value == '' )
        {
            device_profit = 0;
            jQuery( '.pl' ).val('');
            
            jQuery( ".discount-type" ).prop( "disabled", true );
        }
        else
        {
            jQuery( '.device-error' ).hide();
            jQuery( '.device-error' ).text('');
            
            value = parseFloat( 0 );
            
            device_profit += value;
            
            jQuery( ".discount-type" ).prop( "disabled", false );
        }
        
        if( Number.isNaN( dprofit ) )
        {
            device_profit = 0;
        }
        
        calculate_total_profit();
    });
    
    jQuery( '.accessories' ).change(function() 
    {
        accessories_profit = 0;
        
        //get the current option
        var option = jQuery( this ).find('option:selected');

        //get the value from the option
        var value = option.val();
        var accessory = option.text();
        
        //reset our discount input
        jQuery( '.accessory_discount' ).val('');
        accessory_discount = 0;
        
        if( value !== '' )
        {
            jQuery( '.accessories-error' ).hide();
            jQuery( '.accessories-error' ).text('');
            
            value = parseFloat( value );
            
            var data = {};
            
            data['action'] = 'fc_get_accessory_profit';
            data['nonce'] = fc_nonce;
            data['accessory'] = accessory;
            
            jQuery.ajax({
            	type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {	
                    accessories_profit = data.data;
                    accessory_profit();
                },
            });
            
            function accessory_profit()
            {
                accessories_profit = accessories_profit.toFixed( 2 );
                
                if( Number.isNaN( accessories_profit ) )
                {
                    accessories_profit = 0;
                }
                
                if( accessories_profit == 0 )
                {
                    jQuery( '.accessory-profit' ).text('');
                    jQuery( ".accessory_discount" ).prop( "disabled", true );
                    accessory_discount = 0;
                }
                else
                {
                    jQuery( '.accessory-profit' ).text( 'Accessories Profit: £' + accessories_profit );

                    jQuery( ".accessory-discount-left" ).text( 'You have £' + accessories_profit + ' discount available to use' );
                    jQuery( '.accessory-discount' ).show();
                    jQuery( '.ap' ).val( accessories_profit );
                    jQuery( '.ap-old' ).val( accessories_profit );
                    
                    calculate_total_profit();
                }
            }
        }
        else
        {
            accessory_profit = 0;
            jQuery( '.accessory-profit' ).text('');
            jQuery( '.accessory-discount' ).hide();
            jQuery( ".accessory_discount" ).prop( "disabled", true );
            
            jQuery( '.ap' ).val( '' );
            jQuery( '.ap-old' ).val( '' );
            
            calculate_total_profit();
        }
        
        //accessory discount left
        jQuery( ".accessory_discount" ).keyup(function() 
        {
            var ainput = this.value;
            accessory_discount = this.value;
            var temp = jQuery( '.ap-old' ).val();
            
            if ( ainput == '' )
            {
                temp = jQuery( '.ap-old' ).val();
                    
                temp =  parseFloat( temp );
                    
                jQuery( ".accessory-discount-left" ).text( 'You have £' + temp + ' discount available to use' );
                    
                jQuery( '.accessory-profit' ).text( 'Accessories Profit: £' + temp );
                jQuery( '.ap' ).val( temp );
                    
                total_profit = parseFloat( tariff_profit ) + parseFloat( temp ) + parseFloat( insurance_profit );
                
                total_profit = parseFloat( total_profit )
                    
                total_profit =  total_profit.toFixed( 2 );
                    
                jQuery( '.total-profit' ).text( 'Total Profit: £' + total_profit );
                
                jQuery( '.tp' ).val( total_profit );
                jQuery( '.dp' ).val( total_profit );
                jQuery( '.old' ).val( total_profit );
                    
                jQuery( ".save-sales" ).prop( "disabled", false );
                
                accessory_profit = 0;
            }
            
            if ( ainput < 0 )
            {
                temp = jQuery( '.ap-old' ).val();
                    
                temp =  parseFloat( temp );
                    
                jQuery( ".accessory-discount-left" ).html( 'You cannot use a negative number' );
                    
                jQuery( '.accessory-profit' ).text( 'Accessories Profit: £' + temp );
                jQuery( '.ap' ).val( temp );
                    
                total_profit = parseFloat( tariff_profit ) + parseFloat( temp ) + parseFloat( insurance_profit );
                
                total_profit = parseFloat( total_profit )
                    
                total_profit =  total_profit.toFixed( 2 );
                    
                jQuery( '.total-profit' ).text( 'Total Profit: £' + total_profit );
                
                jQuery( '.tp' ).val( total_profit );
                jQuery( '.dp' ).val( total_profit );
                jQuery( '.old' ).val( total_profit );
                    
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
            
            if( ! isNaN( ainput ) )
            {
                temp = jQuery( '.ap-old' ).val();
                
                temp =  parseFloat( temp );
                
                ainput = parseFloat( ainput );
                
                temp = temp - ainput;
                
                temp =  parseFloat( temp );
                
                temp = temp.toFixed( 2 );
                
                if( temp >= 0 )
                {
                    jQuery( ".accessory-discount-left" ).text( 'You have £' + temp + ' discount available to use' );
                    
                    jQuery( '.accessory-profit' ).text( 'Accessories Profit: £' + temp );
                    
                    jQuery( '.ap' ).val( temp );
                    
                    total_profit = parseFloat( tariff_profit ) + parseFloat( temp ) + parseFloat( insurance_profit );
                    
                    total_profit = parseFloat( total_profit )
                    
                    total_profit =  total_profit.toFixed( 2 );
                    
                    jQuery( '.total-profit' ).text( 'Total Profit: £' + total_profit );
                    
                    jQuery( '.tp' ).val( total_profit );
                    jQuery( '.dp' ).val( total_profit );
                    jQuery( '.old' ).val( total_profit );
                    
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
                
                if( temp < 0 )
                {
                    accessories_profit = jQuery( '.ap-old' ).val();
                    
                    jQuery( ".accessory-discount-left" ).html( '<p style="color:red;"> You have used more than your available discount, available discount is £' + accessories_profit +'</p>' );
                    
                    jQuery( '.accessory-profit' ).text( 'Accessories Profit: £' + accessories_profit );
                    
                    jQuery( '.ap' ).val( accessories_profit );
                    
                    total_profit = parseFloat( tariff_profit ) + parseFloat( accessories_profit ) + parseFloat( insurance_profit );
                    
                    total_profit = parseFloat( total_profit );
                    
                    total_profit =  total_profit.toFixed( 2 );
                    
                    jQuery( '.total-profit' ).text( 'Total Profit: £' + total_profit );
                    
                    jQuery( '.tp' ).val( total_profit );
                    jQuery( '.dp' ).val( total_profit );
                    jQuery( '.old' ).val( total_profit );
                    
                    jQuery( ".save-sales" ).prop( "disabled", true );
                }
            }
            else
            {
                jQuery( ".accessory-discount-left" ).html( '<p style="color:red;">Please enter a valid number</p>' );
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
        });
    });
    
    //our variables are set here
    
    var new_profit = '';
        
    var profit_minus = '';
                
    var reduce = '';
    
    var profit = jQuery( '.dp' ).val();
    
    var old = jQuery( '.old' ).val();

    jQuery( ".product_discount" ).keyup(function() 
    {
        if( this.value == '' )
        {
            old = jQuery( '.old' ).val();
            
            jQuery( '.total-profit' ).text('Total Profit: £' + old );
                    
            jQuery( '.tp' ).val( old );
            
            jQuery( '.save-sales' ).prop('disabled', false );
        }
        
        var discount = jQuery( '.product_discount' ).attr( 'discount');
        
        var block = false;
        
        if( ! jQuery('.accessory_discount').prop('disabled') )
        {
            //accessories discount is not disabled
            //get the tariff discount option
            var avalue = jQuery( '.accessory_discount' ).val();
        }
        
        //get the tariff discount option
        var toption = jQuery( '.tariff-discount-type' ).find('option:selected');

        //get the value from the option
        var tvalue = toption.val();
        
        if( discount == 'franchise' )
        {
            profit = jQuery( '.dp' ).val();
            
            if( profit == "" )
            {
                jQuery( ".product-discount-left" ).html( '<p style="color:red;">You have no profit to use this, please set the tariff and accessories first to generate your profit.</p>' );
                block = true;
                jQuery( '.product_discount' ).val( '' );
            }
            else
            {
                if( tvalue == '' )
                {
                    jQuery( ".product-discount-left" ).html( '<p style="color:red;">You need to set your tariff discount.</p>' );
                    block = true;
                    jQuery( '.product_discount' ).val( '' );
                }
                if( avalue == '' )
                {
                    jQuery( ".product-discount-left" ).html( '<p style="color:red;">You need to input your accessory discount first.</p>' );
                    block = true;
                    jQuery( '.product_discount' ).val( '' );
                }
                else
                {
                    profit =  parseFloat( profit );
                    
                    reduce = percent( this.value , 20 );
                    
                    profit_minus = parseFloat( this.value ) - parseFloat( reduce );
                    
                    new_profit = '';
                    
                    new_profit = parseFloat( profit ) - parseFloat( profit_minus );
                    
                    if( new_profit < profit )
                    {
                        new_profit = new_profit.toFixed( 2 );
                        
                        jQuery( '.total-profit' ).text('Total Profit: £' + new_profit );
                        jQuery( '.tp' ).val( new_profit );
                        
                        jQuery( '.save-sales' ).prop('disabled', false );
                    }
                    
                    if( new_profit < 0 )
                    {
                        jQuery( ".product-discount-left" ).html( '<p style="color:red;">You cannot use this amount as you will have a negative profit.</p>' );
                        
                        jQuery( '.total-profit' ).text('Total Profit: £' + new_profit );
                        
                        jQuery( '.tp' ).val( new_profit );
    
                        block = true;
                        
                        jQuery( '.save-sales' ).prop('disabled', true );
                    }
                    
                    if( this.value < 0 )
                    {
                        old = jQuery( '.old' ).val();
                        
                        jQuery( ".product-discount-left" ).html( '<p style="color:red;">Your discount cannot be negative</p>' );
                        block = true;
                        jQuery( '.product_discount' ).val( '' );
                        
                        jQuery( '.total-profit' ).text('Total Profit: £' + old );
                                
                        jQuery( '.tp' ).val( old );
                        
                        jQuery( '.save-sales' ).prop('disabled', true );
                    }
                }
            }
        }
        else
        {
            if( this.value < 0 )
            {
                jQuery( ".product-discount-left" ).html( '<p style="color:red;">Your discount cannot be negative</p>' );
                block = true;
            }
        }
        
        if( ! block )
        {
            var pinput = this.value;
            
            var pdiscount = '';
            
            if( discount == 'franchise' )
            {
                pdiscount = franchise_discount;
            }
            else if( discount == 'regional' )
            {
                pdiscount = rm_discount;
            }
            
            var temp = '';
            
            if ( pinput == '' )
            {
                if( discount == 'franchise' )
                {
                    temp = franchise_discount;
                }
                else if( discount == 'regional' )
                {
                    temp = rm_discount;
                }
    
                jQuery( ".product-discount-left" ).text( 'You have £' + temp + ' discount available to use' );
                    
                jQuery( ".save-sales" ).prop( "disabled", false );
            }
    
            if( ! isNaN( pinput ) )
            {
                temp = pdiscount;
    
                pinput = parseFloat( pinput );
    
                temp = temp - pinput;
    
                temp = temp.toFixed( 2 );
    
                if ( isNaN( pinput ) )
                {
                    temp = pdiscount;
    
                    jQuery( ".product-discount-left" ).text( 'You have £' + temp + ' discount available to use' );
                    
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp >= 0 )
                {
                    jQuery( ".product-discount-left" ).text( 'You have £' + temp + ' discount available to use' );
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp < 0 )
                {
                    jQuery( ".product-discount-left" ).html( '<p style="color:red;"> You have used more than your available discount, available discount is £' + pdiscount +'</p>' );
                    jQuery( ".save-sales" ).prop( "disabled", true );
                }
            }
            else
            {
                jQuery( ".product-discount-left" ).html( '<p style="color:red;">Please enter a valid number</p>' );
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
        }
    });
    
    jQuery( ".product_discount_2" ).keyup(function() 
    {
        if( this.value == '' )
        {
            old = jQuery( '.old' ).val();
            
            jQuery( '.total-profit' ).text('Total Profit: £' + old );
                    
            jQuery( '.tp' ).val( old );
            
            jQuery( '.save-sales' ).prop('disabled', false );
        }
        
        var discount = jQuery( '.product_discount_2' ).attr( 'discount');
        
        var block = false;
        
        if( ! jQuery('.accessory_discount').prop('disabled') )
        {
            //accessories discount is not disabled
            //get the tariff discount option
            var avalue = jQuery( '.accessory_discount' ).val();
        }
        
        //get the tariff discount option
        var toption = jQuery( '.tariff-discount-type' ).find('option:selected');

        //get the value from the option
        var tvalue = toption.val();
        
        if( discount == 'franchise' )
        {
            profit = jQuery( '.dp' ).val();
            
            if( profit == "" )
            {
                jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">You have no profit to use this, please set the tariff and accessories first to generate your profit.</p>' );
                block = true;
                jQuery( '.product_discount_2' ).val( '' );
            }
            else
            {
                if( tvalue == '' )
                {
                    jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">You need to set your tariff discount.</p>' );
                    block = true;
                    jQuery( '.product_discount_2' ).val( '' );
                }
                if( avalue == '' )
                {
                    jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">You need to input your accessory discount first.</p>' );
                    block = true;
                    jQuery( '.product_discount_2' ).val( '' );
                }
                else
                {
                    profit =  parseFloat( profit );
                    
                    reduce = percent( this.value , 20 );
                    
                    profit_minus = parseFloat( this.value ) - parseFloat( reduce );
                    
                    new_profit = '';
                    
                    new_profit = parseFloat( profit ) - parseFloat( profit_minus );
                    
                    if( new_profit < profit )
                    {
                        new_profit = new_profit.toFixed( 2 );
                        
                        jQuery( '.total-profit' ).text('Total Profit: £' + new_profit );
                        jQuery( '.tp' ).val( new_profit );
                        
                        jQuery( '.save-sales' ).prop('disabled', false );
                    }
                    
                    if( new_profit < 0 )
                    {
                        jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">You cannot use this amount as you will have a negative profit.</p>' );
                        
                        jQuery( '.total-profit' ).text('Total Profit: £' + new_profit );
                        
                        jQuery( '.tp' ).val( new_profit );
    
                        block = true;
                        
                        jQuery( '.save-sales' ).prop('disabled', true );
                    }
                    
                    if( this.value < 0 )
                    {
                        old = jQuery( '.old' ).val();
                        
                        jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">Your discount cannot be negative</p>' );
                        block = true;
                        jQuery( '.product_discount_2' ).val( '' );
                        
                        jQuery( '.total-profit' ).text('Total Profit: £' + old );
                                
                        jQuery( '.tp' ).val( old );
                        
                        jQuery( '.save-sales' ).prop('disabled', true );
                    }
                }
            }
        }
        else
        {
            if( this.value < 0 )
            {
                jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">Your discount cannot be negative</p>' );
                block = true;
            }
        }
        
        if( ! block )
        {
            var pinput = this.value;
            
            var pdiscount = '';
            
            if( discount == 'franchise' )
            {
                pdiscount = franchise_discount;
            }
            else if( discount == 'regional' )
            {
                pdiscount = rm_discount;
            }
            
            var temp = '';
            
            if ( pinput == '' )
            {
                var temp = '';
                
                if( discount == 'franchise' )
                {
                    temp = franchise_discount;
                }
                else if( discount == 'regional' )
                {
                    temp = rm_discount;
                }
    
                jQuery( ".product-discount-2-left" ).text( 'You have £' + temp + ' discount available to use' );
                    
                jQuery( ".save-sales" ).prop( "disabled", false );
            }
    
            if( ! isNaN( pinput ) )
            {
                temp = pdiscount;
    
                pinput = parseFloat( pinput );
    
                temp = temp - pinput;
    
                temp = temp.toFixed( 2 );
    
                if ( isNaN( pinput ) )
                {
                    temp = pdiscount;
    
                    jQuery( ".product-discount-2-left" ).text( 'You have £' + temp + ' discount available to use' );
                    
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp >= 0 )
                {
                    jQuery( ".product-discount-2-left" ).text( 'You have £' + temp + ' discount available to use' );
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp < 0 )
                {
                    jQuery( ".product-discount-2-left" ).html( '<p style="color:red;"> You have used more than your available discount, available discount is £' + pdiscount +'</p>' );
                    jQuery( ".save-sales" ).prop( "disabled", true );
                }
            }
            else
            {
                jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">Please enter a valid number</p>' );
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
        }
    });
    
    jQuery( ".tariff_discount" ).keyup(function() 
    {
        var reduce = '';
        
        //get the current option
        var option = jQuery( '.tariff-discount-type' ).find('option:selected');

        //get the value from the option
        var value = option.val();
        
        if(value == 'perk' || value == 'compass') {
            percentage = this.value;
        
            if( percentage == '' )
            {   
                percentage = 0;
                jQuery( '.tariff-discount-left' ).text( '' );
                percent_profit_loss();
                
                jQuery( ".save-sales" ).prop( "disabled", false );
            }
            
            if( percentage <= 25 && percentage > 0 )
            {
                jQuery( '.tariff-discount-left' ).html( '' );
    
                if( tariff_profit > 0 )
                {
                    tariff_profit = tariff_old;
                    reduce = percent( tariff_profit, percentage );
                    
                    reduce = parseFloat( reduce );
                    reduce = reduce.toFixed( 2 );
                
                    tariff_profit = tariff_profit - reduce;
                }
                            
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", false );
            }
            else if( percentage > 25)
            {
                percentage = 0;
                tariff_profit = tariff_old;
                
                jQuery( '.tariff-discount-left' ).html( '<p style="color:red">Your percentage cannot be higher than 25</p>' );
                jQuery( '.tariff_discount' ).val( '' );
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
            else if( percentage == 0 )
            {
                percentage = 0;
                tariff_profit = tariff_old;
                
                jQuery( '.tariff-discount-left' ).html( '<p style="color:red">You cannot have a negative percentage</p>' );
                jQuery( '.tariff_discount' ).val( '' );
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
            else if( percentage < 0 )
            {
                percentage = 0;
                tariff_profit = tariff_old;
                
                jQuery( '.tariff-discount-left' ).html( '<p style="color:red">You cannot have a negative percentage</p>' );
                jQuery( '.tariff_discount' ).val( '' );
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
        } else {
            var amount = this.value;
            
            if( amount == '' )
            {   
                amount = 0;
                jQuery( '.tariff-discount-left' ).text( '' );
                
                tariff_profit = tariff_old;
                    
                percent_profit_loss();
                
                jQuery( ".save-sales" ).prop( "disabled", false );
            }
            
            if( amount <= parseFloat(mrc) && amount > 0 )
            {
                jQuery( '.tariff-discount-left' ).html( '' );
                var tariffoption = jQuery( '.tariff_type_select' ).find('option:selected');
                var tariff_type = tariffoption.val();
    
                if( tariff_profit > 0 )
                {
                    if(tariff_type == 'business')
                    {
                        newmrc = parseFloat(mrc) - parseFloat(amount);
                        tariff_profit = parseFloat(newmrc) * parseFloat(multiplier);
                    }
                    if(tariff_type == 'standard')
                    {
                        newmrc = parseFloat(mrc) - parseFloat(amount);
                        tariff_profit = parseFloat(newmrc) * 0.83 * parseFloat(multiplier);
                    }
                }
                            
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", false );
            } else if( amount > parseFloat(mrc))
            {
                amount = 0;
                tariff_profit = tariff_old;
                
                jQuery( '.tariff-discount-left' ).html( '<p style="color:red">Your amount cannot be higher than ' + mrc + '</p>' );
                jQuery( '.tariff_discount' ).val( '' );
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
            else if( amount == 0 )
            {
                amount = 0;
                tariff_profit = tariff_old;
                
                jQuery( '.tariff-discount-left' ).html( '<p style="color:red">You cannot have a negative amount</p>' );
                jQuery( '.tariff_discount' ).val( '' );
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
            else if( amount < 0 )
            {
                amount = 0;
                tariff_profit = tariff_old;
                
                jQuery( '.tariff-discount-left' ).html( '<p style="color:red">You cannot have a negative amount</p>' );
                jQuery( '.tariff_discount' ).val( '' );
                percent_profit_loss();
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
        }
    });
</script>

<?php
