<?php
class DC_Edd_Discounts_By_Location_Validate {

	public function __construct() {
		add_action('edd_checkout_error_checks', array(&$this, 'validate_discount_location'), 10, 2);
	}

	public function validate_discount_location( $valid_data, $POST ) {
	  $code = $valid_data['discount'];
	  $country = $_POST['billing_country'];
	  $discount = $this->get_the_discount( $code );
	  if( is_object( $discount ) ) {
	    $locations_on = get_post_meta( $discount->ID, '_edd_discount_locations_on', true );
      if( $locations_on == 1) {
        $locations = get_post_meta( $discount->ID, '_edd_discount_locations', true );
        if( ! empty( $locations ) ) {
          if( ! in_array( $country, $locations) ) {
            edd_set_error( 'invalid_discount_location', __( 'This discount is invalid for your location. Please remove discount to proceed.', 'edd' ) );
          }
        }
      }
	  }
	}
	
	public function get_the_discount( $code ) {
	  $discounts = get_posts(
	    array(
        'post_type'      => 'edd_discount',
        'posts_per_page' => -1,
        'orderby'        => 'ID',
        'order'          => 'DESC',
        'post_status'    => 'active',
        'meta_key'       => '_edd_discount_code',
        'meta_value'     => $code
	    )
    );
	  return current( $discounts );
	}
}
