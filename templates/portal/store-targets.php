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

?>

<div class="info-errors" style="display:none"></div>

<p>Welcome <?php echo $user->display_name; ?></p>

<p>Welcome to the new store targets / commission page, on this page you will see the advisors targets and commission due for the month, all columns must go green in order for the advisor to achieve their commission</p></p>

<?php
if( $user && in_array( 'senior_manager', $user->roles )  )
{
    ?>
    <p>Choose the store to see the profit information for that store</p>
    
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
    
    <script>
        jQuery( '.store_locations' ).change(function() 
        {
            //get the current option
            var option = jQuery( this ).find('option:selected');
                                    
            //get the value from the option
            var value = option.val();
            
            if( value !== '' )
            {
                var date = jQuery( '.info_dates' ).val();
                
                if( date == '' )
                {
                    jQuery( '.choose_date_error' ).html( '<p style="color:red;">You must set your date before choosing your store</p>');
                    jQuery( '.store_locations' ).val('').trigger('change');
                }
                else
                {
                    jQuery( '.choose_date_error' ).html( '');
                    var data = {};
                                    
                    data['action'] = 'fc_get_store_information';
                    data['nonce'] = fc_nonce;
                    data['store'] = value;
                    data['date'] = date;
            
                    jQuery.ajax({
                        type: 'POST',
                        url: fc_ajax_url,
                        data: data,
                        success: function( data ) 
                        {   
                            //show our datepicker
                            jQuery( '#info_date' ).show();
                            
                            if(data.data.type !== 'old' )
                            {
                                //clear our old info
                                jQuery( '.profit-information' ).html( '' );
                                jQuery( '.profit-information' ).hide();
                                    
                                //show our new info
                                jQuery( '.new-information' ).html( '' );
                                jQuery( '.new-information' ).hide();
                                    
                                //show our upgrade info
                                jQuery( '.upgrade-information' ).html( '' );
                                jQuery( '.upgrade-information' ).hide();
                                    
                                //show our new hbb info
                                jQuery( '.hbb-new-information' ).html( '' );
                                jQuery( '.hbb-new-information' ).hide();
                                    
                                //show our hbb upgrade info
                                jQuery( '.hbb-upgrades-information' ).html( '' );
                                jQuery( '.hbb-upgrades-information' ).hide();
                                    
                                //show our accessories info
                                jQuery( '.accessories-information' ).html( '' );
                                jQuery( '.accessories-information' ).hide();
                                
                                //show our BT TV info
                                jQuery( '.bt-tv-information' ).html( '' );
                                jQuery( '.bt-tv-information' ).hide();
                                    
                                //show our insurance info
                                jQuery( '.insurance-information' ).html( '' );
                                jQuery( '.insurance-information' ).hide();
                                
                                jQuery( '.new-table' ).html( data.data.new );
                                jQuery( '.new-table' ).show();
                            }
                            else
                            {
                                //show our profit info
                                jQuery( '.profit-information' ).html( data.data.profits );
                                jQuery( '.profit-information' ).show();
                                    
                                //show our new info
                                jQuery( '.new-information' ).html( data.data.new );
                                jQuery( '.new-information' ).show();
                                    
                                //show our upgrade info
                                jQuery( '.upgrade-information' ).html( data.data.upgrade );
                                jQuery( '.upgrade-information' ).show();
                                    
                                //show our new hbb info
                                jQuery( '.hbb-new-information' ).html( data.data.hbb_new );
                                jQuery( '.hbb-new-information' ).show();
                                    
                                //show our hbb upgrade info
                                jQuery( '.hbb-upgrades-information' ).html( data.data.hbb_upgrades );
                                jQuery( '.hbb-upgrades-information' ).show();
                                    
                                //show our accessories info
                                jQuery( '.accessories-information' ).html( data.data.accessories );
                                jQuery( '.accessories-information' ).show();
                                
                                //show our BT TV info
                                jQuery( '.bt-tv-information' ).html( data.data.bt_tv );
                                jQuery( '.bt-tv-information' ).show();
                                    
                                //show our insurance info
                                jQuery( '.insurance-information' ).html( data.data.insurance );
                                jQuery( '.insurance-information' ).show();
                                
                                jQuery( '.new-table' ).html( '' );
                                jQuery( '.new-table' ).hide();
                            }
                        },
                    });
                }
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
        });
    </script>
    <?php
}
elseif( $user && in_array( 'multi_manager', $user->roles )  )
{
?>
    <p>Choose your store to see the profit information for your store</p>
    
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
    
    <script>
        jQuery( '.store_locations' ).change(function() 
        {
            //get the current option
            var option = jQuery( this ).find('option:selected');
                                    
            //get the value from the option
            var value = option.val();
            
            if( value !== '' )
            {
                var date = jQuery( '.info_dates' ).val();
                
                if( date == '' )
                {
                    jQuery( '.choose_date_error' ).html( '<p style="color:red;">You must set your date before choosing your store</p>');
                    jQuery( '.store_locations' ).val('').trigger('change');
                }
                else
                {
                    jQuery( '.choose_date_error' ).html( '');
                    
                    var data = {};
                                    
                    data['action'] = 'fc_get_store_information';
                    data['nonce'] = fc_nonce;
                    data['store'] = value;
                    data['date'] = date;
            
                    jQuery.ajax({
                        type: 'POST',
                        url: fc_ajax_url,
                        data: data,
                        success: function( data ) 
                        {   
                            //show our datepicker
                            jQuery( '#info_date' ).show();
                            
                            if(data.data.type !== 'old' )
                            {
                                //clear our old info
                                jQuery( '.profit-information' ).html( '' );
                                jQuery( '.profit-information' ).hide();
                                    
                                //show our new info
                                jQuery( '.new-information' ).html( '' );
                                jQuery( '.new-information' ).hide();
                                    
                                //show our upgrade info
                                jQuery( '.upgrade-information' ).html( '' );
                                jQuery( '.upgrade-information' ).hide();
                                    
                                //show our new hbb info
                                jQuery( '.hbb-new-information' ).html( '' );
                                jQuery( '.hbb-new-information' ).hide();
                                    
                                //show our hbb upgrade info
                                jQuery( '.hbb-upgrades-information' ).html( '' );
                                jQuery( '.hbb-upgrades-information' ).hide();
                                    
                                //show our accessories info
                                jQuery( '.accessories-information' ).html( '' );
                                jQuery( '.accessories-information' ).hide();
                                
                                //show our BT TV info
                                jQuery( '.bt-tv-information' ).html( '' );
                                jQuery( '.bt-tv-information' ).hide();
                                    
                                //show our insurance info
                                jQuery( '.insurance-information' ).html( '' );
                                jQuery( '.insurance-information' ).hide();
                                
                                jQuery( '.new-table' ).html( data.data.new );
                                jQuery( '.new-table' ).show();
                            }
                            else
                            {
                                //show our profit info
                                jQuery( '.profit-information' ).html( data.data.profits );
                                jQuery( '.profit-information' ).show();
                                    
                                //show our new info
                                jQuery( '.new-information' ).html( data.data.new );
                                jQuery( '.new-information' ).show();
                                    
                                //show our upgrade info
                                jQuery( '.upgrade-information' ).html( data.data.upgrade );
                                jQuery( '.upgrade-information' ).show();
                                    
                                //show our new hbb info
                                jQuery( '.hbb-new-information' ).html( data.data.hbb_new );
                                jQuery( '.hbb-new-information' ).show();
                                    
                                //show our hbb upgrade info
                                jQuery( '.hbb-upgrades-information' ).html( data.data.hbb_upgrades );
                                jQuery( '.hbb-upgrades-information' ).show();
                                    
                                //show our accessories info
                                jQuery( '.accessories-information' ).html( data.data.accessories );
                                jQuery( '.accessories-information' ).show();
                                
                                //show our BT TV info
                                jQuery( '.bt-tv-information' ).html( data.data.bt_tv );
                                jQuery( '.bt-tv-information' ).show();
                                    
                                //show our insurance info
                                jQuery( '.insurance-information' ).html( data.data.insurance );
                                jQuery( '.insurance-information' ).show();
                                
                                jQuery( '.new-table' ).html( '' );
                                jQuery( '.new-table' ).hide();
                            }
                        },
                    });
                }
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
        });
    </script>
<?php
}
?>

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
    jQuery( document ).ready(function() 
    {
        jQuery( '.info_dates' ).val( '<?php echo $end->format("F Y"); ?>' );   
        jQuery( '#info_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
        jQuery( '#info_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
    });
</script>

<?php
if( $user && in_array( 'store_manager', $user->roles ))
{
    ?>
    <script>
        jQuery( document ).ready(function() 
        {
            var date = jQuery( '.info_dates' ).val();
            
            var data = {};
                                       
            data['action'] = 'fc_get_store_information';
            data['nonce'] = fc_nonce;
            data['store'] = '<?php echo $location; ?>';
            data['date'] = date;
                
            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    //show our datepicker
                    jQuery( '#info_date' ).show();
                            
                    if(data.data.type !== 'old' )
                    {
                        //clear our old info
                        jQuery( '.profit-information' ).html( '' );
                        jQuery( '.profit-information' ).hide();
                            
                        //show our new info
                        jQuery( '.new-information' ).html( '' );
                        jQuery( '.new-information' ).hide();
                            
                        //show our upgrade info
                        jQuery( '.upgrade-information' ).html( '' );
                        jQuery( '.upgrade-information' ).hide();
                            
                        //show our new hbb info
                        jQuery( '.hbb-new-information' ).html( '' );
                        jQuery( '.hbb-new-information' ).hide();
                            
                        //show our hbb upgrade info
                        jQuery( '.hbb-upgrades-information' ).html( '' );
                        jQuery( '.hbb-upgrades-information' ).hide();
                            
                        //show our accessories info
                        jQuery( '.accessories-information' ).html( '' );
                        jQuery( '.accessories-information' ).hide();
                        
                        //show our BT TV info
                        jQuery( '.bt-tv-information' ).html( '' );
                        jQuery( '.bt-tv-information' ).hide();
                            
                        //show our insurance info
                        jQuery( '.insurance-information' ).html( '' );
                        jQuery( '.insurance-information' ).hide();
                        
                        jQuery( '.new-table' ).html( data.data.new );
                        jQuery( '.new-table' ).show();
                    }
                    else
                    {
                        //show our profit info
                        jQuery( '.profit-information' ).html( data.data.profits );
                        jQuery( '.profit-information' ).show();
                            
                        //show our new info
                        jQuery( '.new-information' ).html( data.data.new );
                        jQuery( '.new-information' ).show();
                            
                        //show our upgrade info
                        jQuery( '.upgrade-information' ).html( data.data.upgrade );
                        jQuery( '.upgrade-information' ).show();
                            
                        //show our new hbb info
                        jQuery( '.hbb-new-information' ).html( data.data.hbb_new );
                        jQuery( '.hbb-new-information' ).show();
                            
                        //show our hbb upgrade info
                        jQuery( '.hbb-upgrades-information' ).html( data.data.hbb_upgrades );
                        jQuery( '.hbb-upgrades-information' ).show();
                            
                        //show our accessories info
                        jQuery( '.accessories-information' ).html( data.data.accessories );
                        jQuery( '.accessories-information' ).show();
                        
                        //show our BT TV info
                        jQuery( '.bt-tv-information' ).html( data.data.bt_tv );
                        jQuery( '.bt-tv-information' ).show();
                            
                        //show our insurance info
                        jQuery( '.insurance-information' ).html( data.data.insurance );
                        jQuery( '.insurance-information' ).show();
                        
                        jQuery( '.new-table' ).html( '' );
                        jQuery( '.new-table' ).hide();
                    }
                },
            });
        });
        
        jQuery( document ).ready(function() 
        {
            jQuery( ".info_dates" ).select2(
            {
                width: '100%',
            });
        });
    </script>
    <?php
}
?>

<script>
    jQuery( '.info_dates' ).change(function() 
    {
        var location = '';
        <?php
        if( $user && in_array( 'multi_manager', $user->roles ) || $user && in_array( 'senior_manager', $user->roles ) )
        {
            ?>
            //get the current option
            var option = jQuery( '.store_locations' ).find('option:selected');
                                    
            //get the value from the option
            location = option.val();
            
            console.log(location);
            <?php
        }
        else
        {
            ?>
            location = '<?php echo $location; ?>';
            <?php
        }
        ?>
        
        if( location !== '' )
        {
            var date = jQuery( '.info_dates' ).val();
            
            if(date !== '') {
                var data = {};
                                           
                data['action'] = 'fc_get_store_information';
                data['nonce'] = fc_nonce;
                data['store'] = location;
                data['date'] = date;
                    
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        if(data.data.type !== 'old' )
                        {
                            //clear our old info
                            jQuery( '.profit-information' ).html( '' );
                            jQuery( '.profit-information' ).hide();
                                
                            //show our new info
                            jQuery( '.new-information' ).html( '' );
                            jQuery( '.new-information' ).hide();
                                
                            //show our upgrade info
                            jQuery( '.upgrade-information' ).html( '' );
                            jQuery( '.upgrade-information' ).hide();
                                
                            //show our new hbb info
                            jQuery( '.hbb-new-information' ).html( '' );
                            jQuery( '.hbb-new-information' ).hide();
                                
                            //show our hbb upgrade info
                            jQuery( '.hbb-upgrades-information' ).html( '' );
                            jQuery( '.hbb-upgrades-information' ).hide();
                                
                            //show our accessories info
                            jQuery( '.accessories-information' ).html( '' );
                            jQuery( '.accessories-information' ).hide();
                            
                            //show our BT TV info
                            jQuery( '.bt-tv-information' ).html( '' );
                            jQuery( '.bt-tv-information' ).hide();
                                
                            //show our insurance info
                            jQuery( '.insurance-information' ).html( '' );
                            jQuery( '.insurance-information' ).hide();
                            
                            jQuery( '.new-table' ).html( data.data.new );
                            jQuery( '.new-table' ).show();
                        }
                        else
                        {
                            //show our profit info
                            jQuery( '.profit-information' ).html( data.data.profits );
                            jQuery( '.profit-information' ).show();
                                
                            //show our new info
                            jQuery( '.new-information' ).html( data.data.new );
                            jQuery( '.new-information' ).show();
                                
                            //show our upgrade info
                            jQuery( '.upgrade-information' ).html( data.data.upgrade );
                            jQuery( '.upgrade-information' ).show();
                                
                            //show our new hbb info
                            jQuery( '.hbb-new-information' ).html( data.data.hbb_new );
                            jQuery( '.hbb-new-information' ).show();
                                
                            //show our hbb upgrade info
                            jQuery( '.hbb-upgrades-information' ).html( data.data.hbb_upgrades );
                            jQuery( '.hbb-upgrades-information' ).show();
                                
                            //show our accessories info
                            jQuery( '.accessories-information' ).html( data.data.accessories );
                            jQuery( '.accessories-information' ).show();
                            
                            //show our BT TV info
                            jQuery( '.bt-tv-information' ).html( data.data.bt_tv );
                            jQuery( '.bt-tv-information' ).show();
                                
                            //show our insurance info
                            jQuery( '.insurance-information' ).html( data.data.insurance );
                            jQuery( '.insurance-information' ).show();
                            
                            jQuery( '.new-table' ).html( '' );
                            jQuery( '.new-table' ).hide();
                        }
                    },
                });
            }
        }
    });
</script>

<?php
//This is for our previous months targets
?>
<div class="profit-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">Profits</h3>
</div>

<div class="new-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">New</h3>
</div>

<div class="upgrade-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">Upgrade</h3>
</div>

<div class="hbb-new-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">New HBB</h3>
</div>

<div class="hbb-upgrades-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">HBB Upgrades</h3>
</div>

<div class="accessories-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">Accessories</h3>
</div>

<div class="bt-tv-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">Bt TV</h3>
</div>

<div class="insurance-information col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">Insurance</h3>
</div>

<?php
//This is our new profit table
?>

<div class="new-table col-md-12 spacer table-responsive" style="display:none">
    <h3 class="text-center">Staff Targets</h3>
</div>
