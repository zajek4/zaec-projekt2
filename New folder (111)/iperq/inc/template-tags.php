<?php
/**
 * Custom template tag funkcije za temu.
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'custom_theme_posts_pagination' ) ) :
	/**
	 * Ispis paginacije za listu postova (numerirano).
	 */
	function custom_theme_posts_pagination() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => esc_html__( '&larr; Starije objave', 'custom-theme' ),
				'next_text' => esc_html__( 'Novije objave &rarr;', 'custom-theme' ),
				'screen_reader_text' => esc_html__( 'Navigacija po objavama', 'custom-theme' ),
			)
		);
	}
endif;

if ( ! function_exists( 'custom_theme_entry_footer' ) ) :
	/**
	 * Ispis meta podataka posta (kategorije, oznake, uredi link).
	 */
	function custom_theme_entry_footer() {
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'custom-theme' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . esc_html__( 'Kategorije: %s', 'custom-theme' ) . '</span>', $categories_list );
			}
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: naziv posta. */
					__( 'Uredi <span class="screen-reader-text">%s</span>', 'custom-theme' ),
					array( 'span' => array( 'class' => array() ) )
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'custom_theme_avatar' ) ) :
	/**
	 * Vraća avatar autora određene veličine (helper).
	 */
	function custom_theme_avatar( $size = 48 ) {
		return get_avatar( get_the_author_meta( 'ID' ), $size );
	}
endif;
