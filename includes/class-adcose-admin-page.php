<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ADCOSE_Admin_Page {

	/**
	 * Register Tools menu page.
	 *
	 * @return void
	 */
	public function register_menu() {
		add_management_page(
			__( 'Code Search', 'admin-code-search' ),
			__( 'Code Search', 'admin-code-search' ),
			'manage_options',
			'adcose-code-search',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Render admin page.
	 *
	 * @return void
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$data = $this->get_form_data();

		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'Code Search', 'admin-code-search' ) . '</h1>';
		echo '<p>' . esc_html__( 'Search code inside active themes and plugins directly from the WordPress admin area.', 'admin-code-search' ) . '</p>';

		$this->render_form( $data );

		if ( ! empty( $data['error'] ) ) {
			echo '<div class="notice notice-error"><p>' . esc_html( $data['error'] ) . '</p></div>';
		}

		if ( $data['submitted'] && empty( $data['error'] ) ) {
			if ( ! empty( $data['results'] ) ) {
				$this->render_results( $data['results'], $data['term'] );
			} else {
				echo '<div class="notice notice-info"><p>' . esc_html__( 'No matches found.', 'admin-code-search' ) . '</p></div>';
			}
		}

		echo '</div>';
	}

	/**
	 * Prepare submitted form data and run scan if needed.
	 *
	 * @return array
	 */
	private function get_form_data() {
		$data = array(
			'term'         => '',
			'exts'         => 'php',
			'scan_plugins' => true,
			'scan_themes'  => true,
			'submitted'    => false,
			'error'        => '',
			'results'      => array(),
		);

		if ( isset( $_POST['term'] ) ) {
			$data['term'] = sanitize_text_field( wp_unslash( $_POST['term'] ) );
		}

		if ( isset( $_POST['exts'] ) ) {
			$data['exts'] = sanitize_text_field( wp_unslash( $_POST['exts'] ) );
		}

		$data['scan_plugins'] = isset( $_POST['scan_plugins'] );
		$data['scan_themes']  = isset( $_POST['scan_themes'] );

		if ( ! isset( $_POST['adcose_do_search'] ) ) {
			return $data;
		}

		$data['submitted'] = true;

		check_admin_referer( 'adcose_search_action', 'adcose_search_nonce' );

		if ( '' === trim( $data['term'] ) ) {
			$data['error'] = __( 'Search term is required.', 'admin-code-search' );
			return $data;
		}

		if ( ! $data['scan_plugins'] && ! $data['scan_themes'] ) {
			$data['error'] = __( 'Select at least one search location.', 'admin-code-search' );
			return $data;
		}

		$dirs = array();

		if ( $data['scan_plugins'] && defined( 'WP_PLUGIN_DIR' ) ) {
			$dirs[] = wp_normalize_path( WP_PLUGIN_DIR );
		}

		if ( $data['scan_themes'] ) {
			$stylesheet_dir = get_stylesheet_directory();
			$template_dir   = get_template_directory();

			if ( is_dir( $stylesheet_dir ) ) {
				$dirs[] = $stylesheet_dir;
			}

			if ( $template_dir !== $stylesheet_dir && is_dir( $template_dir ) ) {
				$dirs[] = $template_dir;
			}
		}

		$extensions = ADCOSE_Helpers::normalize_extensions( $data['exts'] );

		$exclude_names = array(
			'vendor',
			'node_modules',
			'wp-content/uploads',
			'cache',
			'.git',
			'.svn',
		);

		$scanner = new ADCOSE_Scanner();
		$data['results'] = $scanner->scan( $dirs, $data['term'], $extensions, $exclude_names );

		return $data;
	}

	/**
	 * Render search form.
	 *
	 * @param array $data Form data.
	 * @return void
	 */
	private function render_form( $data ) {
		echo '<form method="post" action="">';

		wp_nonce_field( 'adcose_search_action', 'adcose_search_nonce' );

		echo '<table class="form-table" role="presentation"><tbody>';

		echo '<tr>';
		echo '<th scope="row"><label for="adcose-term">' . esc_html__( 'Search term', 'admin-code-search' ) . '</label></th>';
		echo '<td>';
		echo '<input name="term" id="adcose-term" type="text" class="regular-text" value="' . esc_attr( $data['term'] ) . '" placeholder="' . esc_attr__( 'Type anything...', 'admin-code-search' ) . '">';
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<th scope="row"><label for="adcose-exts">' . esc_html__( 'Extensions', 'admin-code-search' ) . '</label></th>';
		echo '<td>';
		echo '<input name="exts" id="adcose-exts" type="text" class="regular-text" value="' . esc_attr( $data['exts'] ) . '" placeholder="php,inc,module">';
		echo '<p class="description">' . esc_html__( 'Comma-separated. Default: php', 'admin-code-search' ) . '</p>';
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<th scope="row">' . esc_html__( 'Search in', 'admin-code-search' ) . '</th>';
		echo '<td>';
		echo '<label><input type="checkbox" name="scan_plugins" value="1" ' . checked( $data['scan_plugins'], true, false ) . '> ' . esc_html__( 'Plugins', 'admin-code-search' ) . '</label><br>';
		echo '<label><input type="checkbox" name="scan_themes" value="1" ' . checked( $data['scan_themes'], true, false ) . '> ' . esc_html__( 'Themes', 'admin-code-search' ) . '</label>';
		echo '</td>';
		echo '</tr>';

		echo '</tbody></table>';

		echo '<p class="description">' . esc_html__( 'Large searches may take time on sites with many plugins or large codebases.', 'admin-code-search' ) . '</p>';

		echo '<p>';
		echo '<button type="submit" name="adcose_do_search" value="1" class="button button-primary">' . esc_html__( 'Search', 'admin-code-search' ) . '</button>';
		echo '</p>';

		echo '</form>';
	}

	/**
	 * Render results table.
	 *
	 * @param array $results Search results.
	 * @return void
	 */
	private function render_results( $results, $term ) {
		$total_matches = 0;

		foreach ( $results as $file => $rows ) {
			$total_matches += count( $rows );
		}

		echo '<h2>';
		echo esc_html__( 'Results', 'admin-code-search' ) . ' ';
		echo '<span class="description">(' . intval( $total_matches ) . ' ' . esc_html__( 'matches', 'admin-code-search' ) . ' ' . esc_html__( 'in', 'admin-code-search' ) . ' ' . intval( count( $results ) ) . ' ' . esc_html__( 'files', 'admin-code-search' ) . ')</span>';
		echo '</h2>';

		echo '<table class="widefat striped adcose-results-table">';
		echo '<thead><tr>';
		echo '<th>' . esc_html__( 'File', 'admin-code-search' ) . '</th>';
		echo '<th>' . esc_html__( 'Line', 'admin-code-search' ) . '</th>';
		echo '<th>' . esc_html__( 'Snippet', 'admin-code-search' ) . '</th>';
		echo '</tr></thead>';
		echo '<tbody>';

		foreach ( $results as $file => $rows ) {
			foreach ( $rows as $row ) {
				echo '<tr>';
				echo '<td class="adcose-file-cell">' . esc_html( ADCOSE_Helpers::relative_path( $file ) ) . '</td>';
				echo '<td>' . intval( $row['line'] ) . '</td>';
				$highlighted = ADCOSE_Helpers::highlight_term( $row['text'], $term );

echo '<td><code class="adcose-snippet">' . wp_kses(
	$highlighted,
	array(
		'mark' => array(),
	)
) . '</code></td>';
				echo '</tr>';
			}
		}

		echo '</tbody>';
		echo '</table>';
	}

}
