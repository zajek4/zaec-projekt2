<?php
/**
 * Predložak za rezultate pretrage.
 *
 * @package Custom_Theme
 */

get_header();
?>

<main id="primary" class="content-area">
	<div id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					printf(
						/* translators: %s: search query. */
						esc_html__( 'Rezultati pretrage za: %s', 'custom-theme' ),
						'<span>' . get_search_query() . '</span>'
					);
					?>
				</h1>
			</header>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'search' );
			endwhile;

			custom_theme_posts_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div><!-- .site-main -->
</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
