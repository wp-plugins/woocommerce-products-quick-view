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

class WC_QV_Custom_Template_AddToCart_Button_Settings extends WC_QV_Admin_UI
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
	public $option_name = 'quick_view_template_addtocart_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'quick_view_template_addtocart_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 7;
	
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
				'success_message'	=> __( 'Add to Cart Settings successfully saved.', 'wooquickview' ),
				'error_message'		=> __( 'Error: Add to Cart Settings can not save.', 'wooquickview' ),
				'reset_message'		=> __( 'Add to Cart Settings successfully reseted.', 'wooquickview' ),
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
			'name'				=> 'add-to-cart',
			'label'				=> __( 'Add to Cart', 'wooquickview' ),
			'callback_function'	=> 'wc_qv_custom_template_addtocart_button_settings_form',
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
            	'name' => __( 'Add To Cart Setup', 'wooquickview' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Add To Cart', 'wooquickview' ),
				'id' 		=> 'show_addtocart',
				'class'		=> 'show_addtocart',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wooquickview' ),
				'unchecked_label' 	=> __( 'OFF', 'wooquickview' ),
			),
			
			array(
				'name'		=> __( 'Add To Cart Button / Hyperlink', 'wooquickview' ),
                'type' 		=> 'heading',
				'class'		=> 'show_addtocart_container'
           	),
			array(  
				'name' 		=> __( 'Button or Hyperlink Type', 'wooquickview' ),
				'id' 		=> 'addtocart_button_type',
				'class' 	=> 'addtocart_button_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'button',
				'checked_value'		=> 'button',
				'unchecked_value'	=> 'link',
				'checked_label'		=> __( 'Button', 'wooquickview' ),
				'unchecked_label' 	=> __( 'Hyperlink', 'wooquickview' ),
			),
			array(  
				'name' 		=> __( 'Added To Cart Alignment', 'wooquickview' ),
				'id' 		=> 'addtocart_alignment',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'left',
				'onoff_options' => array(
					array(
						'val' 				=> 'left',
						'text' 				=> __( 'Left', 'wooquickview' ),
						'checked_label'		=> __( 'ON', 'wooquickview') ,
						'unchecked_label' 	=> __( 'OFF', 'wooquickview') ,
					),
					array(
						'val' 				=> 'center',
						'text' 				=> __( 'Center', 'wooquickview' ),
						'checked_label'		=> __( 'ON', 'wooquickview') ,
						'unchecked_label' 	=> __( 'OFF', 'wooquickview') ,
					),
					array(
						'val' 				=> 'right',
						'text' 				=> __( 'Right', 'wooquickview' ),
						'checked_label'		=> __( 'ON', 'wooquickview') ,
						'unchecked_label' 	=> __( 'OFF', 'wooquickview') ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Added To Cart Success Icon', 'wooquickview' ),
				'desc_tip'	=> __( 'Upload a 16px x 16px image, support .jpg, .pgn, .jpeg, .gif formats.', 'wooquickview' ),
				'id' 		=> 'addtocart_success_icon',
				'type' 		=> 'upload',
				'default'	=> WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/addtocart_success.png',
			),
			
			array(
            	'name' 		=> __( 'Add To Cart Hyperlink Styling', 'wooquickview' ),
                'type' 		=> 'heading',
          		'class'		=> 'addtocart_hyperlink_styling_container'
           	),
			array(  
				'name' 		=> __( 'Hyperlink Text', 'wooquickview' ),
				'id' 		=> 'addtocart_link_text',
				'type' 		=> 'text',
				'default'	=> __('Add to cart', 'wooquickview')
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'wooquickview' ),
				'id' 		=> 'addtocart_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#21759B' )
			),
			array(  
				'name' 		=> __( 'Hyperlink Hover Colour', 'wooquickview' ),
				'id' 		=> 'addtocart_link_font_hover_colour',
				'type' 		=> 'color',
				'default'	=> '#D54E21'
			),
			
			array(
            	'name' 		=> __( 'Add To Cart Button Styling', 'wooquickview' ),
                'type' 		=> 'heading',
          		'class' 	=> 'addtocart_button_styling_container'
           	),
			array(  
				'name' 		=> __( 'Button Text', 'wooquickview' ),
				'id' 		=> 'addtocart_button_text',
				'type' 		=> 'text',
				'default'	=> __('Add to cart', 'wooquickview')
			),
			array(  
				'name' 		=> __( 'Background Colour', 'wooquickview' ),
				'desc' 		=> __( 'Default', 'wooquickview' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'wooquickview' ),
				'desc' 		=> __( 'Default', 'wooquickview' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#538bbc'
			),
			
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'wooquickview' ),
				'desc' 		=> __( 'Default', 'wooquickview' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Button Font', 'wooquickview' ),
				'id' 		=> 'addtocart_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#FFFFFF' )
			),
			array(  
				'name' 		=> __( 'Button Border', 'wooquickview' ),
				'id' 		=> 'addtocart_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#476381', 'corner' => 'rounded' , 'top_left_corner' => 3 , 'top_right_corner' => 3 , 'bottom_left_corner' => 3 , 'bottom_right_corner' => 3 ),
			),
			array(  
				'name' => __( 'Button Shadow', 'wooquickview' ),
				'id' 		=> 'addtocart_button_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' )
			),
			array(  
				'name' 		=> __( 'Border Margin (Outside)', 'wooquickview' ),
				'id' 		=> 'addtocart_button_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'addtocart_button_margin_top',
	 										'name' 		=> __( 'Top', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
									array(  'id' 		=> 'addtocart_button_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
	 								array(  'id' 		=> 'addtocart_button_margin_left',
	 										'name' 		=> __( 'Left', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
									array(  'id' 		=> 'addtocart_button_margin_right',
	 										'name' 		=> __( 'Right', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Border Padding (Inside)', 'wooquickview' ),
				'desc' 		=> __( 'Padding from Button text to Button border', 'wooquickview' ),
				'id' 		=> 'addtocart_button_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'addtocart_button_padding_top',
	 										'name' 		=> __( 'Top', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
									array(  'id' 		=> 'addtocart_button_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
	 								array(  'id' 		=> 'addtocart_button_padding_left',
	 										'name' 		=> __( 'Left', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
									array(  'id' 		=> 'addtocart_button_padding_right',
	 										'name' 		=> __( 'Right', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
	 							)
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.addtocart_button_type:checked").val() == 'button') {
		$(".addtocart_button_styling_container").slideDown();
		$(".addtocart_hyperlink_styling_container").slideUp();
		//$(".addtocart_button_styling_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		//$(".addtocart_hyperlink_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".addtocart_button_styling_container").slideUp();
		$(".addtocart_hyperlink_styling_container").slideDown();
		//$(".addtocart_button_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		//$(".addtocart_hyperlink_styling_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	
	if ( $("input.show_addtocart:checked").val() == '1') {
		$(".show_addtocart_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".show_addtocart_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".addtocart_button_styling_container").slideUp();
		$(".addtocart_hyperlink_styling_container").slideUp();
	}
		
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.addtocart_button_type', function( event, value, status ) {
		//$(".addtocart_button_styling_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		//$(".addtocart_hyperlink_styling_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true') {
			$(".addtocart_button_styling_container").slideDown();
			$(".addtocart_hyperlink_styling_container").slideUp();
		} else {
			$(".addtocart_button_styling_container").slideUp();
			$(".addtocart_hyperlink_styling_container").slideDown();
		}
	});
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_addtocart', function( event, value, status ) {
		$(".show_addtocart_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".show_addtocart_container").slideDown();
			if ( $("input.addtocart_button_type:checked").val() == 'button') {
				$(".addtocart_button_styling_container").slideDown();
			} else {
				$(".addtocart_hyperlink_styling_container").slideDown();
			}
		} else {
			$(".show_addtocart_container").slideUp();
			$(".addtocart_button_styling_container").slideUp();
			$(".addtocart_hyperlink_styling_container").slideUp()
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $wc_qv_custom_template_addtocart_button_settings;
$wc_qv_custom_template_addtocart_button_settings = new WC_QV_Custom_Template_AddToCart_Button_Settings();

/** 
 * wc_qv_custom_template_addtocart_button_settings_form()
 * Define the callback function to show subtab content
 */
function wc_qv_custom_template_addtocart_button_settings_form() {
	global $wc_qv_custom_template_addtocart_button_settings;
	$wc_qv_custom_template_addtocart_button_settings->settings_form();
}

?>
