// JavaScript Document
jQuery(document).ready(function() {
	if ( jQuery("input[name='quick_view_ultimate_under_image_bt_type']:checked").val() == 'link') {
		jQuery(".show_under_image_hyperlink_styling").show();
		jQuery(".show_under_image_button_styling").hide();
	} else {
		jQuery(".show_under_image_hyperlink_styling").hide();
		jQuery(".show_under_image_button_styling").show();
	}
	jQuery('.quick_view_ultimate_under_image_change').click(function(){
		if ( jQuery("input[name='quick_view_ultimate_under_image_bt_type']:checked").val() == 'link') {
			jQuery(".show_under_image_hyperlink_styling").show();
			jQuery(".show_under_image_button_styling").hide();
		} else {
			jQuery(".show_under_image_hyperlink_styling").hide();
			jQuery(".show_under_image_button_styling").show();
		}
	});
});	
