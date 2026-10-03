<?php
/**
 * Predložak za prikaz posta unutar loopa (single).
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

</article><!-- #post-<?php the_ID(); ?> -->
