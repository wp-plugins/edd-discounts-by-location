<?php
if(!function_exists('get_edd_discounts_by_location_settings')) {
  function get_edd_discounts_by_location_settings($name = '', $tab = '') {
    if(empty($tab) && empty($name)) return '';
    if(empty($tab)) return get_option($name);
    if(empty($name)) return get_option("dc_{$tab}_settings_name");
    $settings = get_option("dc_{$tab}_settings_name");
    if(!isset($settings[$name])) return '';
    return $settings[$name];
  }
}

if(!function_exists('edd_inactive_notice')) {
  function edd_inactive_notice() {
    ?>
    <div id="message" class="error">
      <p><?php printf( __( '%sEasy Digital Downloads is inactive.%s The %sEasy Digital Downloads plugin%s must be active for the EDD Discount By Location to work. Please %sinstall & activate Easy Digital Downloads%s', DC_EDD_DISCOUNTS_BY_TIME_TEXT_DOMAIN ), '<strong>', '</strong>', '<a target="_blank" href="https://wordpress.org/plugins/easy-digital-downloads/">', '</a>', '<a href="' . admin_url( 'plugins.php' ) . '">', '&nbsp;&raquo;</a>' ); ?></p>
    </div>
		<?php
  }
}
?>
