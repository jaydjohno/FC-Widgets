<?php

/**
 * The base class for the Stiles FC plugin
 *
 * @author 	Stiles Media
 * @version 2.0.0
 * @package stiles-fc-plugin
 * @subpackage stiles-fc-plugin/inc
 */

namespace FCPlugin;

defined( 'ABSPATH' ) or die( 'Direct Access Not Allowed!' );

if(!class_exists('FC_Base')) :

	class FC_Base 
	{
		/**
	     * Class instance variable
	     *
	     * @since 2.0.0
	     *
	     * @type object ::self
	     */
		public static $instance;

		/**
		 * Define class & plugin variables
		 *
		 * @return 	null
		 * @since   2.0.0
		 */
		public function __construct() 
		{
			// Get self instance
			self::$instance = $this;
			
			$this->init();
		}
		
		public function init()
		{
		    
		}

		/**
		 * Return instance of base class
		 *
		 * @return 	null
		 * @since   2.0.0
		 */
		public static function get_instance() 
		{
			if(self::$instance === null) 
			{
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
	
	FC_Base::get_instance();

endif;