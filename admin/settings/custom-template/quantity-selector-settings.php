<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Quick View Custom Template Add To Cart Button Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_QV_Custom_Template_Quantity_Selector_Settings extends WC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-data';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'quick_view_template_quantity_selector_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'quick_view_template_quantity_selector_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 6;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Quantity Selector Settings successfully saved.', 'wooquickview' ),
				'error_message'		=> __( 'Error: Quantity Selector Settings can not save.', 'wooquickview' ),
				'reset_message'		=> __( 'Quantity Selector Settings successfully reseted.', 'wooquickview' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'quantity-selector',
			'label'				=> __( 'Quantity Selector', 'wooquickview' ),
			'callback_function'	=> 'wc_qv_custom_template_quantity_selector_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_qv_admin_interface;
		
		$output = '';
		$output .= $wc_qv_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			
			array(
            	'name' => __( 'Quantity Selector Setup', 'wooquickview' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Quantity Selector', 'wooquickview' ),
				'id' 		=> 'show_quantity_selector',
				'class'		=> 'show_quantity_selector',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wooquickview' ),
				'unchecked_label' 	=> __( 'OFF', 'wooquickview' ),
			),
			
			array(
				'name'		=> __( 'Quantity Selector Container', 'wooquickview' ),
                'type' 		=> 'heading',
				'class'		=> 'show_quantity_selector_container'
           	),
			array(  
				'name' 		=> __( 'Container Background Colour', 'wooquickview' ),
				'desc' 		=> __( 'Default', 'wooquickview' ) . ' [default_value]',
				'id' 		=> 'quantity_selector_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#DDDDDD'
			),
			array(  
				'name' 		=> __( 'Container Border', 'wooquickview' ),
				'id' 		=> 'quantity_selector_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#666666', 'corner' => 'rounded' , 'top_left_corner' => 3 , 'top_right_corner' => 3 , 'bottom_left_corner' => 3 , 'bottom_right_corner' => 3 ),
			),
			array(  
				'name' 		=> __( 'Container Shadow', 'wooquickview' ),
				'id' 		=> 'quantity_selector_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' )
			),
			array(  
				'name' 		=> __( 'Container Border Margin (Outside)', 'wooquickview' ),
				'id' 		=> 'quantity_selector_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'quantity_selector_margin_top',
	 										'name' 		=> __( 'Top', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
									array(  'id' 		=> 'quantity_selector_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
	 								array(  'id' 		=> 'quantity_selector_margin_left',
	 										'name' 		=> __( 'Left', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
									array(  'id' 		=> 'quantity_selector_margin_right',
	 										'name' 		=> __( 'Right', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
	 							)
			),
			
			array(
				'name'		=> __( 'Quantity Input', 'wooquickview' ),
                'type' 		=> 'heading',
				'class'		=> 'show_quantity_selector_container'
           	),
			array(  
				'name' 		=> __( 'Quantity Input Font', 'wooquickview' ),
				'id' 		=> 'quantity_input_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '16px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Quantity Input Padding (Inside)', 'wooquickview' ),
				'id' 		=> 'quantity_input_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'quantity_input_padding_top',
	 										'name' 		=> __( 'Top', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
									array(  'id' 		=> 'quantity_input_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
	 								array(  'id' 		=> 'quantity_input_padding_left',
	 										'name' 		=> __( 'Left', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
									array(  'id' 		=> 'quantity_input_padding_right',
	 										'name' 		=> __( 'Right', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
	 							)
			),
			
			array(
				'name'		=> __( 'Quantity Plus / Minus', 'wooquickview' ),
                'type' 		=> 'heading',
				'class'		=> 'show_quantity_selector_container'
           	),
			array(  
				'name' 		=> __( 'Quantity Plus / Minus Font', 'wooquickview' ),
				'id' 		=> 'quantity_plus_minus_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '11px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Background Colour', 'wooquickview' ),
				'desc' 		=> __( 'Default', 'wooquickview' ) . ' [default_value]',
				'id' 		=> 'quantity_plus_minus_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#DDDDDD'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'wooquickview' ),
				'desc' 		=> __( 'Default', 'wooquickview' ) . ' [default_value]',
				'id' 		=> 'quantity_plus_minus_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'wooquickview' ),
				'desc' 		=> __( 'Default', 'wooquickview' ) . ' [default_value]',
				'id' 		=> 'quantity_plus_minus_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#999999'
			),
			array(  
				'name' 		=> __( 'Quantity Plus / Minus Padding (Inside)', 'wooquickview' ),
				'id' 		=> 'quantity_plus_minus_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'quantity_plus_minus_padding_top',
	 										'name' 		=> __( 'Top', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
									array(  'id' 		=> 'quantity_plus_minus_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
	 								array(  'id' 		=> 'quantity_plus_minus_padding_left',
	 										'name' 		=> __( 'Left', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '2' ),
									array(  'id' 		=> 'quantity_plus_minus_padding_right',
	 										'name' 		=> __( 'Right', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '2' ),
	 							)
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	
	if ( $("input.show_quantity_selector:checked").val() == '1') {
		$(".show_quantity_selector_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".show_quantity_selector_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_quantity_selector', function( event, value, status ) {
		$(".show_quantity_selector_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".show_quantity_selector_container").slideDown();
		} else {
			$(".show_quantity_selector_container").slideUp();
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $wc_qv_custom_template_quantity_selector_settings;
$wc_qv_custom_template_quantity_selector_settings = new WC_QV_Custom_Template_Quantity_Selector_Settings();

/** 
 * wc_qv_custom_template_quantity_selector_settings_form()
 * Define the callback function to show subtab content
 */
function wc_qv_custom_template_quantity_selector_settings_form() {
	global $wc_qv_custom_template_quantity_selector_settings;
	$wc_qv_custom_template_quantity_selector_settings->settings_form();
}

?>