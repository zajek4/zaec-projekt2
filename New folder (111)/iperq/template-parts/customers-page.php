<?php
/**
 * Template Name: For Customers
 * Template Post Type: page
 *
 * IPERQ "For Customers" landing page (Figma: W26-06-IPERQ / FINALNO / For Customers).
 * Header and footer come from header.php / footer.php. Page styles live in
 * assets/css/customers.css; the FAQ reuses the shared .pricing-faq component.
 *
 * @package Custom_Theme
 */

get_header();

$customers_assets = get_template_directory_uri() . '/assets/images/customers/';

$customers_faqs = array(
	array(
		'question' => 'Where can I use IPERQ?',
		'answer'   => 'You can use IPERQ at participating businesses listed in the app. Search for a place or explore the map, then open its profile to see its loyalty program.',
	),
	array(
		'question' => 'Where can I use IPERQ?',
		'answer'   => 'You can use IPERQ at participating businesses listed in the app. Search for a place or explore the map, then open its profile to see its loyalty program.',
	),
	array(
		'question' => 'How does my team award stamps and points?',
		'answer'   => 'You can use IPERQ at participating businesses listed in the app. Search for a place or explore the map, then open its profile to see its loyalty program.',
	),
	array(
		'question' => 'Can I join more than one loyalty program?',
		'answer'   => 'Yes. Join as many programs as you like. Each place keeps its own stamps, points and rewards, and you can follow all of them in the IPERQ app.',
	),
	array(
		'question' => 'How do I collect stamps or points?',
		'answer'   => 'Choose an action in the IPERQ app and show your QR code at the counter. The team scans it and the stamps or points are added to that place’s program.',
	),
	array(
		'question' => 'How do I use a reward or discount?',
		'answer'   => 'When a reward or discount is available, select it in the app and show your QR code. The team confirms it at the counter.',
	),
	array(
		'question' => 'Does every business offer the same rewards?',
		'answer'   => 'No. Each business sets its own program, so stamps, points, rewards and discounts can differ from place to place.',
	),
);
$customers_open_faq = 2;
?>

<main id="main-content" class="customers-page">
	<section class="cust-hero" aria-labelledby="customers-page-title">
		<div class="cust-shell">
			<div class="cust-hero__copy">
				<h1 class="cust-hero__title iperq-display-xl" id="customers-page-title">
					<span>Different Places,</span>
					<span class="cust-hero__title-accent iperq-display-accent">One App.</span>
				</h1>
				<p class="cust-hero__lead iperq-hero-lead">Enjoy rewards at participating cafés, restaurants and bars. Keep your loyalty rewards together in the IPERQ app.</p>
			</div>

			<div class="cust-hero__stage">
				<img class="cust-hero__stars" src="<?php echo esc_url( $customers_assets . 'hero-stars.svg' ); ?>" width="1004" height="312" decoding="async" alt="">
				<div class="cust-phone cust-phone--hero">
					<img class="cust-phone__screen" src="<?php echo esc_url( $customers_assets . 'home-screen.webp' ); ?>" width="402" height="874" decoding="async" fetchpriority="high" alt="IPERQ app home screen with saved loyalty programs">
				</div>
				<img class="cust-hero__stat cust-hero__stat--points" src="<?php echo esc_url( $customers_assets . 'stat-points.webp' ); ?>" width="465" height="306" decoding="async" alt="342 points">
				<img class="cust-hero__stat cust-hero__stat--discounts" src="<?php echo esc_url( $customers_assets . 'stat-discounts.webp' ); ?>" width="465" height="306" decoding="async" alt="8 discounts">
				<img class="cust-hero__illustration" src="<?php echo esc_url( $customers_assets . 'hero-illustration.webp' ); ?>" width="658" height="660" decoding="async" alt="">
			</div>

			<div class="cust-download" id="download">
				<img class="cust-download__illustration" src="<?php echo esc_url( $customers_assets . 'download-illustration.svg' ); ?>" width="307" height="243" loading="lazy" decoding="async" alt="">
				<div class="cust-download__content">
					<h2 class="cust-download__title">Download IPERQ</h2>
					<p class="cust-download__copy">Keep stamps, points and rewards in one app, ready for your next visit.</p>
					<?php custom_theme_store_badges( 'indigo', 'cust-store-badges' ); ?>
				</div>
			</div>
		</div>
	</section>

	<section class="cust-section cust-find" id="find-your-place" aria-labelledby="cust-find-title">
		<div class="cust-shell">
			<div class="cust-split cust-split--text-left">
				<div class="cust-split__copy">
					<h2 class="cust-section__title iperq-heading-xl" id="cust-find-title">Find Your Place.</h2>
					<p class="cust-section__copy">Explore participating cafés, restaurants and bars.<br class="cust-break"> Check what’s on offer and join their loyalty programs in the IPERQ app.</p>
					<img class="cust-find__illustration" src="<?php echo esc_url( $customers_assets . 'cafe-illustration.webp' ); ?>" width="744" height="494" loading="lazy" decoding="async" alt="">
				</div>
				<div class="cust-split__art cust-find__art">
					<div class="cust-phone cust-phone--tilted">
						<img class="cust-phone__screen" src="<?php echo esc_url( $customers_assets . 'establishment-screen.webp' ); ?>" width="402" height="1685" loading="lazy" decoding="async" alt="Coffee House Cafe profile with its coffee stamp card in the IPERQ app">
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="cust-section cust-purchases" id="purchases" aria-labelledby="cust-purchases-title">
		<div class="cust-shell">
			<div class="cust-split cust-split--text-right">
				<div class="cust-split__art cust-purchases__art">
					<img class="cust-purchases__phone" src="<?php echo esc_url( $customers_assets . 'qr-phone.webp' ); ?>" width="880" height="1156" loading="lazy" decoding="async" alt="QR code being scanned in the IPERQ app">
				</div>
				<div class="cust-split__copy">
					<h2 class="cust-section__title iperq-heading-xl" id="cust-purchases-title">Make Your Purchases Count.</h2>
					<p class="cust-section__copy">Show your QR code to collect stamps or points with eligible purchases. Track your progress and redeem available rewards or discounts.</p>
					<img class="cust-purchases__illustration" src="<?php echo esc_url( $customers_assets . 'walking-illustration.webp' ); ?>" width="540" height="580" loading="lazy" decoding="async" alt="">
				</div>
			</div>
		</div>
	</section>

	<section class="cust-section cust-collect" id="stamps-and-points" aria-labelledby="cust-collect-title">
		<div class="cust-shell">
			<header class="cust-collect__header">
				<h2 class="cust-collect__title iperq-heading-xl" id="cust-collect-title">Collect Loyalty Stamps Or Points</h2>
				<p class="cust-collect__copy">Two ways to get more from your favourites.<br> Each business sets its own rewards. Here’s how you can earn them.</p>
			</header>

			<div class="cust-program-cards">
				<article class="cust-program-card cust-program-card--stamps">
					<div class="cust-program-card__visual" aria-hidden="true">
						<img class="cust-program-card__phone" src="<?php echo esc_url( $customers_assets . 'phone-top.webp' ); ?>" width="774" height="654" loading="lazy" decoding="async" alt="">
						<div class="cust-stamp-card">
							<?php
							$stamp_rows = array(
								array( 'full', 'full', 'full', 'full', 'full' ),
								array( 'full', 'full', 'full', 'full', 'add' ),
								array( 'empty', 'empty', 'empty', 'empty', 'empty' ),
							);
							foreach ( $stamp_rows as $stamp_row ) :
								?>
								<div class="cust-stamp-card__row">
									<?php foreach ( $stamp_row as $stamp ) : ?>
										<?php if ( 'full' === $stamp ) : ?>
											<span class="cust-stamp cust-stamp--full"><img src="<?php echo esc_url( $customers_assets . 'coffee-cup.svg' ); ?>" width="24" height="24" alt=""></span>
										<?php elseif ( 'add' === $stamp ) : ?>
											<span class="cust-stamp cust-stamp--add"></span>
										<?php else : ?>
											<span class="cust-stamp cust-stamp--empty"></span>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="cust-program-card__text">
						<h3 class="cust-program-card__title">Digital Stamps</h3>
						<p class="cust-program-card__copy">Think: ten coffees, then one on the house. Collect stamps when you buy eligible items and once your card is complete, claim the reward.</p>
					</div>
				</article>

				<article class="cust-program-card cust-program-card--points">
					<div class="cust-program-card__visual" aria-hidden="true">
						<img class="cust-program-card__phone" src="<?php echo esc_url( $customers_assets . 'phone-top.webp' ); ?>" width="774" height="654" loading="lazy" decoding="async" alt="">
						<div class="cust-points-card">
							<?php
							$point_tiers = array(
								array( '5%', '50/50', 100 ),
								array( '10%', '50/100', 37.255 ),
								array( '15%', '50/200', 18.627 ),
							);
							foreach ( $point_tiers as $tier_index => $tier ) :
								?>
								<div class="cust-points-card__row<?php echo 0 === $tier_index ? ' is-reached' : ''; ?>">
									<span class="cust-points-card__pill"><?php echo esc_html( $tier[0] ); ?></span>
									<span class="cust-points-card__progress">
										<span class="cust-points-card__label"><?php echo esc_html( $tier[1] ); ?></span>
										<span class="cust-points-card__bar"><span style="<?php echo esc_attr( '--cust-progress: ' . $tier[2] . '%' ); ?>"></span></span>
									</span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="cust-program-card__text">
						<h3 class="cust-program-card__title">Points &amp; Discounts</h3>
						<p class="cust-program-card__copy">Watch your points add up. Earn points based on what you spend &amp; exchange them for available discounts. Check your balance in the app.</p>
					</div>
				</article>
			</div>

			<div class="cust-ready">
				<p class="cust-ready__text">Ready to get more from your favourites?</p>
				<?php custom_theme_store_badges( 'white', 'cust-store-badges' ); ?>
			</div>
		</div>
	</section>

	<section class="cust-section cust-loyal" id="be-loyal" aria-labelledby="cust-loyal-title">
		<div class="cust-shell">
			<div class="cust-loyal__inner">
				<div class="cust-loyal__art">
					<div class="cust-phone cust-phone--loyal">
						<img class="cust-phone__screen" src="<?php echo esc_url( $customers_assets . 'home-screen.webp' ); ?>" width="402" height="874" loading="lazy" decoding="async" alt="IPERQ app with Blue Bottle Coffee, Espresso Cat Cafe and Coffee House Cafe">
					</div>
				</div>
				<div class="cust-loyal__content">
					<h2 class="cust-loyal__title" id="cust-loyal-title"><span>Be loyal</span> <span>to your</span> <span>fav place</span></h2>
					<?php custom_theme_store_badges( 'white', 'cust-store-badges' ); ?>
				</div>
			</div>
		</div>
	</section>

	<section class="cust-faq" id="faq" aria-labelledby="cust-faq-title">
		<div class="pricing-shell pricing-faq__inner cust-faq__inner">
			<header class="pricing-faq__header cust-faq__header">
				<h2 class="iperq-heading-xl" id="cust-faq-title">Good To Know</h2>
				<p class="iperq-text-md">Have questions how to use our app? Find quick answers below, or reach out to us anytime.</p>
			</header>

			<div class="pricing-faq__list">
				<?php
				foreach ( $customers_faqs as $index => $faq ) :
					$is_open   = $customers_open_faq === $index;
					$answer_id = 'cust-faq-answer-' . ( $index + 1 );
					?>
					<article class="pricing-faq__item<?php echo $is_open ? ' is-open' : ''; ?>">
						<button class="pricing-faq__question" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $answer_id ); ?>">
							<span><?php echo esc_html( $faq['question'] ); ?></span>
							<span class="pricing-faq__icon" aria-hidden="true"></span>
						</button>
						<div class="pricing-faq__answer" id="<?php echo esc_attr( $answer_id ); ?>">
							<p><?php echo esc_html( $faq['answer'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
