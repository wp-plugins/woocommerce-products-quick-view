<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Quick View Custom Template Dynamic Gallery Style Settings

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

class WC_QV_Custom_Template_Gallery_Style_Settings extends WC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'gallery-settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'quick_view_template_gallery_style_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'quick_view_template_gallery_style_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
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
				'success_message'	=> __( 'Gallery Style successfully saved.', 'wooquickview' ),
				'error_message'		=> __( 'Error: Gallery Style can not save.', 'wooquickview' ),
				'reset_message'		=> __( 'Gallery Style successfully reseted.', 'wooquickview' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
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
			'name'				=> 'gallery-style',
			'label'				=> __( 'Gallery Style', 'wooquickview' ),
			'callback_function'	=> 'wc_qv_custom_template_gallery_style_settings_form',
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
		
			array(	'name' => __('Gallery Dimensions', 'wooquickview'), 'type' => 'heading'),
			array(  
				'name' 		=> __( 'Gallery height', 'wooquickview' ),
				'desc'		=> 'px',
				'id' 		=> 'product_gallery_height',
				'type' 		=> 'text',
				'default'	=> 300,
				'css' 		=> 'width:40px;',
			),
			
			array(	
				'name' => __('Gallery Special Effects', 'wooquickview'), 
				'type' => 'heading'
			),
			array(  
				'name' => __( 'Auto start', 'wooquickview' ),
				'desc' 		=> '',
				'id' 		=> 'product_gallery_auto_start',
				'default'	=> 'true',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'true',
				'unchecked_value'	=> 'false',
				'checked_label'		=> __( 'YES', 'wooquickview' ),
				'unchecked_label' 	=> __( 'NO', 'wooquickview' ),
			),
			array(  
				'name' => __( 'Slide transition effect', 'wooquickview' ),
				'desc' 		=> '',
				'id' 		=> 'product_gallery_effect',
				'css' 		=> 'width:120px;',
				'default'	=> 'slide-hori',
				'type' 		=> 'select',
				'options' => array( 
					'none'  			=> __( 'None', 'wooquickview' ),
					'fade'				=> __( 'Fade', 'wooquickview' ),
					'slide-hori'		=> __( 'Slide Hori', 'wooquickview' ),
					'slide-vert'		=> __( 'Slide Vert', 'wooquickview' ),
					'resize'			=> __( 'Resize', 'wooquickview' ),
				),
			),
			array(  
				'name' => __( 'Time between transitions', 'wooquickview' ),
				'desc' 		=> 'seconds',
				'id' 		=> 'product_gallery_speed',
				'type' 		=> 'slider',
				'default'	=> 5,
				'min'		=> 1,
				'max'		=> 10,
				'increment'	=> 1,
			),
			array(  
				'name' => __( 'Transition effect speed', 'wooquickview' ),
				'desc' 		=> 'seconds',
				'id' 		=> 'product_gallery_animation_speed',
				'type' 		=> 'slider',
				'default'	=> 2,
				'min'		=> 1,
				'max'		=> 10,
				'increment'	=> 1,
			),
			
			array(  
				'name' 		=> __( 'Single Image Transition', 'wooquickview' ),
				'desc' 		=> __( 'YES to auto deactivate image transition effect when only 1 image is loaded to gallery.', 'wooquickview' ),
				'id' 		=> 'stop_scroll_1image',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'YES', 'wooquickview' ),
				'unchecked_label' 	=> __( 'NO', 'wooquickview' ),
			),
			
			array(	'name' => __('Gallery Style', 'wooquickview'), 'type' => 'heading'),
			array(  
				'name' 		=> __( 'Gallery Margin', 'wooquickview' ),
				'id' 		=> 'gallery_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'gallery_margin_top',
	 										'name' 		=> __( 'Top', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 
	 								array(  'id' 		=> 'gallery_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'gallery_margin_left',
	 										'name' 		=> __( 'Left', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'gallery_margin_right',
	 										'name' 		=> __( 'Right', 'wooquickview' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			array(  
				'name' => __( 'Image background colour', 'wooquickview' ),
				'desc' 		=> __( 'Gallery image background colour. Default <code>#FFFFFF</code>.', 'wooquickview' ),
				'id' 		=> 'bg_image_wrapper',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Border colour', 'wooquickview' ),
				'desc' 		=> __( 'Gallery border colour. Default <code>#CCCCCC</code>.', 'wooquickview' ),
				'id' 		=> 'border_image_wrapper_color',
				'type' 		=> 'color',
				'default'	=> '#CCCCCC'
			),
			
			array(	'name' => __('Caption text', 'wooquickview'), 'type' => 'heading'),
			array(  
				'name' 		=> __( 'Font', 'wooquickview' ),
				'id' 		=> 'caption_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#FFFFFF' )
			),
			array(  
				'name' => __( 'Background', 'wooquickview' ),
				'desc' 		=> __( 'Caption text background colour. Default [default_value]', 'wooquickview' ),
				'id' 		=> 'product_gallery_bg_des',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
			
			array(	'name' => __('Nav Bar', 'wooquickview'), 'type' => 'heading'),
			array(  
				'name' 		=> __( 'Control', 'wooquickview' ),
				'desc' 		=> __( 'YES to enable Nav bar Control', 'wooquickview' ),
				'class'		=> 'gallery_nav_control',
				'id' 		=> 'product_gallery_nav',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'YES', 'wooquickview' ),
				'unchecked_label' 	=> __( 'NO', 'wooquickview' ),
			),
			
			array(
				'type' 		=> 'heading',
				'class'		=> 'nav_bar_container',
			),
			array(  
				'name' 		=> __( 'Font', 'wooquickview' ),
				'id' 		=> 'navbar_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			array(  
				'name' => __( 'Background', 'wooquickview' ),
				'desc' 		=> __( 'Nav bar background colour. Default [default_value].', 'wooquickview' ),
				'id' 		=> 'bg_nav_color',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' 		=> __( 'Container height', 'wooquickview' ),
				'desc'		=> 'px',
				'id' 		=> 'navbar_height',
				'type' 		=> 'text',
				'default'	=> 25,
				'css' 		=> 'width:40px;',
			),
			
			array(
            	'name' 		=> __('Lazy-load scroll', 'wooquickview'),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Control', 'wooquickview' ),
				'desc' 		=> __( 'YES to enable lazy-load scroll', 'wooquickview' ),
				'class'		=> 'lazy_load_control',
				'id' 		=> 'lazy_load_scroll',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'YES', 'wooquickview' ),
				'unchecked_label' 	=> __( 'NO', 'wooquickview' ),
			),
			
			array(
				'type' 		=> 'heading',
				'class'		=> 'lazy_load_container',
			),
			array(  
				'name' => __( 'Colour', 'wooquickview' ),
				'desc' 		=> __( 'Scroll bar colour. Default [default_value].', 'wooquickview' ),
				'id' 		=> 'transition_scroll_bar',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
		
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.gallery_nav_control:checked").val() == 'yes') {
		$('.nav_bar_container').css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$('.nav_bar_container').css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	if ( $("input.lazy_load_control:checked").val() == 'yes') {
		$(".lazy_load_container").show();
	} else {
		$(".lazy_load_container").hide();
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.gallery_nav_control', function( event, value, status ) {
		$('.nav_bar_container').hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".nav_bar_container").slideDown();
		} else {
			$(".nav_bar_container").slideUp();
		}
	});
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.lazy_load_control', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".lazy_load_container").slideDown();
		} else {
			$(".lazy_load_container").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
	
}

global $wc_qv_custom_template_gallery_style_settings;
$wc_qv_custom_template_gallery_style_settings = new WC_QV_Custom_Template_Gallery_Style_Settings();

/** 
 * wc_qv_custom_template_gallery_style_settings_form()
 * Define the callback function to show subtab content
 */
function wc_qv_custom_template_gallery_style_settings_form() {
	global $wc_qv_custom_template_gallery_style_settings;
	$wc_qv_custom_template_gallery_style_settings->settings_form();
}

?>
