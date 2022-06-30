<?php
/**
 * Plugin Name: FC Widgets
 * Plugin URI: https://stiles.media
 * Description: This plugin sets up all the functionality for the Family Connects website.
 * Version: 2.0.0
 * Author: Stiles Media
 * Author URI: https://stiles.media
 * 
 * @package FCWidgets
 */
 
if ( ! defined( 'ABSPATH' ) ) 
{
	die();
}

//set our timezone
date_default_timezone_set('Europe/London');

// Define constants
define( 'fc_base', plugin_basename( __FILE__ ) );
define( 'fc_dir', plugin_dir_path( __FILE__ ) );
define( 'fc_url', plugin_dir_url( __FILE__ ) );
define('fc_module_dir', fc_dir . 'modules/');
define( 'fc_ver', '2.0.0' );
define( 'fc_slug', 'fc-plugin' );
define('fc_category', 'FC Widgets');
define('fc_category_icon', 'fonts');
define('fc_Required_PHP_Version', '7.0');
define('fc_Required_WP_Version',  '5.0');

/**
 * The core plugin classes that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require fc_dir .  'classes/class-fc.php';

/**
 * The core plugin file that loads all our ajax functions.
 */
require fc_dir .  'inc/portal-functions.php';

/**
 * The core plugin file that loads all our helper functions.
 */
require fc_dir .  'functions/helper-functions.php';

/**
 * The core plugin file that loads all our user modifications.
 */
require fc_dir .  'classes/class-fc-profile-fields.php';
require fc_dir .  'classes/class-fc-portal-setup.php';

/**
 * The core plugin files needed for functionality.
 */
require fc_dir . 'functions/shortcodes.php';

//redirect logged in portal access to the login page
add_action( 'template_redirect', 'wc_redirect_non_logged_to_login_access');
function wc_redirect_non_logged_to_login_access() 
{
    if ( ! is_user_logged_in() && is_account_page() ) 
    {
        wp_redirect( home_url( '/login' ) );
        exit();
    }
}

// Hook the appropriate WordPress action to redirect wp-admin requests to login
add_action('init', 'prevent_wp_login');

function prevent_wp_login() {
    // WP tracks the current page - global the variable to access it
    global $pagenow;
    // Check if a $_GET['action'] is set, and if so, load it into $action variable
    $action = (isset($_GET['action'])) ? $_GET['action'] : '';
    // Check if we're on the login page, and ensure the action is not 'logout'
    if( $pagenow == 'wp-login.php' && ( ! $action || ( $action && ! in_array($action, array('logout', 'lostpassword', 'rp', 'resetpass'))))) {
        // Load the home page url
        $page = get_bloginfo('url') . '/login';
        // Redirect to the login page
        wp_redirect($page);
        // Stop execution to prevent the page loading for any reason
        exit();
    }
}

/**
 * Begins execution of the plugin.
 *
 * @since    2.0.0
 */
if( !function_exists('stiles_fc_init') ) 
{
	function stiles_fc_init() 
	{
		new Stiles_fc_Plugin();
	}
}

function chart_script() 
{
    if( is_page( 138 ) )
    {
    ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <?php
    }
}

add_action('wp_head', 'chart_script');

function ajax_loader() 
{
    if( is_page( 138 ) )
    {
    ?>
        <script>
        jQuery(document).ready(function()
        {
            jQuery(document).ajaxStart(function()
            {
                jQuery("body").addClass("loading");
            });
        
            jQuery(document).ajaxComplete(function()
            {
                setTimeout(function()
                {
                    jQuery("body").removeClass("loading");
                } , 2500); 
            });
        });
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/js/main.js"></script> 
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
        
        <script>
        function startPrintProcess() 
        {
            html2canvas( document.getElementById('staff-review-info') , 
            {
                allowTaint : true,
                background :'#FFFFFF',
                onrendered: function (canvas) 
                {
                    var imgData = canvas.toDataURL('image/png');
                    
                    var margin = 5;
                    var imgWidth = 210 - 2*margin; 
                    var pageHeight = 295;  
                    var imgHeight = canvas.height * imgWidth / canvas.width;
                    var heightLeft = imgHeight;
                
                    var doc = new jsPDF('p', 'mm');
                    var position = 0;
                
                    doc.addImage( imgData , 'PNG', margin, position, imgWidth, imgHeight);
                
                    heightLeft -= pageHeight;
                
                    while (heightLeft >= 0) 
                    {
                        position = heightLeft - imgHeight;
                        doc.addPage();
                        doc.addImage( imgData , 'PNG', margin, position, imgWidth, imgHeight);
                        heightLeft -= pageHeight;
                    }
                      
                    //var doc = new jsPDF( "p", "mm", "a4" );
                    //doc.addImage( imgData, 'PNG', 0, 0, 200, 287 ); // A4 sizes
                    
                    //get the current selected option
                    var option = jQuery( '.review_advisor' ).find( 'option:selected' );
            
                    //get the current advisor from the option
                    var advisor = option.text();
                    
                    if( advisor !== 'Choose Advisor' )
                    {
                        var filename = advisor + '-review for ' + startdate + ' to ' + enddate;
                    }
                    
                    doc.save( filename );
                }
            });
        }
    </script>
    <?php
    }
}

add_action('wp_head', 'ajax_loader');

//output our overlay div
function ajax_overlay()
{
    if( is_page( 138 ) )
    {
    ?>
        <div class="overlay"></div>
        
        <script>
            var picker = new Litepicker({
                element: document.getElementById('datepicker'),
                format: 'YYYY-MM-DD',
                singleMode: false,
                minDate: '2020-10-01',
                maxDate: '<?php echo date("Y-m-d"); ?>',
                numberOfMonths: 1,
                useResetBtn: true,
                onSelect(date1, date2) 
                {
                  	startdate = date1.toDateString();
                  	enddate = date2.toDateString();
                  	
                  	jQuery( '.review-info' ).html( '' );
                    jQuery( '.review-info' ).hide();
                    
                    jQuery('.review_advisor').val([]);
                    
                    jQuery( '.review-advisor' ).find( '.select2-selection__rendered' ).attr( 'title' , 'Choose Advisor' );
                    jQuery( '.review-advisor' ).find( '.select2-selection__rendered' ).text( 'Choose Advisor' );
                },
            })
        </script>
        <?php
    }
}

add_action('wp_footer', 'ajax_overlay');

function redirect_login_and_forgot()
{
    if( ! Elementor\Plugin::instance()->editor->is_edit_mode() )
	{
    	//redirect login page to portal page
    	if ( is_page( 239 ) && is_user_logged_in() )
    	{
    		//not in edit mode, lets redirect
    		wp_redirect( 'https://www.familyconnectgroup.co.uk/portal/', 301 ); 
      		exit;
    	}
	}
	
	if( ! Elementor\Plugin::instance()->editor->is_edit_mode() )
	{
    	//redirect forgot password to edit details page
    	if ( is_page( 1013 ) && is_user_logged_in() )
    	{
		
			//not in edit mode, lets redirect
		    wp_redirect( 'https://www.familyconnectgroup.co.uk/portal/employee-details/', 301 ); 
  		    exit;
		}
	}
}

add_action( 'template_redirect', 'redirect_login_and_forgot' );

add_action( 'init', 'unapproved_sales' );
 
function unapproved_sales() 
{
    $user = wp_get_current_user();
    
    $location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
    
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
    else
    {
        $location = esc_attr( get_user_meta( $user->ID, 'store_managed' , true ) );
    }
    
    if( $user && in_array( 'multi_manager', $user->roles ) || $user && in_array( 'store_manager', $user->roles ) )
    {
        if( ! is_front_page() && ! is_admin() )
        {
            global $wpdb;
        
            if( $user && in_array( 'multi_manager', $user->roles ) )
            {
                wc_clear_notices();
                 
                foreach ( $multi_locations as $location )
                {
                    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store = '$location' AND approve_sale = ''" ) );

                    $dates = array();
                    
                    foreach ( $results as $result )
                    {
                        $date = $result->sale_date;
    
                        $createDate = new DateTime( $date );
                            
                        $date = $createDate->format('Y-m-d');
                            
                        $today = date("Y-m-d");
                            
                        if( $date !== $today )
                        {
                            $dates[ $date ] = $date;
                        }
                    }
                
                    if( ! empty( $dates ) )
                    {
                        usort( $dates , "date_sort" );
                        
                        $list = '';
                        $list .= '<ul class="unapproved_dates">';
                        
                        foreach( $dates as $date )
                        {
                            $list .= '<li>' . $date . '</li>';
                        }
                        
                        $list .= '</ul>';
                        
                        wc_add_notice( 'You have unapproved sales in ' . $location . ' for the following dates ' . $list , 'notice' );
                    }
                }
            }
            else
            {
                $dates = array();
                
                $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_fc_sales_info WHERE store = '$location' AND approve_sale = ''" ) );
                
                foreach ( $results as $result )
                {
                    $date = $result->sale_date;

                    $createDate = new DateTime( $date );
                        
                    $date = $createDate->format('Y-m-d');
                        
                    $today = date("Y-m-d");
                        
                    if( $date !== $today )
                    {
                        $dates[ $date ] = $date;
                    }
                }
                
                wc_clear_notices();
                
                if( ! empty( $dates ) )
                {
                    usort( $dates , "date_sort" );
                    
                    $list = '';
                    $list .= '<ul class="unapproved_dates">';
                    
                    foreach( $dates as $date )
                    {
                        $list .= '<li>' . $date . '</li>';
                    }
                    
                    $list .= '</ul>';
                    
                    wc_add_notice( 'You have unapproved sales in ' . $location . ' for the following dates ' . $list , 'notice' );
                }
            }
        }
    }
}