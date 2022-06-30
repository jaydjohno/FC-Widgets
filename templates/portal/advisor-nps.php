<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

$salesemployees = fc_get_sale_users();
$employees = fc_get_users();

$manager_location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );

$locations = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC;" ) );

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

//get our start point based on our first sale and get first day of month
$start = new DateTime( '01 March 2022' );
$start->modify( 'first day of this month' );

//get our current date and the first date of this month
$end = new DateTime( 'now' );
$end->modify( 'last day of this month' );

//now set our parameters
$interval = DateInterval::createFromDateString( '1 month' );
$period   = new DatePeriod( $start , $interval , $end );

?>

<p>Welcome <?php echo $user->display_name; ?></p>

<p>In this section you can update your advisors NPS percentages, if you manage more than one store you will need to choose the location first, 
then choose your dates and then the advisor to see their NPS percentage.</p>

<p>Enter the percentage as a number without the percentage sign, so 85 instead of 85%.</p>

<?php

if( $user && in_array( 'senior_manager', $user->roles ) )
{
?>
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
<?php 
} else if( $user && in_array( 'multi_manager', $user->roles )  )
{ 
    ?>
    <p class="form-row wps-drop spacer" id="store_location" data-priority=""><label for="store_location" class="">Choose Store &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="store_locations" class="store_locations" autocomplete="off" required>
                <option value="">Select Store to Continue</option>
                <?php
            
                foreach ( $multi_locations as $mlocation )
                {
                    ?>
                    <option value="<?php echo $mlocation; ?>"><?php echo $mlocation; ?></option>');
                    <?php
                }
                ?>
            </select>
        </span>
    </p>
    
    <div class="store_location_error" style="display:none"></div>
    <?php
}

if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
{
    echo '<p class="store">Choose Your Store Before Continuing</p>';
}

if( $user && in_array( 'store_manager', $user->roles ) )
{
    echo '<p>You are managing the NPS percentages for the ' . $manager_location . ' Store</p>';
}
?>

<p class="form-row wps-drop spacer" id="info_date" data-priority="" style="display:none;"><label for="info_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
    <span class="woocommerce-input-wrapper">
        <select name="info_dates" class="info_dates" autocomplete="off" required>
            <option value="">Select Date</option>
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

<h4 class="nps-info" style="display:none; margin-top:40px;">Advisor NPS Percentages</h4>

<p class="nps-instructions" style="display:none; margin-top:20px; margin-bottom:20px;">Change your advisors NPS percentages using this form</p>

<div id="nps_outcome"></div>
        
<?php
if( $user && in_array( 'senior_manager', $user->roles ) )
{
?>              
    <form id='save-nps-form' class="spacer" action="" method="post" store="" role="senior_manager" month="" year="" style="margin-top:20px;">
<?php
}
if( $user && in_array( 'multi_manager', $user->roles ) )
{
?>              
    <form id='save-nps-form' class="spacer" action="" method="post" store="" role="multi_manager" month="" year="" style="margin-top:20px;">
<?php
}
else
{
?>
    <form id='save-nps-form' class="spacer" action="" method="post" store="<?php echo $manager_location; ?>" role="store_manager" month="" year="" style="margin-top:20px;">
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
    
    <div class="choose_date_error"></div>
    
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide advisor-nps" style="display:none;">
        <label for="advisor_nps"><?php esc_html_e( 'Advisor NPS Percentage', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="advisor_nps" id="advisor_nps" value="" autocomplete="off" /> 
        <span><em><?php esc_html_e( 'Please ensure this figure is correct as it will affect the employees commission', 'woocommerce' ); ?></em></span>
    </p>
    
    <div class="nps-button-container" style="display:none;">
        <button type="submit" id="save-nps" class="woocommerce-Button button" style="margin-top:20px" name="save-nps" value="<?php esc_attr_e( 'Save NPS %', 'woocommerce' ); ?>"><?php esc_html_e( 'Save NPS %', 'woocommerce' ); ?>
        </button>
    </div>
</form>

<div class="store-nps table-responsive" style="display:none;"></div>

<script>
    jQuery( '.store_locations' ).change(function() 
    {
        //get the current option
        var option = jQuery( this ).find('option:selected');
            
        //get the value from the option
        var value = option.val();
        
        if( value !== '' )
        {
            var user_data = {};
                                
            user_data['action'] = 'fc_get_commission_users';
            user_data['nonce'] = fc_nonce;
            user_data['store'] = value;

            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: user_data,
                success: function( data ) 
                {   
                    //show our commission table
                    jQuery( '.advisor' ).html( data.data );
                    jQuery( '#choose_advisor' ).show();
                    jQuery( '.nps-info' ).show();
                    jQuery( '.nps-instructions' ).show();
                    jQuery('#save-nps-form').attr( 'location' , value );
                    jQuery( '.store' ).text( 'You are managing the NPS percentages for the ' + value + ' Store' );
                    jQuery('#info_date').show();
                    jQuery('.advisor-nps').hide();
                    jQuery('.nps-button-container').hide();
                },
            });
            
            var nps_data = {};
                                
            nps_data['action'] = 'fc_get_store_nps';
            nps_data['nonce'] = fc_nonce;
            nps_data['store'] = value;
            nps_data['month'] = '<?php echo date('F'); ?>';
            nps_data['year'] = '<?php echo date('Y'); ?>';

            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: nps_data,
                success: function( data ) 
                {   
                    //show our commission table
                    jQuery( '.store-nps' ).html( data.data );
                    jQuery( '.store-nps' ).show();
                },
            });
        } else {
            //show our commission table
            jQuery( '.advisor' ).html( '' );
            jQuery( '#choose_advisor' ).hide();
            jQuery( '.nps-info' ).hide();
            jQuery( '.nps-instructions' ).hide();
            jQuery('#save-nps-form').attr( 'location' , '' );
            jQuery( '.store' ).text( 'Choose Your Store Before Continuing' );
            jQuery('#info_date').hide();
            jQuery('.advisor-nps').hide();
            jQuery('.nps-button-container').hide();
            jQuery( '.store-nps' ).html( '' );
        }
    });
    
    jQuery( document ).ready(function() 
    {
        jQuery(".store_locations").select2(
        {
            width: '100%',
        });
        
        jQuery(".info_dates").select2(
        {
            width: '100%',
        });
        
        jQuery(".advisor").select2(
        {
            width: '100%',
        });
        
        jQuery( '.info_dates' ).val( '<?php echo $end->format("F Y"); ?>' ); 
        jQuery( '#info_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
        jQuery( '#info_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
        
        <?php
        if( $user && in_array( 'store_manager', $user->roles ) )
        { ?>
            jQuery( '#info_date' ).show();
                
            //get the value from the option
            var value = '<?php echo $manager_location; ?>';
            
            if( value !== '' )
            {
                var user_data = {};
                                    
                user_data['action'] = 'fc_get_commission_users';
                user_data['nonce'] = fc_nonce;
                user_data['store'] = value;
    
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: user_data,
                    success: function( data ) 
                    {   
                        //show our commission table
                        jQuery( '.advisor' ).html( data.data );
                        jQuery( '#choose_advisor' ).show();
                        jQuery( '.nps-info' ).show();
                        jQuery( '.nps-instructions' ).show();
                        jQuery('#save-nps-form').attr( 'location' , value );
                        jQuery( '.store' ).text( 'You are managing the NPS percentages for the ' + value + ' Store' );
                        jQuery('#info_date').show();
                        jQuery('.advisor-nps').hide();
                        jQuery('.nps-button-container').hide();
                    },
                });
                
                var nps_data = {};
                                    
                nps_data['action'] = 'fc_get_store_nps';
                nps_data['nonce'] = fc_nonce;
                nps_data['store'] = value;
                nps_data['month'] = '<?php echo date('F'); ?>';
                nps_data['year'] = '<?php echo date('Y'); ?>';
    
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: nps_data,
                    success: function( data ) 
                    {   
                        //show our commission table
                        jQuery( '.store-nps' ).html( data.data );
                        jQuery( '.store-nps' ).show();
                    },
                });
            } else {
                //show our commission table
                jQuery( '.advisor' ).html( '' );
                jQuery( '#choose_advisor' ).hide();
                jQuery( '.nps-info' ).hide();
                jQuery( '.nps-instructions' ).hide();
                jQuery('#save-nps-form').attr( 'location' , '' );
                jQuery( '.store' ).text( 'Choose Your Store Before Continuing' );
                jQuery('#info_date').hide();
                jQuery('.advisor-nps').hide();
                jQuery('.nps-button-container').hide();
                jQuery( '.store-nps' ).html( '' );
            }
        <?php } ?>
    });
        
    jQuery( document ).on("change",".advisor",function() 
    {
        //get the current option
        var option = jQuery( this ).find('option:selected');
                                
        //get the value from the option
        var value = option.val();
        
        var dateOption  = jQuery( '.info_dates' ).find('option:selected');
        
        var date = dateOption.val();
        
        if( date !== '' )
        {
            var ret = date.split(" ");
            var month = ret[0];
            var year = ret[1];
            
            jQuery( '#save-nps-form' ).attr( 'month' , month );
            jQuery( '#save-nps-form' ).attr( 'year' , year );
            
            var data = {};
        
            data['action'] = 'fc_get_advisor_nps';
            data['nonce'] = fc_nonce;
            data['advisor'] = value;
            data['month'] = month;
            data['year'] = year;
    
            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    jQuery('#advisor_nps').val(data.data);
                    jQuery('#advisor_nps').prop( "readonly", false );
                    jQuery( '.advisor-nps' ).show();
                    jQuery( '.nps-button-container' ).show();
                }
            });
        } else {
            jQuery('#advisor_nps').val('');
            jQuery( '.advisor-nps' ).hide();
            jQuery( '.nps-button-container' ).hide();
        }
    });
    
    jQuery( document ).on("change",".info_dates",function() 
    {
        //get the current option
        var option = jQuery( this ).find('option:selected');
                                
        //get the value from the option
        var value = option.val();
        
        var advisorOption  = jQuery( '.advisor' ).find('option:selected');
        
        var advisor = advisorOption.val();
        
        if( value !== '' && advisor !== '' )
        {
            var ret = value.split(" ");
            var month = ret[0];
            var year = ret[1];
            
            jQuery( '#save-nps-form' ).attr( 'month' , month );
            jQuery( '#save-nps-form' ).attr( 'year' , year );
            
            var data = {};
        
            data['action'] = 'fc_get_advisor_nps';
            data['nonce'] = fc_nonce;
            data['advisor'] = advisor;
            data['month'] = month;
            data['year'] = year;
    
            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    jQuery('#advisor_nps').val(data.data);
                    jQuery('#advisor_nps').prop( "readonly", false );
                    jQuery( '.advisor-nps' ).show();
                    jQuery( '.nps-button-container' ).show();
                }
            });
        } else {
            jQuery('#advisor_nps').val('');
            jQuery( '.advisor-nps' ).hide();
            jQuery( '.nps-button-container' ).hide();
            jQuery( '.store-nps' ).html( '' );
        }
        
        if(value !== '' && advisor == '') {
            refresh_table();
        }
    });
    
    <?php if( $user && in_array( 'senior_manager', $user->roles ) )
    { ?>
        jQuery( document ).on("click","#remove-kpi-override",function() 
        {
            var data = {};
                                    
            data['action'] = 'fc_remove_override';
            data['nonce'] = fc_nonce;
            data['advisor'] = jQuery( this ).attr( 'advisor' );
            data['date'] = jQuery('.info_dates').val();
            data['remove'] = 'kpi';
    
            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                   refresh_table();
                },
            });
        });
        
        jQuery( document ).on("click","#remove-nps-override",function() 
        {
            var data = {};
                                    
            data['action'] = 'fc_remove_override';
            data['nonce'] = fc_nonce;
            data['advisor'] = jQuery( this ).attr( 'advisor' );
            data['date'] = jQuery('.info_dates').val();
            data['remove'] = 'nps';
    
            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                   refresh_table();
                },
            });
        });
    <?php } ?>
    
    function refresh_table() {
        var nps_data = {};
        
        //get our date info
        var option = jQuery( '.info_dates' ).find('option:selected');
                                
        //get the value from the option
        var value = option.val();
        
        if(value !== '') {
            var ret = value.split(" ");
            var month = ret[0];
            var year = ret[1];
        }
                                
        nps_data['action'] = 'fc_get_store_nps';
        nps_data['nonce'] = fc_nonce;
        nps_data['store'] = jQuery('.store_locations').val();
        nps_data['month'] = month;
        nps_data['year'] = year;

        jQuery.ajax({
            type: 'POST',
            url: fc_ajax_url,
            data: nps_data,
            success: function( data ) 
            {   
                //show our commission table
                jQuery( '.store-nps' ).html( data.data );
                jQuery( '.store-nps' ).show();
            },
        });
    }
</script>