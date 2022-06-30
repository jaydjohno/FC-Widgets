<?php

global $wpdb;

$month = date('F');
                
$year = date('Y');

$user = wp_get_current_user();

$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_store_locations ORDER BY location ASC" ) );

foreach ( $results as $result )
{
    $locations[] = $result->location;
}

?>

<div class="unapproved-errors" style="display:none"></div>
    
<p>Welcome <?php echo $user->display_name; ?></p>
    
<p>On this page you can see all stores and any unapproved sales they may have and what dates</p>
    
<br>

<select name="store" class="stores">
    <option value ="">Choose Store</option>
    <?php
    foreach($locations as $location) {
        echo '<option vlaue ="' . $location . '">' . $location . '</option>';
    }
    ?>
</select>

<p class="store-errors"></p>

<div class="unapproved-sales-info"></div>

<script>
    jQuery( document ).ready(function() 
    {
        jQuery(".stores").select2(
		{
            width: '100%',
        });
        
        jQuery( '.stores' ).val( '' ).trigger('change');
    });
        
    jQuery('.stores').on('change', function() {
        var store = this.value;
        
        if(store !== '') {
            jQuery('.store-error').text('');
            
            var data = {};
        
            data['action'] = 'fc_get_unapproved_sales_info';
            data['nonce'] = fc_nonce;
            data['store'] = store;

            jQuery.ajax({
                type: 'POST',
                url: fc_ajax_url,
                data: data,
                success: function( data ) 
                {   
                    jQuery( ".unapproved-sales-info" ).html( data );
                },
            });
        }
    });
</script>