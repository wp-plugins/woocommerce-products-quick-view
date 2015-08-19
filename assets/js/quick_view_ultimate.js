// JavaScript Document
jQuery(document).ready(function() {
	jQuery(document).on("mouseenter", ".products .product", function(){
		jQuery(this).addClass("product_hover");
		var bt_position = jQuery(this).find(".quick_view_ultimate_container").attr('position');
		var quick_view_ultimate_margin = 0;
		var thumbnail = jQuery(this).find('.thumbnail').outerHeight();
		if(thumbnail <= 0){ thumbnail = jQuery(this).find('img').outerHeight(); }
		if( bt_position == 'center' ){
			quick_view_ultimate_margin = ( thumbnail- jQuery(this).find(".quick_view_ultimate_content").height())/ 2;
			jQuery(this).find(".quick_view_ultimate_container").css('top',quick_view_ultimate_margin+"px");
		}
		if( bt_position == 'bottom' ){
			quick_view_ultimate_margin = ( thumbnail - jQuery(this).find(".quick_view_ultimate_content").height() );
			jQuery(this).find(".quick_view_ultimate_container").css('top',quick_view_ultimate_margin+"px");
		}
		if( bt_position == 'top' ){
			jQuery(this).find(".quick_view_ultimate_container").css('top',"0px");
		}
	});
	jQuery(document).on("mouseleave", ".products .product", function(){
		jQuery(this).removeClass("product_hover");	
	});
	
	jQuery(document).on("mouseenter", ".shop-product", function(){
		jQuery(this).addClass("product_hover");
		var bt_position = jQuery(this).find(".quick_view_ultimate_container").attr('position');
		var quick_view_ultimate_margin = 0;
		var thumbnail = jQuery(this).find('.thumbnail').outerHeight();
		if(thumbnail <= 0){ thumbnail = jQuery(this).find('img').outerHeight(); }
		if( bt_position == 'center' ){
			quick_view_ultimate_margin = ( thumbnail- jQuery(this).find(".quick_view_ultimate_content").height())/ 2;
			jQuery(this).find(".quick_view_ultimate_container").css('top',quick_view_ultimate_margin+"px");
		}
		if( bt_position == 'bottom' ){
			quick_view_ultimate_margin = ( thumbnail - jQuery(this).find(".quick_view_ultimate_content").height() );
			jQuery(this).find(".quick_view_ultimate_container").css('top',quick_view_ultimate_margin+"px");
		}
		if( bt_position == 'top' ){
			jQuery(this).find(".quick_view_ultimate_container").css('top',"0px");
		}
	});
	jQuery(document).on("mouseleave", ".shop-product", function(){
		jQuery(this).removeClass("product_hover");	
	});
});	
