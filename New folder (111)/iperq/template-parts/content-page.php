<?php
/**
 * Predložak za prikaz statičke stranice unutar loopa.
 *
 * @package Custom_Theme
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Stranice:', 'custom-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
