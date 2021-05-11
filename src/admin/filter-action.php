<?php

namespace Bubuku\Plugins\ShowTemplateName\Admin;

use const Bubuku\Plugins\ShowTemplateName\PLUGIN_NAME;

class FilterAction {

	public function __construct() {
		$this->_define_admin_hooks();
	}

	/**
	 * Add name column head
	 *
	 * @since    0.1
	 * @access   public
	 * 
	 * @param array $defaults Default values of columns name.
	 * 
	 * @return array<array>
	 */
	public function page_column_views( $defaults ) {
		$defaults['page-layout'] = __('Template', PLUGIN_NAME);
		return $defaults;
	}

	/**
	 * Add name in the column header.
	 *
	 * @since    0.1
	 * @access   public
	 * 
	 * @param string $column_name
	 * @param number $id 	
	 */
	public function page_custom_column_views( $column_name, $id ) {
		if ( $column_name === 'page-layout' ) {
			$set_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
			
			if ( $set_template == 'default' ) {
				echo __('Default', PLUGIN_NAME);
			} else {
				$aTemplates = get_page_templates();
				ksort( $aTemplates );
				foreach ( array_keys( $aTemplates ) as $template ) {
					if ( $set_template == $aTemplates[$template]) {
						echo $template;
					}
				}
			}
		}
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function _define_admin_hooks() {
		add_filter( 'manage_pages_columns', array( $this, 'page_column_views'), 10, 1 );
		add_action( 'manage_pages_custom_column', array( $this, 'page_custom_column_views'), 5, 2 );
	}
}