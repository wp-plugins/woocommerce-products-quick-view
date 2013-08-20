<?php
/**
 * WC_Quick_View_Ultimate_Settings Class
 *
 * Class Function into WooCommerce plugin
 *
 * Table Of Contents
 *
 * __construct()
 * set_setting()
 * on_add_tab()
 * wc_quick_view_ultimate_hover_position_style_end()
 * wc_quick_view_ultimate_under_image_style_end()
 * wc_quick_view_ultimate_fancybox_pop_up_end()
 * wc_quick_view_ultimate_end()
 * settings_tab_action()
 * add_settings_fields()
 * get_tab_in_view()
 * init_form_fields()
 * get_transparent()
 * get_font_size()
 * get_border()
 * get_font()
 * save_settings()
 * setting()
 * add_scripts()
 */
class WC_Quick_View_Ultimate_Settings
{
	/*
    * Admin Functions
    */
	public function set_setting($reset=false){
		
		// Global Settings
		if ( get_option('quick_view_ultimate_enable') == '' || $reset ) {
			update_option('quick_view_ultimate_enable','yes');
		}
		
		// Button Show On Hover
		if ( get_option('quick_view_ultimate_on_hover_bt_text') == '' || $reset ) {
			update_option('quick_view_ultimate_on_hover_bt_text', __('QUICKVIEW', 'wooquickview') );
		}
		if ( get_option('quick_view_ultimate_on_hover_bt_alink') == '' || $reset ) {
			update_option('quick_view_ultimate_on_hover_bt_alink','center');
		}
	}
	
	public function __construct() {
   		$this->current_tab = ( isset($_GET['tab']) ) ? $_GET['tab'] : 'general';
    	$this->settings_tabs = array(
        	'wc_quick_view_ultimate_settings' => __('Quick View', 'wooquickview')
        );
        add_action('woocommerce_settings_tabs', array(&$this, 'on_add_tab'), 10);
		
        // Run these actions when generating the settings tabs.
        foreach ( $this->settings_tabs as $name => $label ) {
        	add_action('woocommerce_settings_tabs_' . $name, array(&$this, 'settings_tab_action'), 10);
			if (get_option('a3rev_wc_quick_view_ultimate_just_confirm') == 1) {
          		update_option('a3rev_wc_quick_view_ultimate_just_confirm', 0);
			} else {
				add_action('woocommerce_update_options_' . $name, array(&$this, 'save_settings'), 10);
			}
        }
		
		add_action( 'woocommerce_settings_wc_quick_view_ultimate_colourbox_pop_up_end_after', array(&$this, 'wc_quick_view_ultimate_colourbox_pop_up_end') );
		
		add_action( 'woocommerce_settings_quick_view_ultimate_popup_content_start', array(&$this, 'quick_view_ultimate_popup_content_start') );
		add_action( 'woocommerce_settings_wc_quick_view_ultimate_end_after', array(&$this, 'wc_quick_view_ultimate_end') );
		add_action( 'woocommerce_settings_wc_quick_view_ultimate_hover_position_style_end_after', array(&$this, 'wc_quick_view_ultimate_hover_position_style_end') );
		add_action( 'woocommerce_settings_wc_quick_view_ultimate_under_image_style_end_after', array(&$this, 'wc_quick_view_ultimate_under_image_style_end') );
		add_action( 'woocommerce_settings_wc_quick_view_ultimate_fancybox_pop_up_end_after', array(&$this, 'wc_quick_view_ultimate_fancybox_pop_up_end') );
		
        // Add the settings fields to each tab.
        add_action('woocommerce_wc_quick_view_ultimate_settings', array(&$this, 'add_settings_fields'), 10);
				
	}

    /* ----------------------------------------------------------------------------------- */
    /* Admin Tabs */
    /* ----------------------------------------------------------------------------------- */
	public function on_add_tab() {
    	foreach ( $this->settings_tabs as $name => $label ) :
        	$class = 'nav-tab';
      		if ( $this->current_tab == $name )
            	$class .= ' nav-tab-active';
      		echo '<a href="' . admin_url('admin.php?page=woocommerce_settings&tab=' . $name) . '" class="' . $class . '">' . $label . '</a>';
     	endforeach;
	}
	
	public function quick_view_ultimate_popup_content_start() {
	?>
    		<tr valign="top" class="">
				<th class="titledesc" scope="row"><label for="quick_view_ultimate_popup_content1"><?php _e('Product Page Content', 'wooquickview');?></label></th>
				<td class="forminp">
                	<label><input type="radio" checked="checked" name="quick_view_ultimate_popup_content" id="quick_view_ultimate_popup_content1" value="product_page"  /> <?php _e("Check will show Product page excluding site header, sidebar and Footer. Note any plugin that runs its JavaScript just on the product page cannot run because this is not the actual product page url.", 'wooquickview'); ?></label>
				</td>
			</tr>
            <tr valign="top" class="">
				<th class="titledesc" scope="row"><label for="quick_view_ultimate_popup_content2"><?php _e('Site Product Page', 'wooquickview');?></label></th>
				<td class="forminp">
                	<label><input type="radio" <?php checked( get_option('quick_view_ultimate_popup_content', '') , 'full_page' ); ?> name="quick_view_ultimate_popup_content" id="quick_view_ultimate_popup_content2" value="full_page"  /> <?php _e("Check will show Product page, site header, sidebar and footer.", 'wooquickview'); ?></label>
				</td>
			</tr>
    <?php
	}
	
	public function wc_quick_view_ultimate_hover_position_style_end(){
		echo '</div></div><div class="section" id="under-image-style"><div class="pro_feature_fields">';	
	}
	
	public function wc_quick_view_ultimate_under_image_style_end(){
		echo '</div></div><div class="section" id="fancybox-pop-up"><div class="pro_feature_fields">';	
	}
	public function wc_quick_view_ultimate_fancybox_pop_up_end(){
		echo '</div></div><div class="section" id="colourbox-pop-up"><div class="pro_feature_fields">';	
	}
	
	public function wc_quick_view_ultimate_colourbox_pop_up_end() {
		echo '</div>';	
	}
	
	public function wc_quick_view_ultimate_end() {
	?>
    	</div>
    	<h3><?php _e('House Keeping', 'wooquickview');?> :</h3>		
        <table class="form-table">
            <tr valign="top" class="">
				<th class="titledesc" scope="row"><label for="quick_view_ultimate_clean_on_deletion"><?php _e('Clean up on Deletion', 'wooquickview');?></label></th>
				<td class="forminp">
						<label>
						<input <?php checked( get_option('quick_view_ultimate_clean_on_deletion'), 1); ?> type="checkbox" value="1" id="quick_view_ultimate_clean_on_deletion" name="quick_view_ultimate_clean_on_deletion">
						<?php _e('Check this box and if you ever delete this plugin it will completely remove all tables and data it created, leaving no trace it was ever here.', 'wooquickview');?></label> <br>
				</td>
			</tr>
		</table>
    <?php
		echo '</div><div class="section" id="hover-position-style">';	
	}
	

    /**
     * settings_tab_action()
     *
     * Do this when viewing our custom settings tab(s). One function for all tabs.
    */
    public function settings_tab_action() {
    	global $woocommerce_settings;
		
		// Determine the current tab in effect.
        $current_tab = $this->get_tab_in_view(current_filter(), 'woocommerce_settings_tabs_');

        // Hook onto this from another function to keep things clean.
        // do_action( 'woocommerce_newsletter_settings' );

		if(isset($_REQUEST['saved']) && get_option("wc_quick_view_ultimate_message") != ''){
			echo '<div id="message" class="updated fade"><p>'.get_option("wc_quick_view_ultimate_message").'</p></div>';
			update_option('wc_quick_view_ultimate_message', '');
		}
		?>
        <style type="text/css">
		.form-table { margin:0; }
		#a3_plugin_panel_container { position:relative; margin-top:10px;}
		#a3_plugin_panel_fields {width:65%; float:left; margin-top:10px;}
		#a3_plugin_panel_upgrade_area { position:relative; margin-left: 65%; padding-left:10px;}
		#a3_plugin_panel_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px 10px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
		.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
		.pro_feature_fields h3 { margin:6px 5px; }
		.pro_feature_fields p { margin-left:5px; }
		.pro_feature_fields  .form-table td, .pro_feature_fields .form-table th { padding:4px 10px; }		
        </style>
        <div id="a3_plugin_panel_container">
            <div class="a3_subsubsub_section">
                <ul class="subsubsub">
                    <li><a href="#global-settings" class="current"><?php _e('Settings', 'wooquickview'); ?></a> | </li>
                    <li><a href="#hover-position-style"><?php _e('Hover Position & Style', 'wooquickview'); ?></a> | </li>
                    <li><a href="#under-image-style"><?php _e('Under Image Style', 'wooquickview'); ?></a> | </li>
                    <li><a href="#fancybox-pop-up"><?php _e('Fancy Box Pop Up', 'wooquickview'); ?></a> | </li>
                    <li><a href="#colourbox-pop-up"><?php _e('Colour Box Pop Up', 'wooquickview'); ?></a></li>
                </ul>
                <br class="clear">
                <div id="a3_plugin_panel_fields">
                    <div class="section" id="global-settings">
                    <?php
                    do_action('woocommerce_wc_quick_view_ultimate_settings');
                    // Display settings for this tab (make sure to add the settings to the tab).
                    woocommerce_admin_fields($woocommerce_settings[$current_tab]);
                    ?>
                    </div>
            	</div>
                <div id="a3_plugin_panel_upgrade_area"><?php echo WC_Quick_View_Ultimate::plugin_extension(); ?></div>
            </div>
		</div>
        <div style="clear:both;"></div>
        	<script type="text/javascript">
				jQuery(window).load(function(){
					// Subsubsub tabs
					jQuery('div.a3_subsubsub_section ul.subsubsub li a:eq(0)').addClass('current');
					jQuery('div.a3_subsubsub_section .section:gt(0)').hide();

					jQuery('div.a3_subsubsub_section ul.subsubsub li a').click(function(){
						var $clicked = jQuery(this);
						var $section = $clicked.closest('.a3_subsubsub_section');
						var $target  = $clicked.attr('href');

						$section.find('a').removeClass('current');

						if ( $section.find('.section:visible').size() > 0 ) {
							$section.find('.section:visible').fadeOut( 100, function() {
								$section.find( $target ).fadeIn('fast');
							});
						} else {
							$section.find( $target ).fadeIn('fast');
						}

						$clicked.addClass('current');
						jQuery('#last_tab').val( $target );

						return false;
					});

					<?php if (isset($_GET['subtab']) && $_GET['subtab']) echo 'jQuery("div.a3_subsubsub_section ul.subsubsub li a[href=#'.$_GET['subtab'].']").click();'; ?>
				});
				(function($){
					$(function(){
						$("input[name=quick_view_ultimate_type]").attr('disabled', 'disabled');
						$("input[name=quick_view_ultimate_popup_content]").attr('disabled', 'disabled');
						
						$("#quick_view_ultimate_on_hover_bt_padding_tb").attr('disabled', 'disabled');
						$("#quick_view_ultimate_on_hover_bt_padding_lr").attr('disabled', 'disabled');
						$("#quick_view_ultimate_on_hover_bt_rounded").attr('disabled', 'disabled');
						$("#quick_view_ultimate_on_hover_bt_enable_shadow").attr('disabled', 'disabled');
						
						$("#quick_view_ultimate_under_image_bt_margin").attr('disabled', 'disabled');
						$("#quick_view_ultimate_under_image_bt_text").attr('disabled', 'disabled');
						$("#quick_view_ultimate_under_image_bt_padding_tb").attr('disabled', 'disabled');
						$("#quick_view_ultimate_under_image_bt_padding_lr").attr('disabled', 'disabled');
						$("#quick_view_ultimate_under_image_bt_rounded").attr('disabled', 'disabled');
						$("#quick_view_ultimate_under_image_bt_class").attr('disabled', 'disabled');
						$("#quick_view_ultimate_under_image_link_text").attr('disabled', 'disabled');
						
						$("input[name=quick_view_ultimate_fancybox_center_on_scroll]").attr('disabled', 'disabled');
						$("#quick_view_ultimate_fancybox_speed_in").attr('disabled', 'disabled');
						$("#quick_view_ultimate_fancybox_speed_out").attr('disabled', 'disabled');
						
						$("input[name=quick_view_ultimate_colorbox_center_on_scroll]").attr('disabled', 'disabled');
						$("#quick_view_ultimate_colorbox_speed").attr('disabled', 'disabled');
					});
				})(jQuery);
			</script>
        <?php
		add_action('admin_footer', array(&$this, 'add_scripts'), 10);
	}

	/**
     * add_settings_fields()
     *
     * Add settings fields for each tab.
    */
    public function add_settings_fields() {
    	global $woocommerce_settings;

        // Load the prepared form fields.
        $this->init_form_fields();

        if ( is_array($this->fields) ) :
        	foreach ( $this->fields as $k => $v ) :
                $woocommerce_settings[$k] = $v;
            endforeach;
        endif;
	}

    /**
    * get_tab_in_view()
    *
    * Get the tab current in view/processing.
    */
    public function get_tab_in_view($current_filter, $filter_base) {
    	return str_replace($filter_base, '', $current_filter);
    }
	

    /**
     * init_form_fields()
     *
     * Prepare form fields to be used in the various tabs.
     */
	public function init_form_fields() {
		global $wpdb;
		
  		// Define settings			
     	$this->fields['wc_quick_view_ultimate_settings'] = apply_filters('woocommerce_wc_quick_view_ultimate_settings_fields', array(
		
			array(
            	'name' => __( 'Global Settings', 'wooquickview' ),
                'type' => 'title',
                'desc' => '',
          		'id' => 'wc_quick_view_ultimate_start'
           	),
			array(  
				'name' 		=> __( 'Enable/Disable', 'wooquickview' ),
				'desc' 		=> __("Check to activate the Quick View feature.", 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_enable',
				'type' 		=> 'checkbox',
				'std' 		=> 1,
				'default'	=> 'yes'
			),
			array('type' => 'sectionend'),
			
			array(
            	'name' => '',
                'type' => 'title',
                'desc' => '<div class="pro_feature_fields">',
           	),
			array(  
				'name' 		=> __( "Show Button on", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_type',
				'type' 		=> 'radio',
				'std' 		=> 'hover',
				'default'	=> 'hover',
				'options'	=> array(
						'hover'			=> __( 'Show on mouse hover over image.', 'wooquickview' ) ,							
						'under'			=> __( 'Show as button or link text under image.', 'wooquickview' ) ,
				),
			),
			array(  
				'name' 		=> __( "Popup Tool", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_popup_tool',
				'css' 		=> 'width:300px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'fancybox',
				'default'	=> 'fancybox',
				'options'	=> array(
						'fancybox'		=> __( 'Fancybox (Default)', 'wooquickview' ) ,							
						'colorbox'		=> __( 'ColorBox', 'wooquickview' ) ,
					),
			),
			array('type' => 'sectionend'),
			
			array(
            	'name' => __( 'Pop-Up Content', 'wooquickview' ),
                'type' => 'title',
                'id' => 'quick_view_ultimate_popup_content_start',
           	),
			array('type' => 'sectionend', 'id' => 'wc_quick_view_ultimate_end'),
			
			array(
            	'name' => __( 'Button Show On Hover', 'wooquickview' ),
                'type' => 'title',
                'desc' => '',
          		'id' => 'wc_quick_view_ultimate_show_on_hover_start'
           	),
			array(  
				'name' => __( 'Button Text', 'wooquickview' ),
				'desc' 		=> __('Text for Quick View Button Show On Hover', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_text',
				'type' 		=> 'text',
				'css' 		=> 'width:300px;',
				'std' 		=> __('QUICKVIEW', 'wooquickview'),
				'default'	=> __('QUICKVIEW', 'wooquickview')
			),
			array(  
				'name' 		=> __( 'Button Align', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_alink',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'center',
				'default'	=> 'center',
				'options'	=> array(
						'top'			=> __( 'Top', 'wooquickview' ) ,	
						'center'		=> __( 'Center', 'wooquickview' ) ,	
						'bottom'		=> __( 'Bottom', 'wooquickview' ) ,	
					),
			),
			array('type' => 'sectionend'),
			
			array(
            	'name' => '',
                'type' => 'title',
                'desc' => '<div class="pro_feature_fields">',
           	),
			array(  
				'name' => __( 'Button Padding Top/Bottom', 'wooquickview' ),
				'desc' 		=> 'px '.__('(Padding Top/Bottom from Button text to Button border Show On Hover)', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_padding_tb',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '7',
				'default'	=> '7'
			),
			array(  
				'name' => __( 'Button Padding Left/Right', 'wooquickview' ),
				'desc' 		=> 'px '.__('(Padding Left/Right from Button text to Button border Show On Hover)', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_padding_lr',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '17',
				'default'	=> '17'
			),
			array(  
				'name' => __( 'Background Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #999999',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_bg',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#999999',
				'default'	=> '#999999'
			),
			array(  
				'name' => __( 'Background Colour Gradient From', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #999999',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_bg_from',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#999999',
				'default'	=> '#999999'
			),
			array(  
				'name' => __( 'Background Colour Gradient To', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #999999',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_bg_to',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#999999',
				'default'	=> '#999999'
			),
			array(  
				'name' 		=> __( 'Button Transparency', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_transparent',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '5',
				'default'	=> '5',
				'options'	=> $this->get_transparent(),
			),
			array(  
				'name' 		=> __( 'Button Border Weight', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_border_width',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '1',
				'default'	=> '1',
				'options'	=> $this->get_border(),
			),
			array(  
				'name' 		=> __( 'Button Border Style', 'wooquickview' ),
				'desc' 		=> '',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_border_style',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'solid',
				'default'	=> 'solid',
				'options'	=> array(
						'solid'			=> __( 'Solid', 'wooquickview' ) ,	
						'dotted'		=> __( 'Dotted', 'wooquickview' ) ,							
						'dashed'		=> __( 'Dashed', 'wooquickview' ) ,
						'double'		=> __( 'Double', 'wooquickview' ) ,
					),
			),
			array(  
				'name' => __( 'Button Border Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #FFFFFF',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_border_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Border Rounded', 'wooquickview' ),
				'desc' 		=> 'px',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_rounded',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '3',
				'default'	=> '3'
			),
			array(  
				'name' 		=> __( 'Button Font', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_font_family',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'Arial, sans-serif',
				'default'	=> 'Arial, sans-serif',
				'options'	=> $this->get_font(),
			),
			array(  
				'name' 		=> __( 'Button Font Size', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_font_size',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '14',
				'default'	=> '14',
				'options'	=> $this->get_font_size(),
			),
			array(  
				'name' 		=> __( 'Button Font Style', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_font_style',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'normal',
				'default'	=> 'normal',
				'options'	=> array(
						'normal'		=> __( 'Normal', 'wooquickview' ) ,	
						'italic'		=> __( 'Italic', 'wooquickview' ) ,	
						'bold'			=> __( 'Bold', 'wooquickview' ) ,
						'bold_italic'	=> __( 'Bold/Italic', 'wooquickview' ) ,	
					),
			),
			array(  
				'name' => __( 'Button Font Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #FFFFFF',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_font_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' 		=> __( 'Button Shadow', 'wooquickview' ),
				'desc' 		=> __("Activating this setting show shadow for button.", 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_on_hover_bt_enable_shadow',
				'type' 		=> 'checkbox',
				'std' 		=> '1',
				'default'	=> 'yes',
			),
			array(  
				'name' => __( 'Button Shadow Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #999999',
				'id' 		=> 'quick_view_ultimate_on_hover_bt_shadow_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#999999',
				'default'	=> '#999999'
			),
			array('type' => 'sectionend', 'id' => 'wc_quick_view_ultimate_hover_position_style_end'),
			
			array(
            	'name' => __( 'Button/Hyperlink Show under Image', 'wooquickview' ),
                'type' => 'title',
                'desc' => '',
          		'id' => 'wc_quick_view_ultimate_show_under_image_start'
           	),
			array(  
				'name' 		=> __( 'Button or Hyperlink Type', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_bt_type',
				'class' 	=> 'quick_view_ultimate_under_image_change',
				'type' 		=> 'radio',
				'std' 		=> 'link',
				'default'	=> 'link',
				'options'	=> array(
						'link'			=> __( 'Hyperlink', 'wooquickview' ) ,	
						'button'		=> __( 'Button', 'wooquickview' ) ,	
					),
			),
			array(  
				'name' 		=> __( 'Button or Hyperlink Align', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_bt_alink',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'button',
				'default'	=> 'button',
				'options'	=> array(
						'center'		=> __( 'Center', 'wooquickview' ) ,	
						'left'			=> __( 'Left', 'wooquickview' ) ,	
						'right'			=> __( 'Right', 'wooquickview' ) ,	
					),
			),
			array(  
				'name' => __( 'Button or Hyperlink magrin', 'wooquickview' ),
				'desc' 		=> 'px '. __('Above/Below', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_under_image_bt_margin',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '10',
				'default'	=> '10'
			),
			array('type' => 'sectionend'),
			
			array( 'type' 	=> 'title', 'desc'	=> '<div class="show_under_image_hyperlink_styling">' ),
			array('type' => 'sectionend'),
			
			array(
            	'name' => __( 'Hyperlink Styling', 'wooquickview' ),
                'type' => 'title',
          		'id' => 'wc_quick_view_ultimate_show_under_image_hyperlink_start'
           	),
			array(  
				'name' => __( 'Hyperlink Text', 'wooquickview' ),
				'desc' 		=> __('Text for Hyperlink show under image', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_under_image_link_text',
				'type' 		=> 'text',
				'css' 		=> 'width:300px;',
				'std' 		=> __('Quick View', 'wooquickview'),
				'default'	=> __('Quick View', 'wooquickview')
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_link_font_family',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'Arial, sans-serif',
				'default'	=> 'Arial, sans-serif',
				'options'	=> $this->get_font(),
			),
			array(  
				'name' 		=> __( 'Hyperlink Font Size', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_link_font_size',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '12',
				'default'	=> '12',
				'options'	=> $this->get_font_size(),
			),
			array(  
				'name' 		=> __( 'Hyperlink Font Style', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_link_font_style',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'bold',
				'default'	=> 'bold',
				'options'	=> array(
						'normal'		=> __( 'Normal', 'wooquickview' ) ,	
						'italic'		=> __( 'Italic', 'wooquickview' ) ,	
						'bold'			=> __( 'Bold', 'wooquickview' ) ,
						'bold_italic'	=> __( 'Bold/Italic', 'wooquickview' ) ,	
					),
			),
			array(  
				'name' => __( 'Hyperlink Font Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #000000',
				'id' 		=> 'quick_view_ultimate_under_image_link_font_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
			array(  
				'name' => __( 'Hyperlink hover Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #999999',
				'id' 		=> 'quick_view_ultimate_under_image_link_font_hover_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#999999',
				'default'	=> '#999999'
			),
			array('type' => 'sectionend'),
			
			array( 'type' 	=> 'title', 'desc'	=> '</div><div class="show_under_image_button_styling">' ),
			array('type' => 'sectionend'),
			
			array(
            	'name' => __( 'Button Styling', 'wooquickview' ),
                'type' => 'title',
          		'id' => 'wc_quick_view_ultimate_show_under_image_button_start'
           	),
			array(  
				'name' => __( 'Button Text', 'wooquickview' ),
				'desc' 		=> __('Text for Button show under image', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_under_image_bt_text',
				'type' 		=> 'text',
				'css' 		=> 'width:300px;',
				'std' 		=> __('Quick View', 'wooquickview'),
				'default'	=> __('Quick View', 'wooquickview')
			),
			array(  
				'name' => __( 'Button Padding Top/Bottom', 'wooquickview' ),
				'desc' 		=> 'px '. __('Padding Top/Bottom from Button text to Button border show under image', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_under_image_bt_padding_tb',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '7',
				'default'	=> '7'
			),
			array(  
				'name' => __( 'Button Padding Left/Right', 'wooquickview' ),
				'desc' 		=> 'px '. __('Padding Left/Right from Button text to Button border show under image', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_under_image_bt_padding_lr',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '8',
				'default'	=> '8'
			),
			array(  
				'name' => __( 'Background Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #000000',
				'id' 		=> 'quick_view_ultimate_under_image_bt_bg',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
			array(  
				'name' => __( 'Background Colour Gradient From', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #000000',
				'id' 		=> 'quick_view_ultimate_under_image_bt_bg_from',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
			
			array(  
				'name' => __( 'Background Colour Gradient To', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #000000',
				'id' 		=> 'quick_view_ultimate_under_image_bt_bg_to',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
			array(  
				'name' 		=> __( 'Button Border Weight', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_bt_border_width',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '1',
				'default'	=> '1',
				'options'	=> $this->get_border(),
			),
			array(  
				'name' 		=> __( 'Button Border Style', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_bt_border_style',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'solid',
				'default'	=> 'solid',
				'options'	=> array(
						'solid'			=> __( 'Solid', 'wooquickview' ) ,	
						'dotted'		=> __( 'Dotted', 'wooquickview' ) ,							
						'dashed'		=> __( 'Dashed', 'wooquickview' ) ,
						'double'		=> __( 'Double', 'wooquickview' ) ,
					),
			),
			array(  
				'name' => __( 'Button Border Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #000000',
				'id' 		=> 'quick_view_ultimate_under_image_bt_border_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
			array(  
				'name' => __( 'Border Rounded', 'wooquickview' ),
				'desc' 		=> 'px',
				'id' 		=> 'quick_view_ultimate_under_image_bt_rounded',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '3',
				'default'	=> '3'
			),
			array(  
				'name' 		=> __( 'Button Font', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_bt_font_family',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'Arial, sans-serif',
				'default'	=> 'Arial, sans-serif',
				'options'	=> $this->get_font(),
			),
			array(  
				'name' 		=> __( 'Button Font Size', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_bt_font_size',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '12',
				'default'	=> '12',
				'options'	=> $this->get_font_size(),
			),
			array(  
				'name' 		=> __( 'Button Font Style', 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_under_image_bt_font_style',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'bold',
				'default'	=> 'bold',
				'options'	=> array(
						'normal'		=> __( 'Normal', 'wooquickview' ) ,	
						'italic'		=> __( 'Italic', 'wooquickview' ) ,	
						'bold'			=> __( 'Bold', 'wooquickview' ) ,
						'bold_italic'	=> __( 'Bold/Italic', 'wooquickview' ) ,	
					),
			),
			array(  
				'name' => __( 'Button Font Colour', 'wooquickview' ),
				'desc' 		=> __('Default', 'wooquickview'). ' #FFFFFF',
				'id' 		=> 'quick_view_ultimate_under_image_bt_font_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' => __( 'CSS Class', 'wooquickview' ),
				'desc' 		=> __('Enter your own button CSS class', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_under_image_bt_class',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'std' 		=> '',
				'default'	=> ''
			),
			array('type' => 'sectionend'),
			
			array( 'type' 	=> 'title', 'desc'	=> '</div>' ),
			array('type' => 'sectionend', 'id' => 'wc_quick_view_ultimate_under_image_style_end'),
	
			array(
            	'name' => __( 'Fancy Box Pop Up', 'wooquickview' ),
                'type' => 'title',
          		'id' => 'wc_quick_view_ultimate_fancybox_pop_up_start'
           	),
			array(  
				'name' 		=> __( "Popup Tool Wide", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_popup_tool_wide',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '75',
				'default'	=> '75',
				'options'	=> array(
						'50'			=> __( '50%', 'wooquickview' ) ,							
						'75'			=> __( '75%', 'wooquickview' ) ,
						'100'			=> __( '100%', 'wooquickview' ) ,
				),
			),
			array(  
				'name' 		=> __( "Fix Position on Scroll", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_fancybox_center_on_scroll',
				'type' 		=> 'radio',
				'std' 		=> 'true',
				'default'	=> 'true',
				'options'	=> array(
						'true'			=> __( 'Yes - Pop-up stays centered in screen while page scrolls behind it.', 'wooquickview' ) ,							
						'false'			=> __( 'No - Pop-up scrolls up and down with the page.' , 'wooquickview' ) ,
				),
			),
			array(  
				'name' 		=> __( 'Open Transition Effect', 'wooquickview' ),
				'desc' 		=> __("Choose a pop-up opening effect. Default - None.", 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_fancybox_transition_in',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'none',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'wooquickview' ) ,	
						'fade'			=> __( 'Fade', 'wooquickview' ) ,	
						'elastic'		=> __( 'Elastic', 'wooquickview' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Close Transistion Effect', 'wooquickview' ),
				'desc' 		=> __("Choose a pop-up closing effect. Default - None.", 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_fancybox_transition_out',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'none',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'wooquickview' ) ,	
						'fade'			=> __( 'Fade', 'wooquickview' ) ,	
						'elastic'		=> __( 'Elastic', 'wooquickview' ) ,
					),
			),
			array(  
				'name' => __( 'Opening Speed', 'wooquickview' ),
				'desc' 		=> __('Milliseconds when open popup', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_fancybox_speed_in',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '300',
				'default'	=> '300'
			),
			array(  
				'name' => __( 'Closing Speed', 'wooquickview' ),
				'desc' 		=> __('Milliseconds when close popup', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_fancybox_speed_out',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '0',
				'default'	=> '0'
			),
			array(  
				'name' => __( 'Background Overlay Colour', 'wooquickview' ),
				'desc' 		=> __('Select a colour or type TRANSPARENT for no colour.', 'wooquickview'). ' ' . __('Default', 'wooquickview'). ' #666666',
				'id' 		=> 'quick_view_ultimate_fancybox_overlay_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#666666',
				'default'	=> '#666666'
			),
			array( 'type' 	=> 'title', 'desc'	=> '</div>' ),
			
			array('type' => 'sectionend', 'id' => 'wc_quick_view_ultimate_fancybox_pop_up_end'),
			array('type' => 'sectionend'),
			
			array(
            	'name' => __( 'Colour Box Pop Up', 'wooquickview' ),
                'type' => 'title',
                'desc' => '',
          		'id' => 'wc_quick_view_ultimate_colourbox_pop_up_start'
           	),
			array(  
				'name' 		=> __( "Popup Tool Wide", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_colorbox_popup_tool_wide',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> '75',
				'default'	=> '75',
				'options'	=> array(
						'50'			=> __( '50%', 'wooquickview' ) ,							
						'75'			=> __( '75%', 'wooquickview' ) ,
						'100'			=> __( '100%', 'wooquickview' ) ,
				),
			),
			array(  
				'name' 		=> __( "Fix Position on Scroll", 'wooquickview' ),
				'id' 		=> 'quick_view_ultimate_colorbox_center_on_scroll',
				'type' 		=> 'radio',
				'std' 		=> 'true',
				'default'	=> 'true',
				'options'	=> array(
						'true'			=> __( 'Yes - Pop-up stays centered in screen while page scrolls behind it.', 'wooquickview' ) ,							
						'false'			=> __( 'No - Pop-up scrolls up and down with the page.' , 'wooquickview' ) ,
				),
			),
			array(  
				'name' 		=> __( 'Open & Close Transition Effect', 'wooquickview' ),
				'desc' 		=> __("Choose a pop-up opening & closing effect. Default - None", 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_colorbox_transition',
				'css' 		=> 'width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'std' 		=> 'none',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'wooquickview' ) ,	
						'fade'			=> __( 'Fade', 'wooquickview' ) ,	
						'elastic'		=> __( 'Elastic', 'wooquickview' ) ,
					),
			),
			array(  
				'name' => __( 'Opening & Closing Speed', 'wooquickview' ),
				'desc' 		=> __('Milliseconds when open and close popup', 'wooquickview'),
				'id' 		=> 'quick_view_ultimate_colorbox_speed',
				'type' 		=> 'text',
				'css' 		=> 'width:120px;',
				'std' 		=> '300',
				'default'	=> '300'
			),
			array(  
				'name' => __( 'Background Overlay Colour', 'wooquickview' ),
				'desc' 		=> __('Select a colour or type TRANSPARENT for no colour.', 'wooquickview'). ' ' . __('Default', 'wooquickview'). ' #666666',
				'id' 		=> 'quick_view_ultimate_colorbox_overlay_color',
				'type' 		=> 'color',
				'css' 		=> 'width:120px;',
				'std' 		=> '#666666',
				'default'	=> '#666666'
			),
			array('type' => 'sectionend', 'id' => 'wc_quick_view_ultimate_colourbox_pop_up_end'),
			
        ));
	}
	
	public static function get_transparent() {
		$transparent = array();
		for ( $i = 1 ; $i <= 10 ; $i ++ ){$transparent[$i] = $i. '0%' ;}
		return $transparent;
	}
	
	public static function get_font_size() {
		$font_size = array();
		for ( $i = 9 ; $i <= 40 ; $i ++ ){$font_size[$i] = $i. 'px' ;}
		return $font_size;
	}
	public static function get_border() {
		$border_width = array();
		for ( $i = 0 ; $i <= 20 ; $i ++ ){$border_width[$i] = $i. 'px' ;}
		return $border_width;
	}
	
	public static function get_font() {
		$fonts = array( 
			'Arial, sans-serif'													=> __( 'Arial', 'wooquickview' ),
			'Verdana, Geneva, sans-serif'										=> __( 'Verdana', 'wooquickview' ),
			'Trebuchet MS, Tahoma, sans-serif'								=> __( 'Trebuchet', 'wooquickview' ),
			'Georgia, serif'													=> __( 'Georgia', 'wooquickview' ),
			'Times New Roman, serif'											=> __( 'Times New Roman', 'wooquickview' ),
			'Tahoma, Geneva, Verdana, sans-serif'								=> __( 'Tahoma', 'wooquickview' ),
			'Palatino, Palatino Linotype, serif'								=> __( 'Palatino', 'wooquickview' ),
			'Helvetica Neue, Helvetica, sans-serif'							=> __( 'Helvetica*', 'wooquickview' ),
			'Calibri, Candara, Segoe, Optima, sans-serif'						=> __( 'Calibri*', 'wooquickview' ),
			'Myriad Pro, Myriad, sans-serif'									=> __( 'Myriad Pro*', 'wooquickview' ),
			'Lucida Grande, Lucida Sans Unicode, Lucida Sans, sans-serif'	=> __( 'Lucida', 'wooquickview' ),
			'Arial Black, sans-serif'											=> __( 'Arial Black', 'wooquickview' ),
			'Gill Sans, Gill Sans MT, Calibri, sans-serif'					=> __( 'Gill Sans*', 'wooquickview' ),
			'Geneva, Tahoma, Verdana, sans-serif'								=> __( 'Geneva*', 'wooquickview' ),
			'Impact, Charcoal, sans-serif'										=> __( 'Impact', 'wooquickview' ),
			'Courier, Courier New, monospace'									=> __( 'Courier', 'wooquickview' ),
			'Century Gothic, sans-serif'										=> __( 'Century Gothic', 'wooquickview' ),
		);
		
		return apply_filters('quick_view_ultimate_fonts_support', $fonts );
	}

    /**
     * save_settings()
     *
     * Save settings in a single field in the database for each tab's fields (one field per tab).
     */
	public function save_settings() {
     	global $woocommerce_settings;

        // Make sure our settings fields are recognised.
        $this->add_settings_fields();

        $current_tab = $this->get_tab_in_view(current_filter(), 'woocommerce_update_options_');

		woocommerce_update_options($woocommerce_settings[$current_tab]);
		
		delete_option( 'quick_view_ultimate_type' );
		delete_option( 'quick_view_ultimate_popup_tool' );
		delete_option( 'quick_view_ultimate_popup_content' );
		
		delete_option( 'quick_view_ultimate_on_hover_bt_padding_tb' );
		delete_option( 'quick_view_ultimate_on_hover_bt_padding_lr' );
		delete_option( 'quick_view_ultimate_on_hover_bt_bg' );
		delete_option( 'quick_view_ultimate_on_hover_bt_bg_from' );
		delete_option( 'quick_view_ultimate_on_hover_bt_bg_to' );
		delete_option( 'quick_view_ultimate_on_hover_bt_border_width' );
		delete_option( 'quick_view_ultimate_on_hover_bt_border_style' );
		delete_option( 'quick_view_ultimate_on_hover_bt_border_color' );
		delete_option( 'quick_view_ultimate_on_hover_bt_rounded' );
		delete_option( 'quick_view_ultimate_on_hover_bt_font_family' );
		delete_option( 'quick_view_ultimate_on_hover_bt_font_size' );
		delete_option( 'quick_view_ultimate_on_hover_bt_font_style' );
		delete_option( 'quick_view_ultimate_on_hover_bt_font_color' );
		delete_option( 'quick_view_ultimate_on_hover_bt_enable_shadow' );
		delete_option( 'quick_view_ultimate_on_hover_bt_shadow_color' );
		delete_option( 'quick_view_ultimate_on_hover_bt_transparent' );
		
		delete_option( 'quick_view_ultimate_under_image_bt_type' );
		delete_option( 'quick_view_ultimate_under_image_bt_alink' );
		delete_option( 'quick_view_ultimate_under_image_link_text' );
		delete_option( 'quick_view_ultimate_under_image_link_font_family' );
		delete_option( 'quick_view_ultimate_under_image_link_font_size' );
		delete_option( 'quick_view_ultimate_under_image_link_font_style' );
		delete_option( 'quick_view_ultimate_under_image_link_font_color' );
		delete_option( 'quick_view_ultimate_under_image_link_font_hover_color' );
		delete_option( 'quick_view_ultimate_under_image_bt_text' );
		delete_option( 'quick_view_ultimate_under_image_bt_padding_tb' );
		delete_option( 'quick_view_ultimate_under_image_bt_padding_lr' );
		delete_option( 'quick_view_ultimate_under_image_bt_bg' );
		delete_option( 'quick_view_ultimate_under_image_bt_bg_from' );
		delete_option( 'quick_view_ultimate_under_image_bt_bg_to' );
		delete_option( 'quick_view_ultimate_under_image_bt_border_width' );
		delete_option( 'quick_view_ultimate_under_image_bt_border_style' );
		delete_option( 'quick_view_ultimate_under_image_bt_border_color' );
		delete_option( 'quick_view_ultimate_under_image_bt_rounded' );
		delete_option( 'quick_view_ultimate_under_image_bt_font_family' );
		delete_option( 'quick_view_ultimate_under_image_bt_font_size' );
		delete_option( 'quick_view_ultimate_under_image_bt_font_style');
		delete_option( 'quick_view_ultimate_under_image_bt_font_color' );
		delete_option( 'quick_view_ultimate_under_image_bt_margin' );
		delete_option( 'quick_view_ultimate_under_image_bt_class' );
		
		delete_option( 'quick_view_ultimate_fancybox_popup_tool_wide' );
		delete_option( 'quick_view_ultimate_fancybox_center_on_scroll' );
		delete_option( 'quick_view_ultimate_fancybox_transition_in' );
		delete_option( 'quick_view_ultimate_fancybox_transition_out' );
		delete_option( 'quick_view_ultimate_fancybox_speed_in' );
		delete_option( 'quick_view_ultimate_fancybox_speed_out' );
		delete_option( 'quick_view_ultimate_fancybox_overlay_color' );
		
		delete_option( 'quick_view_ultimate_colorbox_popup_tool_wide' );
		delete_option( 'quick_view_ultimate_colorbox_center_on_scroll' );
		delete_option( 'quick_view_ultimate_colorbox_transition' );
		delete_option( 'quick_view_ultimate_colorbox_speed' );
		delete_option( 'quick_view_ultimate_colorbox_overlay_color' );
		
		if ( isset($_REQUEST['quick_view_ultimate_clean_on_deletion']) ) {
			update_option('quick_view_ultimate_clean_on_deletion',  $_REQUEST['quick_view_ultimate_clean_on_deletion']);
		} else { 
			update_option('quick_view_ultimate_clean_on_deletion',  0);
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[WC_QUICK_VIEW_ULTIMATE_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
	}

    /** Helper functions ***************************************************** */
         
    /**
     * Gets a setting
     */
    public function setting($key) {
		return get_option($key);
	}
	
	public function add_scripts(){
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script('jquery');
		
		wp_enqueue_style( 'a3rev-chosen-style', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/chosen/chosen.css' );
		wp_enqueue_script( 'chosen', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/chosen/chosen.jquery'.$suffix.'.js', array(), false, true );
		
		wp_enqueue_script( 'a3rev-chosen-script-init', WC_QUICK_VIEW_ULTIMATE_JS_URL.'/init-chosen.js', array(), false, true );
		
		wp_enqueue_script( 'quick_view_ultimate-admin', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/admin.js', array(), false, true );
	}
}
?>