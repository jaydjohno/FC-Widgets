<?php

defined( 'ABSPATH' ) || exit;

$user = wp_get_current_user();

$time = new DateTime('now');
$today = $time->format('Y-m-d');
$newtime = $time->modify('-100 years')->format('Y-m-d');

do_action( 'woocommerce_before_edit_account_form' ); ?>

<script>
    jQuery( document ).ready(function() 
    {
        jQuery("#account_display_name").prop("disabled", true);
    });
    
</script>

<div id="form-outcome"></div>

<form class="woocommerce-EditAccountForm edit-account" id="save-account-details" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
	
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide display-name">
		<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the portal', 'woocommerce' ); ?></em></span>
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>
	<div class="clear"></div>

	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</p>
	
	<p class="form-row validate-required" id="date_of_birth_field" data-priority=""><label for="date_of_birth" class="">Date of Birth&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="date" class="input-text " name="date_of_birth" id="date_of_birth" placeholder="" value="<?php echo esc_attr( get_user_meta( $user->ID, 'date_of_birth' , true ) ); ?>" min="<?php echo esc_attr( $newtime ); ?>" max="<?php echo esc_attr( $today ); ?>" aria-describedby="date-of-birth-description"></span></p>
	
	<?php
	if( $user && in_array( 'store_manager', $user->roles ) )
	{
	?>
	    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    		<label for="account_email"><?php esc_html_e( 'Store Managed', 'woocommerce' ); ?></label>
    		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="store_managed" id="store_managed" value="<?php echo esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) ); ?>" disabled />
	    </p>
	<?php
	}
	elseif( $user && in_array( 'employee', $user->roles ) )
	{
	?>
    	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    		<label for="account_email"><?php esc_html_e( 'Store Location', 'woocommerce' ); ?></label>
    		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="store_location" id="store_location" value="<?php echo esc_attr( get_user_meta( $user->ID, 'store_location' , true ) ); ?>" disabled />
    	</p>
	<?php
	}
	?>

	<fieldset>
		<legend><?php esc_html_e( 'Change Your Password', 'woocommerce' ); ?></legend>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<button type="submit" id="save-account" class="woocommerce-Button button" style="margin-top:20px" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>