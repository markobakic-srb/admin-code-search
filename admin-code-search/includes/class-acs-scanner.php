<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACS_Scanner {

	/**
	 * Scan directories for matching lines.
	 *
	 * @param array  $dirs          Directories to scan.
	 * @param string $term          Search term.
	 * @param array  $extensions    Allowed file extensions.
	 * @param array  $exclude_names Excluded path fragments.
	 * @return array
	 */
	public function scan( $dirs, $term, $extensions, $exclude_names ) {
		$results = array();

		$flags = FilesystemIterator::SKIP_DOTS;

		foreach ( $dirs as $base_dir ) {
			if ( ! is_dir( $base_dir ) ) {
				continue;
			}

			$iterator = new RecursiveIteratorIterator(
				new RecursiveCallbackFilterIterator(
					new RecursiveDirectoryIterator( $base_dir, $flags ),
					function( $current ) use ( $extensions, $exclude_names ) {
						$pathname = $current->getPathname();

						if ( $current->isDir() ) {
							foreach ( $exclude_names as $excluded ) {
								if ( false !== stripos( $pathname, $excluded ) ) {
									return false;
								}
							}
							return true;
						}

						if ( $current->isFile() ) {
							$extension = strtolower( $current->getExtension() );
							return in_array( $extension, $extensions, true );
						}

						return false;
					}
				),
				RecursiveIteratorIterator::LEAVES_ONLY
			);

			foreach ( $iterator as $file_info ) {
				$file_path = $file_info->getPathname();
				$this->scan_file( $file_path, $term, $results );
			}
		}

		ksort( $results );

		return $results;
	}

	/**
	 * Scan a single file line-by-line.
	 *
	 * @param string $file_path File path.
	 * @param string $term      Search term.
	 * @param array  $results   Results array by reference.
	 * @return void
	 */
	private function scan_file( $file_path, $term, &$results ) {
		try {
			$handle = @fopen( $file_path, 'r' );

			if ( ! $handle ) {
				return;
			}

			$line_number = 0;

			while ( false !== ( $line = fgets( $handle ) ) ) {
				$line_number++;

				if ( false !== stripos( $line, $term ) ) {
					$results[ $file_path ][] = array(
						'line' => $line_number,
						'text' => rtrim( $line, "\r\n" ),
					);
				}
			}

			fclose( $handle );
		} catch ( \Throwable $e ) {
			// Ignore unreadable files.
		}
	}
}
