<?php
/*
Plugin Name: WooCommerce Products Quick View
Description: This plugin adds the ultimate Quick View feature to your Shop page, Product category and Product tags listings. Opens the full pages content - add to cart and even view cart without leaving the page.
Version: 1.2.5
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

?>