<?php
/**
 * Predložak za statičke stranice.
 *
 * @package Custom_Theme
 */

get_header();
?>

<main id="primary" class="content-area">
	<div id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile;
		?>

	</div><!-- .site-main -->
</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
