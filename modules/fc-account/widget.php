<?php
/**
 * FC Account Module.
 *
 * @package FCWidgets
 */

namespace FCPlugin\FCAccount;

if ( ! defined( 'ABSPATH' ) ) 
{
	exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'widget/fc-account.php';

class Module
{
	/**
	 * Module should load or not.
	 *
	 * @since 1.20.0
	 * @access public
	 *
	 * @return bool true|false.
	 */
	public static function is_enabled() 
	{
		return true;
	}

	/**
	 * Constructor.
	 */
	public function __construct() 
	{ // phpcs:ignore Generic.CodeAnalysis.UselessOverridingMethod.Found
		parent::__construct();
	}
}