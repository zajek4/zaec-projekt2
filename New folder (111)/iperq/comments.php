<?php
/**
 * Predložak za prikaz i formu komentara.
 *
 * @package Custom_Theme
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$custom_theme_comment_count = get_comments_number();
			if ( '1' === $custom_theme_comment_count ) {
				esc_html_e( '1 komentar', 'custom-theme' );
			} else {
				printf(
					/* translators: %s: broj komentara. */
					esc_html( _n( '%s komentar', '%s komentara', $custom_theme_comment_count, 'custom-theme' ) ),
					number_format_i18n( $custom_theme_comment_count )
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => esc_html__( '&larr; Starije', 'custom-theme' ),
				'next_text' => esc_html__( 'Novije &rarr;', 'custom-theme' ),
			)
		);
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Komentari su zatvoreni.', 'custom-theme' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply' => esc_html__( 'Ostavite komentar', 'custom-theme' ),
			'class_submit' => 'submit',
		)
	);
	?>

</div><!-- #comments -->
