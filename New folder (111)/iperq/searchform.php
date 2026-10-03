<?php
/**
 * Predložak forme za pretragu.
 *
 * @package Custom_Theme
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-field-<?php echo esc_attr( wp_unique_id() ); ?>" class="screen-reader-text">
		<?php esc_html_e( 'Pretraži:', 'custom-theme' ); ?>
	</label>
	<input
		type="search"
		id="search-field-<?php echo esc_attr( wp_unique_id() ); ?>"
		class="search-field"
		placeholder="<?php echo esc_attr_x( 'Pretraži &hellip;', 'placeholder', 'custom-theme' ); ?>"
		value="<?php echo get_search_query(); ?>"
		name="s"
	/>
	<button type="submit" class="search-submit">
		<?php echo esc_html_x( 'Pretraži', 'submit button', 'custom-theme' ); ?>
	</button>
</form>
