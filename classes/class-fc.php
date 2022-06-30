<?php

namespace FCPlugin;

defined( 'ABSPATH' ) or die( 'Direct Access Not Allowed!' );

if( !class_exists('Stiles_FC_Plugin') ) :

	class Stiles_FC_Plugin 
	{
		/**
	     * Plugin slug
	     *
	     * @since 2.0.0
	     *
	     * @type string
	     */
		public $plugin_slug;

		/**
	     * Plugin version
	     *
	     * @since 2.0.0
	     *
	     * @type string
	     */
		private $version;
		
		/**
	     * Plugin version
	     *
	     * @since 2.0.0
	     *
	     * @type string
	     */
		private static $instance;
    	
    	public static function get_instance() 
    	{
    		if ( ! isset( self::$instance ) ) 
    		{
    			self::$instance = new self();
    		}
		    return self::$instance;
	    }

		/**
		 * Plugin initialization functions
		 *
		 * @return 	null
		 * @since    2.0.0
		 */
		public function __construct() 
		{
			$this->plugin_slug = fc_slug;
			$this->version = fc_ver;

			$this->set_locale();
			$this->load_dependencies();
		}


		/**
		 * Loads all required plugin files and loads classes
		 *
		 * @return 	null
		 * @since   2.0.0
		 */
		private function load_dependencies() 
		{
			require_once fc_dir . 'classes/class-fc-base.php';
			require_once fc_dir . 'classes/class-fc-helper.php';
			require_once fc_dir . 'classes/class-fc-modules.php';
		}

		/**
		 * Loads the plugin text-domain for internationalization
		 *
		 * @return 	null
		 * @since   2.0.0
		 */
		private function set_locale() 
		{
			load_plugin_textdomain( $this->plugin_slug, false, fc_dir . 'language' );
	    }
	}
	
    Stiles_FC_Plugin::get_instance();

endif;