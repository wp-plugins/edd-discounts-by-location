<?php
/*
Plugin Name: Edd Discounts By Location
Plugin URI: http://dualcube.com
Description: This is Easy Digital Downloads add-on. This plugin enables you to provide country specific discounts.
Author: Dualcube
Version: 1.0.1
Author URI: http://dualcube.com
*/

if ( ! class_exists( 'WC_Dependencies' ) )
	require_once 'includes/class-dc-dependencies.php';
if( ! EDD_Dependencies::edd_active_check() ) {
 add_action( 'admin_notices', 'edd_inactive_notice' );
}
require_once 'includes/dc-edd-discounts-by-location-core-functions.php';
require_once 'config.php';
if(!defined('ABSPATH')) exit; // Exit if accessed directly
if(!defined('DC_EDD_DISCOUNTS_BY_LOCATION_PLUGIN_TOKEN')) exit;
if(!defined('DC_EDD_DISCOUNTS_BY_LOCATION_TEXT_DOMAIN')) exit;

if(!class_exists('DC_Edd_Discounts_By_Location')) {
	require_once( 'classes/class-dc-edd-discounts-by-location.php' );
	global $DC_Edd_Discounts_By_Location;
	$DC_Edd_Discounts_By_Location = new DC_Edd_Discounts_By_Location( __FILE__ );
	$GLOBALS['DC_Edd_Discounts_By_Location'] = $DC_Edd_Discounts_By_Location;
}
?>
