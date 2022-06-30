<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$employees = fc_get_users();

$locations = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

foreach ( $results as $result )
{
    $locations[] = $result->location;
}

$location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );

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

?>
<h2 class="text-center">Assign Store Cover</h2>

<p>Welcome <?php echo $user->display_name; ?></p>

<?php

if( $user && in_array( 'senior_manager', $user->roles ) )
{
    ?>
    <p class="form-row wps-drop spacer" id="store_location" data-priority=""><label for="store_location" class="">Choose Store &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="store_locations" class="store_locations" autocomplete="off" required>
                <option value="">Select Store to Continue</option>
                <?php
            
                foreach( $locations as $location )
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
                var data = {};
                                                    
                data['action'] = 'fc_senior_get_cover_staff';
                data['nonce'] = fc_nonce;
                data['store'] = value;
                            
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( ".advisor" ).html( data );
                                            
                        jQuery( ".advisor" ).select2(
                        {
                            width: '100%',
                        });
                        
                        jQuery( '.location' ).html( value );
                        jQuery( '.intro' ).show();
                    },
                });
                
                data = {};
                                                    
                data['action'] = 'fc_senior_get_cover_info';
                data['nonce'] = fc_nonce;
                data['store'] = value;
                            
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( ".cover-info" ).html( data );
                        jQuery( ".current-store-cover" ).show();
                    },
                });
            }
        });
    </script>
    
    <p class="intro" style+"display:none">You are viewing staff for the <span class="location">Skipton</span> store, use this form to assign store cover, it is your responsibility to remove the staff members cover or their sales will be going to another store and will affect their targets.</p>
    <?php
}
elseif( $user && in_array( 'multi_manager', $user->roles ) )
{
    ?>
    <p class="form-row wps-drop spacer" id="store_location" data-priority=""><label for="store_location" class="">Choose Store &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="store_locations" class="store_locations" autocomplete="off" required>
                <option value="">Select Store to Continue</option>
                <?php
            
                foreach( $multi_locations as $location )
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
            
            jQuery( '.assign-store-cover' ).attr( 'store' , value );
            
            if( value !== '' )
            {
                var data = {};
                                                    
                data['action'] = 'fc_senior_get_cover_staff';
                data['nonce'] = fc_nonce;
                data['store'] = value;
                            
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( ".advisor" ).html( data );
                                            
                        jQuery( ".advisor" ).select2(
                        {
                            width: '100%',
                        });
                        
                        jQuery( '.location' ).html( value );
                        jQuery( '.intro' ).show();
                    },
                });
                
                data = {};
                                                    
                data['action'] = 'fc_senior_get_cover_info';
                data['nonce'] = fc_nonce;
                data['store'] = value;
                            
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( ".cover-info" ).html( data );
                        jQuery( ".current-store-cover" ).show();
                    },
                });
            }
        });
    </script>
    
    <p class="intro" style="display:none">You are viewing staff for the <span class="location">Skipton</span> store, use this form to assign store cover, it is your responsibility to remove the staff members cover or their sales will be going to another store and will affect their targets.</p>

    <?php
}
else
{
    ?>
        <p>You are viewing staff for the <?php echo $location; ?> store, use this form to assign store cover, it is your responsibility to remove the staff members cover or their sales will be going to another store and will affect their targets</p>
    <?php
}
?>

<script>
    jQuery( document ).ready(function() 
    {
        jQuery( ".store_locations" ).select2(
        {
            width: '100%',
        });
        
        jQuery( ".advisor" ).select2(
        {
            width: '100%',
        });
                
        jQuery( ".store_cover" ).select2(
        {
            width: '100%',
        });
    });
</script>

<div class="cover-outcome" style="display:none"></div>

<form class="assign-store-cover" store="<?php echo $location; ?>">
    <?php
    if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
    {
    ?> 
        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name sales-advisor">
                    <label for="sales_advisor"><?php esc_html_e( 'Choose Advisor', 'woocommerce' ); ?>&nbsp;<span class="required">*</span>
                    </label>
                    <select name="advisor" class="advisor" autocomplete="off" required>
                        <option value="">Select Store to Continue</option>
                    </select>
                </p>
            </div>
        </div>
    <?php
    }
    else if( $user && in_array( 'store_manager', $user->roles ) )
    {
    ?>
        <div class="row">
            <div class="col-md-12">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name sales-advisor">
                    <label for="sales_advisor"><?php esc_html_e( 'Choose Advisor', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <select name="advisor" class="advisor" autocomplete="off" required>
                        <option value="">Choose Advisor</option>;
                        <?php
                        foreach( $employees as $id => $employee)
                        {
                            $cover_store = get_user_meta( $id , 'store_cover' , true );
                            
                            if( $cover_store == 'yes' )
                            {
                                echo '<option value="' . $id . '" disabled>' . $employee . '</option>';
                            }
                            else
                            {
                                echo '<option value="' . $id . '">' . $employee . '</option>';
                            }
                        }
                        ?>
                    </select>
                </p>
            </div>
        </div>
    <?php
    }
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide user-name store-cover">
                <label for="store_cover"><?php esc_html_e( 'Select Cover Store', 'woocommerce' ); ?>&nbsp;<span class="required">*</span>
                </label>
                <select name="store_cover" class="store_cover" autocomplete="off" required>
                    <option value="">Advisor Store Cover</option>
                    <?php
                    foreach( $locations as $location )
                    {
                    ?>
                        <option value="<?php echo $location; ?>"><?php echo $location; ?></option>');
                    <?php
                    }
                    ?>
                </select>
            </p>
        </div>
    </div>
    
    <p>
        <button type="submit" class="save-cover woocommerce-Button button" style="margin-top:20px" name="save_store_cover" value="<?php esc_attr_e( 'Add Store Cover', 'woocommerce' ); ?>"><?php esc_html_e( 'Add Store Cover', 'woocommerce' ); ?></button>
    </p>
</form>

<?php
if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
{
    ?>
    <h3 class="current-store-cover text-center spacer" style="display:none;">Current Store Cover</h3>
    
    <div class="col-md-12 cover-info"></div>
    <?php
}
else
{
    ?>
    <h3 class="current-store-cover text-center spacer">Current Store Cover</h3>
    
    <div class="col-md-12 cover-info">
        <?php
        
        $user = wp_get_current_user();
        
        $employees = array();
        
        $store = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
        
    	$store = strtolower( $store );
        
        $users = get_users();
        
        foreach ( $users as $user ) 
        {
            $employee_store = get_user_meta( $user->ID, 'store_location' , true );
                
            $employee_store = strtolower( $employee_store );
                
            if( $employee_store === $store )
            {
                $id = $user->ID;
                $user_info = get_userdata( $id );
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
        
                $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
            }
        }
        
        $user = wp_get_current_user();
        $id = $user->ID;
        $user_info = get_userdata( $id );
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
        
        $employees[ $id ] = esc_html( $first_name . ' ' . $last_name );
        
        $cover = array();
        
        foreach( $employees as $id => $employee )
        {
            $cover_store = get_user_meta( $id , 'store_cover' , true);
            
            if( $cover_store == 'yes' )
            {
                $cover[ $id ] = esc_html( $employee );
            }
        }
        
        if( ! empty( $cover ) )
        {
            echo '<table class="table">';
            echo '   <thead>';
            echo '        <tr>';
            echo '            <th>Staff Member</th>';
            echo '            <th>Store Covering</th>';
            echo '            <th></th>';
            echo '        </tr>';
            echo '    </thead>';
            echo '    <tbody>';
                
                foreach( $cover as $id => $employee )
                {
                    $cover_store = get_user_meta( $id , 'cover_store' , true);
                    
                    echo '<tr>';
                    echo '    <td>' . $employee . '</td>';
                    echo '    <td>' . $cover_store . '</td>';
                    echo '    <td><a id="' . $id . '"class="btn btn-default cancel-cover">Remove Cover</a></td>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
            echo '</table>';
        }
        else
        {
            echo '<p>No Staff currently assigned for store cover</p>';
        }
        
    echo '</div>';
}

?>

<script>
    jQuery(document).on( "click" , ".cancel-cover" , function( event ) 
    {
        var advisor = jQuery( this ).attr( 'id' );
        var name = jQuery( this ).attr( 'advisor' );
        <?php
        if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
        {
        ?>
            var option = jQuery( '.store_locations' ).find('option:selected');
                                        
            //get the value from the option
            var value = option.val();
            <?php
        }
        else
        {
            ?>
            var value = '<?php echo $store; ?>';
            <?php
        }
        ?>
        
        var data = {};
                                                    
        data['action'] = 'fc_delete_store_cover';
        data['nonce'] = fc_nonce;
        data['store'] = value;
        data['advisor'] = advisor;
                            
        jQuery.ajax({
            type: 'POST',
            dataType: 'html',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {   
                jQuery( '.cover-outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Staff Cover for ' + name + ' was deleted successfully</div></div>' );
                jQuery( '.cover-outcome' ).show();
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                
                setTimeout(function()
                { 
                    jQuery( '.cover-outcome' ).html( '' );
                }, 4000);
                
                <?php
                if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
                {
                    ?>
                    jQuery( ".store_locations" ).trigger( 'change' );
                <?php
                }
                else
                {
                    ?>
                    manager_cover()
                    <?php
                }
                ?>
            },
        });
    });
    <?php
    if( $user && in_array( 'store_manager', $user->roles ) )
    {
        ?>
        function manager_cover()
        {
            var store = '<?php echo $store; ?>';
            
            var data = {};
                                                    
            data['action'] = 'fc_senior_get_cover_staff';
            data['nonce'] = fc_nonce;
            data['store'] = store;
                            
            jQuery.ajax({
                type: 'POST',
                dataType: 'html',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    jQuery( ".advisor" ).html( data );
                                            
                    jQuery( ".advisor" ).select2(
                    {
                        width: '100%',
                    });
                },
            });
                
            data = {};
                                                        
            data['action'] = 'fc_senior_get_cover_info';
            data['nonce'] = fc_nonce;
            data['store'] = store;
                                
            jQuery.ajax({
                type: 'POST',
                dataType: 'html',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    jQuery( ".cover-info" ).html( data );
                },
            });
        }
        <?php
    }
    ?>
    
    jQuery( ".assign-store-cover" ).submit(function( event ) 
    {
        var option = jQuery( '.store_cover' ).find('option:selected');
        var store = option.val();
        
        option = jQuery( '.advisor' ).find('option:selected');
        var advisor = option.val();
        var name = option.text();
        
        var data = {};
                
        data['action'] = 'fc_save_store_cover';
        data['nonce'] = fc_nonce;
        data['store'] = store;
        data['advisor'] = advisor;
                
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: fc_ajax_url,
            data: data,
            success: function(data) 
            {	
                jQuery( '.cover-outcome' ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Staff Cover assigned for ' + name + '</div></div>' );
                jQuery( '.cover-outcome' ).show();
                
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                
                setTimeout(function()
                { 
                    jQuery( '.cover-outcome' ).html( '' );
                }, 4000);
                
                <?php
                if( $user && in_array( 'senior_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
                {
                    ?>
                    jQuery( ".store_locations" ).trigger( 'change' );
                <?php
                }
                else
                {
                    ?>
                    manager_cover()
                    <?php
                }
                ?>
            },
        });
        
        event.preventDefault();
    });
</script>

<?php

