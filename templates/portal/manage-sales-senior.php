<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

$first_name = get_user_meta( $user->ID, 'first_name', true );
$last_name = get_user_meta( $user->ID, 'last_name', true );

$full_name = $first_name . ' ' . $last_name;

$salesemployees = fc_get_sale_users();
$employees = fc_get_users();
$location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );

$locations = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

foreach ( $results as $result )
{
    $locations[] = $result->location;
}

$rm_discount = array();
$fran_discount = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_tracker" ) );

foreach ( $results as $result )
{
    $rm_discount[ $result->store ] = $result->regionalManager;
    $fran_discount[ $result->store ] = $result->franchise;
}

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_discount_pots" ) );

foreach ( $results as $result )
{
    $rm_discount_pot[ $result->store ] = $result->regionalManager;
    $fran_discount_pot[ $result->store ] = $result->franchise;
}

$rm_discount_used = floatval( $rm_discount_pot[ $location ] ) - floatval( $rm_discount[ $location ] );

$franchise_used = floatval( $fran_discount_pot[ $location ] ) - floatval( $fran_discount[ $location ] );

$profit = '';
$daily_profit = '';
$profit_target = '';
$profit_variance = '';

//get our profit info
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info" ) );

foreach ( $results as $result )
{
    if( $result->store == $location )
    {
        $profit = floatval( $profit ) + floatval( $result->total_profit );
        $profit = number_format((float)$profit, 2, '.', '');
    }
}

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE()" ) );
    
foreach ( $results as $result )
{
    if( $result->store == $location )
    {
        $daily_profit = floatval( $daily_profit ) + floatval( $result->total_profit );
    }
}

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_profit_targets" ) );

foreach ( $results as $result )
{
    if( $result->store == $location )
    {
        $profit_target = floatval( $result->target );
        $profit_target = number_format((float)$profit_target, 2, '.', '');
    }
}

if( $profit > $profit_target )
{
    $profit_variance = $profit - $profit_target;
    $profit_variance = number_format((float)$profit_variance, 2, '.', '');
    $profit_variance = '+' . $profit_variance;
}
else
{
    $profit_variance = $profit_target - $profit;
    $profit_variance = number_format((float)$profit_variance, 2, '.', '');
    $profit_variance = '-' . $profit_variance;
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

//get our tariffs info
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_tariffs" ) );

foreach ( $results as $result )
{
    if ( $result->type == 'HSM')
    {
        $hsmtariff_new[ $result->tariff ] = $result->new_price;
        $hsmtariff_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'TLO')
    {
        $tlotariff_new[ $result->tariff ] = $result->new_price;
        $tlotariff_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'Connected')
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
    if ( $result->type == 'Tablet')
    {
        $tablet_new[ $result->tariff ] = $result->new_price;
        $tablet_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'Home Broadband')
    {
        $broadband_new[ $result->tariff ] = $result->new_price;
        $broadband_upgrade[ $result->tariff ] = $result->upgrade_price;
    }
    if ( $result->type == 'Insurance')
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
    if ( $result->type == 'Standard')
    {
        $standardtariff[ $result->tariff ] = $result->value;
    }
    if ( $result->type == 'Business' )
    {
        $businesstariff[ $result->tariff ] = $result->value;
    }
    if ( $result->type == 'SIMO' )
    {
        $simOnly_standard[ $result->tariff ] = $result->value;
    }
    if ( $result->type == 'BSIMO' )
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

$date = new DateTime(); // For today/now, don't pass an arg.
$enddate = $date->format("Y-m-d");

$results = $wpdb->get_results( $wpdb->prepare( "select sale_date from wp_fc_sales_info order by sale_date asc limit 1;" ) );

foreach ( $results as $result )
{
    $date = $result->sale_date;
}

$createDate = new DateTime( $date );

$startdate = $createDate->format( 'Y-m-d' );

?>

<script>
    var percentage = 0;
    var multiplier = 0;
    var mrc = 0;
    var amount = 0;
    var rmdiscount = 0;
    var frandiscount = 0;
    
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
    
    var type = '';
    
    var action = '';
    
    var tariff_value = '';
    
    var approved_sales = {};
    
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
        
        if(accessory_discount == '')
        {
            accessory_discount = 0;
        }
        
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
            
            var discount_type = jQuery( '.product_discount' ).attr( 'discount' );
            
            var discount_2 = jQuery( '.product_discount_2' ).val();
            
            if( discount_type == 'franchise' )
            {
                jQuery( '.product_discount' ).trigger('keyup');
            }
            if( discount_2 !== '' )
            {
                jQuery( '.product_discount_2' ).trigger('keyup');
            }
            
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
    
    function no_sales()
    {
        jQuery( '#sales' ).children( '.tab' ).remove();
        
        jQuery('.sales-management-container').hide();

        jQuery( '.sales-message' ).text( 'We could not find any sales for this store' );
        jQuery( '#plustab' ).show();
        jQuery( '#minustab' ).addClass( 'disabled' );
        jQuery( '.sales-message' ).show();
        
        //new sale
        jQuery( '.approve-message' ).hide();
        
        document.getElementById('manager-sales-input-form').reset();
        
        jQuery( '.type' ).val( 'new' ).trigger('change');
        jQuery( '.product_type' ).val( '' ).trigger('change');
        jQuery( '.discount-type' ).val( '' ).trigger('change');
        jQuery( '.tariff-discount-type' ).val( '' ).trigger('change');
        jQuery( '.discount-type' ).val( '' ).trigger('change');
        jQuery( '.insurance_type' ).val( '' ).trigger('change');
        
        //reset our radios
        jQuery('.accessory-no').prop('checked', 'checked').trigger('change');
        jQuery('.accessory-discount-no').prop('checked', 'checked').trigger('change');
        jQuery('.insurance-no').prop('checked', 'checked').trigger('change');
        
        //clear our profit text
        jQuery( '.profit-loss' ).text('');
        jQuery( '.accessory-profit' ).text('');
        jQuery( '.insurance-profit' ).text('');
        jQuery( '.total-profit' ).text('');
        
        jQuery( '.product_discount' ).val('');
        jQuery( '.product-discount' ).hide();
        
        jQuery( '.product_discount_2' ).val('');
        jQuery( '.product-discount-2' ).hide();
        
        //update our hidden values
        jQuery( '.pl' ).val('');
        jQuery( '.ap' ).val('');
        jQuery( '.ap-old' ).val('');
        jQuery( '.inpt' ).val('');
        jQuery( '.tp' ).val('');
        jQuery( '.dp' ).val('');
        jQuery( '.old' ).val('');
        
        //remove our errors
        jQuery( '.type-error' ).text('');
        jQuery( '.product-type-error' ).text('');
        jQuery( '.accessories-error' ).text('');
        jQuery( '.accessory-discount-error' ).text('');
        jQuery( '.accessory-discount-left' ).text('');
        jQuery( '.insurance-type-error' ).text('');
        jQuery( '.insurance-choice-error' ).text('');
        jQuery( '.device-error' ).text('');
        jQuery( '.discount-type-error' ).text('');
        jQuery( '.product-discount-left' ).text('');
        jQuery( '.product-discount-2-left' ).text('');
        jQuery( '.tariff-type-error' ).text('');
        jQuery( '.tariff-error' ).text('');
        jQuery( '.broadband-tv-error' ).text( '' );
        jQuery( '.tariff-discount-error' ).text('');
        jQuery( '.tariff-discount-left' ).text('');
        
        //hide them
        jQuery( '.type-error' ).hide();
        jQuery( '.product-type-error' ).hide();
        jQuery( '.accessories-error' ).hide();
        jQuery( '.accessory-discount-error' ).hide();
        jQuery( '.accessory-discount-left' ).hide();
        jQuery( '.insurance-type-error' ).hide();
        jQuery( '.insurance-choice-error' ).hide();
        jQuery( '.device-error' ).hide();
        jQuery( '.discount-type-error' ).hide();
        jQuery( '.product-discount-left' ).hide();
        jQuery( ".product-discount-2-left" ).hide();
        jQuery( '.tariff-type-error' ).hide();
        jQuery( '.tariff-error' ).hide();
        jQuery( '.broadband-tv-error' ).hide();
        jQuery( '.tariff-discount-error' ).hide();
        jQuery( '.tariff-discount-left' ).hide();
        
        jQuery(".save-sales").html("Save Sale");
        
        jQuery(".sale_comment").prop("disabled", true);
        jQuery(".sale-comment").hide();
        
        enable_select2();
        clone_elements();
        
        jQuery( '#minustab' ).hide();
        jQuery("#manager-sales-input-form :input").prop("disabled", true );
    }
    
    function before_new_sale()
    {
        //get our advisors
        var date =jQuery('#sales_date').val();
        var store = jQuery('.store_locations').val();
        var action = 'add';
        
        if( date !==  '' )
        {
            var data = {};
                                            
            data['action'] = 'fc_senior_get_sales_staff';
            data['nonce'] = fc_nonce;
            data['store'] = store;
            data['date'] = date;
            data['type'] = action;
                    
            jQuery.ajax({
                type: 'POST',
                dataType: 'html',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    jQuery( ".sales-advisor" ).html( data );
                                    
                    jQuery( ".advisor" ).select2(
                    {
                        width: '100%',
                    });
                },
            });
        }
        
        //new sale
        jQuery( '#manager-sales-input-form' ).attr( 'sale_id' , '' );
        jQuery( '.type' ).val( 'new' ).trigger('change');
        jQuery( '.product_type' ).val( '' ).trigger('change');
        jQuery( '.tariff_type_select' ).val('').trigger('change');
        jQuery( '.discount-type' ).val('').trigger('change');
        jQuery( '.accessories' ).val('').trigger('change');
        jQuery( '.accessory-discount-left' ).val('');
        jQuery('.advisor_name').val('');
        accessory_discount = 0;

        //now reactivate all our disabled inputs we need
        jQuery(".device").prop("disabled", true);
        jQuery(".discount-type").prop("disabled", true);
        jQuery(".product_discount").prop("disabled", true);
        jQuery(".product_discount_2").prop("disabled", true);
        jQuery(".tariff_type").prop("disabled", true);
        jQuery(".tariff").prop("disabled", true);
        jQuery(".tariff-discount-type").prop("disabled", true);
        jQuery(".tariff_discount").prop("disabled", true);
        jQuery(".accessories").prop("disabled", true);
        jQuery(".accessory_discount").prop("disabled", true);
        jQuery(".insurance_type").prop("disabled", true);

        //reset our radios
        jQuery('.accessory-no').prop('checked', 'checked').trigger('change');
        jQuery('.accessory-discount-no').prop('checked', 'checked').trigger('change');
        jQuery('.insurance-no').prop('checked', 'checked').trigger('change');

        //clear our profit text
        jQuery( '.profit-loss' ).text('');
        jQuery( '.accessory-profit' ).text('');
        jQuery( '.insurance-profit' ).text('');
        jQuery( '.total-profit' ).text('');

        //update our hidden values
        jQuery( '.pl' ).val('').trigger('change');
        jQuery( '.ap' ).val('').trigger('change');
        jQuery( '.ap-old' ).val('').trigger('change');
        jQuery( '.inp' ).val('').trigger('change');
        jQuery( '.tp' ).val('').trigger('change');
        jQuery( '.dp' ).val('').trigger('change');
        jQuery( '.old' ).val('').trigger('change');

        //remove our errors
        jQuery( '.type-error' ).text('');
        jQuery( '.product-type-error' ).text('');
        jQuery( '.accessories-error' ).text('');
        jQuery( '.accessory-discount-error' ).text('');
        jQuery( '.accessory-discount-left' ).text('');
        jQuery( '.insurance-type-error' ).text('');
        jQuery( '.insurance-choice-error' ).text('');
        jQuery( '.device-error' ).text('');
        jQuery( '.discount-type-error' ).text('');
        jQuery( '.product-discount-left' ).text('');
        jQuery( '.product-discount-2-left' ).text('');
        jQuery( '.tariff-type-error' ).text('');
        jQuery( '.tariff-error' ).text('');
        jQuery( '.broadband-tv-error' ).text( '' );
        jQuery( '.tariff-discount-error' ).text('');
        jQuery( '.tariff-discount-left' ).text('');

        //hide them
        jQuery( '.type-error' ).hide();
        jQuery( '.product-type-error' ).hide();
        jQuery( '.accessories-error' ).hide();
        jQuery( '.accessory-discount-error' ).hide();
        jQuery( '.accessory-discount-left' ).hide();
        jQuery( '.insurance-type-error' ).hide();
        jQuery( '.insurance-choice-error' ).hide();
        jQuery( '.device-error' ).hide();
        jQuery( '.discount-type-error' ).hide();
        jQuery( '.product-discount-left' ).hide();
        jQuery( ".product-discount-2-left" ).hide();
        jQuery( '.tariff-type-error' ).hide();
        jQuery( '.tariff-error' ).hide();
        jQuery( '.broadband-tv-error' ).hide();
        jQuery( '.tariff-discount-error' ).hide();
        jQuery( '.tariff-discount-left' ).hide();
        jQuery( '.product-discount-2' ).hide();
        jQuery( '.product-discount' ).hide();
        
        enable_select2();
        clone_elements();
        
        jQuery(".type").prop("disabled", true);
        jQuery(".product_type").prop("disabled", true);
        jQuery(".accessory-radio").prop("disabled", true);
        jQuery(".insurance-radio").prop("disabled", true);
        jQuery('.advisor-name').hide();
    }
    
    function new_sale()
    {
        //new sale
        jQuery( '#manager-sales-input-form' ).attr( 'sale_id' , '' );
        jQuery( '.type' ).val( 'new' ).trigger('change');
        jQuery( '.product_type' ).val( '' ).trigger('change');
        jQuery( '.tariff_type_select' ).val('').trigger('change');
        jQuery( '.discount-type' ).val('').trigger('change');
        jQuery( '.accessories' ).val('').trigger('change');
        jQuery( '.accessory-discount-left' ).val('');

        //now reactivate all our disabled inputs we need
        jQuery(".device").prop("disabled", true);
        jQuery(".discount-type").prop("disabled", true);
        jQuery(".product_discount").prop("disabled", true);
        jQuery(".product_discount_2").prop("disabled", true);
        jQuery(".tariff_type").prop("disabled", true);
        jQuery(".tariff").prop("disabled", true);
        jQuery(".tariff-discount-type").prop("disabled", true);
        jQuery(".tariff_discount").prop("disabled", true);
        jQuery(".accessories").prop("disabled", true);
        jQuery(".accessory_discount").prop("disabled", true);
        jQuery(".insurance_type").prop("disabled", true);

        //reset our radios
        jQuery('.accessory-no').prop('checked', 'checked').trigger('change');
        jQuery('.accessory-discount-no').prop('checked', 'checked').trigger('change');
        jQuery('.insurance-no').prop('checked', 'checked').trigger('change');

        //clear our profit text
        jQuery( '.profit-loss' ).text('');
        jQuery( '.accessory-profit' ).text('');
        jQuery( '.insurance-profit' ).text('');
        jQuery( '.total-profit' ).text('');

        //update our hidden values
        jQuery( '.pl' ).val('').trigger('change');
        jQuery( '.ap' ).val('').trigger('change');
        jQuery( '.ap-old' ).val('').trigger('change');
        jQuery( '.inp' ).val('').trigger('change');
        jQuery( '.tp' ).val('').trigger('change');
        jQuery( '.dp' ).val('').trigger('change');
        jQuery( '.old' ).val('').trigger('change');

        //remove our errors
        jQuery( '.type-error' ).text('');
        jQuery( '.product-type-error' ).text('');
        jQuery( '.accessories-error' ).text('');
        jQuery( '.accessory-discount-error' ).text('');
        jQuery( '.accessory-discount-left' ).text('');
        jQuery( '.insurance-type-error' ).text('');
        jQuery( '.insurance-choice-error' ).text('');
        jQuery( '.device-error' ).text('');
        jQuery( '.discount-type-error' ).text('');
        jQuery( '.product-discount-left' ).text('');
        jQuery( '.product-discount-2-left' ).text('');
        jQuery( '.tariff-type-error' ).text('');
        jQuery( '.tariff-error' ).text('');
        jQuery( '.broadband-tv-error' ).text( '' );
        jQuery( '.tariff-discount-error' ).text('');
        jQuery( '.tariff-discount-left' ).text('');

        //hide them
        jQuery( '.type-error' ).hide();
        jQuery( '.product-type-error' ).hide();
        jQuery( '.accessories-error' ).hide();
        jQuery( '.accessory-discount-error' ).hide();
        jQuery( '.accessory-discount-left' ).hide();
        jQuery( '.insurance-type-error' ).hide();
        jQuery( '.insurance-choice-error' ).hide();
        jQuery( '.device-error' ).hide();
        jQuery( '.discount-type-error' ).hide();
        jQuery( '.product-discount-left' ).hide();
        jQuery( ".product-discount-2-left" ).hide();
        jQuery( '.tariff-type-error' ).hide();
        jQuery( '.tariff-error' ).hide();
        jQuery( '.broadband-tv-error' ).hide();
        jQuery( '.tariff-discount-error' ).hide();
        jQuery( '.tariff-discount-left' ).hide();
        jQuery( '.product-discount-2' ).hide();
        jQuery( '.product-discount' ).hide();
        
        enable_select2();
        clone_elements();
        
        jQuery(".type").prop("disabled", false);
        jQuery(".product_type").prop("disabled", false);
        jQuery(".accessory-radio").prop("disabled", false);
        jQuery(".insurance-radio").prop("disabled", false);
    }
    
    function get_sale( id )
    {
        var sale_id = id;
                
        var data = {};

        data['action'] = 'fc_get_sale';
        data['nonce'] = fc_nonce;
        data['id'] = id;

        jQuery.ajax({
            type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {
                var obj = data.data[0];
                
                console.log(obj);
                
                //remove our errors
                jQuery( '.type-error' ).text('');
                jQuery( '.product-type-error' ).text('');
                jQuery( '.accessories-error' ).text('');
                jQuery( '.accessory-discount-error' ).text('');
                jQuery( '.accessory-discount-left' ).text('');
                jQuery( '.insurance-type-error' ).text('');
                jQuery( '.insurance-choice-error' ).text('');
                jQuery( '.device-error' ).text('');
                jQuery( '.discount-type-error' ).text('');
                jQuery( '.product-discount-left' ).text('');
                jQuery( '.product-discount-2-left' ).text('');
                jQuery( '.tariff-type-error' ).text('');
                jQuery( '.tariff-error' ).text('');
                jQuery( '.broadband-tv-error' ).text( '' );
                jQuery( '.tariff-discount-error' ).text('');
                jQuery( '.tariff-discount-left' ).text('');
                
                //reset form
                jQuery( '#manager-sales-input-form' ).attr( 'sale_id' , '' );
                jQuery( '.type' ).val( 'new' ).trigger('change');
                jQuery( '.product_type' ).val( '' ).trigger('change');
                jQuery( '.tariff_type_select' ).val('').trigger('change');
                jQuery( '.discount-type' ).val('').trigger('change');
                jQuery( '.accessories' ).val('').trigger('change');
                jQuery( '.accessory-discount-left' ).val('');
            
                //hide them
                jQuery( '.type-error' ).hide();
                jQuery( '.product-type-error' ).hide();
                jQuery( '.accessories-error' ).hide();
                jQuery( '.accessory-discount-error' ).hide();
                jQuery( '.accessory-discount-left' ).hide();
                jQuery( '.insurance-type-error' ).hide();
                jQuery( '.insurance-choice-error' ).hide();
                jQuery( '.device-error' ).hide();
                jQuery( '.discount-type-error' ).hide();
                jQuery( '.product-discount-left' ).hide();
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-error' ).hide();
                jQuery( '.broadband-tv-error' ).hide();
                jQuery( '.tariff-discount-error' ).hide();
                jQuery( '.tariff-discount-left' ).hide();
                jQuery('.sales-advisor').hide();
                jQuery(".advisor").prop("disabled", true);
                
                //reset our hidden values
                jQuery('.pl').val('');
                jQuery('.ap').val('');
                jQuery('.ap-old').val('');
                jQuery('.tp').val('');
                jQuery('.dp').val('');
                jQuery('.old').val('');
            
                jQuery("#sale_comment").prop("disabled", false);
                jQuery(".sale-comment").show();
            
                //add our sale ID to our form
                jQuery( '#manager-sales-input-form' ).attr( 'sale_id' , obj.id );
            
                //change our form input to match the sale chosen
                jQuery( '.type' ).val( obj.type ).trigger('change');
                jQuery(".type").prop("disabled", false);
                jQuery( '.product_type' ).val( obj.product_type ).trigger('change');
                jQuery(".product_type").prop("disabled", false);
                
                jQuery('.advisor-name').show();
                jQuery('.advisor_name').val(obj.advisor);
                jQuery('.advisor_name').show();
                
                if( obj.product_type !== 'homebroadband' )
                {
                    //we need our device info as well, also needs set by text
                    var device_name = obj.device;
                    var device_select = jQuery('.device');
                    var device = device_select.find("option:contains('"+device_name+"')");
                    
                    jQuery(device_select.find("option:contains('"+device_name+"')")).each(function(){
                        if (jQuery(this).text() == device_name) {
                            jQuery(this).prop('selected', true).trigger('change');
                            //jQuery(this).attr('selected', 'selected').trigger('change');
                            return false;
                        }
                        return true;
                    });
                }
            
                if( obj.product_type == 'handset' )
                {
                    //lets add our tariff info in
                    jQuery( '.tariff_type_select' ).val( obj.tariff_type ).trigger('change');
                }
                
                if( obj.product_type == 'simonly' )
                {
                    if(obj.tariff_type == '') {
                        //this must be an old one, select Standard
                        jQuery( '.tariff_type_select' ).val( 'standard' ).trigger('change');
                    } else {
                        jQuery( '.tariff_type_select' ).val( obj.tariff_type ).trigger('change');
                    }
                }
            
                //we need to set our tariff using its name
                var tariff_name = obj.tariff;
                var tariff_select = jQuery('.tariff');
                var tariff = tariff_select.find("option:contains('"+tariff_name+"')");
                
                jQuery(tariff_select.find("option:contains('"+tariff_name+"')")).each(function(){
                    if (jQuery(this).text() == tariff_name) {
                        jQuery(this).prop('selected', true).trigger('change');
                        //jQuery(this).attr('selected', 'selected').trigger('change');
                        return false;
                    }
                    return true;
                });
            
                if( obj.product_type == 'homebroadband' )
                {
                    jQuery( '.broadband-tv-type' ).val( obj.broadband_tv ).trigger('change');
                }
            
                //now lets set our radio values
                if( obj.accessory_needed == 'yes' )
                {
                    //set our radio values
                    jQuery('.accessory-yes').prop('checked', 'checked').trigger('change');
                    jQuery('.accessory-no').attr( 'checked' , false ).trigger('change');
            
                    //set our accessory
                    var accessory_name = obj.accessory;
                    var accessory_select = jQuery('.accessories');
                    
                    jQuery(accessory_select.find("option:contains('" + accessory_name + "')")).each(function(){
                        if (jQuery(this).text() == accessory_name) {
                            jQuery(this).prop('selected', true).trigger('change');
                            //jQuery(this).attr('selected', 'selected').trigger('change');
                            return false;
                        }
                        return true;
                    });
            
                    //is there a discount needed
                    if( obj.accessory_discount == 'yes' )
                    {
                        jQuery('.accessory-discount-yes').prop('checked', 'checked').trigger('change');
                        jQuery('.accessory-discount-no').attr( 'checked' , false ).trigger('change');
                        jQuery( '.accessory_discount' ).val( obj.accessory_discount_value ).trigger('keyup');
                        
                        accessory_discount = obj.accessory_discount_value;

                        jQuery( '.accessory-discount-left' ).html( 'You have £' + obj.accessory_profit + ' discount available to use' );
                    }
            
                    if( obj.accessory_discount == 'no' )
                    {
                        jQuery('.accessory-discount-yes').attr( 'checked' , false ).trigger('change');
                        jQuery('.accessory-discount-no').prop('checked', 'checked').trigger('change');
                        jQuery( '.accessory_discount' ).val( '' );
                        accessory_discount = 0;
                    }
                }
            
                if( obj.accessory_needed == 'no' )
                {
                    jQuery('.accessory-no').prop('checked', 'checked').trigger('change');
                    jQuery('.accessory-yes').attr( 'checked' , false ).trigger('change');
                    jQuery( '.accessories' ).val( '' ).trigger('change');
                    jQuery( '.accessory_discount' ).val( '' );
                    accessory_discount = 0;
                }
                
                jQuery('input[name=accessory]').attr("disabled",false);
                
                //finally check if insurance is needed
                if( obj.insurance == 'yes' )
                {
                    jQuery('.insurance-yes').prop('checked', 'checked').trigger('change');
                    jQuery('.insurance-no').attr( 'checked' , false ).trigger('change');
                    jQuery( '.insurance_type' ).val( obj.insurance_type ).trigger('change');
                    var insurance_name = obj.insurance_choice;
                    var insurance_select = jQuery('.insurance_choices');
                    
                    jQuery(insurance_select.find("option:contains('" + insurance_name + "')")).each(function(){
                        if (jQuery(this).text() == insurance_name) {
                            jQuery(this).prop('selected', true).trigger('change');
                            //jQuery(this).attr('selected', 'selected').trigger('change');
                            return false;
                        }
                        return true;
                    });
                }
                if( obj.insurance == 'no' )
                {
                    jQuery('.insurance-no').prop('checked', 'checked').trigger('change');
                    jQuery('.insurance-yes').attr( 'checked' , false ).trigger('change');
                    jQuery( '.insurance_type' ).val( '' ).trigger('change');
                    jQuery( '.insurance_choices' ).val( '' ).trigger('change');
                }
                
                if( obj.pobo == 'yes' )
                {
                    jQuery('.pobo-yes').prop('checked', 'checked').trigger('change');
                    jQuery('.pobo-no').attr( 'checked' , false ).trigger('change');
                }
                if( obj.pobo == 'no' )
                {
                    jQuery('.pobo-no').prop('checked', 'checked').trigger('change');
                    jQuery('.pobo-yes').attr( 'checked' , false ).trigger('change');
                }
                
                if( obj.hrc == 'yes' )
                {
                    jQuery('.hrc-yes').prop('checked', 'checked').trigger('change');
                    jQuery('.hrc-no').attr( 'checked' , false ).trigger('change');
                }
                if( obj.hrc == 'no' )
                {
                    jQuery('.hrc-no').prop('checked', 'checked').trigger('change');
                    jQuery('.hrc-yes').attr( 'checked' , false ).trigger('change');
                }
            
                if( obj.comment !== '' )
                {
                    jQuery("#sale_comment").text( obj.commennt );
                    jQuery("#sale_comment").show()
                }
            
                if( obj.tariff_discount_type !== '' )
                {
                    jQuery( '.tariff-discount-type' ).val( '' );
                    jQuery( '.tariff-discount-type' ).val( obj.tariff_discount_type ).trigger('change');
            
                    if( obj.tariff_discount_type == 'perk' | obj.tariff_discount_type == 'compass' || obj.tariff_discount_type == 'mrc')
                    {
                        jQuery( '.tariff_discount' ).val( obj.tariff_discount ).trigger('keyup');
                        jQuery( '.tariff-discount-left' ).hide();
                    }
                }
                
                if( obj.product_type !== 'homebroadband' )
                {
                    if( obj.device_discount_type !== 'none' )
                    {
                        jQuery( '.discount-type' ).val( obj.device_discount_type ).trigger('change');
                        jQuery( '.product_discount' ).val( obj.device_discount ).trigger('keyup');
                        jQuery( '.product-discount-left' ).hide();
                        
                        console.log('discount ' + obj.device_discount);
                        
                        if( obj.device_discount_type == 'both' )
                        {
                            jQuery( '.product_discount_2' ).val( obj.device_discount_2 ).trigger('keyup');
                            jQuery( '.product-discount-2-left' ).hide();
                        }
                    }
                    else
                    {
                        jQuery( '.discount-type' ).val( obj.device_discount_type ).trigger('change');
                        jQuery( '.product_discount' ).val( '' );
                        jQuery( '.product_discount' ).prop("disabled", true);
                        jQuery( '.product_discount_2' ).val( '' );
                        jQuery( '.product_discount_2' ).prop("disabled", true);
                    }
                }
                else
                {
                    if( obj.device_discount_type !== 'none' )
                    {
                        jQuery( '.discount-type' ).val( obj.device_discount_type ).trigger('change');
                        jQuery( '.product_discount' ).val( obj.device_discount ).trigger('keyup');
                        //jQuery( '.product_discount' ).trigger('keyup');
                        jQuery( '.product-discount-left' ).hide();
                        
                        if( obj.device_discount_type == 'both' )
                        {
                            jQuery( '.product_discount_2' ).val( obj.device_discount_2 ).trigger('keyup');
                            jQuery( '.product-discount-2-left' ).hide();
                        }
                    }
                    else
                    {
                        jQuery( '.discount-type' ).val( obj.device_discount_type ).trigger('change');
                        jQuery( '.product_discount' ).val( '' );
                        jQuery( '.product_discount' ).prop("disabled", true);
                        jQuery( '.product_discount_2' ).val( '' );
                        jQuery( '.product_discount_2' ).prop("disabled", true);
                    }
                }
                
                //select our tariff after our discount has been entered
                //we need to set our tariff using its name
                var tariff_name = obj.tariff;
                var tariff_select = jQuery('.tariff');
                var tariff = tariff_select.find("option:contains('"+tariff_name+"')");
                
                jQuery(tariff_select.find("option:contains('"+tariff_name+"')")).each(function(){
                    if (jQuery(this).text() == tariff_name) {
                        jQuery(this).prop('selected', true).trigger('change');
                        //jQuery(this).attr('selected', 'selected').trigger('change');
                        return false;
                    }
                    return true;
                });
                
                enable_select2();
                
                <?php
                if( $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
                {
                    ?>  
                    if( obj.approve_sale == 'yes' )
                    {
                        jQuery("#manager-sales-input-form :input").prop("disabled", true);
                        jQuery('.tariff_discount').prop("disabled", true);
                        jQuery('.broadband-tv-type').prop("disabled", true);
                        jQuery(".save-sales").html("Sale Approved");
                        jQuery("#manager-sales-input-form :submit").prop("disabled", true);
                        jQuery("#manager-sales-input-form input,textarea,select").prop("disabled",true); 
                        jQuery( '.approve-message' ).show();
                        jQuery('.tariff-discount-type').prop("disabled",true);

                        if( obj.comment !== '' )
                        {
                            jQuery("#sale_comment").text( obj.commennt );
                            jQuery("#sale_comment").show()
                        }
                    }
                    else {
                        jQuery(".save-sales").html("Save Sale");
                        jQuery("#manager-sales-input-form :submit").prop("disabled", false);
                    }
                    <?php
                }
                ?>
            }
        });
    }
</script>

<div class="sales-errors" style="display:none"></div>

<p>Welcome <?php echo $user->display_name; ?></p>

    <p class="form-row wps-drop spacer" id="store_location" data-priority=""><label for="store_location" class="">Choose Store &nbsp;<span class="required">*</span></label>
    <span class="woocommerce-input-wrapper">
        <select name="store_locations" class="store_locations" autocomplete="off" required>
            <option value="">Select Store to Continue</option>
            <?php
        
            foreach( $locations as $slocation )
            {
            ?>
                <option value="<?php echo $slocation; ?>"><?php echo $slocation; ?></option>');
            <?php
            }
        
            ?>
        </select>
    </span>
</p>

<div class="store_location_error" style="display:none"></div>

<script>
    jQuery( '.store_locations' ).change(function() 
    {
        //show our date
        jQuery( '.sales-date' ).show();
        jQuery( '#sales_date' ).show();
        jQuery( '#sales_date_field' ).show();
        jQuery( "#sales_date" ).prop( "disabled", false );
        
        //hide our advisor for the sale
        jQuery( '.advisor_name' ).val( '' );
        jQuery( ".advisor_name" ).prop( "disabled", true );
        jQuery( ".advisor-name" ).hide();
        
        //get the current option
        var option = jQuery( this ).find('option:selected');
                                
        //get the value from the option
        var value = option.val();
        
        var date = jQuery( '#sales_date' ).val();
        
        if( value !== '' )
        {
            if( date !== '' )
            {
                var data = {};
                                
                data['action'] = 'fc_senior_get_sales_staff';
                data['nonce'] = fc_nonce;
                data['store'] = value;
                data['date'] = date;
        
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( ".sales-advisor" ).html( data );
                        
                        jQuery( ".advisor" ).select2(
                        {
                            width: '100%',
                        });
                    
                        jQuery( '.store' ).text( 'You are managing the sales information for the ' + value + ' Store' );
                        jQuery( '.add-sales' ).attr( 'store' , value );
                        jQuery( '#save-footfall-form' ).attr( 'store' , value );
                        jQuery( '#save-kpi-form' ).attr( 'store' , value );
                        jQuery( '.profit-store-location' ).text( value );
                        jQuery( '.input-hours-store' ).text( value );
                        jQuery( '.sales-intro' ).show();
                        
                        //show our store info
                        jQuery( '.store-info-heading' ).hide();
                        jQuery( '.store-info' ).show();
                        
                        //show our date form
                        jQuery( '#sales_date_field' ).show();
                        jQuery( "#sales_date" ).prop("disabled", false );
                    },
                });
            }
            
            var salesdata = {};
    
            salesdata['action'] = 'fc_get_senior_sales';
            salesdata['nonce'] = fc_nonce;
            salesdata['store'] = value;
            salesdata['date'] = date;
            
            const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            
            const d = new Date(date);
            var name = month[d.getMonth()];

            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: salesdata,
                success: function( data ) 
                {   
                    jQuery( '#sales' ).children( '.tab' ).remove();
                    sales = data.data;
    
                    if( sales.length > 0 )
                    {
                        jQuery('.sales-management-store').html(value);
                        jQuery('.sales-management-date').html(date);
                        jQuery('.sales-management-month-date').html(name);
                        jQuery('.sales-management-container').show();
                        
                        jQuery( '#manager-sales-input-form' ).attr( 'type' , 'existing' );
                        type = 'existing';
    
                        //remove our sales message
                        jQuery( '.sales-message' ).hide();
                        jQuery( '.sales-message' ).text( '' );
    
                        for( var i = 0; i < sales.length; i++ ) 
                        {
                            var obj = sales[i][0];
    
                            var salenum = i + 1;
    
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
    
                            pill = '<li class="tab" id="tab"><a id="' + obj.id + '" data-toggle="pill" href="" style="text-align:center;">' + name + '</a></li>';
    
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
                        
                        //undisable our buttons
        				jQuery("#approve-all-sales").attr("disabled", false);
        				jQuery("#unapprove-all-sales").attr("disabled", false);
        				jQuery("#delete-all-sales").attr("disabled", false);
        				
        				jQuery("#approve-all-month-sales").attr("disabled", false);
        				jQuery("#unapprove-all-month-sales").attr("disabled", false);
        				jQuery("#delete-all-month-sales").attr("disabled", false);
                    }
                    else
                    {
                        no_sales();
                    }
                },
            });
            
            var profit_data = {};
            
            profit_data['action'] = 'fc_senior_get_profit';
            profit_data['nonce'] = fc_nonce;
            profit_data['store'] = value;
            
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: profit_data,
                success: function( data ) 
                {   
                    jQuery( '.profit-target' ).text( "£" + data.data.profit_target.toFixed(2) );
                    jQuery( '.profit-variance' ).text( "£" + data.data.profit_variance );
                },
            });
            
            var discount_data = {};
            
            discount_data['action'] = 'fc_senior_get_discounts';
            discount_data['nonce'] = fc_nonce;
            discount_data['store'] = value;
            discount_data['date'] = date;
            
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: fc_ajax_url,
                data: discount_data,
                success: function( data ) 
                {   
                    jQuery( '.rm_discount' ).val(data.data.rm);
                    jQuery( '.fran_discount' ).val(data.data.fran);
                    
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
    });
    
    jQuery( document ).ready(function() 
    {
        jQuery(".store_locations").select2(
        {
            width: '100%',
        });
    });
</script>

<p class="store">Choose Your Store Before Continuing</p>

<div class="row spacer">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#manage-sales">Manage Sales</a></li>
        <li><a data-toggle="tab" href="#sale-information">Store Information</a></li>
    </ul>
</div>

<div class="tab-content">
    <div id="manage-sales" class="tab-pane fade in active">
        <div class="sales-outcome spacer"></div>
        
            <div class="cold-md-12 sales-buttons" style="display:none">
                <p>What Do You Want To Do?</p>
                <button type="button" id="approve-sales" class="woocommerce-Button button spacer" style="margin-right:20px;" name="approve-sales" value="Approve Sales">Approve Sales            </button>
                <button type="button" id="add-sales" class="woocommerce-Button button spacer" name="add-sales" value="Add Sales">Add / View Sales</button>
            </div>
        
        <script>
            jQuery( "#approve-sales" ).click(function() 
            {
                jQuery( '.advisor' )
                    .empty()
                    .append('<option value="">Choose Advisor</option>');
                
                action = "approve";
                
                jQuery( '#sales_date_field' ).show();
                jQuery( '.sales-date' ).show();
                jQuery( '.sales-advisor' ).show();
                
                document.getElementById("sales_date").valueAsDate = new Date();
                
                jQuery( '#sales_date' ).trigger( 'change' );
                
                jQuery( '.advisor' ).show();
                
                jQuery( '.approve-message' ).hide();
    
                document.getElementById('manager-sales-input-form').reset();
                                    
                jQuery( '.add-sales' ).attr( 'sale_id' , '' );
                jQuery( '.type' ).val( 'new' ).trigger('change');
                jQuery( '.product_type' ).val( '' ).trigger('change');
                jQuery( '.tariff_type_select' ).val('').trigger('change');
                jQuery( '.discount-type' ).val('').trigger('change');
                jQuery( '.accessories' ).val('').trigger('change');
                jQuery( '.accessory-discount-left' ).val('')
        
                //now reactivate all our disabled inputs we need
                jQuery(".device").prop("disabled", true);
                jQuery(".discount-type").prop("disabled", true);
                jQuery(".product_discount").prop("disabled", true);
                jQuery(".product_discount_2").prop("disabled", true);
                jQuery(".tariff_type").prop("disabled", true);
                jQuery(".tariff").prop("disabled", true);
                jQuery(".tariff-discount-type").prop("disabled", true);
                jQuery(".tariff_discount").prop("disabled", true);
                jQuery(".accessories").prop("disabled", true);
                jQuery(".accessory_discount").prop("disabled", true);
                jQuery(".insurance_type").prop("disabled", true);
        
                //reset our radios
                jQuery('.accessory-no').prop('checked', 'checked').trigger('change');
                jQuery('.accessory-discount-no').prop('checked', 'checked').trigger('change');
                jQuery('.insurance-no').prop('checked', 'checked').trigger('change');
        
                //clear our profit text
                jQuery( '.profit-loss' ).text('');
                jQuery( '.accessory-profit' ).text('');
                jQuery( '.insurance-profit' ).text('');
                jQuery( '.total-profit' ).text('');
        
                //update our hidden values
                jQuery( '.pl' ).val('').trigger('change');
                jQuery( '.ap' ).val('').trigger('change');
                jQuery( '.ap-old' ).val('').trigger('change');
                jQuery( '.inp' ).val('').trigger('change');
                jQuery( '.tp' ).val('').trigger('change');
                jQuery( '.dp' ).val('').trigger('change');
                jQuery( '.old' ).val('').trigger('change');
        
                //remove our errors
                jQuery( '.type-error' ).text('');
                jQuery( '.product-type-error' ).text('');
                jQuery( '.accessories-error' ).text('');
                jQuery( '.accessory-discount-error' ).text('');
                jQuery( '.accessory-discount-left' ).text('');
                jQuery( '.insurance-type-error' ).text('');
                jQuery( '.insurance-choice-error' ).text('');
                jQuery( '.device-error' ).text('');
                jQuery( '.discount-type-error' ).text('');
                jQuery( '.product-discount-left' ).text('');
                jQuery( '.product-discount-2-left' ).text('');
                jQuery( '.tariff-type-error' ).text('');
                jQuery( '.tariff-error' ).text('');
                jQuery( '.broadband-tv-error' ).text( '' );
                jQuery( '.tariff-discount-error' ).text('');
                jQuery( '.tariff-discount-left' ).text('');
        
                //hide them
                jQuery( '.type-error' ).hide();
                jQuery( '.product-type-error' ).hide();
                jQuery( '.accessories-error' ).hide();
                jQuery( '.accessory-discount-error' ).hide();
                jQuery( '.accessory-discount-left' ).hide();
                jQuery( '.insurance-type-error' ).hide();
                jQuery( '.insurance-choice-error' ).hide();
                jQuery( '.device-error' ).hide();
                jQuery( '.discount-type-error' ).hide();
                jQuery( '.product-discount-left' ).hide();
                jQuery( ".product-discount-2-left" ).hide();
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-error' ).hide();
                jQuery( '.broadband-tv-error' ).hide();
                jQuery( '.tariff-discount-error' ).hide();
                jQuery( '.tariff-discount-left' ).hide();
        
                jQuery("#manager-sales-input-form :input").prop("disabled", true );
                
                jQuery( '#plustab').hide();
                jQuery( '#minustab' ).hide();
                jQuery( '#sales' ).children( '.tab' ).remove();
                jQuery('.sales-management-container').hide();
            });
            
            jQuery( "#add-sales" ).click(function() 
            {
                jQuery( '.advisor' )
                    .empty()
                    .append('<option value="">Choose Advisor</option>');
                
                action = "add";
                    
                jQuery( '#sales_date_field' ).show();
                jQuery( '.sales-date' ).show();
                jQuery( '.sales-advisor' ).show();

                document.getElementById("sales_date").valueAsDate = new Date();
                
                jQuery( '#sales_date' ).trigger( 'change' );
                
                jQuery( '.advisor' ).show();
                
                jQuery( '.approve-message' ).hide();
    
                document.getElementById('manager-sales-input-form').reset();
                                    
                jQuery( '.add-sales' ).attr( 'sale_id' , '' );
                jQuery( '.type' ).val( 'new' ).trigger('change');
                jQuery( '.product_type' ).val( '' ).trigger('change');
                jQuery( '.tariff_type_select' ).val('').trigger('change');
                jQuery( '.discount-type' ).val('').trigger('change');
                jQuery( '.accessories' ).val('').trigger('change');
                jQuery( '.accessory-discount-left' ).val('')
        
                //now reactivate all our disabled inputs we need
                jQuery(".device").prop("disabled", true);
                jQuery(".discount-type").prop("disabled", true);
                jQuery(".product_discount").prop("disabled", true);
                jQuery(".product_discount_2").prop("disabled", true);
                jQuery(".tariff_type").prop("disabled", true);
                jQuery(".tariff").prop("disabled", true);
                jQuery(".tariff-discount-type").prop("disabled", true);
                jQuery(".tariff_discount").prop("disabled", true);
                jQuery(".accessories").prop("disabled", true);
                jQuery(".accessory_discount").prop("disabled", true);
                jQuery(".insurance_type").prop("disabled", true);
        
                //reset our radios
                jQuery('.accessory-no').prop('checked', 'checked').trigger('change');
                jQuery('.accessory-discount-no').prop('checked', 'checked').trigger('change');
                jQuery('.insurance-no').prop('checked', 'checked').trigger('change');
        
                //clear our profit text
                jQuery( '.profit-loss' ).text('');
                jQuery( '.accessory-profit' ).text('');
                jQuery( '.insurance-profit' ).text('');
                jQuery( '.total-profit' ).text('');
        
                //update our hidden values
                jQuery( '.pl' ).val('').trigger('change');
                jQuery( '.ap' ).val('').trigger('change');
                jQuery( '.ap-old' ).val('').trigger('change');
                jQuery( '.inp' ).val('').trigger('change');
                jQuery( '.tp' ).val('').trigger('change');
                jQuery( '.dp' ).val('').trigger('change');
                jQuery( '.old' ).val('').trigger('change');
        
                //remove our errors
                jQuery( '.type-error' ).text('');
                jQuery( '.product-type-error' ).text('');
                jQuery( '.accessories-error' ).text('');
                jQuery( '.accessory-discount-error' ).text('');
                jQuery( '.accessory-discount-left' ).text('');
                jQuery( '.insurance-type-error' ).text('');
                jQuery( '.insurance-choice-error' ).text('');
                jQuery( '.device-error' ).text('');
                jQuery( '.discount-type-error' ).text('');
                jQuery( '.product-discount-left' ).text('');
                jQuery( '.product-discount-2-left' ).text('');
                jQuery( '.tariff-type-error' ).text('');
                jQuery( '.tariff-error' ).text('');
                jQuery( '.broadband-tv-error' ).text( '' );
                jQuery( '.tariff-discount-error' ).text('');
                jQuery( '.tariff-discount-left' ).text('');
        
                //hide them
                jQuery( '.type-error' ).hide();
                jQuery( '.product-type-error' ).hide();
                jQuery( '.accessories-error' ).hide();
                jQuery( '.accessory-discount-error' ).hide();
                jQuery( '.accessory-discount-left' ).hide();
                jQuery( '.insurance-type-error' ).hide();
                jQuery( '.insurance-choice-error' ).hide();
                jQuery( '.device-error' ).hide();
                jQuery( '.discount-type-error' ).hide();
                jQuery( '.product-discount-left' ).hide();
                jQuery( ".product-discount-2-left" ).hide();
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-error' ).hide();
                jQuery( '.broadband-tv-error' ).hide();
                jQuery( '.tariff-discount-error' ).hide();
                jQuery( '.tariff-discount-left' ).hide();
        
                jQuery("#manager-sales-input-form :input").prop("disabled", true );
                
                jQuery( '#plustab').hide();
                jQuery( '#minustab' ).hide();
                jQuery( '#sales' ).children( '.tab' ).remove();
                jQuery('.sales-management-container').hide();
            });
        </script>
        
        <div class="col-md-12 sales-date" style="display:none;">
            <p class="form-row validate-required spacer" id="sales_date_field" data-priority="" style="display: none">
                <label for="sales_date" class="">Choose Sale Date&nbsp;<abbr class="required" title="required">*</abbr></label>
                <span class="woocommerce-input-wrapper">
                    <input type="date" class="input-text " name="sales_date" id="sales_date" placeholder="" value="<?php echo $enddate; ?>" min="<?php echo $startdate; ?>" max="<?php echo $enddate; ?>" aria-describedby="date-of-birth-description" autocomplete="off"  disabled>
                </span>
            </p>
        </div>
        
        <div class="sales_date_error" style="display:none"></div>
        
        <div class="choose_advisor_error" style="display:none"></div>
        
        <script>
            var sales = '';
            var sale = '';
        
            jQuery( document ).ready(function() 
            {
                jQuery("#manager-sales-input-form :input").prop("disabled", true);
            });
        
            jQuery( '#sales_date' ).change( function() 
            {
                jQuery( '.advisor' ).empty();
                
                var date = jQuery( this ).val();
                
                jQuery( '.sales-outcome' ).html( '' );
                jQuery( '.sales-outcome' ).hide();
                
                var store = jQuery( '.store_locations' ).val();
                
                jQuery( '#sales' ).children( '.tab' ).remove();
                jQuery('.sales-management-container').hide();
                
                //hide our plus and minus tabs
                jQuery( '#plustab' ).hide();
                jQuery( '#minustab' ).hide();
                
                //hide our comment box
                jQuery(".sale_comment").prop("disabled", true);
                jQuery(".sale-comment").hide();
                
                //change our button text
                jQuery(".save-sales").html("Save Sales");
        
                //new sale
                jQuery( '.approve-message' ).hide();
                
                //hide our advisor for the sale
                jQuery( '.advisor_name' ).val( '' );
                jQuery( ".advisor_name" ).prop( "disabled", true );
                jQuery( ".advisor-name" ).hide();
                
                document.getElementById('manager-sales-input-form').reset();
                
                jQuery( '.add-sales' ).attr( 'sale_id' , '' );
                jQuery( '.type' ).val( 'new' ).trigger('change');
                jQuery( '.product_type' ).val( '' ).trigger('change');
                jQuery( '.tariff_type_select' ).val('').trigger('change');
                jQuery( '.discount-type' ).val('').trigger('change');
                jQuery( '.accessories' ).val('').trigger('change');
                jQuery( '.accessory-discount-left' ).val('')
        
                //now reactivate all our disabled inputs we need
                jQuery(".device").prop("disabled", true);
                jQuery(".discount-type").prop("disabled", true);
                jQuery(".product_discount").prop("disabled", true);
                jQuery(".product_discount_2").prop("disabled", true);
                jQuery(".tariff_type").prop("disabled", true);
                jQuery(".tariff").prop("disabled", true);
                jQuery(".tariff-discount-type").prop("disabled", true);
                jQuery(".tariff_discount").prop("disabled", true);
                jQuery(".accessories").prop("disabled", true);
                jQuery(".accessory_discount").prop("disabled", true);
                jQuery(".insurance_type").prop("disabled", true);
        
                //reset our radios
                jQuery('.accessory-no').prop('checked', 'checked').trigger('change');
                jQuery('.accessory-discount-no').prop('checked', 'checked').trigger('change');
                jQuery('.insurance-no').prop('checked', 'checked').trigger('change');
        
                //clear our profit text
                jQuery( '.profit-loss' ).text('');
                jQuery( '.accessory-profit' ).text('');
                jQuery( '.insurance-profit' ).text('');
                jQuery( '.total-profit' ).text('');
        
                //update our hidden values
                jQuery( '.pl' ).val('').trigger('change');
                jQuery( '.ap' ).val('').trigger('change');
                jQuery( '.ap-old' ).val('').trigger('change');
                jQuery( '.inp' ).val('').trigger('change');
                jQuery( '.tp' ).val('').trigger('change');
                jQuery( '.dp' ).val('').trigger('change');
                jQuery( '.old' ).val('').trigger('change');
        
                //remove our errors
                jQuery( '.type-error' ).text('');
                jQuery( '.product-type-error' ).text('');
                jQuery( '.accessories-error' ).text('');
                jQuery( '.accessory-discount-error' ).text('');
                jQuery( '.accessory-discount-left' ).text('');
                jQuery( '.insurance-type-error' ).text('');
                jQuery( '.insurance-choice-error' ).text('');
                jQuery( '.device-error' ).text('');
                jQuery( '.discount-type-error' ).text('');
                jQuery( '.product-discount-left' ).text('');
                jQuery( '.product-discount-2-left' ).text('');
                jQuery( '.tariff-type-error' ).text('');
                jQuery( '.tariff-error' ).text('');
                jQuery( '.broadband-tv-error' ).text( '' );
                jQuery( '.tariff-discount-error' ).text('');
                jQuery( '.tariff-discount-left' ).text('');
        
                //hide them
                jQuery( '.type-error' ).hide();
                jQuery( '.product-type-error' ).hide();
                jQuery( '.accessories-error' ).hide();
                jQuery( '.accessory-discount-error' ).hide();
                jQuery( '.accessory-discount-left' ).hide();
                jQuery( '.insurance-type-error' ).hide();
                jQuery( '.insurance-choice-error' ).hide();
                jQuery( '.device-error' ).hide();
                jQuery( '.discount-type-error' ).hide();
                jQuery( '.product-discount-left' ).hide();
                jQuery( ".product-discount-2-left" ).hide();
                jQuery( '.tariff-type-error' ).hide();
                jQuery( '.tariff-error' ).hide();
                jQuery( '.broadband-tv-error' ).hide();
                jQuery( '.tariff-discount-error' ).hide();
                jQuery( '.tariff-discount-left' ).hide();
        
                jQuery( '#plustab' ).addClass( 'disabled' );
                jQuery("#manager-sales-input-form :input").prop("disabled", true );
                
                if( date !==  '' )
                {
                    var data = {};
                                                    
                    data['action'] = 'fc_get_senior_sales';
                    data['nonce'] = fc_nonce;
                    data['store'] = store;
                    data['date'] = date;
                    
                    const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            
                    const d = new Date(date);
                    var name = month[d.getMonth()];
        
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
        					    //we have sales get the discount pot
        					    var discount_data = {};
                                    
                                var date = jQuery( '#sales_date' ).val();
                                
                                jQuery('.sales-management-store').html(store);
                                jQuery('.sales-management-date').html(date);
                                jQuery('.sales-management-month-date').html(name);
                                jQuery('.sales-management-container').show();
                                
                                discount_data['action'] = 'fc_senior_get_discounts';
                                discount_data['nonce'] = fc_nonce;
                                discount_data['store'] = store;
                                discount_data['date'] = date;
                                            
                                jQuery.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    url: fc_ajax_url,
                                    data: discount_data,
                                    success: function( data ) 
                                    {   
                                        jQuery( '.fran_discount' ).val(data.data.fran);
                                        jQuery( '.rm_discount' ).val(data.data.rm);         
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
                                    
        						jQuery( '#manager-sales-input-form' ).attr( 'type' , 'existing' );
        						type = 'existing';
        	
        						//remove our sales message
        						jQuery( '.sales-message' ).hide();
        						jQuery( '.sales-message' ).text( '' );
        	
        						for( var i = 0; i < sales.length; i++ ) 
        						{
        							var obj = sales[i][0];
        	
        							var salenum = i + 1;
        	
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
        	
        							pill = '<li class="tab" id="tab"><a  id="' + obj.id + '" data-toggle="pill" href="" style="text-align:center;">' + name + '</a></li>';
        	
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
        						
        						//undisable our buttons
        						jQuery("#approve-all-sales").attr("disabled", false);
        						jQuery("#unapprove-all-sales").attr("disabled", false);
        						jQuery("#delete-all-sales").attr("disabled", false);
        						
        						jQuery("#approve-all-month-sales").attr("disabled", false);
        						jQuery("#unapprove-all-month-sales").attr("disabled", false);
        						jQuery("#delete-all-month-sales").attr("disabled", false);
        					}
        					else
        					{
        						no_sales();
        					}
        				},
        			});
                }
            });
        
            jQuery( document ).on("change",".advisor",function() 
            {
                jQuery( 'choose_advisor_error' ).hide();
                
                var option = jQuery( '.advisor' ).find('option:selected');
    
                //get the current advisor from the option
                var advisor = option.text();
                
                jQuery('.advisor_name').val(advisor);
                
                new_sale();
                
                jQuery( ".advisor_name" ).prop( "disabled", true );
                jQuery( '.sales-advisor' ).hide();
                jQuery( '.advisor-name' ).show();
            });
        
            jQuery(document).on('click', '#sales li:not( #plustab, #minustab )', function( event ) 
            {
                jQuery( '#manager-sales-input-form' ).attr( 'type' , 'existing' );
                var sale_id = event.target.id;
                
                var updated = jQuery( '#manager-sales-input-form' ).attr( "updated" );
        
                var advisor = jQuery( '#manager-sales-input-form' ).attr( "employee" );
        
                if( sale_id == '' )
                {
                    jQuery(".sale_comment").prop("disabled", true);
                    jQuery(".sale-comment").hide();
                    
                    jQuery( '.sales-message' ).html('');
                    jQuery( '#manager-sales-input-form' ).attr( 'type' , 'new' );
                    type = 'new';
                    
                    jQuery("#manager-sales-input-form :input").prop("disabled", false);
                    jQuery(".save-sales").html("Save Sale");
                    jQuery( '.approve-message' ).hide();
                    
                    new_sale();
                }
                else
                {
                    if( updated == 'yes' )
                    {
                        var date = jQuery( "#sales_date" ).val();
                        
                        jQuery( '#manager-sales-input-form' ).attr("action" , action);
                        
                        var data = {};
        
                        data['action'] = 'fc_get_sales_info';
                        data['nonce'] = fc_nonce;
                        data['advisor'] = advisor;
                        data['date'] = date;
                        data['type'] = action;
        
                        jQuery.ajax({
                            type: 'POST',
                            url: fc_ajax_url,
                            data: data,
                            success: function( data ) 
                            {
                                sales = data.data;
                                jQuery( '#manager-sales-input-form' ).attr( "updated" , "" );
                                add_sales();
                            }
                        });
                    }
                    else
                    {
                        add_sales();
                    }
        
                    function add_sales()
                    {
                        get_sale( sale_id );
                        enable_select2();
                    }
                }
            });
        </script>
        
        <form class="stilesAddSalesForm add-sales" id="manager-sales-input-form" action="" method="post" style="margin-top:20px;" store="" role="senior_manager" employee="<?php echo $full_name; ?>" sale_id="" updated="" type="" >
            <div class="sales-container">
                <div class="sales-management-container" style="display:none; margin-top:20px;">
                    <div class="cold-md-12 manage-sales-buttons">
                        <p>Sales Management for <span class="sales-management-store"></span> on <span class="sales-management-date"></span></p>
                        <button type="button" id="approve-all-sales" class="woocommerce-Button button spacer" style="margin-right:20px;" name="approve-all-sales" value="Approve All Sales">Approve All Sales</button>
                        <button type="button" id="unapprove-all-sales" class="woocommerce-Button button spacer" style="margin-right:20px;" name="unapprove-all-sales" value="Unapprove All Sales">Unapprove All Sales</button>
                        <button type="button" id="delete-all-sales" class="woocommerce-Button button spacer" name="delete-all-sales" value="Delete All Sales">Delete All Sales</button>
                    </div>
                    
                    <div class="cold-md-12 manage-sales-buttons">
                        <p>Sales Management for <span class="sales-management-store"></span> in <span class="sales-management-month-date"></span></p>
                        <button type="button" id="approve-all-month-sales" class="woocommerce-Button button spacer" style="margin-right:20px;" name="approve-all-month-sales" value="Approve All Sales">Approve All Sales</button>
                        <button type="button" id="unapprove-all-month-sales" class="woocommerce-Button button spacer" style="margin-right:20px;" name="unapprove-all--month-sales" value="Unapprove All Sales">Unapprove All Sales</button>
                        <button type="button" id="delete-all-month-sales" class="woocommerce-Button button spacer" name="delete-all-month-sales" value="Delete All Sales">Delete All Sales</button>
                    </div>
                    
                    <p class="manage-sales-outcome" style="margin-top:15px;"></p>
                </div>
                
                <h3>Sales</h3>
                
                <p class="sales-message spacer-bottom"></p>
                
                <ul class="nav nav-pills" id="sales" role="tablist">
                    <li id="plustab" class="disabled" style="display:none"><a id="plus" href="#"><i class="fas fa-plus"></i></a></li>
                    <li id="minustab" class="disabled" style="display:none"><a id="minus" href="#"><i class="fas fa-minus"></i></a></li>
                </ul>
              
                <div class="tab-content">
                    <div id="sales-form" class="tab-pane fade in active">

                        <div id="form-overlay" style="display:none;">
                            <div class="form-loader" style="display:none;"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name sales-advisor" style="display:none;">
                                    <label for="sales_advisor"><?php esc_html_e( 'Choose Advisor to Continue', 'woocommerce' ); ?>&nbsp;
                                    <span class="required">*</span>
                                    </label>
                                    <select name="advisor" class="advisor" autocomplete="off" required>
                                        <option value="">Select Store to Continue</option>
                                    </select>
                                </p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name advisor-name" style="display:none;">
                                    <label for="advisor-name"><?php esc_html_e( 'Advisor', 'woocommerce' ); ?>&nbsp;
                                    <span class="required">*</span>
                                    </label>
                                    <input type="text" class="advisor_name" name="advisor_name" autocomplete="off" disabled>
                                </p>
                            </div>
                        </div>
                        
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
                                    
                                    //check if there is a value already in discount box
                                    var existing_discount = jQuery( '.product_discount' ).val();
                                    
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
                                        jQuery( '.product-discount' ).hide();
                                        
                                        jQuery( '.product_discount_2' ).val('');
                                        jQuery( '.product-discount-2' ).hide();
                                    }
                                    else
                                    {
                                        jQuery( '.discount-type-error' ).hide();
                                        jQuery( '.discount-type-error' ).html('');
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
                                        jQuery( '.product-discount' ).hide();
                                        
                                        jQuery( '.product_discount_2' ).val('');
                                        jQuery( '.product-discount-2' ).hide();
                                    }
                                    else if( value == 'rm' )
                                    {
                                        jQuery( '.product_discount' ).attr( 'discount' , 'regional' );
                                        jQuery( ".product_discount" ).prop( "disabled", false );
                                        jQuery( '.product_discount_label' ).text( 'Enter Regional Managers Discount');
                                        jQuery( '.product_discount_label' ).append( '&nbsp; <span class="required">*</span>');
                                        
                                        if( type == 'new' )
                                        {
                                            jQuery( ".product-discount-left" ).text( 'You have £' + jQuery( '.rm_discount' ).val()  + ' discount available to use' );
                                            jQuery( ".product-discount-left" ).show();
                                        }
                                        
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
                                        
                                        if( type == 'new' )
                                        {
                                            jQuery( ".product-discount-left" ).text( 'You have £' + jQuery( '.fran_discount' ).val() + ' discount available to use' );
                                            jQuery( ".product-discount-left" ).show();
                                        }
                                        
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
                                        
                                        if( type == 'new' )
                                        {
                                            jQuery( ".product-discount-left" ).text( 'You have £' + jQuery( '.rm_discount' ).val() + ' discount available to use' );
                                            jQuery( ".product-discount-left" ).show();
                                            jQuery( ".product-discount-2-left" ).text( 'You have £' + jQuery( '.fran_discount' ).val() + ' discount available to use' );
                                            jQuery( ".product-discount-2-left" ).show();
                                        }
                                        
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
                                            <option value="tlo">Time Limited OFfers</option>
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
                            
                            <div class="tariff-discount-error" style="display:none"></div>
                            
                            <script>
                                jQuery( '.tariff-discount-type' ).change(function() 
                                {
                                    //get the current option
                                    var option = jQuery( this ).find('option:selected');
                    
                                    //get the value from the option
                                    var value = option.val();
                                    
                                    tariff_profit = tariff_value;
                                    tariff_old = tariff_value;
                                    
                                    if( value !== 'perk' || value !== 'compass' || value !== 'mrc' || value == '' )
                                    {
                                        jQuery( ".tariff_discount" ).prop( "disabled", true );
                                        jQuery( '.tariff_discount_label' ).text( '');
                                        jQuery( '.tariff-discount' ).hide();
                                        jQuery( ".tariff-discount-left" ).hide();
                                    }
                                    
                                    if( value == '' )
                                    {
                                        percentage = 0;
                                        percent_profit_loss();
                                    }
                                    
                                    if( value == 'none' )
                                    {
                                        jQuery( '.tariff-discount-error' ).html('');
                                        jQuery( '.tariff-discount-error' ).hide();
                                            
                                        tariff_profit = tariff_value;
                                        tariff_old = tariff_value;
                                        
                                        percentage = 0;
                                        
                                        if( tariff_profit > 0 )
                                        {
                                            percent_profit_loss();
                                        }
                                            
                                        jQuery( ".tariff_discount" ).prop( "disabled", true );
                                        jQuery( '.tariff-discount' ).hide();
                                        jQuery( ".tariff-discount-left" ).text( '' );
                                        jQuery( ".tariff-discount-left" ).hide();
                                        jQuery( ".tariff_discount" ).val('');
                                    }
                                    else if( value == 'perk' || value == 'compass' || value == 'mrc' )
                                    {
                                        jQuery( '.tariff-discount-error' ).html('');
                                        jQuery( '.tariff-discount-error' ).hide();
                                            
                                        tariff_profit = tariff_value;
                                        tariff_old = tariff_value;
                                        
                                        if( tariff_profit > 0 )
                                        {
                                            percent_profit_loss();
                                        }
                                        
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
                                            tariff_old = tariff_profit - reduce;
                                            
                                            percent_profit_loss();
                                        }
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
                                            tariff_old = tariff_profit - reduce;
                                            
                                            percent_profit_loss();
                                        }
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
                                            tariff_old = tariff_profit - reduce;
                                        
                                            percent_profit_loss();
                                        }
                                    }
                                });
                            </script>
                            
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
                                <p><?php esc_html_e( 'Accessory', 'woocommerce' ); ?></p>
                                <label class="radio-inline">
                                    <input class="accessory-radio accessory-no" type="radio" name="accessory" value="no" autocomplete="off" checked >No
                                </label>
                                <label class="radio-inline">
                                    <input class="accessory-radio accessory-yes" type="radio" name="accessory" value="yes" autocomplete="off" >Yes
                                </label>
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
                                        $count = 1;
                                        foreach( $accessories as $accessory => $price )
                                        {
                                            ?>
                                            <option value="<?php echo $count; ?>"><?php echo $accessory; ?></option>`); 
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                    </select>
                                </p>
                            </div>
                        </div>
                        
                        <div class="accessories-error" style="display:none"></div>
                        
                        <div class="row">
                            <div class="col-md-12 accessory-discount" style="display:none">
                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name">
                                    <p><?php esc_html_e( 'Accessory Discount', 'woocommerce' ); ?></p>
                                    <label class="radio-inline">
                                        <input class="accessory-discount-radio accessory-discount-no" type="radio" name="accessory-discount" value="no" autocomplete="off" checked >No
                                    </label>
                                    <label class="radio-inline">
                                        <input class="accessory-discount-radio accessory-discount-yes" type="radio" name="accessory-discount" value="yes" autocomplete="off">Yes
                                    </label>
                                </p>
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
                                        }
                                    }
                                    else
                                    {
                                        jQuery( ".accessory_discount" ).prop( "disabled", true );
                                        jQuery( '.accessory_discount_input' ).hide();
                                        jQuery( '.accessory-discount-left' ).hide();
                                        jQuery( '.accessory_discount' ).val( '' );
                                        jQuery( '.accessory_discount' ).trigger( 'keyup' );
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
                        
                        <div class="row">
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
                                    jQuery( '.insurance-choice ' ).hide();
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
                                }
                                
                                calculate_total_profit();
                            });
                        </script>
                        
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12 hrc">
                                <p><?php esc_html_e( 'Is This a HRC Sale?', 'woocommerce' ); ?></p>
                                <label class="radio-inline">
                                    <input class="hrc-radio hrc-no" type="radio" name="hrc" value="no" autocomplete="off" checked >No
                                </label>
                                <label class="radio-inline">
                                    <input class="hrc-radio hrc-yes" type="radio" name="hrc"value="yes" autocomplete="off" >Yes
                                </label>
                            </div>
                        </div>
                
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
                        
                        <div class="row">
                            <div class="col-md-12 pobo">
                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name">
                                    <p><?php esc_html_e( 'Is This a POBO Sale?', 'woocommerce' ); ?></p>
                                    <label class="radio-inline">
                                        <input class="pobo-radio pobo-no" type="radio" name="pobo" value="no" autocomplete="off" checked >No
                                    </label>
                                    <label class="radio-inline">
                                        <input class="pobo-radio pobo-yes" type="radio" name="pobo"value="yes" autocomplete="off" >Yes
                                    </label>
                                </p>
                            </div>
                        </div>
                
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
                                <input type="hidden" class="dp" name="dp" value="">
                                <input type="hidden" class="old" name="old" value="">
                                <input type="hidden" class="fran_discount" name="fran_discount" value="">
                                <input type="hidden" class="rm_discount" name="rm_discount" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name sale-comment" style="display:none;">
                        <label for="sale-comment"><?php esc_html_e( 'Enter Comment for Sale', 'woocommerce' ); ?>&nbsp;
                        </label>
                        <textarea id="sale_comment" name="sale_comment" rows="4" cols="50" autocomplete="off" disabled ></textarea>
                    </p>
                </div>
            </div>
            
            <p>
                <button type="submit" class="save-sales woocommerce-Button button" style="margin-top:20px" name="save_account_details" value="<?php esc_attr_e( 'Save Sales', 'woocommerce' ); ?>"><?php esc_html_e( 'Save Sales', 'woocommerce' ); ?></button>
            </p>
            
            <div class="col-md-12 sales-notice" style="display:none; margin-top:15px;"></div>
        </form>
    </div>
    
    <div id="sale-information" class="tab-pane fade in">
        <div class="row">
            <h3 class="store-info-heading text-center spacer">Choose Store</h3>
        <div class="col-md-12 store-info" style="display:none">
                <p class="sales-intro" style="display:none">You are viewing the <span class="profit-store-location"></span> sales information for <?php echo date('F'); ?></p>
                
                
                <p>The current date is <?php echo date("l jS \of F Y"); ?></p>
                
                <div class="table-responsive">
                    <table class="table spacer">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" class="blank-row text-center"><h4>Profit Info</h4></td>
                            </tr>
                            <tr>
                                <td class="blank-row"></td>
                                <td class="blank-row"></td>
                            </tr>
                            <tr>
                                <?php
                                if( $user && in_array( 'store_manager', $user->roles ) )
                                {
                                    ?>
                                    <td>Daily Profit</td>
                                    <td><?php echo '£' . $daily_profit; ?></td>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <td>Daily Profit</td>
                                    <td><span class="daily-profit"></span></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                if( $user && in_array( 'store_manager', $user->roles ) )
                                {
                                    ?>
                                    <td>Store Profit Target</td>
                                    <td><?php echo '£' . $profit; ?></td>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <td>Store Profit Target</td>
                                    <td><span class="profit-target"></span></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td>Store Profit</td>
                                <td><span class="profit-amount"></span></td>
                            </tr>
                            <tr>
                                <td>Store Profit Variance</td>
                                <td><span class="profit-variance"></span></td>
                            </tr>
                            <tr>
                                <td class="blank-row"></td>
                                <td class="blank-row"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="blank-row text-center"><h4>Discount Info</h4></td>
                            </tr>
                            <tr>
                                <td class="blank-row"></td>
                                <td class="blank-row"></td>
                            </tr>
                            <tr>
                                <script>
                                    document.write( '<td class="col-md-6">RM Discount Pot</td>' );
                                    document.write( '<td class="col-md-6">£<span class="rm-discount-pot" style="display:none"></span></td>' );
                                    document.write( '</tr>' );
                                    document.write( '<tr>' );
                                    document.write( '<td class="col-md-6">RM Discount Used</td>' );
                                    document.write( '<td class="col-md-6">£<span class="rm-used" style="display:none"></span></td>' );
                                    document.write( '</tr>' );
                                    document.write( '<tr>' );
                                    document.write( '<td class="col-md-6">RM Discount Remaining</td>' );
                                    document.write( '<td class="col-md-6">£<span class="rm-discount" style="display:none"></span></td>' );
                                    document.write( '</tr>' );
                                    document.write( '<tr>' );
                                    document.write( '<td class="col-md-6">Franchise Discount Used</td>' );
                                    document.write( '<td class="col-md-6">£<span class="fran-discount" style="display:none"></span></td>' );
                                </script>
                            </tr>
                            <tr>
                                <td class="blank-row"></td>
                                <td class="blank-row"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="blank-row text-center"><h4>Footfall Info</h4></td>
                            </tr>
                            <tr>
                                <td class="blank-row"></td>
                                <td class="blank-row"></td>
                            </tr>
                            <tr>
                                <td>FootFall</td>
                                <td><span class="targets-footfall"></span></td>
                            </tr>
                            <tr>
                                <td>Projected Footfall</td>
                                <td><span class="projected-footfall"></span></td>
                            </tr>
                            <tr>
                                <td>Average FF Per Day</td>
                                <td><span class="average-footfall"></td>
                            </tr>
                        </tbody>
                     </table>
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() 
    {
        jQuery( '#datepicker' ).val('');
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
        
        jQuery(".review_advisor").select2(
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

    function clone_elements()
    {
        var count = 0;
        var tabs = '';
        var name = '';
        var pill = '';
        
        jQuery( '#minustab' ).hide();
        jQuery( '#plustab' ).removeClass( 'disabled' );
        
        tabs = jQuery("#sales li:not( #plustab, #minustab )");
        count = tabs.length;
        
        if( count > 0 )
        {
            jQuery( '#minustab' ).show();
        }
        else
        {
            jQuery( '#minustab' ).hide();
        }
        
        jQuery('#plustab').off('click').on('click', '#plus', function()
        {
            jQuery(".sale_comment").prop("disabled", true);
            jQuery(".sale-comment").hide();
            
            jQuery( '.sales-message' ).html('');
            jQuery( '#manager-sales-input-form' ).attr( 'type' , 'new' );
            type = 'new';
            tabs = jQuery("#sales li:not( #plustab, #minustab )");
            count = tabs.length;
            
            //now get our next sale number
            count = count + 1;
            
            name = 'Sale ' + count;
            
            var pill = '';
            
            pill = '<li class="tab" id="tab"><a  data-toggle="pill" href="" id="">' + name + '</a></li>';
            
            console.log(pill);
        
            jQuery( pill ).insertBefore( "#plustab" );
            
            jQuery('ul#sales').children('.tab').removeClass('active');
            
            jQuery('ul#sales').children('.tab').last().addClass('active');
            
            if( count > 0 )
            {
                jQuery( '#minustab' ).show();
                jQuery( '#minustab' ).removeClass( 'disabled' );
            }
            else
            {
                jQuery( '#minustab' ).hide();
                jQuery( '#minustab' ).addClass( 'disabled' );
            }
            
            jQuery("#manager-sales-input-form :input").prop("disabled", false);
            jQuery(".save-sales").html("Save Sale");
            jQuery( '.approve-message' ).hide();
            
            jQuery( '#plustab' ).addClass( 'disabled' );
            //jQuery('.advisor').val('').toggle('change');
            jQuery('.sales-advisor').show();
            
            before_new_sale();

            event.preventDefault();
        });
        
        jQuery( "#minustab" ).off('click').on( "click", function() 
        {
            var active_tab = jQuery( "#sales" ).find( '.active' ).find( "a").attr( 'id' );
            var active_name = jQuery( "#sales" ).find( '.active' ).find( "a").text();
            
            var tabs = jQuery("#sales li:not( #plustab, #minustab )");
            var count = tabs.length;
            
            Swal.fire({
                icon: 'error',
                title: 'Are you sure you want delete ' + active_name + '?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `Yes I Do`,
                denyButtonText: `I Changed My Mind`,
            }).then( (result) => 
            {
                /* Read more about isConfirmed, isDenied below */
                if ( result.isConfirmed ) 
                {
                    jQuery( '#sales_tab' ).trigger('change');
                    if( active_tab == '' )
                    {
                        //this will be our new sale
                        jQuery('ul#sales').children('.tab').last().remove();
                        
                        tabs = jQuery("#sales li:not( #plustab, #minustab )");
                        count = tabs.length;
                        
                        if ( count >= 1 )
                        {
                            tabs = jQuery("#sales li:not( #plustab, #minustab )");
                            count = tabs.length;
                        }
                        
                        if( count <= 0 )
                        {
                            jQuery( '.sales-message' ).text( 'We could not find any sales for this store' );
                            jQuery( '#plustab' ).show();
                            jQuery( '#minustab' ).addClass( 'disabled' );
                            jQuery( '.sales-message' ).show();
                            
                            //hide our advisor for the sale
                            jQuery( '.advisor_name' ).val( '' );
                            jQuery( ".advisor_name" ).prop( "disabled", true );
                            jQuery( '.advisor_name' ).hide();
                            
                            new_sale();
                            
                            jQuery( '#minustab' ).hide();
                            jQuery("#manager-sales-input-form :input").prop("disabled", true );
                        }
                        else
                        {
                            first_sale();
                        }
                    }
                    else
                    {
                        //lets get the store
                        var option = jQuery( '.store_locations' ).find('option:selected');
                        store = option.val();
        
                        //this is the normal sale
                        var data = {};
                    
                        data['action'] = 'fc_delete_sale';
                        data['nonce'] = fc_nonce;
                        data['id'] = active_tab;
                        data['store'] = store;
                        
                        jQuery.ajax({
                        	type: 'POST',
                            url: fc_ajax_url,
                            data: data,
                            success: function( data ) 
                            {	
                                var length = 0;
                                
                                if( data.data == 'deleted' )
                                {
                                    jQuery( "#sales" ).find( '.active' ).remove();
                                    
                                    tabs = jQuery("#sales li:not( #plustab, #minustab )");
                                    count = tabs.length;
                                    
                                    if ( count >= 1 )
                                    {
                                        tabs = jQuery("#sales li:not( #plustab, #minustab )");
                                        count = tabs.length;
                                    }
                                    
                                    jQuery( 'ul#sales' ).children( '.tab' ).each( function( i, ele )
                                    {
                                        var id = i + 1;
                                        jQuery( this ).find( 'a' ).text( 'Sale ' + id );
                                    });
                                    
                                    if( length <= 0 )
                                    {
                                        jQuery( '.sales-message' ).text( 'We could not find any sales for this store' );
                                        jQuery( '#plustab' ).show();
                                        jQuery( '#minustab' ).addClass( 'disabled' );
                                        jQuery( '.sales-message' ).show();
                                        
                                        new_sale();
                                        
                                        jQuery( '#minustab' ).hide();
                                        jQuery("#manager-sales-input-form :input").prop("disabled", true );
                                        
                                        first_sale();
                                    }
                                    else
                                    {
                                        first_sale();
                                    }
                                    
                                    jQuery( ".sales-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">' + active_name + ' was deleted successfully.</div></div>' );
                            
                                    jQuery( ".sales-outcome" ).show();
                                    
                                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                                    
                                    //lets update our profits
                                    var store = '';
                                    
                                    <?php
                                    if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
                                    {
                                        ?>
                                        //get the current option
                                        var option = jQuery( '.store_locations' ).find('option:selected');
                                                                
                                        //get the value from the option
                                        store = option.val();
                                        <?php
                                    }
                                    elseif( $user && in_array( 'store_manager', $user->roles ) )
                                    {
                                        ?>
                                        store = '<?php echo $location; ?>';
                                        <?php
                                    }
                                    ?>
                                    
                                    var discount_data = {};
                                    
                                    var date = jQuery( '#sales_date' ).val();
                                    
                                    discount_data['action'] = 'fc_senior_get_discounts';
                                    discount_data['nonce'] = fc_nonce;
                                    discount_data['store'] = store;
                                    discount_data['date'] = date;
                                                
                                    jQuery.ajax({
                                        type: 'POST',
                                        dataType: 'json',
                                        url: fc_ajax_url,
                                        data: discount_data,
                                        success: function( data ) 
                                        {  
                                            jQuery( '.fran_discount' ).val(data.data.fran);
                                            jQuery( '.rm_discount' ).val(data.data.rm);          
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
                                else
                                {
                                    jQuery( ".sales-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">There was an error deleting ' + active_name + ', please try again.</div></div>' );
                            
                                    jQuery( ".sales-outcome" ).show();
                                    
                                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                                }
                            },
                        });
                    }
                    
                    function first_sale()
                    {
                        tabs = jQuery("#sales li:not( #plustab, #minustab )");
                        
                        if( tabs.length > 0 )
                        {
                            //remove our sales message
                            jQuery( '.sales-message' ).hide();
                            jQuery( '.sales-message' ).text( '' );
                            
                            //get our first sale
                            var first_sale = jQuery('ul#sales li:first');
                            
                            //add our active class
                            
                            first_sale.addClass( 'active' );
                            
                            var first_id = jQuery('ul#sales li:first a').attr('id');
                            
                            if(first_id > 0) {
                                get_sale( first_id );
                            }
                            
                            enable_select2();
                            clone_elements();
                            
                            jQuery( '#minustab' ).removeClass( 'disabled' );
                        }
                        else
                        {
                            no_sales();
                        }
                    }
                }
            })
            
            jQuery( '#minustab' ).removeClass( 'disabled' );
            
            event.preventDefault();
        });
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
            $count=1;
            
            foreach( $broadband_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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

            $count=1;
            
            foreach( $broadband_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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

            $count=1;
            
            foreach( $simOnly_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            foreach( $simOnly_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $connected_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $connected_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;

            foreach( $tablet_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $tablet_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $standardtariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $standardtariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $businesstariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $businesstariff as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $price; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $hsmtariff_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $hsmtariff_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $tlotariff_new as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
            $count=1;
            
            foreach( $tlotariff_upgrade as $tariff => $price )
            {
                ?>
                jQuery( '.tariff' )
                    .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                <?php
                $count++;
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
        
        if(value !== 'homebroadband') {
            jQuery( ".broadband-tv-type" ).prop( "disabled", true );
        }
        
        if ( value == 'homebroadband' )
        {
            jQuery( ".broadband-tv-type" ).prop( "disabled", false );
            
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
        
        if( tariff !== 'Choose Tariff' )
        {
            if(producttype == 'handset' && handset == 'Choose Device') 
            {
                jQuery('.tariff').val("").trigger('change');
                jQuery('.tariff-error').html('Please choose your device before choosing tariff').css("color", "red");
                jQuery('.tariff-error').show();
            } else if(producttype == 'handset') {
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
                }else {
                    //this is our other tariff types, these can be worked out normally
                    tariff_profit = mrc;
                    tariff_value = mrc;
                    get_tariff_profit( tariff_profit );
                }
                
                //work out our profits
                if(tariff_type == 'business')
                {
                    tariff_profit = parseFloat(mrc) * parseFloat(multiplier);
                    tariff_value = parseFloat(mrc) * parseFloat(multiplier);
                }
                if(tariff_type == 'standard')
                {
                    tariff_profit = parseFloat(mrc) * 0.83 * parseFloat(multiplier);
                    tariff_value = parseFloat(mrc) * 0.83 * parseFloat(multiplier);
                }
                
                get_tariff_profit( tariff_profit );
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
                    tariff_value = parseFloat(mrc) * 0.83 * parseFloat(multiplier);
                }
                
                get_tariff_profit( tariff_profit );
            } else {
                tariff_profit = mrc;
                tariff_value = mrc;
                
                get_tariff_profit( tariff_profit );
            }
        }
        
        function get_tariff_profit( value )
        {
            if( value == '' )
            {
                jQuery( '.pl' ).val('');
                jQuery( ".tariff-discount-type" ).prop( "disabled", true );
                
                jQuery( '.broadband-tv-select' ).hide();
                jQuery( ".broadband-tv-type" ).prop( "disabled", true );
            }
            else
            {
                jQuery( '.tariff-error' ).hide();
                jQuery( '.tariff-error' ).text('');
                jQuery( '.broadband-tv-error' ).hide();
                jQuery( '.broadband-tv-error' ).text('');
                
                if( saletype == 'upgrade' && tarifftype == 'hsm' )
                {
                    tariff_profit += 0;
                    tariff_old += 0;
                }
                else
                {
                    value = parseFloat( value );
                    
                    tariff_profit = value;
                    tariff_old = value;
                }
                
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
            
            calculate_total_profit();
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
                    
                    //check if siscount was entered
                    var accessory_discount = jQuery( '.accessory_discount' ).val();
                    
                    if( accessory_discount !== '' )
                    {
                        //a discount was entered
                        var text = accessories_profit - accessory_discount;
                        
                        jQuery( '.accessory-profit' ).text( 'Accessories Profit: £' + text );

                        jQuery( ".accessory-discount-left" ).text( 'You have £' + text + ' discount available to use' );
                    }
                    
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
        jQuery(document).on('keyup', '.accessory_discount', function () 
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
                
                total_profit = parseFloat( total_profit );
                    
                total_profit =  total_profit.toFixed( 2 );
                    
                jQuery( '.total-profit' ).text( 'Total Profit: £' + total_profit );
                
                jQuery( '.tp' ).val( total_profit );
                jQuery( '.dp' ).val( total_profit );
                jQuery( '.old' ).val( total_profit );
                    
                jQuery( ".save-sales" ).prop( "disabled", false );
                
                accessory_discount = 0;
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
                    
                    total_profit = parseFloat( total_profit );
                    
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
    
    jQuery(document).on('keyup', '.product_discount', function () 
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
                jQuery( ".product-discount-left" ).show();
                block = true;
                jQuery( '.product_discount' ).val( '' );
            }
            else
            {
                if( tvalue == '' )
                {
                    jQuery( ".product-discount-left" ).html( '<p style="color:red;">You need to set your tariff discount.</p>' );
                    jQuery( ".product-discount-left" ).show();
                    block = true;
                    jQuery( '.product_discount' ).val( '' );
                }
                if( avalue == '' )
                {
                    jQuery( ".product-discount-left" ).html( '<p style="color:red;">You need to input your accessory discount first.</p>' );
                    jQuery( ".product-discount-left" ).show();
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
                        jQuery( ".product-discount-left" ).show();
                        
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
                jQuery( ".product-discount-left" ).show();
                block = true;
            }
        }

        if( ! block )
        {
            var pinput = this.value;
            
            var pdiscount = '';
            
            if( discount == 'franchise' )
            {
                pdiscount = jQuery( '.fran_discount' ).val();
            }
            else if( discount == 'regional' )
            {
                pdiscount = jQuery( '.rm_discount' ).val();
            }
                        
            var temp = '';
            
            if ( pinput == '' )
            {
                var temp = '';
                
                if( discount == 'franchise' )
                {
                    temp = jQuery( '.fran_discount' ).val();;
                }
                else if( discount == 'regional' )
                {
                    temp = jQuery( '.rm_discount' ).val();
                }
    
                jQuery( ".product-discount-left" ).text( 'You have £' + temp + ' discount available to use' );
                jQuery( ".product-discount-left" ).show();
                    
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
                    jQuery( ".product-discount-left" ).show();
                    
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp >= 0 )
                {
                    jQuery( ".product-discount-left" ).text( 'You have £' + temp + ' discount available to use' );
                    jQuery( ".product-discount-left" ).show();
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp < 0 )
                {
                    jQuery( ".product-discount-left" ).html( '<p style="color:red;"> You have used more than your available discount, available discount is £' + pdiscount +'</p>' );
                    jQuery( ".product-discount-left" ).show();
                    jQuery( ".save-sales" ).prop( "disabled", true );
                }
            }
            else
            {
                jQuery( ".product-discount-left" ).html( '<p style="color:red;">Please enter a valid number</p>' );
                jQuery( ".product-discount-left" ).show();
                jQuery( ".save-sales" ).prop( "disabled", true );
            }
        }
    });
    
    jQuery(document).on('keyup', '.product_discount_2', function () 
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
                jQuery( ".product-discount-2-left" ).show();
                block = true;
                jQuery( '.product_discount_2' ).val( '' );
            }
            else
            {
                if( tvalue == '' )
                {
                    jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">You need to set your tariff discount.</p>' );
                    jQuery( ".product-discount-2-left" ).show();
                    block = true;
                    jQuery( '.product_discount_2' ).val( '' );
                }
                if( avalue == '' )
                {
                    jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">You need to input your accessory discount first.</p>' );
                    jQuery( ".product-discount-2-left" ).show();
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
                        jQuery( ".product-discount-2-left" ).show();
                        jQuery( '.total-profit' ).text('Total Profit: £' + new_profit );
                        
                        jQuery( '.tp' ).val( new_profit );
    
                        block = true;
                        
                        jQuery( '.save-sales' ).prop('disabled', true );
                    }
                    
                    if( this.value < 0 )
                    {
                        old = jQuery( '.old' ).val();
                        
                        jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">Your discount cannot be negative</p>' );
                        jQuery( ".product-discount-2-left" ).show();
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
                jQuery( ".product-discount-2-left" ).show();
                block = true;
            }
        }
        
        if( ! block )
        {
            var pinput = this.value;
            
            var pdiscount = '';
            
            if( discount == 'franchise' )
            {
                pdiscount = jQuery( '.fran_discount' ).val();
            }
            else if( discount == 'regional' )
            {
                pdiscount = jQuery( '.rm_discount' ).val();
            }
            
            var temp = '';
            
            if ( pinput == '' )
            {
                var temp = '';
                
                if( discount == 'franchise' )
                {
                    temp = jQuery( '.fran_discount' ).val();
                }
                else if( discount == 'regional' )
                {
                    temp = jQuery( '.rm_discount' ).val();
                }
    
                jQuery( ".product-discount-2-left" ).text( 'You have £' + temp + ' discount available to use' );
                jQuery( ".product-discount-2-left" ).show();
                jQuery( ".save-sales" ).prop("disabled", false );
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
                    jQuery( ".product-discount-2-left" ).show();
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp >= 0 )
                {
                    jQuery( ".product-discount-2-left" ).text( 'You have £' + temp + ' discount available to use' );
                    jQuery( ".product-discount-2-left" ).show();
                    jQuery( ".save-sales" ).prop( "disabled", false );
                }
    
                if( temp < 0 )
                {
                    jQuery( ".product-discount-2-left" ).html( '<p style="color:red;"> You have used more than your available discount, available discount is £' + pdiscount +'</p>' );
                    jQuery( ".product-discount-2-left" ).show();
                    jQuery( ".save-sales" ).prop( "disabled", true );
                }
            }
            else
            {
                jQuery( ".product-discount-2-left" ).html( '<p style="color:red;">Please enter a valid number</p>' );
                jQuery( ".product-discount-2-left" ).show();
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
    
    jQuery(document).on('click', '#approve-all-sales', function () 
    {
        manage_sales('approve');
    });
    
    jQuery(document).on('click', '#unapprove-all-sales', function () 
    {
        manage_sales('unapprove');
    });
    
    jQuery(document).on('click', '#delete-all-sales', function () 
    {
        manage_month_sales('delete');
    });
    
    jQuery(document).on('click', '#approve-all-month-sales', function () 
    {
        manage_month_sales('approve');
    });
    
    jQuery(document).on('click', '#unapprove-all-month-sales', function () 
    {
        manage_month_sales('unapprove');
    });
    
    jQuery(document).on('click', '#delete-all-month-sales', function () 
    {
        manage_sales('delete');
    });
    
    function manage_sales(action)
    {
        var store = jQuery('.store_locations').val();
        var date = jQuery('#sales_date').val();
        
        jQuery('.manage-sales-outcome').html('');
        
        var data = {};
                    
        data['action'] = 'fc_senior_manage_sales';
        data['nonce'] = fc_nonce;
        data['sale_action'] = action;
        data['store'] = store;
        data['date'] = date;
        
        jQuery.ajax({
        	type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {	
                if(data.data == 'approved')
                {
                    jQuery('.manage-sales-outcome').html('All sales have been approved');
                }
                
                if(data.data == 'unapproved')
                {
                    jQuery('.manage-sales-outcome').html('All sales have been unapproved');
                }
                
                if(data.data == 'deleted')
                {
                    jQuery('.manage-sales-outcome').html('All sales have been deleted');
                }
            }
        });
    }
    
    function manage_month_sales(action)
    {
        var store = jQuery('.store_locations').val();
        var date = jQuery('#sales_date').val();
        
        jQuery('.manage-sales-outcome').html('');
        
        var data = {};
                    
        data['action'] = 'fc_senior_manage_month_sales';
        data['nonce'] = fc_nonce;
        data['sale_action'] = action;
        data['store'] = store;
        data['date'] = date;
        
        jQuery.ajax({
        	type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {	
                if(data.data == 'approved')
                {
                    jQuery('.manage-sales-outcome').html('All sales have been approved');
                }
                
                if(data.data == 'unapproved')
                {
                    jQuery('.manage-sales-outcome').html('All sales have been unapproved');
                }
                
                if(data.data == 'deleted')
                {
                    jQuery('.manage-sales-outcome').html('All sales have been deleted');
                }
            }
        });
    }
</script>