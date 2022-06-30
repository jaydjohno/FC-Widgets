<?php
/**
 * fc Module Manager.
 *
 * @package fcWidgets
 */

namespace FCPlugin;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) 
{
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'FC_Modules' ) ) 
{
    class FC_Modules 
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
	    
        public function __construct ()
    	{
    		$this->register_categories();
    		$this->register_modules();
    	}
    	
    	public function register_modules()
    	{
    	    add_action( 'elementor/widgets/widgets_registered', function() 
            {
                require fc_module_dir . 'fc-account/widget.php';
            });
    	}
    	
    	public function register_categories()
    	{
    	    add_action( 'elementor/elements/categories_registered', function () 
            {
            	$elementsManager = Plugin::instance()->elements_manager;
				
            	$elementsManager->add_category
            	(
            		'fc-category',
            			array(
            				'title' => fc_category,
            				'icon'  => fc_category_icon,
            			)
            	);
            });
    	}
    }
    
    FC_Modules::get_instance();
}