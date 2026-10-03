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
		const pricingPage = document.querySelector('.pricing-page');
		if (!pricingPage) return;

		const tabs = Array.from(pricingPage.querySelectorAll('[data-pricing-type]'));
		const panel = pricingPage.querySelector('#pricing-plan-panel');
		const sideCards = panel ? Array.from(panel.querySelectorAll('[data-pricing-card="stamp-only"]')) : [];
		const locationsSelect = pricingPage.querySelector('#locations-select');
		const prices = panel ? Array.from(panel.querySelectorAll('[data-base-price]')) : [];
		const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		let switchTimer = null;

		const updatePrices = () => {
			if (!locationsSelect) return;

			const locations = Number.parseInt(locationsSelect.value, 10);
			const locationSurcharge = Math.max(0, locations - 1) * 20;

			prices.forEach((price) => {
				const basePrice = Number.parseInt(price.dataset.basePrice, 10);
				if (Number.isNaN(basePrice)) return;
				price.textContent = String(basePrice + locationSurcharge);
			});
		};

		const setPricingMode = (mode, sourceTab) => {
			if (!panel || !['stamp', 'points'].includes(mode)) return;
			if (panel.dataset.pricingMode === mode) return;

			window.clearTimeout(switchTimer);

			tabs.forEach((tab) => {
				const isActive = tab.dataset.pricingType === mode;
				tab.classList.toggle('is-active', isActive);
				tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
				tab.setAttribute('tabindex', isActive ? '0' : '-1');
			});

			if (sourceTab) {
				panel.setAttribute('aria-labelledby', sourceTab.id);
			}

			if (mode === 'points') {
				if (reduceMotion) {
					sideCards.forEach((card) => {
						card.hidden = true;
						card.classList.remove('is-leaving');
					});
					panel.dataset.pricingMode = 'points';
					return;
				}

				sideCards.forEach((card) => card.classList.add('is-leaving'));
				panel.dataset.pricingMode = 'points';
				switchTimer = window.setTimeout(() => {
					sideCards.forEach((card) => {
						card.hidden = true;
						card.classList.remove('is-leaving');
					});
				}, 300);
				return;
			}

			sideCards.forEach((card) => {
				card.hidden = false;
				card.classList.add('is-leaving');
			});
			panel.dataset.pricingMode = 'stamp';
			void panel.offsetWidth;
			requestAnimationFrame(() => {
				requestAnimationFrame(() => {
					sideCards.forEach((card) => card.classList.remove('is-leaving'));
				});
			});
		};

		tabs.forEach((tab, index) => {
			tab.addEventListener('click', () => setPricingMode(tab.dataset.pricingType, tab));
			tab.addEventListener('keydown', (event) => {
				if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
				event.preventDefault();
				let nextIndex = index;
				if (event.key === 'ArrowRight') nextIndex = (index + 1) % tabs.length;
				if (event.key === 'ArrowLeft') nextIndex = (index - 1 + tabs.length) % tabs.length;
				if (event.key === 'Home') nextIndex = 0;
				if (event.key === 'End') nextIndex = tabs.length - 1;
				tabs[nextIndex].focus();
				setPricingMode(tabs[nextIndex].dataset.pricingType, tabs[nextIndex]);
			});
		});

		if (locationsSelect) {
			locationsSelect.addEventListener('change', updatePrices);
			updatePrices();
		}

		const faqItems = Array.from(pricingPage.querySelectorAll('.pricing-faq__item'));

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
