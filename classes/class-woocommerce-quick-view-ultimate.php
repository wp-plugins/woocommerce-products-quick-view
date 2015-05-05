<?php
/**
 * WC_Quick_View_Ultimate Class
 *
 * Table Of Contents
 *
 * WC_Quick_View_Ultimate()
 * init()
 * fix_responsi_theme()
 * fix_style_js_responsi_theme()
 * add_quick_view_ultimate_under_image_each_products()
 * add_quick_view_ultimate_hover_each_products()
 * quick_view_ultimate_wp_enqueue_script()
 * quick_view_ultimate_wp_enqueue_style()
 * quick_view_ultimate_popup()
 * quick_view_ultimate_reload_cart()
 * a3_wp_admin()
 * plugin_extension()
 * plugin_extra_links()
 */
class WC_Quick_View_Ultimate
{
	public function WC_Quick_View_Ultimate() {
		$this->init();
	}
	
	public function init () {
		
		//Fix Responsi Theme
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'fix_responsi_theme'), 42 );
		
		//Add Quick View Hover Each Products
		//add_action( 'woocommerce_after_shop_loop_item', array( $this, 'add_quick_view_ultimate_hover_each_products'), 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'add_quick_view_ultimate_hover_each_products'), 11 );
		
		//Add Quick View Under Image Each Products
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'add_quick_view_ultimate_under_image_each_products'), 11 );
		
		//Enqueue Script
		add_action( 'woocommerce_after_shop_loop', array( $this, 'quick_view_ultimate_wp_enqueue_script'),13 );
		add_action( 'woocommerce_after_shop_loop', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
		add_action( 'wp_head', array( $this, 'fix_style_js_responsi_theme'), 13 );
		
		// Include google fonts into header
		add_action( 'wp_head', array( $this, 'add_google_fonts'), 11 );
		
		// Add script check if checkout then close popup and redirect to checkout page
		add_action( 'wp_head', array( $this, 'redirect_to_checkout_page_from_popup') );
		
		//Enqueue Script On Home Page Responsi	
		add_action( 'wp_footer', array( $this, 'quick_view_ultimate_popup') );
		
		//Ajax Action
		add_action('wp_ajax_quick_view_ultimate_reload_cart', array( $this, 'quick_view_ultimate_reload_cart') );
		add_action('wp_ajax_nopriv_quick_view_ultimate_reload_cart', array( $this, 'quick_view_ultimate_reload_cart') );
		
		// Add upgrade notice to Dashboard pages
		global $wc_qv_admin_init;
		add_filter( $wc_qv_admin_init->plugin_name . '_plugin_extension', array( $this, 'plugin_extension' ) );
		
		$admin_pages = $wc_qv_admin_init->admin_pages();
		if ( is_array( $admin_pages ) && count( $admin_pages ) > 0 ) {
			foreach ( $admin_pages as $admin_page ) {
				add_action( $wc_qv_admin_init->plugin_name . '-' . $admin_page . '_tab_start', array( $this, 'plugin_extension_start' ) );
				add_action( $wc_qv_admin_init->plugin_name . '-' . $admin_page . '_tab_end', array( $this, 'plugin_extension_end' ) );
			}
		}
	}
	
	public function redirect_to_checkout_page_from_popup() {
		if ( is_checkout() ) {
			$woocommerce_db_version = get_option( 'woocommerce_db_version', null );
	?>
    	<script type="text/javascript">
		if ( window.self !== window.top ) {
			self.parent.location.href = '<?php if ( version_compare( $woocommerce_db_version, '2.1', '<' ) ) { echo get_permalink( woocommerce_get_page_id( 'checkout' ) ); } else { echo get_permalink( wc_get_page_id( 'checkout' ) ); } ?>';
		}
		</script>
    <?php
		}
	}
	
	public function fix_responsi_theme(){
		if(function_exists('add_responsi_pagination_theme')){
			remove_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'add_quick_view_ultimate_under_image_each_products'), 11 );
			add_action( 'responsi_before_shop_loop_item_content_container', array( $this, 'add_quick_view_ultimate_under_image_each_products'), 11 );
		}
	}
	
	public function add_google_fonts() {
		global $wc_qv_fonts_face;
		$quick_view_ultimate_on_hover_bt_font = get_option( 'quick_view_ultimate_on_hover_bt_font' );
		$quick_view_ultimate_under_image_link_font = get_option( 'quick_view_ultimate_under_image_link_font' );
		$quick_view_ultimate_under_image_bt_font = get_option( 'quick_view_ultimate_under_image_bt_font' );
		
		$google_fonts = array( $quick_view_ultimate_on_hover_bt_font['face'], $quick_view_ultimate_under_image_link_font['face'], $quick_view_ultimate_under_image_bt_font['face'] );
		
		$wc_qv_fonts_face->generate_google_webfonts( $google_fonts );
	}
	
	public function fix_style_js_responsi_theme(){
		if ( (is_home() && function_exists('add_responsi_pagination_theme')) ){
			add_action( 'woo_main_end', array( $this, 'quick_view_ultimate_wp_enqueue_script'),13 );
			add_action( 'a3rev_main_end', array( $this, 'quick_view_ultimate_wp_enqueue_script'),13 );
			add_action( 'woo_main_end', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
			add_action( 'a3rev_main_end', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
		}
		if ( is_singular('product') ) {
			add_action( 'wp_footer', array( $this, 'quick_view_ultimate_wp_enqueue_script'),13 );
			add_action( 'wp_footer', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
		}
	}
	
	public function add_quick_view_ultimate_under_image_each_products(){
		
		//if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return; // Not on product page - return
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		
		$do_this = false;
		
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		if( !$do_this ) return;
		if( $quick_view_ultimate_type != 'under' ) return;
		
		$quick_view_ultimate_popup_tool = get_option( 'quick_view_ultimate_popup_tool' );
		$quick_view_ultimate_under_image_bt_type = get_option( 'quick_view_ultimate_under_image_bt_type' );
		$quick_view_ultimate_under_image_link_text = esc_attr( stripslashes( get_option( 'quick_view_ultimate_under_image_link_text' ) ) );
		$quick_view_ultimate_under_image_bt_text = esc_attr( stripslashes( get_option( 'quick_view_ultimate_under_image_bt_text' ) ) );
		$quick_view_ultimate_under_image_bt_class = esc_attr( stripslashes( get_option( 'quick_view_ultimate_under_image_bt_class' ) ) );
		
		$quick_view_ultimate_button = '';
		$link_text = $quick_view_ultimate_under_image_link_text;
		$class = $quick_view_ultimate_popup_tool.' quick_view_ultimate_under_link quick_view_ultimate_click';
		if( $quick_view_ultimate_under_image_bt_type == 'button' ){
			$link_text = $quick_view_ultimate_under_image_bt_text;
			$class = $quick_view_ultimate_popup_tool.' quick_view_ultimate_under_button quick_view_ultimate_click';
			if( trim($quick_view_ultimate_under_image_bt_class) != '' ){$class .= ' '.trim($quick_view_ultimate_under_image_bt_class);}
		}
		
		$quick_view_ultimate_button .= '<div style="clear:both;"></div><div class="quick_view_ultimate_container_under"><div class="quick_view_ultimate_content_under"><a class="'.$class.'" id="'.get_the_ID().'" href="'.get_permalink().'" data-link="'.get_permalink().'">'.$link_text.'</a></div></div><div style="clear:both;"></div>';
		
		echo $quick_view_ultimate_button;

	}
	
	public function add_quick_view_ultimate_hover_each_products(){
		
		//if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return; // Not on product page - return
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		
		$do_this = false;
		
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		
		if( !$do_this ) return;
		if( $quick_view_ultimate_type != 'hover' ) return;
		
		$quick_view_ultimate_on_hover_bt_alink = esc_attr( stripslashes( get_option('quick_view_ultimate_on_hover_bt_alink') ) );
		$quick_view_ultimate_popup_tool = 'fancybox';
		$quick_view_ultimate_on_hover_bt_text = esc_attr( stripslashes( get_option( 'quick_view_ultimate_on_hover_bt_text' ) ) );
		
		$quick_view_ultimate_button = '';
		
		$class = $quick_view_ultimate_popup_tool.' quick_view_ultimate_button quick_view_ultimate_click';
		
		$quick_view_ultimate_button .= '<div class="quick_view_ultimate_container" position="'.$quick_view_ultimate_on_hover_bt_alink.'"><div class="quick_view_ultimate_content"><span id="'.get_the_ID().'" data-link="'.get_permalink().'" class="'.$class.'">'.$quick_view_ultimate_on_hover_bt_text.'</span></div></div>';
		echo $quick_view_ultimate_button;
		
	}
	
	public function quick_view_ultimate_wp_enqueue_script(){
		
		//if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return; // Not on product page - return
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		$do_this = false;
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		if( !$do_this ) return;
		if( $quick_view_ultimate_type != 'hover' ) return;
		wp_enqueue_script('jquery');
		wp_register_script( 'quick-view-script', WC_QUICK_VIEW_ULTIMATE_JS_URL.'/quick_view_ultimate.js');
		wp_enqueue_script( 'quick-view-script' );
	}
	
	public function quick_view_ultimate_wp_enqueue_style(){
		
		//if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return; // Not on product page - return
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$do_this = false;
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		if( !$do_this ) return;
		wp_enqueue_style( 'quick-view-css', WC_QUICK_VIEW_ULTIMATE_CSS_URL.'/style.css');
		WC_Quick_View_Ultimate_Style::button_style_under_image();
		WC_Quick_View_Ultimate_Style::button_style_show_on_hover();
	}
	
	public function quick_view_ultimate_popup(){
		
		//if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return; // Not on product page - return
		
		global $woocommerce;
		$suffix 				= defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$woocommerce_db_version = get_option( 'woocommerce_db_version', null );
		
		$frontend_script_path 	= ( ( version_compare( $woocommerce_db_version, '2.1', '<' ) ) ? $woocommerce->plugin_url() : WC()->plugin_url() ) . '/assets/js/frontend/';
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$do_this = false;
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		if( !$do_this ) return;
		
			wp_enqueue_style( 'woocommerce_fancybox_styles', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/fancybox/fancybox.css' );
			wp_enqueue_script( 'fancybox', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/fancybox/fancybox'.$suffix.'.js', array(), false, true );
			?>
			<!--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
            <?php
		wp_enqueue_style( 'quick-view-css', WC_QUICK_VIEW_ULTIMATE_CSS_URL.'/style.css');
		
		
		$quick_view_ultimate_fancybox_center_on_scroll = 'true';
		$quick_view_ultimate_fancybox_transition_in = 'none';
		$quick_view_ultimate_fancybox_transition_out = 'none';
		$quick_view_ultimate_fancybox_speed_in = 300;
		$quick_view_ultimate_fancybox_speed_out = 0;
		$quick_view_ultimate_fancybox_overlay_color = '#666666';
		
		?>
		<script type="text/javascript">
			function wc_qv_getWidth() {
				xWidth = null;
				if(window.screen != null)
				  xWidth = window.screen.availWidth;
			
				if(window.innerWidth != null)
				  xWidth = window.innerWidth;
			
				if(document.body != null)
				  xWidth = document.body.clientWidth;
			
				return xWidth;
			}
			jQuery(document).on("click", ".quick_view_ultimate_click.fancybox", function(){
			
				var product_id = jQuery(this).attr('id');
				var product_url = jQuery(this).attr('data-link');
				
				var obj = jQuery(this);
				
				// detect iOS to fix scroll for iframe on fancybox
				var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
				if ( iOS ) {
					jQuery('#fancybox-content').attr( "style", "overflow-y: auto !important; -webkit-overflow-scrolling: touch !important;" );
				}
				
				var url = product_url;
				var popup_wide = 600;
				if ( wc_qv_getWidth()  <= 600 ) { 
					popup_wide = '90%'; 
				}
			
                jQuery.fancybox({
					href: url,
					type: "iframe",
					centerOnScroll : <?php echo $quick_view_ultimate_fancybox_center_on_scroll;?>,
					transitionIn : '<?php echo $quick_view_ultimate_fancybox_transition_in;?>', 
					transitionOut: '<?php echo $quick_view_ultimate_fancybox_transition_out;?>',
					easingIn: 'swing',
					easingOut: 'swing',
					speedIn : <?php echo $quick_view_ultimate_fancybox_speed_in;?>,
					speedOut : <?php echo $quick_view_ultimate_fancybox_speed_out;?>,
					width: popup_wide,
					autoScale: true,
					height: 460,
					margin: 0,
					padding: 10,
					maxWidth: "90%",
					maxHeight: "80%",
					autoDimensions: true,
					overlayColor: '<?php echo $quick_view_ultimate_fancybox_overlay_color;?>',
					showCloseButton : true,
					openEffect	: "none",
					closeEffect	: "none",
					onClosed: function() {
						jQuery.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>?action=quick_view_ultimate_reload_cart&security=<?php echo wp_create_nonce("reload-cart");?>', '', function(rsHTML){
							jQuery('.widget_shopping_cart_content').html(rsHTML);
							
						});
					}
                });

				return false;
			});
			
		</script>
		<?php
	}
	
	public function quick_view_ultimate_reload_cart() {
		global $woocommerce;
		check_ajax_referer( 'reload-cart', 'security' );
		if(function_exists('woocommerce_mini_cart'))woocommerce_mini_cart() ;
		die();
	}
	
	public function plugin_extension_start() {
		global $wc_qv_admin_init;
		
		$wc_qv_admin_init->plugin_extension_start();
	}
	
	public function plugin_extension_end() {
		global $wc_qv_admin_init;
		
		$wc_qv_admin_init->plugin_extension_end();
	}
	
	public static function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', WC_QUICK_VIEW_ULTIMATE_CSS_URL . '/a3_wp_admin.css' );
	}

	public static function admin_sidebar_menu_css() {
		wp_enqueue_style( 'a3rev-wc-qv-admin-sidebar-menu-style', WC_QUICK_VIEW_ULTIMATE_CSS_URL . '/admin_sidebar_menu.css' );
	}
	
	public function plugin_extension() {
		$html = '';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><div class="a3-plugin-ui-icon a3-plugin-ui-a3-rev-logo"></div></a>';
		$html .= '<h3>'.__('Upgrade to WooCommerce Quick View Ultimate', 'wooquickview').'</h3>';
		$html .= '<p>'.__("<strong>NOTE:</strong> All the functions inside the Yellow border on the plugins admin panel are extra functionality that is activated by upgrading to the Pro version", 'wooquickview').':</p>';
		$html .= '<p>';
		$html .= '<h3 style="margin-bottom:5px;">* <a href="'.WC_QUICK_VIEW_ULTIMATE_AUTHOR_URI.'" target="_blank">'.__('WooCommerce Quick View Ultimate', 'wooquickview').'</a></h3>';
		$html .= '<div><strong>'.__('Activates these advanced Features', 'wooquickview').':</strong></div>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__("Quick View Custom Template for pop-up.", 'wooquickview').'</li>';
		$html .= '<li>2. '.__("Custom Template Dynamic Product Gallery.", 'wooquickview').'</li>';
		$html .= '<li>3. '.__('Custom Template Next &gt; &lt; Previous Product feature.', 'wooquickview').'</li>';
		$html .= '<li>4. '.__('Custom Template Style and layout settings.', 'wooquickview').'</li>';
		$html .= '<li>5. '.__('Optional Fancybox | Colorbox pop-up tool.', 'wooquickview').'</li>';
		$html .= '<li>6. '.__('Select pop-up open and close effect.', 'wooquickview').'</li>';
		$html .= '<li>7. '.__('Set pop-up opening / closing speed.', 'wooquickview').'</li>';
		$html .= '<li>8. '.__("Set pop-up background overlay colour.", 'wooquickview').'</li>';
		$html .= '<li>9. '.__("Access to support from developers.", 'wooquickview').'</li>';
		$html .= '<li>10. '.__("Lifetime upgrades and maintenence.", 'wooquickview').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('View this plugins', 'wooquickview').' <a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce-quick-view-ultimate/" target="_blank">'.__('documentation', 'wooquickview').'</a></h3>';
		$html .= '<h3>'.__('Visit this plugins', 'wooquickview').' <a href="http://wordpress.org/support/plugin/woocommerce-products-quick-view/" target="_blank">'.__('support forum', 'wooquickview').'</a></h3>';
		$html .= '<h3>'.__('More FREE a3rev WooCommerce Plugins', 'wooquickview').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-product-sort-and-display/" target="_blank">'.__('WooCommerce Product Sort and Display', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('WooCommerce Dynamic Products Gallery', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-predictive-search/" target="_blank">'.__('WooCommerce Predictive Search', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-compare-products/" target="_blank">'.__('WooCommerce Compare Products', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woo-widget-product-slideshow/" target="_blank">'.__('WooCommerce Widget Product Slideshow', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-email-inquiry-cart-options/" target="_blank">'.__('WooCommerce Email Inquiry & Cart Options', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://a3rev.com/shop/woocommerce-email-inquiry-ultimate/" target="_blank">'.__('WooCommerce Email Inquiry Ultimate (Pro Only)', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://a3rev.com/shop/woocommerce-quotes-and-orders/" target="_blank">'.__('WooCommerce Quotes and Orders (Pro Only)', 'wooquickview').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('FREE a3rev WordPress Plugins', 'wooquickview').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="https://wordpress.org/plugins/a3-lazy-load/" target="_blank">'.__('a3 Lazy Load', 'wooquickview').'</a> ('.__( 'WooCommerce Compatible' , 'wooquickview' ).')</li>';
		$html .= '<li>* <a href="https://wordpress.org/plugins/a3-portfolio/" target="_blank">'.__('a3 Portfolio', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/a3-responsive-slider/" target="_blank">'.__('a3 Responsive Slider', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/contact-us-page-contact-people/" target="_blank">'.__('Contact Us Page - Contact People', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'wooquickview').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'wooquickview').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		return $html;
	}
	
	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WC_QUICK_VIEW_ULTIMATE_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce-quick-view-ultimate/" target="_blank">'.__('Documentation', 'wooquickview').'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/woocommerce-products-quick-view/" target="_blank">'.__('Support', 'wooquickview').'</a>';
		return $links;
	}
}
?>
