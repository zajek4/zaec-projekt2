<?php
/**
 * Template Name: Naslovnica V2
 * Template Post Type: page
 *
 * IPERQ business landing-page predložak prema dostavljenom dizajnu.
 * Header i footer dolaze iz header.php / footer.php. Styling sadržaja ove
 * stranice nalazi se u jasno odvojenoj .business-page sekciji style.css-a.
 * Ilustracije stranice koriste URL-ove iz polja ispod.
 *
 * @package Custom_Theme
 */

$iperq_placeholders = array(
	'hero'      => content_url( '/uploads/2026/09/Donut.svg' ),
	'setup'     => content_url( '/uploads/2026/09/Color_x5F_RGB_x5F_0_x5F_0_x5F_0.svg' ),
	'team'      => content_url( '/uploads/2026/09/Semua_x5F_Group_x5F_Warna_x5F_SVG.svg' ),
	'program_stamp'  => content_url( '/uploads/2026/09/Component-10.svg' ),
	'program_coin_1' => content_url( '/uploads/2026/09/Icon-wrapper.svg' ),
	'program_coin_2' => content_url( '/uploads/2026/09/Icon-wrapper2.svg' ),
	'program_person' => content_url( '/uploads/2026/09/magnific_remove-the-bagguette-part_Bh5RmIWoQR-1111.svg' ),
	'program_points' => content_url( '/uploads/2026/09/Component-9.svg' ),
	'walk_qr'        => content_url( '/uploads/2026/09/qrcode.svg' ),
	'walk_rewards'   => content_url( '/uploads/2026/09/rewards.svg' ),
	'walk_confirm'   => content_url( '/uploads/2026/09/valja.svg' ),
	'walk_search'    => content_url( '/uploads/2026/09/povecalo.svg' ),
	'track_screen'   => content_url( '/uploads/2026/09/Cashier-%C2%B7-Award-Points-2.png' ),
	'analytics_transaction' => content_url( '/uploads/2026/09/Transaction-Points-Preview-1.svg' ),
	'analytics_insights'    => content_url( '/uploads/2026/09/Insights-Vertical.svg' ),
	'analytics_person'      => content_url( '/uploads/2026/09/magnific_remove-the-icons-from-the_rg6ms9Wxtc-1.svg' ),
	'cta'       => 'https://placehold.co/300x190/f3eff5/4b006e?text=CTA+illustration',
);

/*
 * Theme-bundled artwork (Figma PORPAVCI update): new hero devices, the
 * "Your customers stay loyal." illustration, Scan & Collect and Reward Your
 * Customers. The phone screens are shared with the For Customers page.
 */
$iperq_business_assets  = get_template_directory_uri() . '/assets/images/business/';
$iperq_customers_assets = get_template_directory_uri() . '/assets/images/customers/';

/* "Talk To Us" / "Book a Demo" lead to the contact form on the Pricing page. */
$iperq_contact_url = home_url( '/pricing/#book-a-demo' );

get_header();
?>

<main id="main-content" class="business-page__content">
	<section class="biz-hero">
			<div class="biz-narrow biz-hero__content">
				<h1 class="biz-title iperq-display-xl">Give Customers<br><span class="biz-title--mint iperq-display-accent">Reasons To Stay Loyal.</span></h1>
				<p class="biz-copy biz-hero__intro iperq-hero-lead">Bring a digital loyalty program to your restaurants, cafés &amp; bars. Connect your business with a dedicated cashier app for your team &amp; a rewards app for your customers.</p>
				<div class="biz-actions">
					<a class="biz-btn biz-btn--mint iperq-hero-control" href="#get-started">Get Started <span class="biz-btn__arrow">→</span></a>
					<a class="biz-btn iperq-hero-control" href="<?php echo esc_url( $iperq_contact_url ); ?>">Talk To Us <span class="biz-btn__arrow">→</span></a>
				</div>
				<p class="biz-hero__note iperq-caption">Set up the program yourself, or talk to our team first.</p>
				<img class="biz-hero__art biz-placeholder" src="<?php echo esc_url( $iperq_placeholders['hero'] ); ?>" width="206" height="221" decoding="async" alt="Placeholder for hero illustration">
			</div>
	
			<div class="biz-pos" aria-label="IPERQ cashier and customer apps">
				<div class="biz-device biz-device--cashier">
					<img class="biz-device__screen" src="<?php echo esc_url( $iperq_business_assets . 'cashier-award-points.webp' ); ?>" width="1280" height="800" loading="eager" decoding="async" fetchpriority="high" alt="Cashier app: points request for a 24.50 receipt">
				</div>
				<div class="biz-device biz-device--phone">
					<img class="biz-device__screen" src="<?php echo esc_url( $iperq_customers_assets . 'home-screen.webp' ); ?>" width="402" height="874" loading="eager" decoding="async" alt="IPERQ customer app with saved loyalty programs">
				</div>
				<img class="biz-device biz-device--scan" src="<?php echo esc_url( $iperq_business_assets . 'cashier-scan-app.webp' ); ?>" width="1280" height="800" loading="eager" decoding="async" alt="Cashier app scanning a customer QR code">
			</div>
		</section>
	
		<section class="biz-section biz-how" id="how">
			<div class="biz-shell">
				<div class="biz-section-head">
					<h2 class="biz-title biz-title--mint iperq-heading-xl">How Does IPERQ Work?</h2>
					<p class="biz-copy iperq-text-md">One program. Everyone connected.</p>
				</div>
				<div class="biz-step-grid">
					<article class="biz-step-card"><h3 class="iperq-heading-lg">You set the reward system.</h3><p class="iperq-text-sm">Register your business and choose the food &amp; drinks categories of your offer &amp; set the rewards.</p><img src="<?php echo esc_url( $iperq_placeholders['setup'] ); ?>" loading="lazy" decoding="async" alt="Reward system illustration"></article>
					<article class="biz-step-card"><h3 class="iperq-heading-lg">Your team makes it happen.</h3><p class="iperq-text-sm">Staff scan customer QR codes in the cashier app to award stamps &amp; points or approve rewards &amp; discounts.</p><img src="<?php echo esc_url( $iperq_placeholders['team'] ); ?>" loading="lazy" decoding="async" alt="Staff illustration"></article>
					<article class="biz-step-card"><h3 class="iperq-heading-lg">Your customers stay loyal.</h3><p class="iperq-text-sm">Customers track their progress &amp; show their QR code when it's time to collect or redeem.</p><img class="biz-step-card__art--customers" src="<?php echo esc_url( $iperq_business_assets . 'customers-stay-loyal.svg' ); ?>" width="149" height="199" loading="lazy" decoding="async" alt="Customer holding a coffee cup with the IPERQ QR code"></article>
				</div>
			</div>
		</section>
	
		<section class="biz-section biz-program" id="get-started">
			<div class="biz-narrow biz-split">
				<div class="biz-split__copy">
					<h2 class="biz-title biz-title--mint iperq-heading-xl">Pick Your Loyalty Program</h2>
					<p class="biz-copy iperq-text-md">Choose digital stamps for repeat purchases or<br>points based on spending. Set clear goals and give customers something to look forward to.</p>
					<a class="biz-btn biz-btn--mint iperq-button-label" href="#">Get Started <span class="biz-btn__arrow">→</span></a>
				</div>
				<div class="biz-program-art" aria-label="Loyalty program previews">
					<img class="biz-program-image biz-program-image--stamp" src="<?php echo esc_url( $iperq_placeholders['program_stamp'] ); ?>" loading="lazy" decoding="async" alt="Stamp-based loyalty program">
					<img class="biz-program-image biz-program-image--coin-large" src="<?php echo esc_url( $iperq_placeholders['program_coin_1'] ); ?>" loading="lazy" decoding="async" alt="">
					<img class="biz-program-image biz-program-image--coin-small" src="<?php echo esc_url( $iperq_placeholders['program_coin_2'] ); ?>" loading="lazy" decoding="async" alt="">
					<img class="biz-program-image biz-program-image--person" src="<?php echo esc_url( $iperq_placeholders['program_person'] ); ?>" loading="lazy" decoding="async" alt="Customer illustration">
					<img class="biz-program-image biz-program-image--points" src="<?php echo esc_url( $iperq_placeholders['program_points'] ); ?>" loading="lazy" decoding="async" alt="Points-based loyalty program">
				</div>
			</div>
		</section>
	
		<section class="biz-track biz-collect" aria-label="Scan and collect">
			<div class="biz-shell">
				<h2 class="biz-track__word biz-collect__word"><span>Scan</span><span>&amp; Collect</span></h2>
				<img class="biz-collect-image" src="<?php echo esc_url( $iperq_business_assets . 'cashier-scan-app.webp' ); ?>" width="1280" height="800" loading="lazy" decoding="async" alt="Cashier app asking the customer to show their QR code">
			</div>
		</section>
	
		<section class="biz-section biz-walkthrough" id="walkthrough">
			<div class="biz-shell">
				<div class="biz-section-head">
					<h2 class="biz-title biz-title--mint iperq-heading-xl">A Simple Cashier<span class="biz-title-break biz-title-break--mobile"><br></span><span class="biz-title-break biz-title-break--desktop"> App<br></span><span class="biz-title-mobile-prefix"> App</span> Walkthrough</h2>
					<p class="biz-copy biz-walkthrough__lead iperq-text-md">Train your team in under 60 seconds. Learn how to award stamps, track points, and validate client rewards with zero friction.</p>
				</div>
				<div class="biz-walkthrough-grid">
					<article class="biz-walk-card is-active" tabindex="0"><div class="biz-walk-card__top"><span class="biz-walk-card__num">01</span><span class="biz-walk-card__icon"><img src="<?php echo esc_url( $iperq_placeholders['walk_qr'] ); ?>" loading="lazy" decoding="async" alt=""></span></div><h3>Scan the customer's<br>QR code</h3><p>The customer selects an action in their IPERQ app and shows the code. Your team scans it to open the request.</p></article>
					<article class="biz-walk-card" tabindex="0"><div class="biz-walk-card__top"><span class="biz-walk-card__num">02</span><span class="biz-walk-card__icon"><img src="<?php echo esc_url( $iperq_placeholders['walk_rewards'] ); ?>" loading="lazy" decoding="async" alt=""></span></div><h3>Check the details</h3><p>Review the requested stamps, rewards or discount. For points, enter the purchase amount.</p></article>
					<article class="biz-walk-card" tabindex="0"><div class="biz-walk-card__top"><span class="biz-walk-card__num">03</span><span class="biz-walk-card__icon"><img src="<?php echo esc_url( $iperq_placeholders['walk_confirm'] ); ?>" loading="lazy" decoding="async" alt=""></span></div><h3>Confirm the transaction</h3><p>Approve the request and get a clear confirmation. Your team is ready for the next customer.</p></article>
					<article class="biz-walk-card" tabindex="0"><div class="biz-walk-card__top"><span class="biz-walk-card__num">04</span><span class="biz-walk-card__icon"><img src="<?php echo esc_url( $iperq_placeholders['walk_search'] ); ?>" loading="lazy" decoding="async" alt=""></span></div><h3>Keep recent activity in view</h3><p>Check recent transactions and their status with organized requests handled from one place.</p></article>
				</div>
				<div class="biz-dots"><i></i><i></i><i></i></div>
				<div class="biz-demo-row"><span class="iperq-caption">Ready to deploy this to your tablets?</span><a class="biz-btn biz-btn--mint iperq-button-label" href="<?php echo esc_url( $iperq_contact_url ); ?>">Book a Demo <span>→</span></a></div>
			</div>
		</section>
	
		<section class="biz-reward" id="rewards">
			<div class="biz-reward-grid">
				<div class="biz-reward-art" aria-label="Customer rewards previews">
					<img class="biz-reward-insights" src="<?php echo esc_url( $iperq_placeholders['analytics_insights'] ); ?>" width="434" height="318" loading="lazy" decoding="async" alt="Insights: 48 stamps and 13 rewards in the last 6 months">
					<div class="biz-reward-stats">
						<p class="biz-reward-stats__item"><strong>12</strong><span>Stamp-based</span></p>
						<p class="biz-reward-stats__item"><strong>4</strong><span>Point-based</span></p>
					</div>
					<div class="biz-device biz-device--reward">
						<img class="biz-device__screen" src="<?php echo esc_url( $iperq_customers_assets . 'establishment-screen.webp' ); ?>" width="402" height="1685" loading="lazy" decoding="async" alt="Coffee House Cafe stamp cards and rewards in the IPERQ app">
					</div>
				</div>
				<div class="biz-reward-copy">
					<h2 class="biz-title biz-title--mint iperq-heading-xl">Reward Your Customers</h2>
					<p class="biz-copy iperq-text-md">Give customers rewards and discounts they can earn through your loyalty program. They can track their progress and see what’s ready to redeem in the IPERQ app.</p>
					<a class="biz-btn biz-btn--mint iperq-button-label" href="<?php echo esc_url( home_url( '/for-customers/' ) ); ?>">Customer Experience <span>→</span></a>
				</div>
			</div>
		</section>
	
		<section class="biz-track">
			<div class="biz-shell" style="position:relative">
				<h2 class="biz-track__word"><span>Track</span><span>Analytics</span></h2>
				<img class="biz-track-image" src="<?php echo esc_url( $iperq_placeholders['track_screen'] ); ?>" loading="lazy" decoding="async" alt="Cashier award points screen">
			</div>
		</section>
	
		<section class="biz-analytics" id="analytics">
			<div class="biz-narrow biz-analytics-grid">
				<div class="biz-analytics-art">
					<img class="biz-analytics-image biz-analytics-image--transaction" src="<?php echo esc_url( $iperq_placeholders['analytics_transaction'] ); ?>" loading="lazy" decoding="async" alt="Transaction points preview">
					<img class="biz-analytics-image biz-analytics-image--insights" src="<?php echo esc_url( $iperq_placeholders['analytics_insights'] ); ?>" loading="lazy" decoding="async" alt="Loyalty program insights">
					<img class="biz-analytics-image biz-analytics-image--person" src="<?php echo esc_url( $iperq_placeholders['analytics_person'] ); ?>" loading="lazy" decoding="async" alt="Analytics illustration">
				</div>
				<div class="biz-analytics-copy">
					<h2 class="biz-title biz-title--mint iperq-heading-xl">See how your loyalty program is performing.</h2>
					<p class="biz-copy iperq-text-md">Follow your program’s performance through the IPERQ business dashboard. Use customer loyalty insights to review your reward strategy and make informed decisions about what comes next.</p>
					<a class="biz-btn biz-btn--mint iperq-button-label" href="#">Get Started <span>→</span></a>
				</div>
			</div>
		</section>
</main>

<?php
get_footer();
