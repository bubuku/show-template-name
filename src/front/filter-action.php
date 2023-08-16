<?php

namespace Bubuku\Plugins\ShowTemplateName\Front;

use const Bubuku\Plugins\ShowTemplateName\PLUGIN_NAME;

class FilterAction {

	public function __construct() {
		$this->_define_front_hooks();
	}

	/**
	 * Show in the top admin bar the name of the current template.
	 *
	 * @since    0.1
	 * @access   public
	 * 
	 * @param [type] $wp_admin_bar
	 * @return void
	 */
	public function show_template_name( $wp_admin_bar ) {
		if ( is_admin() ) {
			return;
		}

		$template_name = '';
        if ( $current_template = get_page_template_slug( get_queried_object_id() ) ){
            $templates = wp_get_theme()->get_page_templates();
            $template_name = $templates[$current_template];
        }

		if ( empty( $template_name ) ) {
			return false;
		}

		$wp_admin_bar->add_menu( 
			array(
				'id'    => 'template-name',
				'title' => '<span style="background:#228789;height:100%;display:block;margin:0 -10px;padding:0 10px;">Current Template: '. $template_name .'</span>',
			) 
		);

		return true;
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function _define_front_hooks() {
		// Show in the top admin bar the name of the current template.
		add_action( 'admin_bar_menu', array( $this, 'show_template_name' ), 999 );

	}
}