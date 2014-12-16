<?php
class DC_Edd_Discounts_By_Location_Admin {
  
  public $settings;

	public function __construct() {
		//admin script and style
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_script'));
		
		//add_action('dc_edd_discounts_by_location_dualcube_admin_footer', array(&$this, 'dualcube_admin_footer_for_dc_edd_discounts_by_location'));
	}

	function dualcube_admin_footer_for_dc_edd_discounts_by_location() {
    global $DC_Edd_Discounts_By_Location;
    ?>
    <div style="clear: both"></div>
    <div id="dc_admin_footer">
      <?php _e('Powered by', $DC_Edd_Discounts_By_Location->text_domain); ?> <a href="http://dualcube.com" target="_blank"><img src="<?php echo $DC_Edd_Discounts_By_Location->plugin_url.'/assets/images/dualcube.png'; ?>"></a><?php _e('Dualcube', $DC_Edd_Discounts_By_Location->text_domain); ?> &copy; <?php echo date('Y');?>
    </div>
    <?php
	}

	/**
	 * Admin Scripts
	 */

	public function enqueue_admin_script() {
		global $DC_Edd_Discounts_By_Location;
		$screen = get_current_screen();
		// Enqueue admin script and stylesheet from here
		if (in_array( $screen->id, array( 'download_page_edd-discounts' ))) {   
		  wp_enqueue_script('edd_location_admin_js', $DC_Edd_Discounts_By_Location->plugin_url.'assets/admin/js/admin.js', array('jquery'), $DC_Edd_Discounts_By_Location->version, true);
		  wp_enqueue_style('edd_location_admin_css',  $DC_Edd_Discounts_By_Location->plugin_url.'assets/admin/css/admin.css', array(), $DC_Edd_Discounts_By_Location->version);
	  }
	}
}