<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACS_Plugin {

	/**
	 * Admin page instance.
	 *
	 * @var ACS_Admin_Page
	 */
	private $admin_page;

	/**
	 * Initialize plugin hooks.
	 *
	 * @return void
	 */
	public function init() {
		$this->admin_page = new ACS_Admin_Page();

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'admin_menu', array( $this->admin_page, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Load translations.
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'admin-code-search',
			false,
			dirname( ACS_BASENAME ) . '/languages'
		);
	}

	/**
	 * Enqueue admin assets only on this plugin page.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 * @return void
	 */
	public function enqueue_admin_assets( $hook_suffix ) {
		if ( 'tools_page_acs-code-search' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style(
			'acs-admin-css',
			ACS_URL . 'assets/css/admin-code-search.css',
			array(),
			ACS_VERSION
		);
	}
}
