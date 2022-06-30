<?php
global $wpdb;

$employees = fc_get_users();

//we need our devices for our filters
$payg = array();
$handsets = array();
$tablets = array();
$connected = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_devices" ) );

foreach ( $results as $result )
{
    if( $result->type == 'Handsets' )
    {
        $handsets[ $result->device ] = $result->device;
    }
    elseif( $result->type == 'PayG Handsets' )
    {
        $payg[ $result->device ] = $result->device;
    }
    elseif( $result->type == 'Tablets' )
    {
        $tablets[ $result->device ] = $result->device;
    }
    elseif( $result->type == 'connected' )
    {
        $connected[ $result->device ] = $result->device;
    }
}

$devices = array_merge($handsets,$payg,$tablets,$connected);

//get our tariff info

//we need the standard upgrade and new tariffs
$standardtariff = array();

//we need the business upgrade and new tariffs
$businesstariff = array();

//we need our HSM tariffs
$hsmtariff = array();

//we need our TLO tariffs
$tlotariff = array();

//get our sim only triffs
$simOnly = array();

//get our connected tariffs
$connected = array();

//get our tablet tariffs
$tablet = array();

//get our broadband tariffs
$broadband = array();

//get our insurance tariffs
$insurance = array();

//get our tariffs info
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_tariffs" ) );

foreach ( $results as $result )
{
    if ( $result->type == 'Standard' )
    {
        $standardtariff[ $result->tariff ] = $result->tariff;
    }
    if ( $result->type == 'Business' )
    {
        $businesstariff[ $result->tariff ] = $result->tariff;
    }
    if ( $result->type == 'HSM' )
    {
        $hsmtariff[ $result->tariff ] = $result->tariff;
    }
    if ( $result->type == 'TLO' )
    {
        $tlotariff[ $result->tariff ] = $result->tariff;
    }
    if ( $result->type == 'SIMO' )
    {
        $simOnly[ $result->tariff ] = $result->tariff;
    }
    if ( $result->type == 'Connected' )
    {
        if ( strpos( $result->tariff , 'Tablet' ) !== false) 
        {
            $tablet[ $result->tariff ] = $result->tariff;
        }
        else
        {
            $connected[ $result->tariff ] = $result->tariff;
        }
    }
    if ( $result->type == 'Tablet' )
    {
        $tablet[ $result->tariff ] = $result->tariff;
    }
    if ( $result->type == 'Home Broadband' )
    {
        $broadband[ $result->tariff ] = $result->tariff;
    }
    if ( $result->type == 'Insurance' )
    {
        $insurance[ $result->tariff ] = $result->tariff;
    }
}

$tariffs = array_merge($broadband,$tablet,$connected,$simOnly,$tlotariff,$hsmtariff,$businesstariff,$standardtariff);
$accessories = array();

//get our accessories list
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_accessories" ) );

foreach ( $results as $result )
{
    $accessories[ $result->accessory ] = $result->accessory;
}

$locations = array();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

foreach ( $results as $result )
{
    $locations[] = $result->location;
}

?>

<div class="search-errors" style="display:none"></div>
    
<p>Welcome <?php echo $user->display_name; ?></p>
    
<p>On this page you can generate sales reports, use the report filters to generate your report</p>
    
<br>

<form class="search-sales"> 
    <div class="row">
        <div class="col-md-7 center-block" style="float:none;">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#report-filters">Choose Report Filters</a>
                        </h4>
                    </div>
                    <div id="report-filters" class="panel-collapse collapse">
                        <div class="filter-container store-locations-container">
                            <p>Choose Store</p>
                            <select name="store_locations" class="store_locations" autocomplete="off">
                                <option value="">Choose Store</option>
                                <?php
                            
                                foreach( $locations as $slocation )
                                {
                                ?>
                                    <option value="<?php echo $slocation; ?>"><?php echo $slocation; ?></option>');
                                <?php
                                }
                            
                                ?>
                            </select>
                        </div>
                        
                        <div class="filter-container sales-date">
                            <label for="sale_date" style="font-weight: normal;"><?php esc_html_e( 'Pick Date Range', 'woocommerce' ); ?></label>
                            <input type="text" id="datepicker" val=""/>
                        </div>
                        
                        <div class="filter-container advisor-container">
                            <p>Choose Advisor</p>
                            <div class="input-group">
                                <select name="advisor" class="advisor" autocomplete="off">
                                    <option value="">Choose Advisor</option>
                                    <?php
                                
                                    foreach( $employees as $id => $employee )
                                    {
                                    ?>
                                        <option value="<?php echo $employee; ?>"><?php echo $employee; ?></option>');
                                    <?php
                                    }
                                
                                    ?>
                                </select>
                            </div>
                        </div>
        
                        <div class="filter-container sale-type-container">
                            <p>Choose Sale Type</p>
                            <div class="input-group">
                                 <label class="radio-inline"><input type="radio" name="sale-type" value="new">New</label>
                                <label class="radio-inline"><input type="radio" name="sale-type" value="upgrade">Upgrade</label> 
                            </div>
                        </div>
                        
                        <div class="filter-container product-type-container">
                            <p>Choose Product Type</p>
                            <div class="input-group">
                                <label class="radio-inline"><input type="radio" name="product-type" value="homebroadband">Home Broadband</label>
                                <label class="radio-inline"><input type="radio" name="product-type" value="simonly">Sim Only</label>
                                <label class="radio-inline"><input type="radio" name="product-type" value="handset">Handset</label> 
                                <label class="radio-inline"><input type="radio" name="product-type" value="tablet">Tablet</label>
                                <label class="radio-inline"><input type="radio" name="product-type" value="connected">Connected</label>
                                <label class="radio-inline"><input type="radio" name="product-type" value="accessory">Accessory</label>
                                <label class="radio-inline"><input type="radio" name="product-type" value="insurance">Insurance</label> 
                            </div>
                        </div>
                        
                        <div class="filter-container device-container">
                            <p>Choose a Device</p>
                            <div class="input-group">
                                <select name="device" class="device">
                                    <option value="">Choose a Device</option>
                                    
                                    <?php
                                
                                    foreach( $devices as $device )
                                    {
                                    ?>
                                        <option value="<?php echo $device; ?>"><?php echo $device; ?></option>');
                                    <?php
                                    }
                                
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container device-discount-container">
                            <p>Device Discount</p>
                            <div class="input-group">
                                <select name="device-discount" class="device-discount">
                                    <option value="">Device Discount</option>
                                    <option value="regional">Regional Manager</option>
                                    <option value="franchise">Franchise</option>
                                    <option value="both">Regional Manager and franchise</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container tariff-type-container">
                            <p>Tariff type</p>
                            <div class="input-group">
                                <select name="tariff-type" class="tariff-type">
                                    <option value="">Tariff Type</option>
                                    <option value="standard">Standard</option>
                                    <option value="business">Business</option>
                                    <option value="hsm">High Street Match</option>
                                    <option value="tlo">Time Limited Offers</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container tariff-group-container">
                            <p>Tariff type</p>
                            <div class="input-group">
                                <select name="tariff-group" class="tariff-group">
                                    <option value="">Tariff Group</option>
                                    <option value="smart">Smart Tariffs</option>
                                    <option value="essential">Essential Tariffs</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container tariff-container">
                            <p>Tariff</p>
                            <div class="input-group">
                                <select name="tariff" class="tariff">
                                    <option value="">Choose Tariff</option>
                                    
                                    <?php
                                
                                    foreach( $tariffs as $tariff)
                                    {
                                    ?>
                                        <option value="<?php echo $tariff; ?>"><?php echo $tariff; ?></option>');
                                    <?php
                                    }
                                
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container tariff-discount-container">
                            <p>Tariff Discount</p>
                            <div class="input-group">
                                <select name="tariff-discount" class="tariff-discount">
                                    <option value="">Tariff Discount</option>
                                    <option value="friends">Friends and Family</option>
                                    <option value="pre2post">Pre 2 Post</option>
                                    <option value="addline">Add Line / BOB</option>
                                    <option value="perk">Perk</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container accessory-container">
                            <p>Accessory</p>
                            <div class="input-group">
                                <select name="accessory" class="accessory">
                                    <option value="">Choose Accessory</option>
                                    <?php
                                    foreach( $accessories as $accessory )
                                    {
                                        ?>
                                        <option value="<?php echo $accessory; ?>"><?php echo $accessory; ?></option>`);
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container insurance-type-container">
                            <p>Insurance Type</p>
                            <div class="input-group">
                                <select name="insurance-type" class="insurance-type">
                                    <option value="">Insurance Type</option>
                                    <option value="damage">Damage</option>
                                    <option value="full">Full</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container insurance-container">
                            <p>Insurance</p>
                            <div class="input-group">
                                <select name="insurance" class="insurance">
                                    <option value="">Choose Insurance</option>
                                    
                                    <?php
                                    foreach( $insurance as $i )
                                    {
                                        ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>`);
                                        <?php
                                    }
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-container sales-parameters-container">
                            <p>Sales Parameters</p>
                            <div class="input-group">
                                <label class="radio-inline">
                                    <input type="checkbox" class="hrc" value="hrc">HRC Sale
                                </label>
                                <label class="radio-inline">
                                    <input type="checkbox" class="pobo" value="pobo">POBO Sale
                                </label>
                            </div>
                        </div>
                        
                        <div class="filter-container submit-button">
                            <button class="btn btn-primary reset-filters" type="button">
                                Reset Filters
                            </button>
                            <button class="btn btn-primary submit-search" type="submit">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</form>

<div class="found-sales"></div>

<script>
    function hide_fields() {
        jQuery('.device-container').hide();
        jQuery('.device-discount-container').hide();
        jQuery('.tariff-type-container').hide();
        jQuery('.tariff-container').hide();
        jQuery('.tariff-discount-container').hide();
        jQuery('.accessory-container').hide();
        jQuery('.insurance-type-container').hide();
        jQuery('.insurance-container').hide();
        jQuery('.sales-parameters-container').hide();
    }
    
    function enable_Select2() {
        jQuery(".store_locations").select2(
        {
            width: '100%',
        });
        
        jQuery(".advisor").select2(
        {
            width: '100%',
        });
        
        jQuery(".sale_months").select2(
        {
            width: '100%',
        });
        
        jQuery(".device").select2(
        {
            width: '100%',
        });
        
        jQuery(".device-discount").select2(
        {
            width: '100%',
        });
        
        jQuery(".tariff-type").select2(
        {
            width: '100%',
        });
        
        jQuery(".tariff-group").select2(
        {
            width: '100%',
        });
        
        jQuery(".tariff").select2(
        {
            width: '100%',
        });
        
        jQuery(".tariff-discount").select2(
        {
            width: '100%',
        });
        
        jQuery(".accessory").select2(
        {
            width: '100%',
        });
        
        jQuery(".insurance-type").select2(
        {
            width: '100%',
        });
        
        jQuery(".insurance").select2(
        {
            width: '100%',
        });
    }
        
    jQuery(document).ready(function() 
    {
        //reset our form
        jQuery('.search-sales').trigger("reset");
        
        jQuery( '#datepicker' ).val('');
        
        //run our functions
        //hide_fields();
        enable_Select2();
        
        jQuery('input[type=radio][name=sale-type]').on('change', function() 
        {
            var saletype = jQuery(this).val();
            var producttype = jQuery("input[name='product-type']:checked").val();

            if(saletype !== undefined && producttype !== undefined ) {
                //show_fields();
            }
        });
        
        jQuery('input[type=radio][name=product-type]').on('change', function() 
        {
            var saletype = jQuery("input[name='sale-type']:checked").val();
            var producttype = jQuery(this).val();

            if(saletype !== undefined && producttype !== undefined ) {
                //show_fields();
            }
        });
        
        jQuery('.tariff-type').on('change', function() 
        {
            //show_fields();
        });
        
        function show_fields() {
            var saletype = jQuery("input[name='sale-type']:checked").val();
            var producttype = jQuery("input[name='product-type']:checked").val();
            var tarifftype = jQuery("input[name='tariff-type']:checked").val();
            
            if ( tarifftype == '' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
            }
            
            if ( producttype == '' )
            {
                jQuery('.device')
                    .empty()
                    .append('<option selected="selected" value="">Choose a Device</option>');
            }
            
            if( tarifftype == 'standard' || tarifftype =='business' )
            {
                jQuery( '.tariff-discount-container' ).show();
            }
            else
            {
                jQuery( '.tariff-discount-container' ).hide();
            }
            
            if(producttype == 'handset' || producttype == 'tablet' || producttype == 'connected') 
            {
                jQuery( '.device-container' ).show();
                jQuery( '.device-discount-container' ).show();
                
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
            } else
            {
                jQuery( '.device-container' ).hide();
                jQuery( '.device-discount-container' ).hide();
            }
            
            if(producttype == 'insurance' || producttype == 'accessory') 
            {
                jQuery( '.tariff-container' ).hide();
                jQuery( '.tariff-discount-container' ).hide();
                jQuery( '.tariff-type-container' ).hide();
            } else
            {
                jQuery( '.tariff-container' ).show();
                jQuery( '.tariff-discount-container' ).show();
            }
            
            if(producttype == 'insurance') 
            {
                jQuery( '.accessory-container' ).hide();
            } else
            {
                jQuery( '.accessory-container' ).show();
            }
            
            if(producttype == 'connected')
            {
                jQuery( '.device' )
                    .empty()
                    .append('<option selected="selected" value="">Choose a Device</option>');
                <?php
                foreach( $connected as $device => $price )
                {
                    ?>
                    jQuery( '.device' )
                        .append('<option value="<?php echo $count; ?>"><?php echo $device; ?></option>');
                    <?php
                    $count++;
                }
                ?>
            }
            
            if(producttype == 'tablet')
            {
                jQuery( '.device' )
                    .empty()
                    .append('<option selected="selected" value="">Choose a Device</option>');
                <?php
                foreach( $tablets as $device => $price )
                {
                    ?>
                    jQuery( '.device' )
                        .append('<option value="<?php echo $count; ?>"><?php echo $device; ?></option>');
                    <?php
                    $count++;
                }
                ?>
            }
            
            if(producttype == 'handset')
            {
                jQuery( '.device' )
                    .empty()
                    .append('<option selected="selected" value="">Choose a Device</option>');
                <?php
                foreach( $handsets as $device => $price )
                {
                    ?>
                    jQuery( '.device' )
                        .append('<option value="<?php echo $count; ?>"><?php echo $device; ?></option>');
                    <?php
                    $count++;
                }
                ?>
                
                jQuery('.tariff-type-container').show();
                
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff Type to See Tariffs</option>');
            } else {
                jQuery('.tariff-type-container').hide();
            }
            
            if(producttype == 'insurance' || producttype == 'tablet' || producttype == 'handset' )
            {
                jQuery('.insurance-type-container').show();
                jQuery('.insurance-container').show();
            } else
            {
                jQuery('.insurance-type-container').hide();
                jQuery('.insurance-container').hide();
            }
            
            jQuery('.sales-parameters-container').show();
            
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
            }
            
            if ( tarifftype == 'standard' && saletype == 'new'  )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
                $count=1;
                
                foreach( $standardtariff_new as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                    <?php
                    $count++;
                }
    
                ?>
            }
            
            if ( tarifftype == 'standard' && saletype == 'upgrade'  )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
                
                <?php
                $count=1;
                
                foreach( $standardtariff_upgrade as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                    <?php
                    $count++;
                }
    
                ?>
            }
            if ( tarifftype == 'business' && saletype == 'new' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
                $count=1;
                
                foreach( $businesstariff_new as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                    <?php
                    $count++;
                }
    
                ?>
            }
            if ( tarifftype == 'business' && saletype == 'upgrade' )
            {
                jQuery('.tariff')
                .empty()
                .append('<option selected="selected" value="">Choose Tariff</option>');
    
                <?php
                $count=1;
                
                foreach( $businesstariff_upgrade as $tariff => $price )
                {
                    ?>
                    jQuery( '.tariff' )
                        .append('<option value="<?php echo $count; ?>"><?php echo $tariff; ?></option>');
                    <?php
                    $count++;
                }
    
                ?>
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
            }
        }
    });
    
    jQuery(".reset-filters").on("click", function(event)
    {
        jQuery(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('').trigger('change');
        jQuery(':checkbox, :radio').prop('checked', false).trigger('change');
        jQuery('.search-sales').trigger("reset");
    });
    
    jQuery(".submit-search").on("click", function(event)
    {
        var store = jQuery('.store_locations').val();
        var advisor = jQuery('.advisor').val();
        var saleType = jQuery('input[name="sale-type"]:checked').val();
        var productType = jQuery('input[name="product-type"]:checked').val();
        var option = jQuery('.device').find('option:selected');
        var device = option.text();
        var deviceDiscount = jQuery('.device-discount').val();
        var tariffType = jQuery('.tariff-type').val();
        var tariffgroup = jQuery('.tariff-group').val();
        var option = jQuery('.tariff').find('option:selected');
        var tariff = option.text();
        var tariffDiscount = jQuery('.tariff-discount').val();
        var option = jQuery('.accessory').find('option:selected');
        var accessory = option.text();
        var insuranceType = jQuery('.insurance-type').val();
        var option = jQuery('.insurance').find('option:selected');
        var insurance = option.text();
        
        if(jQuery('.hrc').prop('checked'))
        {
            var hrc = jQuery('.hrc').val();
        } else {
            var hrc = '';
        }
        
        if(jQuery('.pobo').prop('checked')) 
        {
            var pobo = jQuery('.pobo').val();
        } else {
            var pobo = '';
        }
        
        var data = {};
                                            
        data['action'] = 'fc_generate_sales_report';
        data['nonce'] = fc_nonce;
        data['store'] = store;
        data['advisor'] = advisor;
        data['saleType'] = saleType;
        data['productType'] = productType;
        data['device'] = device;
        data['deviceDiscount'] = deviceDiscount;
        data['tariffType'] = tariffType;
        data['tariffgroup'] = tariffgroup;
        data['tariff'] = tariff;
        data['tariffDiscount'] = tariffDiscount;
        data['accessory'] = accessory;
        data['insuranceType'] = insuranceType;
        data['insurance'] = insurance;
        data['hrc'] = hrc;
        data['pobo'] = pobo;
        
        if(typeof startdate !== 'undefined'){
            data['start'] = startdate;
        }
        
        if(typeof enddate !== 'undefined'){
            data['end'] = enddate;
        }
                
        jQuery.ajax({
            type: 'POST',
            url: fc_ajax_url,
            data: data,
            success: function( data ) 
            {   
                jQuery(".panel-collapse").collapse("hide");
                jQuery('.found-sales').html(data);
            },
        });
        event.preventDefault();
    }); 
</script>