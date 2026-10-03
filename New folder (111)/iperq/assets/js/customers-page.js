/**
 * IPERQ For Customers page interactions.
 *
 * The FAQ uses the shared .pricing-faq markup, so the accordion behaves exactly
 * like the one on the Pricing page: one item open at a time, and the row above
 * the open card drops its separator.
 */
(function () {
	'use strict';

	const onReady = (callback) => {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', callback, { once: true });
		} else {
			callback();
		}
	};

	onReady(() => {
		const page = document.querySelector('.customers-page');
		if (!page) return;

		const faqItems = Array.from(page.querySelectorAll('.pricing-faq__item'));

		const syncFaqAdjacency = () => {
			faqItems.forEach((faqItem) => faqItem.classList.remove('is-before-open'));
			const openItem = faqItems.find((faqItem) => faqItem.classList.contains('is-open'));
			if (!openItem) return;
			const previousItem = openItem.previousElementSibling;
			if (previousItem && previousItem.classList.contains('pricing-faq__item')) {
				previousItem.classList.add('is-before-open');
			}
		};

		faqItems.forEach((item) => {
			const button = item.querySelector('.pricing-faq__question');
			if (!button) return;

			button.addEventListener('click', () => {
				const willOpen = !item.classList.contains('is-open');

				faqItems.forEach((otherItem) => {
					otherItem.classList.remove('is-open');
					const otherButton = otherItem.querySelector('.pricing-faq__question');
					if (otherButton) otherButton.setAttribute('aria-expanded', 'false');
				});

				if (willOpen) {
					item.classList.add('is-open');
					button.setAttribute('aria-expanded', 'true');
				}

				syncFaqAdjacency();
			});
		});

		syncFaqAdjacency();
	});
})();
