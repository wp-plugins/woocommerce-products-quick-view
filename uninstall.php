<?php
/**
 * Plugin Uninstall
 *
 * Uninstalling deletes options, tables, and pages.
 *
 */
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

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