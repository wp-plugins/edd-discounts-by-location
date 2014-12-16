<?php
class DC_Edd_Discounts_By_Location_Locations {
  public $countries;

	public function __construct() {
	  add_action('edd_countries', array(&$this, 'get_countries'));
	  
	  add_action('edd_edit_discount_form_before_use_once', array(&$this, 'edit_enable_locations_to_discount'), 10, 2);
		add_action('edd_edit_discount_form_before_use_once', array(&$this, 'edit_add_locations_to_discount'), 10, 2);
		
	  add_action('edd_add_discount_form_before_use_once', array(&$this, 'add_enable_locations_to_discount'));
		add_action('edd_add_discount_form_before_use_once', array(&$this, 'add_add_locations_to_discount'));
		
		add_action('edd_post_update_discount', array(&$this, 'save_enable_locations_to_discount'), 10, 2);
		add_action('edd_post_update_discount', array(&$this, 'save_locations_to_discount'), 10, 2);
		
		add_action('edd_post_insert_discount', array(&$this, 'save_enable_locations_to_discount'), 10, 2);
		add_action('edd_post_insert_discount', array(&$this, 'save_locations_to_discount'), 10, 2);
	}
	
	public function get_countries( $countries ) {
	  $this->countries = $countries;
	  return $countries;
	}
	
	public function edit_enable_locations_to_discount( $discount_id, $discount ) {
	  global $DC_Edd_Discounts_By_Location;
		$locations_on = get_post_meta( $discount_id, '_edd_discount_locations_on', true);
		$args = array(
		  'name'     => 'locations_enable',
		  'id'       => 'edd-locations-enable',
			'current'  => $locations_on,
			'class'    => 'edd-checkbox'
    );
    $html = $this->insert_tab_row('locations enable', 'checkbox', $args, 'Enable Country for this discount.');
		echo $html;
	}
	
	public function add_enable_locations_to_discount() {
	  global $DC_Edd_Discounts_By_Location;
		$args = array(
		  'name'     => 'locations_enable',
		  'id'       => 'edd-locations-enable',
			'current'  => null,
			'class'    => 'edd-checkbox'
    );
    $html = $this->insert_tab_row('locations enable', 'checkbox', $args, 'Enable Country for this discount.');
		echo $html;
	}
	
	public function save_enable_locations_to_discount( $details, $discount_id ) {
	  $on = 0;
	  if( isset($_POST['locations_enable']) )
	    $on = 1;
	  update_post_meta( $discount_id, '_edd_discount_locations_on', $on );
	}

	public function edit_add_locations_to_discount( $discount_id, $discount ) {
		global $DC_Edd_Discounts_By_Location;
		$countries = array_diff( $this->countries, array('Choose') );
		$locations_on = get_post_meta( $discount_id, '_edd_discount_locations_on', true);
		$disabled = null;
		if($locations_on == 0)
		  $disabled = 'disabled';
		$locations = get_post_meta( $discount_id, '_edd_discount_locations', true);
		$args = array(
			'options'          => $countries,
			'name'             => 'locations[]',
			'class'            => '',
			'id'               => 'edd-locations',
			'selected'         => $locations,
			'chosen'           => true,
			'multiple'         => true,
			'show_option_all'  => false,
			'show_option_none' => false,
			'disabled'         => $disabled
		);
		$html = $this->insert_tab_row('locations', 'select', $args, 'Select Countries relevant to this discount.');
		echo $html;
	}
	
	public function add_add_locations_to_discount() {
		global $DC_Edd_Discounts_By_Location;
		$countries = edd_get_country_list();
		$args = array(
			'options'          => $countries,
			'name'             => 'locations[]',
			'class'            => '',
			'id'               => 'edd-locations',
			'selected'         => $locations,
			'chosen'           => true,
			'multiple'         => true,
			'show_option_all'  => false,
			'show_option_none' => false,
			'disabled'         => 'disabled'
		);
		$html = $this->insert_tab_row('locations', 'select', $args, 'Select Countries relevant to this discount.');
		echo $html;
	}
	
	public function save_locations_to_discount( $details, $discount_id ) {	  
	  if( isset( $_POST['locations_enable'] ) ) {
	    $locations = array_diff( $_POST['locations'], array(0) );
	    update_post_meta( $discount_id, '_edd_discount_locations', $locations );
	  }
	}
	
	public function insert_tab_row( $lable = '', $element = '', $args = array(), $text = '' ) {
	  $html = '<tr>';
		$html .= '<th valign="top" scope="row">';
		$html .= '<label for="edd_' . str_replace( ' ', '_', $lable) . '">' . ucfirst( $lable ) . '</label>';
		$html .= '</th>';
		$html .= '<td>';		
		switch($element) {
		  case 'select':
		    $html .= $this->select($args);
		    break;
      case 'checkbox':
        $html .= $this->checkbox($args);
        break;
      case 'text':
        $html .= $this->text($args);
        break;
		}
		$html .= '<p class="description">';
		$html .= $text;
		$html .= '</p>';
		$html .= '</td>';
		$html .= '</tr>';
	  return $html;
	}

	/**
	 * Renders an HTML Dropdown
	 *
	 * @since 1.6
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function select( $args = array() ) {
		$defaults = array(
			'options'          => array(),
			'name'             => null,
			'class'            => '',
			'id'               => '',
			'selected'         => 0,
			'chosen'           => false,
			'multiple'         => false,
			'show_option_all'  => _x( 'All', 'all dropdown items', 'edd' ),
			'show_option_none' => _x( 'None', 'no dropdown items', 'edd' ),
			'disabled'         => null
		);

		$args = wp_parse_args( $args, $defaults );


		if( $args['multiple'] ) {
			$multiple = ' MULTIPLE';
		} else {
			$multiple = '';
		}

		if( $args['chosen'] ) {
			$args['class'] .= ' edd-select-chosen';
		}

		$output = '<select name="' . esc_attr( $args[ 'name' ] ) . '" id="' . esc_attr( sanitize_key( str_replace( '-', '_', $args[ 'id' ] ) ) ) . '" class="edd-select ' . esc_attr( $args[ 'class'] ) . '"' . $multiple . ' ' . esc_attr( $args[ 'disabled'] ) . '>';

		if ( ! empty( $args[ 'options' ] ) ) {
			if ( $args[ 'show_option_all' ] ) {
				if( $args['multiple'] ) {
					$selected = selected( true, in_array( 0, $args['selected'] ), false );
				} else {
					$selected = selected( $args['selected'], 0, false );
				}
				$output .= '<option value="all"' . $selected . '>' . esc_html( $args[ 'show_option_all' ] ) . '</option>';
			}

			if ( $args[ 'show_option_none' ] ) {
				if( $args['multiple'] ) {
					$selected = selected( true, in_array( -1, $args['selected'] ), false );
				} else {
					$selected = selected( $args['selected'], -1, false );
				}
				$output .= '<option value="-1"' . $selected . '>' . esc_html( $args[ 'show_option_none' ] ) . '</option>';
			}

			foreach( $args[ 'options' ] as $key => $option ) {

				if( $args['multiple'] && is_array( $args['selected'] ) ) {
					$selected = selected( true, in_array( $key, $args['selected'] ), false );
				} else {
					$selected = selected( $args['selected'], $key, false );
				}

				$output .= '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option ) . '</option>';
			}
		}

		$output .= '</select>';

		return $output;
	}

	/**
	 * Renders an HTML Checkbox
	 *
	 * @since 1.9
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function checkbox( $args = array() ) {
		$defaults = array(
			'name'     => null,
			'id'       => null,
			'current'  => null,
			'class'    => 'edd-checkbox'
		);

		$args = wp_parse_args( $args, $defaults );

		$output = '<input type="checkbox" name="' . esc_attr( $args[ 'name' ] ) . '" id="' . esc_attr( str_replace( '-', '_', $args[ 'id' ]) ) . '" class="' . $args[ 'class' ] . ' ' . esc_attr( $args[ 'name'] ) . '" ' . checked( 1, $args[ 'current' ], false ) . ' />';

		return $output;
	}
	
	/**
	 * Renders an HTML Text
	 *
	 * @since 1.9
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function text( $args = array() ) {
		$defaults = array(
			'name'     => null,
			'id'       => null,
			'current'  => null,
			'class'    => 'edd-text',
			'size'     => 8,
			'disabled' => null
		);

		$args = wp_parse_args( $args, $defaults );

		$output = '<input type="text" name="' . esc_attr( $args[ 'name' ] ) . '" id="' . esc_attr( str_replace( '-', '_', $args[ 'id' ]) ) . '" class="' . $args[ 'class' ] . ' ' . esc_attr( $args[ 'name'] ) . '" value="' . $args[ 'current' ] . '" size="' . $args[ 'size' ] . '"' . esc_attr( $args[ 'disabled'] ) . ' />';

		return $output;
	}
}
