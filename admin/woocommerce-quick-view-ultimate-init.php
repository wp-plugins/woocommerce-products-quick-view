<?php
/**
 * Register Activation Hook
 */
update_option('wc_quick_view_ultimate_plugin', 'wc_quick_view_ultimate');
function wc_quick_view_ultimate_install(){
	global $wpdb;
	//global $wp_rewrite;

	// Set Settings Default from Admin Init
	global $wc_qv_admin_init;
	$wc_qv_admin_init->set_default_settings();

	update_option('wc_quick_view_ultimate_version', '1.2.1');
	update_option('wc_quick_view_lite_version', '1.2.1');
	update_option('wc_quick_view_ultimate_plugin', 'wc_quick_view_ultimate');
	//$wp_rewrite->flush_rules();
	update_option('wc_quick_view_ultimate_just_installed', true);
}

function quick_view_ultimate_init() {
	if ( get_option('wc_quick_view_ultimate_just_installed') ) {
		delete_option('wc_quick_view_ultimate_just_installed');
		wp_redirect( admin_url( 'admin.php?page=wc-quick-view', 'relative' ) );
		exit;
	}
	load_plugin_textdomain( 'wooquickview', false, WC_QUICK_VIEW_ULTIMATE_FOLDER.'/languages' );
}

// Add language
add_action('init', 'quick_view_ultimate_init');

// Add custom style to dashboard
add_action( 'admin_enqueue_scripts', array( 'WC_Quick_View_Ultimate', 'a3_wp_admin' ) );

// Add admin sidebar menu css
add_action( 'admin_enqueue_scripts', array( 'WC_Quick_View_Ultimate', 'admin_sidebar_menu_css' ) );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Quick_View_Ultimate', 'plugin_extra_links'), 10, 2 );

global $wc_qv_admin_init;
$wc_qv_admin_init->init();

global $wc_quick_view_ultimate;
$GLOBALS['wc_quick_view_ultimate_ultimate'] = new WC_Quick_View_Ultimate();

// Check upgrade functions
add_action('plugins_loaded', 'wc_quick_view_lite_upgrade_plugin');
function wc_quick_view_lite_upgrade_plugin () {

	// Upgrade to 1.0.2
	if ( version_compare(get_option('wc_quick_view_ultimate_version'), '1.0.2' ) === -1) {
		$quick_view_ultimate_on_hover_bt_border_width = get_option( 'quick_view_ultimate_on_hover_bt_border_width' );
		$quick_view_ultimate_on_hover_bt_border_style = get_option( 'quick_view_ultimate_on_hover_bt_border_style' );
		$quick_view_ultimate_on_hover_bt_border_color = get_option( 'quick_view_ultimate_on_hover_bt_border_color' );
		$quick_view_ultimate_on_hover_bt_rounded = get_option( 'quick_view_ultimate_on_hover_bt_rounded' );
		$quick_view_ultimate_on_hover_bt = array(
			'width' 	=> $quick_view_ultimate_on_hover_bt_border_width . 'px',
			'style'		=> $quick_view_ultimate_on_hover_bt_border_style,
			'color'		=> $quick_view_ultimate_on_hover_bt_border_color,
			'corner'	=> ( $quick_view_ultimate_on_hover_bt_rounded > 0) ? 'rounded' : 'square',
			'rounded_value' => $quick_view_ultimate_on_hover_bt_rounded
		);
		update_option( 'quick_view_ultimate_on_hover_bt_border', $quick_view_ultimate_on_hover_bt );

		$quick_view_ultimate_on_hover_bt_font_family = get_option( 'quick_view_ultimate_on_hover_bt_font_family' );
		$quick_view_ultimate_on_hover_bt_font_size = get_option( 'quick_view_ultimate_on_hover_bt_font_size' );
		$quick_view_ultimate_on_hover_bt_font_style = get_option( 'quick_view_ultimate_on_hover_bt_font_style' );
		$quick_view_ultimate_on_hover_bt_font_color = get_option( 'quick_view_ultimate_on_hover_bt_font_color' );
		$quick_view_ultimate_on_hover_bt_font = array(
			'size' 		=> $quick_view_ultimate_on_hover_bt_font_size . 'px',
			'face'		=> $quick_view_ultimate_on_hover_bt_font_family,
			'style'		=> $quick_view_ultimate_on_hover_bt_font_style,
			'color' 	=> $quick_view_ultimate_on_hover_bt_font_color
		);
		update_option( 'quick_view_ultimate_on_hover_bt_font', $quick_view_ultimate_on_hover_bt_font );

		$quick_view_ultimate_on_hover_bt_enable_shadow = get_option( 'quick_view_ultimate_on_hover_bt_enable_shadow' );
		$quick_view_ultimate_on_hover_bt_shadow_color = get_option( 'quick_view_ultimate_on_hover_bt_shadow_color' );
		$quick_view_ultimate_on_hover_bt_shadow = array(
			'enable'	=> ( $quick_view_ultimate_on_hover_bt_enable_shadow == 'yes' ) ? 1 : 0,
			'h_shadow'	=> '0px',
			'v_shadow'	=> '0px',
			'blur' 		=> '30px',
			'spread'	=> '0px',
			'color'		=> $quick_view_ultimate_on_hover_bt_shadow_color,
			'inset'		=> '',

		);
		update_option( 'quick_view_ultimate_on_hover_bt_shadow', $quick_view_ultimate_on_hover_bt_shadow );

		$quick_view_ultimate_on_hover_bt_transparent = get_option( 'quick_view_ultimate_on_hover_bt_transparent' );
		$quick_view_ultimate_on_hover_bt_transparent = $quick_view_ultimate_on_hover_bt_transparent * 10;
		update_option( 'quick_view_ultimate_on_hover_bt_transparent', $quick_view_ultimate_on_hover_bt_transparent );

		$quick_view_ultimate_under_image_link_font_family = get_option( 'quick_view_ultimate_under_image_link_font_family' );
		$quick_view_ultimate_under_image_link_font_size = get_option( 'quick_view_ultimate_under_image_link_font_size' );
		$quick_view_ultimate_under_image_link_font_style = get_option( 'quick_view_ultimate_under_image_link_font_style' );
		$quick_view_ultimate_under_image_link_font_color = get_option( 'quick_view_ultimate_under_image_link_font_color' );
		$quick_view_ultimate_under_image_link_font = array(
			'size' 		=> $quick_view_ultimate_under_image_link_font_size . 'px',
			'face'		=> $quick_view_ultimate_under_image_link_font_family,
			'style'		=> $quick_view_ultimate_under_image_link_font_style,
			'color' 	=> $quick_view_ultimate_under_image_link_font_color
		);
		update_option( 'quick_view_ultimate_under_image_link_font', $quick_view_ultimate_under_image_link_font );

		$quick_view_ultimate_under_image_bt_border_width = get_option( 'quick_view_ultimate_under_image_bt_border_width' );
		$quick_view_ultimate_under_image_bt_border_style = get_option( 'quick_view_ultimate_under_image_bt_border_style' );
		$quick_view_ultimate_under_image_bt_border_color = get_option( 'quick_view_ultimate_under_image_bt_border_color' );
		$quick_view_ultimate_under_image_bt_rounded = get_option( 'quick_view_ultimate_under_image_bt_rounded' );
		$quick_view_ultimate_under_image_bt_border = array(
			'width' 	=> $quick_view_ultimate_under_image_bt_border_width . 'px',
			'style'		=> $quick_view_ultimate_under_image_bt_border_style,
			'color'		=> $quick_view_ultimate_under_image_bt_border_color,
			'corner'	=> ( $quick_view_ultimate_under_image_bt_rounded > 0) ? 'rounded' : 'square',
			'rounded_value' => $quick_view_ultimate_under_image_bt_rounded
		);
		update_option( 'quick_view_ultimate_under_image_bt_border', $quick_view_ultimate_under_image_bt_border );

		$quick_view_ultimate_under_image_bt_font_family = get_option( 'quick_view_ultimate_under_image_bt_font_family' );
		$quick_view_ultimate_under_image_bt_font_size = get_option( 'quick_view_ultimate_under_image_bt_font_size' );
		$quick_view_ultimate_under_image_bt_font_style = get_option( 'quick_view_ultimate_under_image_bt_font_style' );
		$quick_view_ultimate_under_image_bt_font_color = get_option( 'quick_view_ultimate_under_image_bt_font_color' );
		$quick_view_ultimate_under_image_bt_font = array(
			'size' 		=> $quick_view_ultimate_under_image_bt_font_size . 'px',
			'face'		=> $quick_view_ultimate_under_image_bt_font_family,
			'style'		=> $quick_view_ultimate_under_image_bt_font_style,
			'color' 	=> $quick_view_ultimate_under_image_bt_font_color
		);
		update_option( 'quick_view_ultimate_under_image_bt_font', $quick_view_ultimate_under_image_bt_font );

		update_option('wc_quick_view_ultimate_version', '1.0.2');
	}

	update_option('wc_quick_view_ultimate_version', '1.2.1');
	update_option('wc_quick_view_lite_version', '1.2.1');

}
?>
