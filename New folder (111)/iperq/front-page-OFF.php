<?php
/**
 * Canonical IPERQ front page.
 *
 * The actual business landing markup lives in naslovnica.php so the page
 * template and the site front page always render the same implementation.
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require get_template_directory() . '/naslovnica.php';
