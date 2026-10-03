<?php
/**
 * Predložak za prikaz kad nema postova/rezultata.
 *
 * @package Custom_Theme
 */
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Ništa nije pronađeno', 'custom-theme' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: link za objavu prvog posta. */
						__( 'Spremni ste za objavu prvog posta? <a href="%s">Krenite ovdje</a>.', 'custom-theme' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Nažalost, ništa ne odgovara vašem upitu. Pokušajte s drugim ključnim riječima.', 'custom-theme' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'Trenutno nema objavljenog sadržaja.', 'custom-theme' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>
