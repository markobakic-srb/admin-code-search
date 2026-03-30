<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ADCOSE_Plugin {

	/**
	 * Admin page instance.
	 *
	 * @var ADCOSE_Admin_Page
	 */
	private $admin_page;

	/**
	 * Initialize plugin hooks.
	 *
	 * @return void
	 */
	public function init() {
		$this->admin_page = new ADCOSE_Admin_Page();

		add_action( 'admin_menu', array( $this->admin_page, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Enqueue admin assets only on this plugin page.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 * @return void
	 */
	public function enqueue_admin_assets( $hook_suffix ) {
		if ( 'tools_page_adcose-code-search' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style(
			'adcose-admin-css',
			ADCOSE_URL . 'assets/css/admin-code-search.css',
			array(),
			ADCOSE_VERSION
		);
	}
}
