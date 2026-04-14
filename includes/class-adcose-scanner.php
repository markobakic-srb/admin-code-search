<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ADCOSE_Scanner {

	/**
	 * Maximum number of matches returned per search.
	 *
	 * @var int
	 */
	const MAX_RESULTS = 500;

	/**
	 * Scan directories for matching lines.
	 *
	 * @param array   $dirs           Directories to scan.
	 * @param string  $term           Search term.
	 * @param array   $extensions     Allowed file extensions.
	 * @param array   $exclude_names  Excluded path fragments.
	 * @param boolean $case_sensitive Whether search is case-sensitive.
	 * @param string  $match_mode     Match mode: partial, whole_word, or exact.
	 * @return array
	 */
	public function scan( $dirs, $term, $extensions, $exclude_names, $case_sensitive = false, $match_mode = 'partial' ) {
		$results = array();
		$summary = array(
			'total_matches' => 0,
			'total_files'   => 0,
			'was_limited'   => false,
			'result_limit'  => self::MAX_RESULTS,
		);

		$flags = FilesystemIterator::SKIP_DOTS;

		foreach ( $dirs as $base_dir ) {
			if ( ! is_dir( $base_dir ) ) {
				continue;
			}

			$iterator = new RecursiveIteratorIterator(
				new RecursiveCallbackFilterIterator(
					new RecursiveDirectoryIterator( $base_dir, $flags ),
					function ( $current ) use ( $extensions, $exclude_names ) {
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
				if ( $summary['total_matches'] >= self::MAX_RESULTS ) {
					$summary['was_limited'] = true;
					break;
				}

				$file_path = $file_info->getPathname();
				$this->scan_file( $file_path, $term, $results, $summary, $case_sensitive, $match_mode );
			}

			if ( $summary['total_matches'] >= self::MAX_RESULTS ) {
				$summary['was_limited'] = true;
				break;
			}
		}

		ksort( $results );
		$summary['total_files'] = count( $results );

		return array(
			'results' => $results,
			'summary' => $summary,
		);
	}

	/**
	 * Scan a single file line-by-line.
	 *
	 * @param string  $file_path      File path.
	 * @param string  $term           Search term.
	 * @param array   $results        Results array by reference.
	 * @param array   $summary        Summary array by reference.
	 * @param boolean $case_sensitive Whether search is case-sensitive.
	 * @param string  $match_mode     Match mode: partial, whole_word, or exact.
	 * @return void
	 */
	private function scan_file( $file_path, $term, &$results, &$summary, $case_sensitive = false, $match_mode = 'partial' ) {
		try {
			if ( ! is_readable( $file_path ) ) {
				return;
			}

			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen -- Line-by-line scanning is used intentionally to avoid loading full files into memory.
			$handle = fopen( $file_path, 'r' );

			if ( ! $handle ) {
				return;
			}

			$line_number = 0;

			while ( false !== ( $line = fgets( $handle ) ) ) {
				if ( $summary['total_matches'] >= self::MAX_RESULTS ) {
					$summary['was_limited'] = true;
					break;
				}

				$line_number++;
				$line_to_check = rtrim( $line, "\r\n" );

				if ( 'exact' === $match_mode ) {
					$left  = trim( $line_to_check );
					$right = trim( $term );

					$is_match = $case_sensitive
						? $left === $right
						: strtolower( $left ) === strtolower( $right );
				} elseif ( 'whole_word' === $match_mode ) {
					$pattern = '/\b' . preg_quote( $term, '/' ) . '\b/' . ( $case_sensitive ? '' : 'i' );
					$is_match = 1 === preg_match( $pattern, $line_to_check );
				} else {
					$is_match = $case_sensitive
						? false !== strpos( $line_to_check, $term )
						: false !== stripos( $line_to_check, $term );
				}

				if ( $is_match ) {
					$results[ $file_path ][] = array(
						'line' => $line_number,
						'text' => $line_to_check,
					);

					$summary['total_matches']++;

					if ( $summary['total_matches'] >= self::MAX_RESULTS ) {
						$summary['was_limited'] = true;
						break;
					}
				}
			}

			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose -- Paired with fopen() for efficient line-by-line scanning.
			fclose( $handle );
		} catch ( \Throwable $e ) {
			// Ignore unreadable files.
		}
	}
}