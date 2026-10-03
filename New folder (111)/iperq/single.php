<?php
/**
 * Predložak za pojedinačni post.
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

			get_template_part( 'template-parts/content', 'single' );

			the_post_navigation(
				array(
					'prev_text' => '&larr; %title',
					'next_text' => '%title &rarr;',
				)
			);

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
