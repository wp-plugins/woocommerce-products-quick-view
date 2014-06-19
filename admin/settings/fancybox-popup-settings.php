<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Quick View Fancybox Popup Settings

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

class WC_QV_Fancybox_Popup_Settings extends WC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'popup-style';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = '';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_quick_view_fancybox_popup_settings';
	
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
				'success_message'	=> __( 'Fancy Box Pop Up Settings successfully saved.', 'wooquickview' ),
				'error_message'		=> __( 'Error: Fancy Box Pop Up Settings can not save.', 'wooquickview' ),
				'reset_message'		=> __( 'Fancy Box Pop Up Settings successfully reseted.', 'wooquickview' ),
			);
			
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
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
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
			'name'				=> 'fancybox-pop-up',
			'label'				=> __( 'Fancy Box Pop Up', 'wooquickview' ),
			'callback_function'	=> 'wc_qv_fancybox_popup_settings_form',
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
            	'name' 		=> __( 'Fancy Box Pop Up', 'wooquickview' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Pop-up Maximum Width', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_popup_width',
				'desc'		=> 'px',
				'type' 		=> 'slider',
				'default'	=> 600,
				'min'		=> 520,
				'max'		=> 800,
				'increment'	=> 10
			),
			array(  
				'name' 		=> __( 'Pop-up Maximum Height', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_popup_height',
				'desc'		=> 'px',
				'type' 		=> 'slider',
				'default'	=> 460,
				'min'		=> 300,
				'max'		=> 500,
				'increment'	=> 10
			),
			array(  
				'name' 		=> __( "Fix Position on Scroll", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_center_on_scroll',
				'type' 		=> 'onoff_radio',
				'default'	=> 'true',
				'onoff_options' => array(
					array(
						'val' 				=> 'true',
						'text'				=> __( 'Pop-up stays centered in screen while page scrolls behind it.', 'wooquickview' ) ,
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					),
					
					array(
						'val' 				=> 'false',
						'text' 				=> __( 'Pop-up scrolls up and down with the page.', 'wooquickview' ) ,
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					) 
				),
			),
			array(  
				'name' 		=> __( 'Open Transition Effect', 'wooquickview' ),
				'desc' 		=> __( "Choose a pop-up opening effect. Default - None.", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_transition_in',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'wooquickview' ) ,	
						'fade'			=> __( 'Fade', 'wooquickview' ) ,	
						'elastic'		=> __( 'Elastic', 'wooquickview' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Close Transistion Effect', 'wooquickview' ),
				'desc' 		=> __( "Choose a pop-up closing effect. Default - None.", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_transition_out',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'wooquickview' ) ,	
						'fade'			=> __( 'Fade', 'wooquickview' ) ,	
						'elastic'		=> __( 'Elastic', 'wooquickview' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Opening Speed', 'wooquickview' ),
				'desc' 		=> __( 'Milliseconds when open popup', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_speed_in',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '300'
			),
			array(  
				'name' 		=> __( 'Closing Speed', 'wooquickview' ),
				'desc' 		=> __( 'Milliseconds when close popup', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_speed_out',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '0'
			),
			array(  
				'name' 		=> __( 'Background Overlay Colour', 'wooquickview' ),
				'desc' 		=> __( 'Select a colour or empty for no colour.', 'wooquickview' ). ' ' . __( 'Default', 'wooquickview' ). ' [default_value]',
				'id' 		=> 'quick_view_ultimate_fancybox_overlay_color',
				'type' 		=> 'color',
				'default'	=> '#666666'
			),
			
        ));
	}
}

global $wc_qv_fancybox_popup_settings;
$wc_qv_fancybox_popup_settings = new WC_QV_Fancybox_Popup_Settings();

/** 
 * wc_qv_fancybox_popup_settings_form()
 * Define the callback function to show subtab content
 */
function wc_qv_fancybox_popup_settings_form() {
	global $wc_qv_fancybox_popup_settings;
	$wc_qv_fancybox_popup_settings->settings_form();
}

?>
