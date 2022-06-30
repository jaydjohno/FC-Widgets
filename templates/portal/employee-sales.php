<?php

global $wpdb;

$user = wp_get_current_user();

//get our advisor first name and last name
$id = $user->ID;
$user_info = get_userdata( $id );
$first_name = $user_info->first_name;
$last_name = $user_info->last_name;

//make our fullname
$fullname = $first_name . ' ' . $last_name;

//get our sales info

$employee_sales = array();
        
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE DATE( `sale_date` ) = CURDATE()" ) );

foreach ( $results as $result )
{
    if( $result->advisor == $fullname )
    {
        $employee_sales[] = $result;
    }
}

$time = new DateTime('now');
$today = $time->format('Y-m-d');

?>

<h3 class="spacer text-center">Daily Sales</h3>

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
            var data = {};

            data['action'] = 'fc_get_employee_daily_sales';
            data['nonce'] = fc_nonce;
            data[ 'date' ] = date;

            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    jQuery( '.employee-sales' ).html( data );
                },
            });
        }
    });
    
    //for our accordion
    function toggleIcon(e) 
    {
         jQuery(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
    
    jQuery('.panel-group').on('hidden.bs.collapse', toggleIcon);
    jQuery('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>

<div class="row employee-sales cpacer-top">
    <?php 
    if ( ! empty( $employee_sales ) )
    {
        $i = 1;
        
        foreach($employee_sales as $sale)
        {
            ?>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:15px;">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#sale<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                
                                <?php 
                                if( $sale->product_type == 'homebroadband' )
                                {
                                    ?>
                                    <i class="fas fa-wifi sale-icon"></i> Home Broadband - <?php echo $sale->tariff;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'simonly' )
                                {
                                    ?>
                                    <i class="fas fa-sim-card sale-icon"></i> Sim Only - <?php echo $sale->tariff;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'handset' )
                                {
                                    ?>
                                    <i class="fas fa-mobile sale-icon"></i> Handset - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'tablet' )
                                {
                                    ?>
                                    <i class="fas fa-tablet-alt sale-icon"></i> Tablet - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'connected' )
                                {
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-watch sale-icon" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4 14.333v-1.86A5.985 5.985 0 0 1 2 8c0-1.777.772-3.374 2-4.472V1.667C4 .747 4.746 0 5.667 0h4.666C11.253 0 12 .746 12 1.667v1.86A5.985 5.985 0 0 1 14 8a5.985 5.985 0 0 1-2 4.472v1.861c0 .92-.746 1.667-1.667 1.667H5.667C4.747 16 4 15.254 4 14.333zM13 8A5 5 0 1 0 3 8a5 5 0 0 0 10 0z"/>
                                        <path d="M13.918 8.993A.502.502 0 0 0 14.5 8.5v-1a.5.5 0 0 0-.582-.493 6.044 6.044 0 0 1 0 1.986z"/>
                                        <path fill-rule="evenodd" d="M8 4.5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5H6a.5.5 0 0 1 0-1h1.5V5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    Connected - <?php echo $sale->device;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'accessory' )
                                {
                                    ?>
                                    <i class="fas fa-headphones-alt sale-icon"></i> Accessory - <?php echo $sale->accessory;
                                }
                                ?>
                                
                                <?php 
                                if( $sale->product_type == 'insurance' )
                                {
                                    ?>
                                   <i class="fas fa-file-alt sale-icon"></i> Insurance - <?php echo $sale->insurance_choice;
                                }
                                ?>
                            </a>
                        </h4>
                    </div>
                    <div id="sale<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                        <div class="panel-body">
                            <?php if( $sale->approve_sale == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-12 spacer">
                                        <p><strong class="color:red;">This sale has been approved</strong></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Sale ID</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo $sale->id; ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Store</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->store); ?></p>
                                </div>
                            </div>
                              
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Sale Type</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->type); ?></p>
                                </div>
                            </div>
                            
                            <div class="row sale-row">
                                <div class="col-xs-6">
                                    <p><strong>Product Sold</strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p><?php echo ucfirst($sale->product_type); ?></p>
                                </div>
                            </div>
                            
                            <?php if( $sale->device !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Device</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->device); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Device Discount Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->device_discount_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'rm' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Regional Manager Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'franchise' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Franchise Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->device_discount_type !== '' && $sale->device_discount_type == 'both' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Regional Manager Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount; ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Franchise Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->device_discount_2; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->broadband_tv !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Broadband TV</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->broadband_tv); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_discount_type !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Discount Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->tariff_discount_type); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->tariff_discount !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Tariff Discount</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->tariff_discount; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->accessory_needed !== 'no' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->accessory); ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory Cost</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'.$sale->accessory_cost; ?></p>
                                    </div>
                                </div>
                                <?php
                                
                                if( $sale->accessory_discount !== 'no' )
                                {
                                    ?>
                                    <div class="row sale-row">
                                        <div class="col-xs-6">
                                            <p><strong>Accessory Discount</strong></p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p><?php echo '£' . $sale->accessory_discount_value; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            
                            <?php if( $sale->insurance !== 'no' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance Type</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->insurance_type); ?></p>
                                    </div>
                                </div>
                                
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->insurance_choice); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->hrc == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>HRC Sale</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->hrc); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->pobo == 'yes' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>POBO Sale</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo ucfirst($sale->pobo); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->profit_loss !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Profit / Loss</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£'. $sale->profit_loss; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->total_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Total Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£' . $sale->total_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->accessory_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Accessory Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo '£' . $sale->accessory_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <?php if( $sale->insurance_profit !== '' )
                            {
                                ?>
                                <div class="row sale-row">
                                    <div class="col-xs-6">
                                        <p><strong>Insurance Profit</strong></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo $sale->insurance_profit; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
    }
    else
    {
        ?>
        <p>No sales for this date, this could be for the following reasons:</p><br/>
        <p>1. You were not working on this day</p>
        <p>2. There has been an error while uploading your sales</p>
        <p>3. You have not uploaded your sales</p><br/>
        <p>If point 2 or 3 is the issue then contact your manager who will be able to upload your sales.</p>
        <?php
    }
    ?>
</div>
