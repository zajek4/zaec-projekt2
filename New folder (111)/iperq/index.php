<?php
/**
 * Glavni predložak (fallback za sve ostale).
 *
 * @package Custom_Theme
 */

get_header();
?>

<main id="primary" class="content-area">
	<div id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header class="page-header">
					<h1 class="page-title"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
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
