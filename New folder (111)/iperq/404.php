<?php
/**
 * Predložak za 404 stranicu (nije pronađeno).
 *
 * @package Custom_Theme
 */

get_header();
?>

<main id="primary" class="content-area">
	<div id="main" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Stranica nije pronađena', 'custom-theme' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php esc_html_e( 'Izgleda da ne postoji ništa na ovoj adresi. Pokušajte pretražiti stranicu.', 'custom-theme' ); ?></p>

				<?php get_search_form(); ?>
			</div>
		</section>

	</div><!-- .site-main -->
</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
