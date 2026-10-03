<?php
/**
 * Template Name: Pricing
 * Template Post Type: page
 *
 * IPERQ pricing page with Stamp-based / Points-based pricing states.
 *
 * @package Custom_Theme
 */

get_header();

$pricing_assets = get_template_directory_uri() . '/assets/images/pricing/';
?>

<main id="main-content" class="pricing-page">
	<section class="pricing-hero" aria-labelledby="pricing-page-title">
		<div class="pricing-shell pricing-hero__inner">
			<div class="pricing-hero__copy">
				<h1 class="pricing-hero__title iperq-display-xl" id="pricing-page-title">
					<span>Pricing Headline,</span>
					<span class="pricing-hero__title-accent iperq-display-accent">Goes Exactly Here.</span>
				</h1>
				<p class="pricing-hero__description iperq-hero-lead">Lorem ipsum dolor sit amet consectetur. Aliquam aliquet pharetra neque sed condimentum nullam ut. Congue elit in porttitor vel. Dapibus scelerisque amet venenatis proin orci id nibh venenatis.</p>
			</div>

			<img class="pricing-hero__artwork" src="<?php echo esc_url( $pricing_assets . 'hero-artwork.svg' ); ?>" width="197" height="269" decoding="async" alt="">
		</div>
	</section>

	<section class="pricing-plans" aria-label="Pricing plans">
		<div class="pricing-shell pricing-plans__inner">
			<div class="pricing-controls">
				<div class="pricing-toggle-group" role="tablist" aria-label="Loyalty program pricing type">
					<button class="pricing-toggle-button iperq-hero-control is-active" type="button" role="tab" id="pricing-tab-stamp" aria-selected="true" aria-controls="pricing-plan-panel" data-pricing-type="stamp">Stamp-based</button>
					<button class="pricing-toggle-button iperq-hero-control" type="button" role="tab" id="pricing-tab-points" aria-selected="false" aria-controls="pricing-plan-panel" data-pricing-type="points">Points-based</button>
				</div>

				<div class="pricing-locations">
					<label for="locations-select">NUMBER OF LOCATIONS:</label>
					<div class="pricing-select-wrap">
						<select id="locations-select" name="locations" aria-label="Number of locations">
							<option value="1" selected>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5+</option>
						</select>
					</div>
				</div>
			</div>

			<p class="pricing-disclaimer">* Price shown is per location per month</p>

			<div class="pricing-cards" id="pricing-plan-panel" role="tabpanel" aria-labelledby="pricing-tab-stamp" data-pricing-mode="stamp">
				<article class="pricing-card pricing-card--bronze" data-pricing-card="stamp-only">
					<div class="pricing-card__header">
						<span class="pricing-card__badge-title">BRONZE STAMP-BASED</span>
						<div class="pricing-card__price-wrap">
							<span class="pricing-card__currency">$</span>
							<span class="pricing-card__price" data-base-price="29">29</span>
							<span class="pricing-card__period">/ per month</span>
						</div>
						<p class="pricing-card__subtitle">One stamp category — perfect for a single signature offer (e.g. coffee).</p>
					</div>

					<ul class="pricing-card__features">
						<li><span class="pricing-check" aria-hidden="true"></span><span>1 stamp category</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Single signature offer</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Standard cashier mobile app</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Basic customer analytics</span></li>
					</ul>

					<div class="pricing-card__action">
						<a class="pricing-btn pricing-btn--outline" href="#book-a-demo">Choose this plan</a>
					</div>
				</article>

				<article class="pricing-card pricing-card--silver is-featured" data-pricing-card="shared">
					<div class="pricing-card__header">
						<div class="pricing-card__top-bar">
							<span class="pricing-card__badge-title">SILVER STAMP-BASED</span>
							<span class="pricing-card__tag">MOST POPULAR</span>
						</div>
						<div class="pricing-card__price-wrap">
							<span class="pricing-card__currency">$</span>
							<span class="pricing-card__price" data-base-price="79">79</span>
							<span class="pricing-card__period">/ per month</span>
						</div>
						<p class="pricing-card__subtitle">Up to five stamp categories — coffee, pastries, lunch, and more.</p>
					</div>

					<ul class="pricing-card__features">
						<li><span class="pricing-check" aria-hidden="true"></span><span>2 - 5 stamp categories</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Coffee, pastries, lunch &amp; more</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Multi-device cashier sync</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Advanced customer behavior insights</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>QR code flyers &amp; marketing kit</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Email support (24h response)</span></li>
					</ul>

					<div class="pricing-card__action">
						<a class="pricing-btn pricing-btn--primary" href="#book-a-demo">Choose this plan</a>
					</div>
				</article>

				<article class="pricing-card pricing-card--gold" data-pricing-card="stamp-only">
					<div class="pricing-card__header">
						<span class="pricing-card__badge-title">GOLD STAMP-BASED</span>
						<div class="pricing-card__price-wrap">
							<span class="pricing-card__currency">$</span>
							<span class="pricing-card__price" data-base-price="129">129</span>
							<span class="pricing-card__period">/ per month</span>
						</div>
						<p class="pricing-card__subtitle">Unlimited stamp categories for businesses with a wide product range.</p>
					</div>

					<ul class="pricing-card__features">
						<li><span class="pricing-check" aria-hidden="true"></span><span>6+ stamp categories</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Unlimited customized programs</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Wide product range support</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Real-time custom analytics dashboard</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>API access &amp; custom POS integrations</span></li>
						<li><span class="pricing-check" aria-hidden="true"></span><span>Dedicated account manager</span></li>
					</ul>

					<div class="pricing-card__action">
						<a class="pricing-btn pricing-btn--outline" href="#book-a-demo">Choose this plan</a>
					</div>
				</article>
			</div>

			<div class="pricing-benefits" aria-label="Plan benefits">
				<span>Cancel or switch tiers anytime</span>
				<span>No setup fees</span>
				<span>14-day free trial on all plans</span>
			</div>
		</div>
	</section>

	<section class="pricing-demo" id="book-a-demo" aria-labelledby="pricing-demo-title">
		<div class="pricing-shell pricing-demo__grid">
			<div class="pricing-demo__intro">
				<img class="pricing-demo__illustration" src="<?php echo esc_url( $pricing_assets . 'demo-illustration.png' ); ?>" width="185" height="229" loading="lazy" decoding="async" alt="">
				<h2 class="iperq-heading-xl" id="pricing-demo-title">Book A Demo</h2>
				<p>Take a closer look at the platform, explore stamps and points, and see how your team would handle rewards at the counter.</p>
			</div>

			<div class="pricing-demo__form">
				<?php echo do_shortcode( '[contact-form-7 id="3a59bac" title="Contact form - Pricing"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>

	<section class="pricing-faq" aria-labelledby="pricing-faq-title">
		<div class="pricing-shell pricing-faq__inner">
			<header class="pricing-faq__header">
				<h2 class="iperq-heading-xl" id="pricing-faq-title">Frequently Asked Questions</h2>
				<p class="iperq-text-md">Have questions about setting up your digital rewards or stamps? Find quick answers below, or reach out to our team anytime.</p>
			</header>

			<div class="pricing-faq__list">
				<?php
				$pricing_faqs = array(
					array( 'What’s the difference between stamps and points?', 'Stamps are usually earned per visit or purchase, while points are based on the total amount spent.' ),
					array( 'Can I choose my own rewards?', 'Yes. You can customize the rewards, stamp requirements and special promotion conditions.' ),
					array( 'How does my team award stamps and points?', 'Customers select an action in their IPERQ app and show a QR code. Your team scans it in the cashier app, checks the request and confirms it. When awarding points, staff enter the purchase amount.' ),
					array( 'Do customers need the IPERQ app?', 'Yes, customers use the IPERQ app to collect stamps, track points and redeem rewards.' ),
					array( 'Can I use IPERQ at more than one location?', 'Yes. Multiple business locations can be managed under the same loyalty setup.' ),
					array( 'Can I set up my program myself?', 'Yes. You can set up the program yourself or work with the IPERQ team during onboarding.' ),
					array( 'Can I see a demo before getting started?', 'Yes. Book a demo and the team can walk you through the platform before you get started.' ),
				);

				foreach ( $pricing_faqs as $index => $faq ) :
					$is_open = 2 === $index;
					$answer_id = 'pricing-faq-answer-' . ( $index + 1 );
					?>
					<article class="pricing-faq__item<?php echo $is_open ? ' is-open' : ''; ?>">
						<button class="pricing-faq__question" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $answer_id ); ?>">
							<span><?php echo esc_html( $faq[0] ); ?></span>
							<span class="pricing-faq__icon" aria-hidden="true"></span>
						</button>
						<div class="pricing-faq__answer" id="<?php echo esc_attr( $answer_id ); ?>">
							<p><?php echo esc_html( $faq[1] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
