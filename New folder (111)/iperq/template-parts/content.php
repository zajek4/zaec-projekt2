<?php
/**
 * Predložak za prikaz posta unutar loopa (default).
 *
 * @package Custom_Theme
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php if ( has_post_thumbnail() && ! is_single() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'custom-theme-thumb-small' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				printf(
					/* translators: 1: datum objave, 2: ime autora. */
					esc_html__( 'Objavljeno %1$s od strane %2$s', 'custom-theme' ),
					'<time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>',
					'<span class="author"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
				);
				?>
			</div>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content();
		} else {
			the_excerpt();
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Stranice:', 'custom-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<?php if ( 'post' === get_post_type() ) : ?>
		<footer class="entry-footer">
			<?php
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . esc_html__( 'Kategorije: %s', 'custom-theme' ) . '</span> ', $categories_list );
			}

			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Oznake: %s', 'custom-theme' ) . '</span>', $tags_list );
			}
			?>
		</footer>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
