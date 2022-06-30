<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

$days = cal_days_in_month(CAL_GREGORIAN, date('m'), $year);

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
else {
    $manager_location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
}

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_banking LIMIT 1" ) );

foreach ( $results as $result )
{
    $date = $result->day . ' ' . $result->month . ' ' . $result->year;
}

$start = new DateTime( $date );
$start->modify( 'first day of this month' );

//get our current date and the first date of this month
$end = new DateTime( 'now' );
$end->modify( 'last day of this month' );

//now set our parameters
$interval = DateInterval::createFromDateString( '1 month' );
$period   = new DatePeriod( $start , $interval , $end );

$store_banking = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_banking" ) );

if( $user && in_array( 'store_manager', $user->roles ) )
{
    foreach ( $results as $result )
    {
        if( $result->store == $manager_location && $result->month == $month && $result->year == $year )
        {
            $store_banking[ $result->day ] = $result;
        }
    }
}

if(strtotime("now") < strtotime("1 July 2021"))
{
    echo '<p>This page will be available from the 1st July 2021</p>';
}
else {
?>
    <div class="banking-errors" style="display:none"></div>
    
    <p>Welcome <?php echo $user->display_name; ?></p>
    
    <p>On this page you can see your current months banking figures, and also amend any of your banking figures if needed</p>
    
    <?php if( $user && in_array( 'multi_manager', $user->roles ) )
    { ?>
    <br>
    <label for="stores">Choose your store</label> <br>

    <select name="store" class="stores">
        <option value ="">Choose Store</option>
        <?php
        foreach($multi_locations as $location) {
            echo '<option vlaue ="' . $location . '">' . $location . '</option>';
        }
        ?>
    </select>
    
    <p class="store-errors"></p>
    
    <script>
        jQuery('.stores').on('change', function() {
            var store = this.value;
            var date = jQuery('.info_dates').val();
            
            if(store !== '') {
                
                if(date == '') {
                    jQuery('.date-error').text('Please choose your date').css("color", "red");
                }
                else
                {
                    jQuery('.date-error').text('');
                    
                    var data = {};
                
                    data['action'] = 'fc_get_banking_info';
                    data['nonce'] = fc_nonce;
                    data['store'] = store;
                    data['date'] = date;
    
                    jQuery.ajax({
                        type: 'POST',
                        url: fc_ajax_url,
                        data: data,
                        success: function( data ) 
                        {   
                            jQuery( ".banking-info" ).html( data );
                            jQuery( ".rota-button-container" ).show();
                            jQuery('#info_date').show();
                        },
                    });
                }
            }
            else {
                jQuery('#info_date').hide();
                jQuery('.info_dates').val('');
            }
        });
    </script>
    
    <p class="form-row wps-drop spacer" id="info_date" data-priority="" style="display:none; margin-top:20px;"><label for="info_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="info_dates" class="info_dates" autocomplete="off" required>
                <option value="">Select Date to View Other Months Reports</option>
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
    
    <p class="date-error"></p>
    
    <div class="rota-button-container pull-right" style="margin-bottom:20px; display:none;">
        <p>
            <button type="submit" id="save-banking" class="woocommerce-Button button" style="margin-top:20px" name="save_banking" value="<?php esc_attr_e( 'Save Banking', 'woocommerce' ); ?>"><?php esc_html_e( 'Save Banking', 'woocommerce' ); ?></button>
        </p>
    </div>
    
    <div class="banking-info">
        
    </div>
    
    <?php } else { ?>
        <p class="form-row wps-drop spacer" id="info_date" data-priority="" ><label for="info_date" class="">Choose Month &nbsp;<span class="required">*</span></label>
            <span class="woocommerce-input-wrapper">
                <select name="info_dates" class="info_dates" autocomplete="off" required>
                    <option value="">Select Date to View Other Months Banking</option>
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
        
        <p class="date-error"></p>
    
        <div class="rota-button-container pull-right" style="margin-bottom:20px;">
            <p>
                <button type="submit" id="save-banking" class="woocommerce-Button button" style="margin-top:20px" name="save_banking" value="<?php esc_attr_e( 'Save Banking', 'woocommerce' ); ?>"><?php esc_html_e( 'Save Banking', 'woocommerce' ); ?></button>
            </p>
        </div>
        
        <div class="banking-info">
            <h2 class="text-center"><?php echo $manager_location; ?> Banking</h2>
        
            <p>Do not enter your figures with a £ sign as the form only works with numbers, if the total is £5.99 enter 5.99.</p>
            
            <table class="table spacer banking-table" store="<?php echo $manager_location; ?>">
                <thead>
                    <tr>
                        <th class="col-xs-3" scope="col">Date</th>
                        <th class="col-xs-3" scope="col">Till 1</th>
                        <th class="col-xs-3" scope="col">Till 2</th>
                        <th class="col-xs-3" scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for( $i = 1; $i <= $days; $i++ )
                        { 
                            $num = str_pad($i,2,"0",STR_PAD_LEFT);
                            $date = $num . ' ' . $month . ' ' . $year;
                            
                            if( ! empty( $store_banking[ $num ] ) )
                            { 
                                $bankFigure = $store_banking[ $num ];
                            ?>
                                <tr class="banking">
                                    <th scope="col"><?php echo $date; ?></th>
                                    <td contenteditable="true" onkeyup="totalMoney(this)"><?php echo $bankFigure->till_1; ?></td>
                                    <td contenteditable="true" onkeyup="totalMoney(this)"><?php echo $bankFigure->till_2; ?></td>
                                    <td><?php echo $bankFigure->total; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr class="banking">
                                    <th scope="col"><?php echo $date; ?></th>
                                    <td contenteditable="true" onkeyup="totalMoney(this)"></td>
                                    <td contenteditable="true" onkeyup="totalMoney(this)"></td>
                                    <td></td>
                                    
                                </tr>
                            <?php }
                        } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
    
    <script>
        jQuery( document ).ready(function() 
        {
            jQuery(".info_dates").select2(
    		{
                width: '100%',
            });
            
            jQuery(".stores").select2(
    		{
                width: '100%',
            });
            
            jQuery('.stores').val('').trigger('change');
            
            jQuery( '.info_dates' ).val( '<?php echo $end->format("F Y"); ?>' ); 
            jQuery( '#info_date' ).find( '.select2-selection__rendered' ).attr( 'title' , '<?php echo $end->format("F Y"); ?>' );
            jQuery( '#info_date' ).find( '.select2-selection__rendered' ).text( '<?php echo $end->format("F Y"); ?>' );
        });
        
        function totalMoney(ctrl)
        {
            var parent = jQuery( ctrl ).parent();
            
            var num = ctrl.innerHTML;
            
            jQuery( parent ).each(function( index, tr ) 
            {
                var values = jQuery( 'td', tr ).map(function( index, td ) 
                {
                    return jQuery( td ).text();
                });

                //get all our values
                var value1 = values[0];
                var value2 = values[1];

                if( value1 == '' )
                {
                    value1 = 0;
                }

                if( value2 == '' )
                {
                    value2 = 0;
                }

                //parse our values
                value1 = parseInt( value1, 10 );
                value2 = parseInt( value2, 10 );

                //now add them
                var total = parseInt( value1 + value2 );

                jQuery( parent ).children().last().text( total );
            });
        }
        
        jQuery( '.info_dates' ).change(function() 
        {
            var date = jQuery( this ).val();
            
            if( date !== '' )
            {
                var store = jQuery('.banking-table').attr('store');
                
                jQuery('.date-error').text('');
                
                <?php if( $user && in_array( 'multi_manager', $user->roles ) )
                { ?>
                
                if(store == '') 
                {
                    jQuery('.store-errors').text('Please choose store before continuing').css("color", "red");
                }
                <?php } ?>

                var data = {};
            
                data['action'] = 'fc_get_banking_info';
                data['nonce'] = fc_nonce;
                data['store'] = store;
                data['date'] = date;

                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        jQuery( ".banking-info" ).html( data );
                        jQuery( ".rota-button-container" ).show();
                        jQuery('#info_date').show();
                    },
                });
            }
        });
        
        jQuery('#save-banking').click(function()
        {
            jQuery( ".banking-errors" ).hide();
            jQuery( ".banking-errors" ).text( '' );
    
            var banking = [];
            
            jQuery( '.banking' ).each(function( index, tr ) 
            {
                var values = jQuery( 'td', tr ).map(function( index, td ) 
                {
                    return jQuery( td ).text();
                });
                
                var headings = jQuery( 'th', tr ).map(function( index, th ) 
                {
                    return jQuery( th ).text();
                });
                
                var obj = { "date": headings[0] , "till_1": values[0] , "till_2": values[1] , "total": values[2] };
                
                banking.push( obj );
            })
            
            var store = jQuery('.banking-table').attr('store');
            var date = jQuery('.info_dates').val();
            
            var data = {};
        
            data['action'] = 'fc_save_banking';
            data['nonce'] = fc_nonce;
            data['store'] = store;
            data['banking'] = banking;
            data['date'] = date;
            
            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    if( data.success == true )
                    {
                        jQuery( ".banking-errors" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Banking information has been updated successfully.</div></div>' );
                        
                        jQuery( ".banking-errors" ).show();
                        
                        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                    else
                    {
                        jQuery( ".banking-errors" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="rota-error">There has been an error while updating your banking information, please try again.</li></ul></div>' );
                        
                        jQuery( ".banking-errors" ).show();
                        
                        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                },
            });
        });
    </script>
<?php }
