<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACS_Helpers {

	/**
	 * Normalize comma-separated extensions.
	 *
	 * @param string $extensions_raw Raw extensions string.
	 * @return array
	 */
	public static function normalize_extensions( $extensions_raw ) {
		$extensions = array_map(
			function( $extension ) {
				$extension = strtolower( trim( $extension ) );
				$extension = ltrim( $extension, '.' );
				return $extension;
			},
			explode( ',', $extensions_raw )
		);

		$extensions = array_filter( $extensions );

		if ( empty( $extensions ) ) {
			$extensions = array( 'php' );
		}

		return array_values( array_unique( $extensions ) );
	}

	/**
	 * Convert absolute path to ABSPATH-relative path when possible.
	 *
	 * @param string $absolute_path Absolute path.
	 * @return string
	 */
	public static function relative_path( $absolute_path ) {
		$root = wp_normalize_path( ABSPATH );
		$path = wp_normalize_path( $absolute_path );

		if ( 0 === strpos( $path, $root ) ) {
			return ltrim( substr( $path, strlen( $root ) ), '/' );
		}

		return $path;
	}

	/**
	 * Escape and highlight matching term.
	 *
	 * @param string $line Line text.
	 * @param string $term Search term.
	 * @return string
	 */
	public static function highlight_term( $line, $term ) {
		$safe_line = esc_html( $line );

		if ( '' === $term ) {
			return $safe_line;
		}

		$pattern = '/' . preg_quote( $term, '/' ) . '/i';

		return preg_replace( $pattern, '<mark>$0</mark>', $safe_line );
	}
}
