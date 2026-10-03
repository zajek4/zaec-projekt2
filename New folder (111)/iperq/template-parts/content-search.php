<?php
/**
 * Predložak za prikaz posta unutar rezultata pretrage.
 *
 * @package Custom_Theme
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<div class="entry-meta">
			<?php echo esc_html( get_the_date() ); ?> &middot; <?php echo esc_html( get_post_type() ); ?>
		</div>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
