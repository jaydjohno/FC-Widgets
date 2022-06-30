<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

$locations = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC;" ) );

foreach ( $results as $result )
{
    $locations[] = $result->location;
}

$store_targets = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_targets" ) );

foreach( $locations as $location )
{
    foreach ( $results as $result )
    {
        if( $result->store == $location && $result->month == $month && $result->year == $year )
        {
            $store_targets[ $location ] = $result;
        }
    }
}

?>

<div class="targets-outcome" style="display:none"></div>

<p>Welcome <?php echo $user->display_name; ?></p>

<p>Please enter the <?php echo $month; ?> sales targets in the form below, if you wish to update any targets, change the value and click save when done.</p>

<div class="rota-button-container pull-right" style="margin-bottom:20px;">
    <p>
        <button type="submit" id="save-targets" class="woocommerce-Button button" style="margin-top:20px" name="save_targets" value="<?php esc_attr_e( 'Save Targets', 'woocommerce' ); ?>"><?php esc_html_e( 'Save Targets', 'woocommerce' ); ?></button>
    </p>
</div>

<div class="table-container">
    <?php
    if(strtotime("now") > strtotime("1 July 2021"))
    { ?>
        <table class="table spacer">
            <thead>
                <tr>
                    <th class="col-xs-2" scope="col"></th>
                    <th class="col-xs-1" scope="col">New Handset</th>
                    <th class="col-xs-1" scope="col">New Sim</th>
                    <th class="col-xs-1" scope="col">New / Upgrade Data</th>
                    <th class="col-xs-1" scope="col">Upgrade Handset</th>
                    <th class="col-xs-1" scope="col">Upgrade Sim</th>
                    <th class="col-xs-1" scope="col">New BT</th>
                    <th class="col-xs-1" scope="col">Regrades</th>
                    <th class="col-xs-1" scope="col">Insurance</th>
                    <th class="col-xs-2" scope="col">Profit Target</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach( $locations as $location )
                    { 
                        $targets = $store_targets[ $location ];
                        
                        if( ! empty( $targets ) )
                        {
                        ?>
                            <tr class="targets">
                                <th scope="col"><?php echo $location; ?></th>
                                <td contenteditable="true"><?php echo $targets->new_handset; ?></td>
                                <td contenteditable="true"><?php echo $targets->new_sim; ?></td>
                                <td contenteditable="true"><?php echo $targets->new_data; ?></td>
                                <td contenteditable="true"><?php echo $targets->upgrade_handset; ?></td>
                                <td contenteditable="true"><?php echo $targets->upgrade_sim; ?></td>
                                <td contenteditable="true"><?php echo $targets->new_bt; ?></td>
                                <td contenteditable="true"><?php echo $targets->regrade; ?></td>
                                <td contenteditable="true"><?php echo $targets->insurance; ?></td>
                                <td contenteditable="true"><?php echo $targets->profit_target; ?></td>
                            </tr>
                        <?php
                        }
                        else
                        { ?>
                            <tr class="targets">
                                <th scope="col"><?php echo $location; ?></th>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                            </tr>
                        <?php }
                    } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <table class="table spacer">
            <thead>
                <tr>
                    <th class="col-xs-2" scope="col"></th>
                    <th class="col-xs-1" scope="col">New Handset</th>
                    <th class="col-xs-1" scope="col">New Sim</th>
                    <th class="col-xs-1" scope="col">New Data</th>
                    <th class="col-xs-1" scope="col">Upgrade Handset</th>
                    <th class="col-xs-1" scope="col">Upgrade Sim / Other</th>
                    <th class="col-xs-1" scope="col">New BT</th>
                    <th class="col-xs-1" scope="col">Insurance</th>
                    <th class="col-xs-2" scope="col">Profit Target</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach( $locations as $location )
                    { 
                        $targets = $store_targets[ $location ];
                        
                        if( ! empty( $targets ) )
                        {
                        ?>
                            <tr class="targets">
                                <th scope="col"><?php echo $location; ?></th>
                                <td contenteditable="true"><?php echo $targets->new_handset; ?></td>
                                <td contenteditable="true"><?php echo $targets->new_sim; ?></td>
                                <td contenteditable="true"><?php echo $targets->new_data; ?></td>
                                <td contenteditable="true"><?php echo $targets->upgrade_handset; ?></td>
                                <td contenteditable="true"><?php echo $targets->upgrade_sim; ?></td>
                                <td contenteditable="true"><?php echo $targets->new_bt; ?></td>
                                <td contenteditable="true"><?php echo $targets->insurance; ?></td>
                                <td contenteditable="true"><?php echo $targets->profit_target; ?></td>
                            </tr>
                        <?php
                        }
                        else
                        { ?>
                            <tr class="targets">
                                <th scope="col"><?php echo $location; ?></th>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                            </tr>
                        <?php }
                    } ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<?php
    if(strtotime("now") > strtotime("1 May 2021") && strtotime("now") < strtotime("1 July 2021"))
    { ?>
        <script>
            jQuery('#save-targets').click(function()
            {
                jQuery( ".targets-outcome" ).hide();
                jQuery( ".targets-outcome" ).text( '' );
        
                var targets = [];
                
                jQuery( '.targets' ).each(function( index, tr ) 
                {
                    var values = jQuery( 'td', tr ).map(function( index, td ) 
                    {
                        return jQuery( td ).text();
                    });
                    
                    var headings = jQuery( 'th', tr ).map(function( index, th ) 
                    {
                        return jQuery( th ).text();
                    });
                    
                    var obj = { "store": headings[0] , "new_handset": values[0] , "new_sim": values[1] , "new_data": values[2] , "upgrade_handset": values[3] ,  "upgrade_sim": values[4] ,  "new_bt": values[5] , "insurance": values[6] , "profit_target": values[7] };
                    
                    targets.push( obj );
                })
                
                var data = {};
            
                data['action'] = 'fc_save_targets';
                data['nonce'] = fc_nonce;
                data['targets'] = targets;
                
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        if( data.success == true )
                        {
                            jQuery( ".targets-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Store targets have been updated successfully.</div></div>' );
                            
                            jQuery( ".targets-outcome" ).show();
                            
                            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                        }
                        else
                        {
                            jQuery( ".targets-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="rota-error">There has been an error while updating your targets, please try again.</li></ul></div>' );
                            
                            jQuery( ".targets-outcome" ).show();
                            
                            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                        }
                    },
                });
            });
        </script>
    <?php } else { ?>
        <script>
            jQuery('#save-targets').click(function()
            {
                jQuery( ".targets-outcome" ).hide();
                jQuery( ".targets-outcome" ).text( '' );
        
                var targets = [];
                
                jQuery( '.targets' ).each(function( index, tr ) 
                {
                    var values = jQuery( 'td', tr ).map(function( index, td ) 
                    {
                        return jQuery( td ).text();
                    });
                    
                    var headings = jQuery( 'th', tr ).map(function( index, th ) 
                    {
                        return jQuery( th ).text();
                    });
                    
                    var obj = { "store": headings[0] , "new_handset": values[0] , "new_sim": values[1] , "new_data": values[2] , "upgrade_handset": values[3] ,  "upgrade_sim": values[4] ,  "new_bt": values[5] , "regrade": values[6] , "insurance": values[7] , "profit_target": values[8] };
                    
                    targets.push( obj );
                })
                
                var data = {};
            
                data['action'] = 'fc_save_targets';
                data['nonce'] = fc_nonce;
                data['targets'] = targets;
                
                jQuery.ajax({
                    type: 'POST',
                    url: fc_ajax_url,
                    data: data,
                    success: function( data ) 
                    {   
                        if( data.success == true )
                        {
                            jQuery( ".targets-outcome" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Store targets have been updated successfully.</div></div>' );
                            
                            jQuery( ".targets-outcome" ).show();
                            
                            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                        }
                        else
                        {
                            jQuery( ".targets-outcome" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="rota-error">There has been an error while updating your targets, please try again.</li></ul></div>' );
                            
                            jQuery( ".targets-outcome" ).show();
                            
                            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                        }
                    },
                });
            });
        </script>
    <?php } ?>
    
