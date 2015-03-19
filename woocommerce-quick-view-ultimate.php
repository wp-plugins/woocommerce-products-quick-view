<?php
/*
Plugin Name: WooCommerce Products Quick View
Description: This plugin adds the ultimate Quick View feature to your Shop page, Product category and Product tags listings. Opens the full pages content - add to cart and even view cart without leaving the page.
Version: 1.2.1
Author: A3 Revolution
Author URI: http://www.a3rev.com/
License: This software is under commercial license and copyright to A3 Revolution Software Development team

	WooCommerce Quick View. Plugin for the WooCommerce.
	Copyright© 2011 A3 Revolution Software Development team

	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define('WC_QUICK_VIEW_ULTIMATE_FILE_PATH', dirname(__FILE__));
define('WC_QUICK_VIEW_ULTIMATE_DIR_NAME', basename(WC_QUICK_VIEW_ULTIMATE_FILE_PATH));
define('WC_QUICK_VIEW_ULTIMATE_FOLDER', dirname(plugin_basename(__FILE__)));
define('WC_QUICK_VIEW_ULTIMATE_URL', untrailingslashit(plugins_url('/', __FILE__)));
define('WC_QUICK_VIEW_ULTIMATE_DIR', WP_PLUGIN_DIR . '/' . WC_QUICK_VIEW_ULTIMATE_FOLDER);
define('WC_QUICK_VIEW_ULTIMATE_NAME', plugin_basename(__FILE__));
define('WC_QUICK_VIEW_ULTIMATE_TEMPLATE_PATH', WC_QUICK_VIEW_ULTIMATE_FILE_PATH . '/templates');
define('WC_QUICK_VIEW_ULTIMATE_IMAGES_URL', WC_QUICK_VIEW_ULTIMATE_URL . '/assets/images');
define('WC_QUICK_VIEW_ULTIMATE_JS_URL', WC_QUICK_VIEW_ULTIMATE_URL . '/assets/js');
define('WC_QUICK_VIEW_ULTIMATE_CSS_URL', WC_QUICK_VIEW_ULTIMATE_URL . '/assets/css');
define('WC_QUICK_VIEW_ULTIMATE_WP_TESTED', '4.1.1');
if (!defined("WC_QUICK_VIEW_ULTIMATE_AUTHOR_URI")) define("WC_QUICK_VIEW_ULTIMATE_AUTHOR_URI", "http://a3rev.com/shop/woocommerce-quick-view-ultimate/");

if (!defined("WC_QUICK_VIEW_ULTIMATE_DOCS_URI")) define("WC_QUICK_VIEW_ULTIMATE_DOCS_URI", "http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce-quick-view-ultimate/");

include ('admin/admin-ui.php');
include ('admin/admin-interface.php');

include ('admin/admin-pages/admin-quick-view-page.php');
include ('admin/admin-pages/admin-custom-template-page.php');

include ('admin/admin-init.php');

include 'classes/class-woocommerce-quick-view-ultimate-style.php';
include 'classes/class-woocommerce-quick-view-ultimate.php';

include 'admin/woocommerce-quick-view-ultimate-init.php';

/**
 * Call when the plugin is activated and deactivated
 */
register_activation_hook(__FILE__, 'wc_quick_view_ultimate_install');
function wc_quick_view_lite_uninstall()
{
    if (get_option('quick_view_lite_clean_on_deletion') == 1) {

        // Delete global settings
        delete_option('quick_view_ultimate_enable');
        delete_option('quick_view_ultimate_type');
        delete_option('quick_view_ultimate_popup_tool');
        delete_option('quick_view_ultimate_popup_content');

        // Delete Button Show On Hover
        delete_option('quick_view_ultimate_on_hover_bt_text');
        delete_option('quick_view_ultimate_on_hover_bt_alink');
        delete_option('quick_view_ultimate_on_hover_bt_padding_tb');
        delete_option('quick_view_ultimate_on_hover_bt_padding_lr');
        delete_option('quick_view_ultimate_on_hover_bt_bg');
        delete_option('quick_view_ultimate_on_hover_bt_bg_from');
        delete_option('quick_view_ultimate_on_hover_bt_bg_to');
        delete_option('quick_view_ultimate_on_hover_bt_border');
        delete_option('quick_view_ultimate_on_hover_bt_font');
        delete_option('quick_view_ultimate_on_hover_bt_shadow');
        delete_option('quick_view_ultimate_on_hover_bt_transparent');

        // Delete Button/Hyperlink Show under Image
        delete_option('quick_view_ultimate_under_image_bt_type');
        delete_option('quick_view_ultimate_under_image_bt_alink');
        delete_option('quick_view_ultimate_under_image_link_text');
        delete_option('quick_view_ultimate_under_image_link_font');
        delete_option('quick_view_ultimate_under_image_link_font_hover_color');
        delete_option('quick_view_ultimate_under_image_bt_text');
        delete_option('quick_view_ultimate_under_image_bt_padding_tb');
        delete_option('quick_view_ultimate_under_image_bt_padding_lr');
        delete_option('quick_view_ultimate_under_image_bt_bg');
        delete_option('quick_view_ultimate_under_image_bt_bg_from');
        delete_option('quick_view_ultimate_under_image_bt_bg_to');
        delete_option('quick_view_ultimate_under_image_bt_border');
        delete_option('quick_view_ultimate_under_image_bt_font');
        delete_option('quick_view_ultimate_under_image_bt_margin');
        delete_option('quick_view_ultimate_under_image_bt_class');

        // Delete Fancy Box Pop Up Settings
        delete_option('quick_view_ultimate_fancybox_popup_width');
        delete_option('quick_view_ultimate_fancybox_popup_height');
        delete_option('quick_view_ultimate_fancybox_center_on_scroll');
        delete_option('quick_view_ultimate_fancybox_transition_in');
        delete_option('quick_view_ultimate_fancybox_transition_out');
        delete_option('quick_view_ultimate_fancybox_speed_in');
        delete_option('quick_view_ultimate_fancybox_speed_out');
        delete_option('quick_view_ultimate_fancybox_overlay_color');

        // Delete Colour Box Pop Up Settings
        delete_option('quick_view_ultimate_colorbox_popup_width');
        delete_option('quick_view_ultimate_colorbox_popup_height');
        delete_option('quick_view_ultimate_colorbox_center_on_scroll');
        delete_option('quick_view_ultimate_colorbox_transition');
        delete_option('quick_view_ultimate_colorbox_speed');
        delete_option('quick_view_ultimate_colorbox_overlay_color');

        delete_option('quick_view_template_addtocart_settings');
        delete_option('quick_view_template_control_settings');
        delete_option('quick_view_template_gallery_style_settings');
        delete_option('quick_view_template_global_settings');
        delete_option('quick_view_template_product_description_settings');
        delete_option('quick_view_template_product_meta_settings');
        delete_option('quick_view_template_product_price_settings');
        delete_option('quick_view_template_product_rating_settings');
        delete_option('quick_view_template_product_title_settings');
        delete_option('quick_view_template_gallery_thumbnails_settings');
        delete_option('quick_view_template_quantity_selector_settings');

        delete_option('quick_view_lite_clean_on_deletion');
    }
}
if (get_option('quick_view_lite_clean_on_deletion') == 1) {
    register_uninstall_hook(__FILE__, 'wc_quick_view_lite_uninstall');
}
?>
