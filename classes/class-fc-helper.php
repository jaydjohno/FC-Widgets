<?php

namespace FCPlugin;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

if ( ! class_exists( 'FC_Helper' ) ) 
{
	/**
	 * Class fc_Helper.
	 */
	final class FC_Helper 
	{
	    private static $instance;
    	
    	public static function get_instance() 
    	{
    		if ( ! isset( self::$instance ) ) 
    		{
    			self::$instance = new self();
    		}
		    return self::$instance;
	    }
	    
	    public function __construct() 
		{
			$this->load_styles();
			
			$this->load_scripts();
		}
	    
	    public function load_scripts()
        {
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_js' ) );
        }
        
        public function widget_js()
        {
            wp_register_script( 'fc-bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js' , array( 'jquery', ), '3.4.1' , false );
            
            wp_register_script( 'fcFrontend', plugins_url( '../assets/js/frontend.js', __FILE__ ), array( 'jquery' ), '', true );

    		wp_localize_script(
			    'fcFrontend', 'fc_ajax_url', admin_url("admin-ajax.php")
		    );
		    
		    wp_localize_script(
			    'fcFrontend', 'fc_nonce', wp_create_nonce("fc-nonce")
		    );
		    
		    wp_enqueue_script( 'fcFrontend' );
        }
        
        public function load_styles() 
        {
        	// Register Widget Styles
        	add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'widget_styles' ) );
        }
        
        public function widget_styles() 
        {
        	wp_register_style( 'fc-frontend', plugins_url( '../assets/css/frontend.css', __FILE__ ) );
        	wp_enqueue_style('fc-frontend');
        	
        	wp_register_style( 'fc-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css' );
        	
        	wp_register_style( 'fc-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css' );
        	
        	wp_register_style( 'fc-charts', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css' );
        }
	}
	
	FC_Helper::get_instance();
}