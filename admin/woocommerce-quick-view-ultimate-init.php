<?php
/**
 * Register Activation Hook
 */
update_option('wc_quick_view_ultimate_plugin', 'wc_quick_view_ultimate');
function wc_quick_view_ultimate_install(){
	global $wpdb;
	//global $wp_rewrite;
	WC_Quick_View_Ultimate_Settings::set_setting();
	update_option('wc_quick_view_ultimate_version', '1.0.0');
	update_option('wc_quick_view_ultimate_plugin', 'wc_quick_view_ultimate');
	//$wp_rewrite->flush_rules();
	update_option('wc_quick_view_ultimate_just_installed', true);
}

function quick_view_ultimate_init() {
	if ( get_option('wc_quick_view_ultimate_just_installed') ) {
		delete_option('wc_quick_view_ultimate_just_installed');
		wp_redirect( admin_url( 'admin.php?page=woocommerce_settings&tab=wc_quick_view_ultimate_settings', 'relative' ) );
		exit;
	}
	load_plugin_textdomain( 'wooquickview', false, WC_QUICK_VIEW_ULTIMATE_FOLDER.'/languages' );
}

// Add language
add_action('init', 'quick_view_ultimate_init');

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Quick_View_Ultimate', 'plugin_extra_links'), 10, 2 );

global $wc_quick_view_ultimate;
$GLOBALS['wc_quick_view_ultimate_ultimate_settings'] = new WC_Quick_View_Ultimate_Settings();
$GLOBALS['wc_quick_view_ultimate_ultimate'] = new WC_Quick_View_Ultimate();

update_option('wc_quick_view_ultimate_version', '1.0.0');

?>