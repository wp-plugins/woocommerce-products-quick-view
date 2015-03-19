<?php
/**
 * WC_Quick_View_Ultimate_Style
 *
 * Table Of Contents
 *
 * WC_Quick_View_Ultimate_Style()
 * button_style_show_on_hover()
 * button_style_under_image()
 */
class WC_Quick_View_Ultimate_Style
{
	
	public function WC_Quick_View_Ultimate_Style(){
		//construct
	}
	
	public static function button_style_show_on_hover(){
		global $wc_qv_admin_interface, $wc_qv_fonts_face;
		$quick_view_ultimate_on_hover_bt_text = get_option( 'quick_view_ultimate_on_hover_bt_text' );
		$quick_view_ultimate_on_hover_bt_alink = get_option( 'quick_view_ultimate_on_hover_bt_alink' );
		$quick_view_ultimate_on_hover_bt_padding_tb = get_option( 'quick_view_ultimate_on_hover_bt_padding_tb' );
		$quick_view_ultimate_on_hover_bt_padding_lr = get_option( 'quick_view_ultimate_on_hover_bt_padding_lr' );
		$quick_view_ultimate_on_hover_bt_bg = get_option( 'quick_view_ultimate_on_hover_bt_bg' );
		$quick_view_ultimate_on_hover_bt_bg_from = get_option( 'quick_view_ultimate_on_hover_bt_bg_from' );
		$quick_view_ultimate_on_hover_bt_bg_to = get_option( 'quick_view_ultimate_on_hover_bt_bg_to' );
		$quick_view_ultimate_on_hover_bt_border = get_option( 'quick_view_ultimate_on_hover_bt_border' );
		$quick_view_ultimate_on_hover_bt_font = get_option( 'quick_view_ultimate_on_hover_bt_font' );
		$quick_view_ultimate_on_hover_bt_shadow = get_option( 'quick_view_ultimate_on_hover_bt_shadow' );
		$quick_view_ultimate_on_hover_bt_transparent = get_option( 'quick_view_ultimate_on_hover_bt_transparent' );
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		$do_this = false;
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		if( !$do_this ) return;
		if( $quick_view_ultimate_type != 'hover' ) return;
		?>
		<style type="text/css">
        .quick_view_ultimate_container{text-align:<?php echo $quick_view_ultimate_on_hover_bt_alink;?>;clear:both;display:block;width:100%;}
		.quick_view_ultimate_container span{
			<?php echo $wc_qv_fonts_face->generate_font_css( $quick_view_ultimate_on_hover_bt_font ); ?>
			text-align:<?php echo $quick_view_ultimate_on_hover_bt_alink;?> !important;
			padding: <?php echo $quick_view_ultimate_on_hover_bt_padding_tb; ?>px <?php echo $quick_view_ultimate_on_hover_bt_padding_lr; ?>px !important;
		}
		
		.product_hover .quick_view_ultimate_container span.quick_view_ultimate_button{
			color:<?php echo $quick_view_ultimate_on_hover_bt_font['color'];?>;
			<?php echo $wc_qv_admin_interface->generate_border_css( $quick_view_ultimate_on_hover_bt_border ); ?>
			background: <?php echo $quick_view_ultimate_on_hover_bt_bg;?>;
			background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $quick_view_ultimate_on_hover_bt_bg_from;?>), to(<?php echo $quick_view_ultimate_on_hover_bt_bg_to;?>));
			background: -webkit-linear-gradient(<?php echo $quick_view_ultimate_on_hover_bt_bg_from;?>, <?php echo $quick_view_ultimate_on_hover_bt_bg_to;?>);
			background: -moz-linear-gradient(center top, <?php echo $quick_view_ultimate_on_hover_bt_bg_from;?> 0%, <?php echo $quick_view_ultimate_on_hover_bt_bg_to;?> 100%);
			background: -moz-gradient(center top, <?php echo $quick_view_ultimate_on_hover_bt_bg_from;?> 0%, <?php echo $quick_view_ultimate_on_hover_bt_bg_to;?> 100%);
			<?php echo $wc_qv_admin_interface->generate_shadow_css( $quick_view_ultimate_on_hover_bt_shadow ); ?>
			<?php
			if($quick_view_ultimate_on_hover_bt_transparent == 100 ) {
				?>
				opacity:1;
				<?php
			}else{
			?>
			opacity:0.<?php echo round( $quick_view_ultimate_on_hover_bt_transparent / 10 );?>;
			<?php
			}
			?>
			filter:alpha(opacity=<?php echo $quick_view_ultimate_on_hover_bt_transparent;?>);
		}
        </style>
		<?php
		
	}
	
	public static function button_style_under_image(){
		global $wc_qv_admin_interface, $wc_qv_fonts_face;
		
		$quick_view_ultimate_under_image_bt_type = get_option( 'quick_view_ultimate_under_image_bt_type' );
		$quick_view_ultimate_under_image_bt_alink = get_option( 'quick_view_ultimate_under_image_bt_alink' );
		
		$quick_view_ultimate_under_image_link_text = get_option( 'quick_view_ultimate_under_image_link_text' );
		$quick_view_ultimate_under_image_link_font = get_option( 'quick_view_ultimate_under_image_link_font' );
		$quick_view_ultimate_under_image_link_font_hover_color = get_option( 'quick_view_ultimate_under_image_link_font_hover_color' );
	
		$quick_view_ultimate_under_image_bt_text = get_option( 'quick_view_ultimate_under_image_bt_text' );
		$quick_view_ultimate_under_image_bt_padding_tb = get_option( 'quick_view_ultimate_under_image_bt_padding_tb' );
		$quick_view_ultimate_under_image_bt_padding_lr = get_option( 'quick_view_ultimate_under_image_bt_padding_lr' );
		$quick_view_ultimate_under_image_bt_bg = get_option( 'quick_view_ultimate_under_image_bt_bg' );
		$quick_view_ultimate_under_image_bt_bg_from = get_option( 'quick_view_ultimate_under_image_bt_bg_from' );
		$quick_view_ultimate_under_image_bt_bg_to = get_option( 'quick_view_ultimate_under_image_bt_bg_to' );
		$quick_view_ultimate_under_image_bt_border = get_option( 'quick_view_ultimate_under_image_bt_border' );
		
		$quick_view_ultimate_under_image_bt_font = get_option( 'quick_view_ultimate_under_image_bt_font' );
		$quick_view_ultimate_under_image_bt_margin = get_option( 'quick_view_ultimate_under_image_bt_margin' );
		$quick_view_ultimate_under_image_bt_class = get_option( 'quick_view_ultimate_under_image_bt_class' );
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		$do_this = false;
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		if( !$do_this ) return;
		if( $quick_view_ultimate_type != 'under' ) return;
		?>
		<style type="text/css">
        .quick_view_ultimate_content_under{text-align:<?php echo $quick_view_ultimate_under_image_bt_alink;?>;clear:both;display:block;width:100%;padding:<?php echo $quick_view_ultimate_under_image_bt_margin;?>px 0px;}
		.quick_view_ultimate_content_under a.quick_view_ultimate_under_link{
			<?php echo $wc_qv_fonts_face->generate_font_css( $quick_view_ultimate_under_image_link_font ); ?>
			text-align:<?php echo $quick_view_ultimate_under_image_bt_alink;?> !important;
		}
		
		.quick_view_ultimate_content_under a.quick_view_ultimate_under_link:hover{
			color:<?php echo $quick_view_ultimate_under_image_link_font_hover_color;?> !important;
		}
		.quick_view_ultimate_content_under a.quick_view_ultimate_under_button{
			<?php echo $wc_qv_fonts_face->generate_font_css( $quick_view_ultimate_under_image_bt_font ); ?>
			<?php echo $wc_qv_admin_interface->generate_border_css( $quick_view_ultimate_under_image_bt_border ); ?>
			text-align:center !important;
			padding: <?php echo $quick_view_ultimate_under_image_bt_padding_tb; ?>px <?php echo $quick_view_ultimate_under_image_bt_padding_lr; ?>px !important;
			background: <?php echo $quick_view_ultimate_under_image_bt_bg;?> !important;
			background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $quick_view_ultimate_under_image_bt_bg_from;?>), to(<?php echo $quick_view_ultimate_under_image_bt_bg_to;?>)) !important;
			background: -webkit-linear-gradient(<?php echo $quick_view_ultimate_under_image_bt_bg_from;?>, <?php echo $quick_view_ultimate_under_image_bt_bg_to;?>) !important;
			background: -moz-linear-gradient(center top, <?php echo $quick_view_ultimate_under_image_bt_bg_from;?> 0%, <?php echo $quick_view_ultimate_under_image_bt_bg_to;?> 100%) !important;
			background: -moz-gradient(center top, <?php echo $quick_view_ultimate_under_image_bt_bg_from;?> 0%, <?php echo $quick_view_ultimate_under_image_bt_bg_to;?> 100%) !important;
		}
        </style>
		<?php
		
	}
	
}
$GLOBALS['wc_quick_view_ultimate_ultimate_style'] = new WC_Quick_View_Ultimate_Style();
