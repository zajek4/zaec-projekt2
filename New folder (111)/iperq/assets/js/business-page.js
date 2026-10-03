/**
 * IPERQ business landing page interactions.
 */
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.biz-walk-card').forEach(function (card) {
		function activate() {
			document.querySelectorAll('.biz-walk-card').forEach(function (item) {
				item.classList.remove('is-active');
			});
			card.classList.add('is-active');
		}

		card.addEventListener('click', activate);
		card.addEventListener('keydown', function (event) {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				activate();
			}
		});
	});
});
