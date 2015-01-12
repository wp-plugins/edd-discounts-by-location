<?php
/**
 * WC Dependency Checker
 *
 */
class EDD_Dependencies {
	private static $active_plugins;
	
	static function init() {
		self::$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() )
			self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	}
	
	static function edd_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'easy-digital-downloads/easy-digital-downloads.php', self::$active_plugins ) || array_key_exists( 'easy-digital-downloads/easy-digital-downloads.php', self::$active_plugins );
		return false;
	}
}

