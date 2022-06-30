<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

$employees = fc_get_users();

$location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );

$locations = array();

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

$results = $wpdb->get_results( $wpdb->prepare( "select sale_date from wp_fc_sales_info order by sale_date asc limit 1;" ) );

foreach ( $results as $result )
{
    $date = $result->sale_date;
}

//get our start point based on our first sale and get first day of month
$start = new DateTime( 'March 2022' );
$start->modify( 'first day of this month' );

//get our current date and the first date of this month
$end = new DateTime( 'now' );
$end->modify( 'last day of this month' );

//now set our parameters
$interval = DateInterval::createFromDateString( '1 month' );
$period   = new DatePeriod( $start , $interval , $end );

?>

<div class="info-errors" style="display:none"></div>

<p>Welcome <?php echo $user->display_name; ?></p>

<?php

if( $user && in_array( 'senior_manager', $user->roles ) )
{
?>
    <p>Choose the store to see the commission information for that store</p>
    
    <p class="form-row wps-drop spacer" id="store_location" data-priority=""><label for="store_location" class="">Choose Store &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="store_locations" class="store_locations" autocomplete="off" required>
                <option value="">Select Store to Continue</option>
                <?php
            
                foreach ( $locations as $location )
                {
                    ?>
                    <option value="<?php echo $location; ?>"><?php echo $location; ?></option>');
                    <?php
                }
                ?>
            </select>
        </span>
    </p>
    
    <div class="store_location_error" style="display:none"></div>
<?php
}
if( $user && in_array( 'multi_manager', $user->roles ) )
{
?>
    <p>Choose your store to see the commission information for your store</p>
    
    <p class="form-row wps-drop spacer" id="store_location" data-priority=""><label for="store_location" class="">Choose Store &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="store_locations" class="store_locations" autocomplete="off" required>
                <option value="">Select Store to Continue</option>
                <?php
            
                foreach ( $multi_locations as $mlocation )
                {
                    ?>
                    <option value="<?php echo $mlocation; ?>"><?php echo $mlocation; ?></option>';
                    <?php
                }
                ?>
            </select>
        </span>
    </p>
    
    <div class="store_location_error" style="display:none"></div>
<?php
}
?>

<p class="form-row wps-drop spacer" id="choose_advisor" data-priority="" style="display:none;"><label for="choose_advisor" class="">Choose Advisor &nbsp;<span class="required">*</span></label>
    <span class="woocommerce-input-wrapper">
        <select name="advisor" class="advisor" autocomplete="off" required>
            <option value="">Choose Advisor</option>
            <?php 
            foreach( $employees as $id => $employee )
            {
                ?>
                <option value="<?php echo $id; ?>"><?php echo $employee; ?></option>
                <?php
            }
            ?>
        </select>
    </span>
</p>

<div class="choose_advisor_error"></div>

<p class="form-row wps-drop spacer" id="info_date" data-priority="" style="display:none;"><label for="info_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
    <span class="woocommerce-input-wrapper">
        <select name="info_dates" class="info_dates" autocomplete="off" required>
            <option value="">Select Date to View Store Commission</option>
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

<div class="choose_date_error"></div>

<script>
    <?php
    if( $user && in_array( 'multi_manager', $user->roles ) || $user && in_array( 'senior_manager', $user->roles ) )
    {
    ?>
        jQuery( '.store_locations' ).change(function() 
        {
            //get the current option
            var option = jQuery( this ).find('option:selected');
                                    
            //get the value from the option
            var value = option.val();
            
            jQuery( '.info_dates' ).val('').trigger('change');
            jQuery( '#info_date' ).hide();
            
            if( value !== '' )
            {
                jQuery( '.choose_date_error' ).html( '');
                
                var data = {};
                                
                data['action'] = 'fc_get_commission_users';
                data['nonce'] = fc_nonce;
                data['store'] = value;
    
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        //show our commission table
                        jQuery( '.advisor' ).html( data.data );
                        jQuery( '#choose_advisor' ).show();
                    },
                });
            } else {
                jQuery( '#choose_advisor' ).hide();
                jQuery( '#info_date' ).hide();
            }
        });
    <?php } ?>
    
    jQuery( '.advisor' ).change(function()
    {
        //get the current option
        var option = jQuery( this ).find('option:selected');
                                
        //get the value from the option
        var value = option.val();
        
        jQuery( '.info_dates' ).val('').trigger('change');
        
        if( value !== '' )
        {
            jQuery( '#info_date' ).show();
        } else {
            jQuery( '#info_date' ).hide();
        }
    });
        
    jQuery( '.info_dates' ).change(function() 
    {
        //get the current option
        var option = jQuery( this ).find('option:selected');
                                
        //get the value from the option
        var value = option.val();
        
        if(value !== '') {
            var advisor = jQuery('.advisor').val();
        
            if( advisor !== '' )
            {
                var data = {};
                                    
                data['action'] = 'fc_get_store_commission';
                data['nonce'] = fc_nonce;
                data['advisor'] = advisor;
                data['date'] = value;
    
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                       jQuery('.commission').html(data.data.commission);
                       jQuery('.commission').show();
                    },
                });
            }
        } else {
            jQuery('.commission').hide();
            jQuery('.commission').html('');
        }
    });
    
    jQuery( document ).ready(function() 
    {
        jQuery(".store_locations").select2(
        {
            width: '100%',
        });
        
        jQuery( ".info_dates" ).select2(
        {
            width: '100%',
        });
        
        jQuery( ".advisor" ).select2(
        {
            width: '100%',
        });
        
        jQuery( '.info_dates' ).val( '<?php echo $end->format("F Y"); ?>' ); 
        jQuery( '#info_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
        jQuery( '#info_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
        
        <?php
        if( $user && in_array( 'store_manager', $user->roles ) )
        {
        ?>
            jQuery( '#choose_advisor' ).show();
        <?php
        }
        ?>
    });
    
    jQuery(document).on('click','#override-kpi',function(){
        var data = {};
                                    
        data['action'] = 'fc_override_commissions';
        data['nonce'] = fc_nonce;
        data['advisor'] = jQuery('.advisor').val();
        data['date'] = jQuery('.info_dates').val();
        data['override'] = 'kpi';

        jQuery.ajax({
            type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {   
               refresh_commission();
            },
        });
    });
    
    jQuery(document).on('click','#override-nps',function(){
        var data = {};
                                    
        data['action'] = 'fc_override_commissions';
        data['nonce'] = fc_nonce;
        data['advisor'] = jQuery('.advisor').val();
        data['date'] = jQuery('.info_dates').val();
        data['override'] = 'nps';

        jQuery.ajax({
            type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {   
               refresh_commission();
            },
        });
    });
    
    function refresh_commission() {
        var data = {};
        
        //get the current option
        var option = jQuery( '.info_dates' ).find('option:selected');
                                
        //get the value from the option
        var value = option.val();
        
        var advisorOption = jQuery( '.advisor' ).find('option:selected');
                                
        //get the value from the option
        var advisor = advisorOption.val();
                                    
        data['action'] = 'fc_get_store_commission';
        data['nonce'] = fc_nonce;
        data['advisor'] = advisor;
        data['date'] = value;

        jQuery.ajax({
            type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {   
               jQuery('.commission').html(data.data.commission);
               jQuery('.commission').show();
            },
        });
    }
</script>

<div class="commission col-md-12 spacer" style="display:none"></div>