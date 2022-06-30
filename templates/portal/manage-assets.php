<?php

global $wpdb;

//get all our assets information
$devices = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_devices" ) );

$tariffs = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_tariffs" ) );

$accessories = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_accessories" ) );

?>

<div id="upload-status"></div>

<div class="col-md-6">
    <h3>Manage Assets</h3>
    
    <p class="form-row validate-required spacer" data-priority="">
        <label for="image" class="">Upload Devices List CSV File</label>
        <div class="col-md-12 spacer-bottom" id="device-csv">
            <span class="woocommerce-input-wrapper">
                <label class="btn-bs-file btn btn-md csv-button">
                    Browse
                    <input type="file" name="device_csv_file" id="device_csv_file"  class="input-button" multiple="false" accept=".csv" /> 
                </label>
                <label class="custom-file-label">No CSV File Uploaded</label>
            </span>
        </div>
    </p>
    
    <p id="device-csv-status" class="csv-message spacer" style="display:none"></p>
    
    <p class="form-row validate-required spacer" data-priority="">
        <label for="image" class="">Upload Tariffs CSV File</label>
        <div class="col-md-12 spacer-bottom" id="tariffs-csv">
            <span class="woocommerce-input-wrapper">
                <label class="btn-bs-file btn btn-md csv-button">
                    Browse
                    <input type="file" name="tariffs_csv_file" id="tariffs_csv_file"  class="input-button" multiple="false" accept=".csv" /> 
                </label>
                <label class="custom-file-label">No CSV File Uploaded</label>
            </span>
        </div>
    </p>
    
    <p id="tariffs-csv-status" class="csv-message spacer" style="display:none"></p>
    
    <p class="form-row validate-required spacer" data-priority="">
        <label for="image" class="">Upload Accessories CSV File</label>
        <div class="col-md-12 spacer-bottom" id="accessories-csv">
            <span class="woocommerce-input-wrapper">
                <label class="btn-bs-file btn btn-md csv-button">
                    Browse
                    <input type="file" name="accessories_csv_file" id="accessories_csv_file"  class="input-button" multiple="false" accept=".csv" /> 
                </label>
                <label class="custom-file-label">No CSV File Uploaded</label>
            </span>
        </div>
    </p>
    
    <p id="accessories-csv-status" class="csv-message spacer" style="display:none"></p>
    
    <p class="form-row validate-required spacer" data-priority="">
        <label for="image" class="">Upload Profit Targets CSV File</label>
        <div class="col-md-12 spacer-bottom" id="profit-targets-csv">
            <span class="woocommerce-input-wrapper">
                <label class="btn-bs-file btn btn-md csv-button">
                    Browse
                    <input type="file" name="profit_targets_csv_file" id="profit_targets_csv_file"  class="input-button" multiple="false" accept=".csv" /> 
                </label>
                <label class="custom-file-label">No CSV File Uploaded</label>
            </span>
        </div>
    </p>
    
    <p id="profit-csv-status" class="csv-message spacer" style="display:none"></p>
    
    <p class="form-row validate-required spacer" data-priority="">
        <label for="image" class="">Upload Discount Pots CSV File</label>
        <div class="col-md-12 spacer-bottom" id="discount-pots-csv">
            <span class="woocommerce-input-wrapper">
                <label class="btn-bs-file btn btn-md csv-button">
                    Browse
                    <input type="file" name="discount_pots_csv_file" id="discount_pots_csv_file"  class="input-button" multiple="false" accept=".csv" /> 
                </label>
                <label class="custom-file-label">No CSV File Uploaded</label>
            </span>
        </div>
    </p>
    
    <p id="discount-csv-status" class="csv-message spacer" style="display:none"></p>
    
    <p class="form-row validate-required spacer" data-priority="">
        <label for="image" class="">Upload Commission Percentages CSV File</label>
        <div class="col-md-12 spacer-bottom" id="staff-commission-csv">
            <span class="woocommerce-input-wrapper">
                <label class="btn-bs-file btn btn-md csv-button">
                    Browse
                    <input type="file" name="staff_commission_csv_file" id="staff_commission_csv_file"  class="input-button" multiple="false" accept=".csv" /> 
                </label>
                <label class="custom-file-label">No CSV File Uploaded</label>
            </span>
        </div>
    </p>
    
    <p id="commission-csv-status" class="csv-message spacer" style="display:none"></p>
</div>

<div class="col-md-6">
    <h3>Delete Assets</h3>
    
    <p class="form-row wps-drop spacer" id="delete_device" data-priority=""><label for="delete_device" class="">Remove a Device from Database &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="devices" class="devices" autocomplete="off" required>
                <option value="">Select Device to Delete</option>
                <?php
                foreach ( $devices as $device )
                {
                    echo '<option value="' . $device->id .'">' . $device->device .'</option>';
                }
                ?>
            </select>
        </span>
    </p>
    
    <div class="btn-group device-buttons" role="group" aria-label="Basic example" style="margin-bottom:10px;">
        <button type="button" class="btn btn-secondary device-delete-all" style="margin-right:20px;">Delete all Devices</button>
        <button type="button" class="btn btn-secondary"><a style = "color:white; text-decoration:none;" href="<?php echo esc_url( home_url( $_SERVER['REQUEST_URI'] ) ); ?>?action=download_devices_csv&_wpnonce=<?php echo wp_create_nonce( 'download_csv' )?>">Download Devices</a></button>
    </div>
    
    <p class="form-row wps-drop spacer" id="delete_tariff" data-priority=""><label for="delete_tariff" class="">Remove a Tariff from Database &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="tariffs" class="tariffs" autocomplete="off" required>
                <option value="">Select Tariff to Delete</option>
                <?php
                foreach ( $tariffs as $tariff )
                {
                    echo '<option value="' . $tariff->id .'">' . $tariff->tariff .'</option>';
                }
                ?>
            </select>
        </span>
    </p>
    
    <div class="btn-group tariff-buttons" role="group" aria-label="Basic example" style="margin-bottom:10px;">
        <button type="button" class="btn btn-secondary tariff-delete-all" style="margin-right:20px;">Delete all Tariffs</button>
        <button type="button" class="btn btn-secondary"><a style = "color:white; text-decoration:none;" href="<?php echo esc_url( home_url( $_SERVER['REQUEST_URI'] ) ); ?>?action=download_tariffs_csv&_wpnonce=<?php echo wp_create_nonce( 'download_csv' )?>">Download Tariffs</a></button>
    </div>
    
    <p class="form-row wps-drop spacer" id="delete_accessory" data-priority=""><label for="delete_accessory" class="">Remove an Accessory from Database &nbsp;<span class="required">*</span></label>
        <span class="woocommerce-input-wrapper">
            <select name="accessories" class="accessories" autocomplete="off" required>
                <option value="">Select Accessory to Delete</option>
                <?php
                foreach ( $accessories as $accessory )
                {
                    echo '<option value="' . $accessory->id .'">' . $accessory->accessory .'</option>';
                }
                ?>
            </select>
        </span>
    </p>
    
    <div class="btn-group accessory-buttons" role="group" aria-label="Basic example" style="margin-bottom:10px;">
        <button type="button" class="btn btn-secondary accessory-delete-all" style="margin-right:20px;">Delete all Accessories</button>
        <button type="button" class="btn btn-secondary"><a style = "color:white; text-decoration:none;" href="<?php echo esc_url( home_url( $_SERVER['REQUEST_URI'] ) ); ?>?action=download_accessories_csv&_wpnonce=<?php echo wp_create_nonce( 'download_csv' )?>">Download Accessories</a></button>
    </div>
</div>

<script>
    jQuery( document ).ready(function() 
    {
        enable_select2();
    });
    
    jQuery( '#device-csv' ).on('change', '#device_csv_file', function()
    {
        var fileInputElement = document.getElementById( "device_csv_file" );
        var filename = fileInputElement.files[0].name;
        
        jQuery( '#device-csv' ).find( '.custom-file-label' ).html( filename );
        
        add_device_csv_upload();
    });
    
    jQuery( '#tariffs-csv' ).on('change', '#tariffs_csv_file', function()
    {
        var fileInputElement = document.getElementById( "tariffs_csv_file" );
        var filename = fileInputElement.files[0].name;
        
        jQuery( '#tariffs-csv' ).find( '.custom-file-label' ).html( filename );
        
        add_tariffs_csv_upload();
    });
    
    jQuery( '#accessories-csv' ).on('change', '#accessories_csv_file', function()
    {
        var fileInputElement = document.getElementById( "accessories_csv_file" );
        var filename = fileInputElement.files[0].name;
        
        jQuery( '#accessories-csv' ).find( '.custom-file-label' ).html( filename );
        
        add_accessories_csv_upload();
    });
    
    jQuery( '#profit-targets-csv' ).on('change', '#profit_targets_csv_file', function()
    {
        var fileInputElement = document.getElementById( "profit_targets_csv_file" );
        var filename = fileInputElement.files[0].name;
        
        jQuery( '#profit-targets-csv' ).find( '.custom-file-label' ).html( filename );
        
        add_profit_csv_upload();
    });
    
    jQuery( '#discount-pots-csv' ).on('change', '#discount_pots_csv_file', function()
    {
        var fileInputElement = document.getElementById( "discount_pots_csv_file" );
        var filename = fileInputElement.files[0].name;
        
        jQuery( '#discount-pots-csv' ).find( '.custom-file-label' ).html( filename );
        
        add_discount_csv_upload();
    });
    
    jQuery( '#staff-commission-csv' ).on('change', '#staff_commission_csv_file', function()
    {
        var fileInputElement = document.getElementById( "staff_commission_csv_file" );
        var filename = fileInputElement.files[0].name;
        
        jQuery( '#staff-commission-csv' ).find( '.custom-file-label' ).html( filename );
        
        add_commission_csv_upload();
    });
    
    jQuery('.devices').on('change', function() 
    {
        var option = jQuery( this ).find('option:selected');

        //get the value from the option
        var value = option.val();
        
        if( value !== '' )
        {
            delete_asset( value, 'device' );
        }
    });
    
    jQuery('.tariffs').on('change', function() 
    {
        var option = jQuery( this ).find('option:selected');

        //get the value from the option
        var value = option.val();
        
        if( value !== '' )
        {
            delete_asset( value, 'tariff' );
        }
    });
    
    jQuery('.accessories').on('change', function() 
    {
        var option = jQuery( this ).find('option:selected');

        //get the value from the option
        var value = option.val();
        
        if( value !== '' )
        {
            delete_asset( value, 'accessory' );
        }
    });
    
    //for our buttons
    jQuery( ".device-delete-all" ).on( "click", function() 
    {
        delete_all_assets( 'device' );
    });
    
    jQuery( ".tariff-delete-all" ).on( "click", function() 
    {
        delete_all_assets( 'tariff' );
    });
    
    jQuery( ".accessory-delete-all" ).on( "click", function() 
    {
        delete_all_assets( 'accessory' );
    });
                        	    
    function add_device_csv_upload()
    {
        jQuery( '#device-csv-status' ).hide();
        
        var formData = new FormData();
        formData.append("action", "upload-attachment");
                                	
        var fileInputElement = document.getElementById( "device_csv_file" );
        formData.append( "async-upload" , fileInputElement.files[0]);
        formData.append( "name" , fileInputElement.files[0].name);
                                  	
        //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
        <?php $my_nonce = wp_create_nonce('media-form'); ?>
        formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function()
        {
            if ( xhr.readyState == 4 && xhr.status == 200 )
            {
                var response = JSON.parse( xhr.responseText );
                
                if( response.success == true )
                {
                    jQuery( '#device-csv-status' ).text( 'File uploaded successfully' );
                    jQuery( '#device-csv-status' ).show();
                    
                    csv_input( response.data.url, 'devices' );
                }
                else
                {
                    jQuery( '#device-csv-status' ).text( 'There was an issue uploading your CSV, please try again' );
                    jQuery( '#device-csv-status' ).show();
                }
            }
        }
        
        xhr.open("POST","/wp-admin/async-upload.php",true);
        xhr.send(formData);
    }
    
    function add_tariffs_csv_upload()
    {
        jQuery( '#tariff-csv-status' ).hide();
        
        var formData = new FormData();
        formData.append("action", "upload-attachment");
                                	
        var fileInputElement = document.getElementById( "tariffs_csv_file" );
        formData.append( "async-upload" , fileInputElement.files[0]);
        formData.append( "name" , fileInputElement.files[0].name);
                                  	
        //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
        <?php $my_nonce = wp_create_nonce('media-form'); ?>
        formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function()
        {
            if ( xhr.readyState == 4 && xhr.status == 200 )
            {
                var response = JSON.parse( xhr.responseText );
                
                if( response.success == true )
                {
                    jQuery( '#tariffs-csv-status' ).text( 'File uploaded successfully' );
                    jQuery( '#tariffs-csv-status' ).show();
                    
                    csv_input( response.data.url, 'tariffs' );
                }
                else
                {
                    jQuery( '#tariffs-csv-status' ).text( 'There was an issue uploading your CSV, please try again' );
                    jQuery( '#tariffs-csv-status' ).show();
                }
            }
        }
        
        xhr.open("POST","/wp-admin/async-upload.php",true);
        xhr.send(formData);
    }
    
    function add_accessories_csv_upload()
    {
        jQuery( '#accessories-csv-status' ).hide();
        
        var formData = new FormData();
        formData.append("action", "upload-attachment");
                                	
        var fileInputElement = document.getElementById( "accessories_csv_file" );
        formData.append( "async-upload" , fileInputElement.files[0]);
        formData.append( "name" , fileInputElement.files[0].name);
                                  	
        //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
        <?php $my_nonce = wp_create_nonce('media-form'); ?>
        formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function()
        {
            if ( xhr.readyState == 4 && xhr.status == 200 )
            {
                var response = JSON.parse( xhr.responseText );
                
                if( response.success == true )
                {
                    jQuery( '#accessories-csv-status' ).text( 'File uploaded successfully' );
                    jQuery( '#accessories-csv-status' ).show();
                    
                    csv_input( response.data.url, 'accessories' );
                }
                else
                {
                    jQuery( '#accessories-csv-status' ).text( 'There was an issue uploading your CSV, please try again' );
                    jQuery( '#accessories-csv-status' ).show();
                }
            }
        }
        
        xhr.open("POST","/wp-admin/async-upload.php",true);
        xhr.send(formData);
    }
    
    function add_profit_csv_upload()
    {
        jQuery( '#profit-csv-status' ).hide();
        
        var formData = new FormData();
        formData.append("action", "upload-attachment");
                                	
        var fileInputElement = document.getElementById( "profit_targets_csv_file" );
        formData.append( "async-upload" , fileInputElement.files[0]);
        formData.append( "name" , fileInputElement.files[0].name);
                                  	
        //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
        <?php $my_nonce = wp_create_nonce('media-form'); ?>
        formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function()
        {
            if ( xhr.readyState == 4 && xhr.status == 200 )
            {
                var response = JSON.parse( xhr.responseText );
                
                if( response.success == true )
                {
                    jQuery( '#profit-csv-status' ).text( 'File uploaded successfully' );
                    jQuery( '#profit-csv-status' ).show();
                    
                    csv_input( response.data.url, 'profit' );
                }
                else
                {
                    jQuery( '#profit-csv-status' ).text( 'There was an issue uploading your CSV, please try again' );
                    jQuery( '#profit-csv-status' ).show();
                }
            }
        }
        
        xhr.open("POST","/wp-admin/async-upload.php",true);
        xhr.send(formData);
    }
    
    function add_discount_csv_upload()
    {
        jQuery( '#disount-csv-status' ).hide();
        
        var formData = new FormData();
        formData.append("action", "upload-attachment");
                                	
        var fileInputElement = document.getElementById( "discount_pots_csv_file" );
        formData.append( "async-upload" , fileInputElement.files[0]);
        formData.append( "name" , fileInputElement.files[0].name);
                                  	
        //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
        <?php $my_nonce = wp_create_nonce('media-form'); ?>
        formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function()
        {
            if ( xhr.readyState == 4 && xhr.status == 200 )
            {
                var response = JSON.parse( xhr.responseText );
                
                if( response.success == true )
                {
                    jQuery( '#discount-csv-status' ).text( 'File uploaded successfully' );
                    jQuery( '#discount-csv-status' ).show();
                    
                    csv_input( response.data.url, 'discount' );
                }
                else
                {
                    jQuery( '#discount-csv-status' ).text( 'There was an issue uploading your CSV, please try again' );
                    jQuery( '#discount-csv-status' ).show();
                }
            }
        }
        
        xhr.open("POST","/wp-admin/async-upload.php",true);
        xhr.send(formData);
    }
    
    function add_commission_csv_upload()
    {
        jQuery( '#commission-csv-status' ).hide();
        
        var formData = new FormData();
        formData.append("action", "upload-attachment");
                                	
        var fileInputElement = document.getElementById( "staff_commission_csv_file" );
        formData.append( "async-upload" , fileInputElement.files[0]);
        formData.append( "name" , fileInputElement.files[0].name);
                                  	
        //also available on page from _wpPluploadSettings.defaults.multipart_params._wpnonce
        <?php $my_nonce = wp_create_nonce('media-form'); ?>
        formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
                                
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function()
        {
            if ( xhr.readyState == 4 && xhr.status == 200 )
            {
                var response = JSON.parse( xhr.responseText );
                
                if( response.success == true )
                {
                    jQuery( '#commission-csv-status' ).text( 'File uploaded successfully' );
                    jQuery( '#commission-csv-status' ).show();
                    
                    csv_input( response.data.url, 'commission' );
                }
                else
                {
                    jQuery( '#commission-csv-status' ).text( 'There was an issue uploading your CSV, please try again' );
                    jQuery( '#commission-csv-status' ).show();
                }
            }
        }
        
        xhr.open("POST","/wp-admin/async-upload.php",true);
        xhr.send(formData);
    }
    
    function csv_input( link , type )
    {
        var csv = link;
        var type = type;
        
        var data = {};
                            
        data[ 'action' ] = 'fc_upload_csv';
        data[ 'nonce' ] = fc_nonce;
        data[ 'csv' ] = csv; 
        data[ 'type' ] = type; 
        
        jQuery.ajax({
    		type: 'POST',
            dataType: 'json',
            url: fc_ajax_url,
            data: data,
            success: function(data) 
            {	
                if( data.success === false )
                {
                    jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="file_error">There was an error adding info to the database. Please try again.</li></ul></div>' );
                    
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                }
                else
                {
                    var message = "";
                    
                    var session = data.data;
                    
                    if( session.hasOwnProperty( 'update' ) && ! session.hasOwnProperty( 'insert' ) )
                    {
                        message = "Your " + type + " information has been added to the database successfully. <br/><br/>" + data.data.update;
                    }
                    
                    else if ( ! session.hasOwnProperty( 'update' ) && session.hasOwnProperty( 'insert' ) )
                    {
                        message = "Your " + type + " information has been added to the database successfully. <br/><br/>" + data.data.insert;
                    }
                    else if ( session.hasOwnProperty( 'update' ) && session.hasOwnProperty( 'insert' ) )
                    {
                        message = "Your " + type + " information has been added to the database successfully. <br/><br/>" + data.data.insert + "<br/><br/>" + data.data.update;
                    }
                    
                    jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">' + message + '.	</div></div>' );
                    
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                }
            },
        });
    }
    
    function delete_asset( asset , type )
    {
        var asset = asset;
        var type = type;
        
        var data = {};
                            
        data[ 'action' ] = 'fc_delete_asset';
        data[ 'nonce' ] = fc_nonce;
        data[ 'id' ] = asset; 
        data[ 'type' ] = type; 
        
        jQuery.ajax({
    		type: 'POST',
            dataType: 'json',
            url: fc_ajax_url,
            data: data,
            success: function(data) 
            {	
                if( data.success === false )
                {
                    jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="file_error">There was an error removing your ' + type + '. Please try again.</li></ul></div>' );
                    
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                }
                else
                {
                    if( data.data == 'device_deleted' )
                    {
                        jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Your device was deleted successfully</div></div>' );
                    }
                    if( data.data == 'tariff_deleted' )
                    {
                        jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Your tariff was deleted successfully</div></div>' );
                    }
                    if( data.data == 'accessory_deleted' )
                    {
                        jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">Your accessory was deleted successfully</div></div>' );
                    }
                    
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                }
            },
        });
    }
    
    function delete_all_assets( type )
    {
        Swal.fire({
            icon: 'error',
            title: 'Are You Sure?',
            text: 'Please confirm you wish to delete all ' + type + 's',
            footer: 'This action cannot be undone',
            showDenyButton: true,
            confirmButtonText: `Blow the Doors!`,
            denyButtonText: `I Can't Do it Captain!`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) 
            {
                var data = {};
                                    
                data[ 'action' ] = 'fc_delete_all_assets';
                data[ 'nonce' ] = fc_nonce; 
                data[ 'type' ] = type; 
                
                jQuery.ajax({
            		type: 'POST',
                    dataType: 'json',
                    url: fc_ajax_url,
                    data: data,
                    success: function(data) 
                    {	
                        if( data.success === false )
                        {
                            jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><ul class="woocommerce-error" role="alert"><li data-id="file_error">There was an error removing yours ' + type + 's. Please try again.</li></ul></div>' );
                            
                            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                        }
                        else
                        {
                            jQuery( "#upload-status" ).html( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">' + tariff + 's were all removed</div></div>' );
                        }
                    },
                }); 
            } else if (result.isDenied) 
            {
                Swal.fire('Please be careful, this is a dangerous operation!', '', 'info')
            }
        })
    }
    
    function enable_select2()
    {
        jQuery(".devices").select2(
        {
            width: '100%',
        });
        
        jQuery(".accessories").select2(
        {
            width: '100%',
        });
        
        jQuery(".tariffs").select2(
        {
            width: '100%',
        });
    }
</script>