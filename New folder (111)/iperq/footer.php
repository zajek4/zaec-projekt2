<?php
/**
 * Global IPERQ site footer.
 *
 * Content is managed in Settings > Footer. Layout and visual design remain
 * controlled by this template and assets/css/footer.css.
 *
 * @package Custom_Theme
 */

$is_full_width_layout = custom_theme_is_full_width_layout();
$is_pricing_page      = function_exists( 'custom_theme_is_pricing_page' ) && custom_theme_is_pricing_page();
$is_customers_page    = function_exists( 'custom_theme_is_customers_page' ) && custom_theme_is_customers_page();
$footer_cta_modifier  = $is_pricing_page ? ' biz-footer-cta--pricing' : ( $is_customers_page ? ' biz-footer-cta--customers' : '' );
$footer_settings      = custom_theme_get_footer_settings();
$footer_assets        = get_template_directory_uri() . '/assets/images/footer/';
$footer_logo_url      = custom_theme_footer_image_url(
	$footer_settings['brand']['logo_id'],
	$footer_settings['brand']['logo_url']
);
?>
<?php if ( ! $is_full_width_layout ) : ?>
			</div><!-- .container -->
		</div><!-- #content -->
<?php endif; ?>

	<footer class="biz-footer" aria-label="Site footer">
		<div class="container biz-footer__container">
			<section class="biz-footer-cta<?php echo esc_attr( $footer_cta_modifier ); ?>" aria-labelledby="footer-cta-title">
				<img class="biz-footer-cta__illustration" src="<?php echo esc_url( $footer_assets . 'footer-illustration.svg' ); ?>" width="247" height="253" loading="lazy" decoding="async" alt="">

				<div class="biz-footer-cta__content">
					<?php if ( $is_pricing_page ) : ?>
						<h2 class="biz-footer-cta__title" id="footer-cta-title">Already Have An Account?</h2>
						<p class="biz-footer-cta__copy">Log in to your account.</p>
						<div class="biz-footer-cta__actions">
							<a class="biz-btn biz-btn--mint" href="#">
								Log in
								<img class="biz-footer-cta__arrow" src="<?php echo esc_url( $footer_assets . 'arrow-right.svg' ); ?>" alt="">
							</a>
						</div>
					<?php elseif ( $is_customers_page ) : ?>
						<h2 class="biz-footer-cta__title" id="footer-cta-title">Staying loyal is one tap away!</h2>
						<p class="biz-footer-cta__copy">Keep your loyalty programs together, from your morning coffee spot to your favourite lunch stop. Download IPERQ app!</p>
						<?php custom_theme_store_badges( 'indigo', 'biz-footer-cta__actions' ); ?>
					<?php else : ?>
						<?php if ( ! empty( $footer_settings['cta']['title'] ) ) : ?>
							<h2 class="biz-footer-cta__title" id="footer-cta-title"><?php echo esc_html( $footer_settings['cta']['title'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $footer_settings['cta']['text'] ) ) : ?>
							<p class="biz-footer-cta__copy"><?php echo esc_html( $footer_settings['cta']['text'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $footer_settings['cta']['primary_label'] ) || ! empty( $footer_settings['cta']['secondary_label'] ) ) : ?>
							<div class="biz-footer-cta__actions">
								<?php if ( ! empty( $footer_settings['cta']['primary_label'] ) ) : ?>
									<a class="biz-btn biz-btn--mint" href="<?php echo esc_url( $footer_settings['cta']['primary_url'] ? $footer_settings['cta']['primary_url'] : '#' ); ?>">
										<?php echo esc_html( $footer_settings['cta']['primary_label'] ); ?>
										<img class="biz-footer-cta__arrow" src="<?php echo esc_url( $footer_assets . 'arrow-right.svg' ); ?>" alt="">
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $footer_settings['cta']['secondary_label'] ) ) : ?>
									<a class="biz-btn biz-btn--light" href="<?php echo esc_url( $footer_settings['cta']['secondary_url'] ? $footer_settings['cta']['secondary_url'] : '#' ); ?>">
										<?php echo esc_html( $footer_settings['cta']['secondary_label'] ); ?>
										<img class="biz-footer-cta__arrow" src="<?php echo esc_url( $footer_assets . 'arrow-right.svg' ); ?>" alt="">
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</section>
		</div>

		<div class="biz-footer__main">
			<div class="container biz-footer__container">
				<div class="biz-footer__grid">
					<div class="biz-footer__brand">
						<?php if ( $footer_logo_url ) : ?>
							<img class="biz-footer__logo" src="<?php echo esc_url( $footer_logo_url ); ?>" loading="lazy" decoding="async" alt="IPERQ">
						<?php endif; ?>

						<?php if ( ! empty( $footer_settings['brand']['text'] ) ) : ?>
							<p class="biz-footer__about"><?php echo esc_html( $footer_settings['brand']['text'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $footer_settings['brand']['socials'] ) ) : ?>
							<div class="biz-footer__socials" aria-label="Social media">
								<?php foreach ( $footer_settings['brand']['socials'] as $social ) : ?>
									<?php
									$icon_url = custom_theme_footer_image_url(
										isset( $social['icon_id'] ) ? $social['icon_id'] : 0,
										isset( $social['icon_url'] ) ? $social['icon_url'] : ''
									);
									if ( ! $icon_url ) {
										continue;
									}
									$label = ! empty( $social['label'] ) ? $social['label'] : 'Social media';
									$url   = ! empty( $social['url'] ) ? $social['url'] : '#';
									?>
									<a class="biz-footer__social" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $label ); ?>">
										<img src="<?php echo esc_url( $icon_url ); ?>" loading="lazy" decoding="async" alt="">
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php
					$footer_columns = array(
						'business'  => 'For Businesses',
						'customers' => 'For Customers',
						'other'     => 'Other links',
					);
					foreach ( $footer_columns as $column_key => $aria_label ) :
						$column = $footer_settings['columns'][ $column_key ];
						?>
						<div class="biz-footer__column" aria-label="<?php echo esc_attr( $aria_label ); ?>">
							<?php if ( ! empty( $column['title'] ) ) : ?>
								<h3 class="biz-footer__heading">
									<?php if ( ! empty( $column['title_url'] ) ) : ?>
										<a class="biz-footer__heading-link" href="<?php echo esc_url( $column['title_url'] ); ?>"><?php echo esc_html( $column['title'] ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $column['title'] ); ?>
									<?php endif; ?>
								</h3>
							<?php endif; ?>

							<?php if ( ! empty( $column['links'] ) ) : ?>
								<ul class="biz-footer__links">
									<?php foreach ( $column['links'] as $link ) : ?>
										<?php if ( empty( $link['label'] ) ) { continue; } ?>
										<li>
											<?php if ( ! empty( $link['url'] ) ) : ?>
												<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
											<?php else : ?>
												<span><?php echo esc_html( $link['label'] ); ?></span>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>

					<div class="biz-footer__newsletter">
						<?php if ( ! empty( $footer_settings['newsletter']['title'] ) ) : ?>
							<h3 class="biz-footer__heading">
								<?php if ( ! empty( $footer_settings['newsletter']['title_url'] ) ) : ?>
									<a class="biz-footer__heading-link" href="<?php echo esc_url( $footer_settings['newsletter']['title_url'] ); ?>"><?php echo esc_html( $footer_settings['newsletter']['title'] ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $footer_settings['newsletter']['title'] ); ?>
								<?php endif; ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $footer_settings['newsletter']['text'] ) ) : ?>
							<p class="biz-footer__newsletter-copy"><?php echo esc_html( $footer_settings['newsletter']['text'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $footer_settings['newsletter']['shortcode'] ) ) : ?>
							<div class="biz-footer__newsletter-form">
								<?php echo do_shortcode( $footer_settings['newsletter']['shortcode'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="biz-footer__bar">
			<div class="container biz-footer__container biz-footer__bar-inner">
				<span>© All rights reserved. Powered by IPERQ</span>
				<span>Design: Michel Studio</span>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
