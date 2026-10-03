/**
 * IPERQ global header interactions.
 * Desktop: full navigation morphs into the existing compact/mobile shell after scroll.
 * Mobile/tablet: existing expandable mint header behaviour remains unchanged.
 */
document.addEventListener('DOMContentLoaded', function () {
	var header = document.querySelector('.biz-header');
	if (!header) {
		return;
	}

	var toggle = header.querySelector('.biz-menu-toggle');
	var mobilePanel = header.querySelector('#business-mobile-menu');
	var mobileHeader = window.matchMedia('(max-width: 900px)');
	var compactMobileHeader = window.matchMedia('(max-width: 600px)');
	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var menuOpen = false;
	var submenuCounter = 0;
	var scrollTicking = false;
	var desktopCompactStartOffset = 72;
	var desktopCompactEndOffset = 16;
	var desktopReturnTimer = null;
	var desktopSettleFrame = null;
	var compactMenuCloseTimer = null;
	var compactMenuCloseDuration = 320;

	/*
	 * Give each visible compact-menu top-level entry a progressive motion offset.
	 * This follows the actual WordPress menu order and stays stable when items
	 * are rearranged in wp-admin.
	 */
	if (mobilePanel) {
		var compactMenuEntries = mobilePanel.querySelectorAll('.biz-mobile-nav__menu > li > a, .biz-mobile-nav__login');
		var compactMenuEntryCount = compactMenuEntries.length;
		compactMenuCloseDuration = 320 + Math.max(0, compactMenuEntryCount - 1) * 24;

		compactMenuEntries.forEach(function (entry, index) {
			entry.style.setProperty('--iperq-mobile-menu-delay', (20 + (index * 38)) + 'ms');
			entry.style.setProperty('--iperq-mobile-menu-exit-delay', ((compactMenuEntryCount - index - 1) * 24) + 'ms');
		});
	}

	function isDesktopCompact() {
		return !mobileHeader.matches && header.classList.contains('is-desktop-compact');
	}

	function canUseCompactPanel() {
		return mobileHeader.matches || isDesktopCompact();
	}

	function directChild(item, selector) {
		return Array.prototype.find.call(item.children, function (child) {
			return child.matches(selector);
		}) || null;
	}

	function setMobileSubmenuHeight(item, open, animate) {
		var submenu = directChild(item, '.sub-menu');
		if (!submenu) {
			return;
		}

		if (!animate || reduceMotion) {
			item.classList.toggle('is-submenu-open', open);
			submenu.style.height = open ? 'auto' : '';
			return;
		}

		if (open) {
			item.classList.add('is-submenu-open');
			submenu.style.height = '0px';

			requestAnimationFrame(function () {
				var targetHeight = submenu.scrollHeight;
				submenu.style.height = targetHeight + 'px';
			});

			var onOpenEnd = function (event) {
				if (event.propertyName !== 'height') {
					return;
				}
				submenu.removeEventListener('transitionend', onOpenEnd);
				if (item.classList.contains('is-submenu-open')) {
					submenu.style.height = 'auto';
				}
			};
			submenu.addEventListener('transitionend', onOpenEnd);
			return;
		}

		var currentHeight = submenu.getBoundingClientRect().height;
		submenu.style.height = currentHeight + 'px';
		void submenu.offsetHeight;

		requestAnimationFrame(function () {
			item.classList.remove('is-submenu-open');
			submenu.style.height = '0px';
		});

		var onCloseEnd = function (event) {
			if (event.propertyName !== 'height') {
				return;
			}
			submenu.removeEventListener('transitionend', onCloseEnd);
			if (!item.classList.contains('is-submenu-open')) {
				submenu.style.removeProperty('height');
			}
		};
		submenu.addEventListener('transitionend', onCloseEnd);
	}

	function setSubmenuState(item, open, animate) {
		var link = directChild(item, 'a');
		if (!link) {
			return;
		}

		var belongsToCompactPanel = Boolean(item.closest('.biz-mobile-panel'));
		link.setAttribute('aria-expanded', open ? 'true' : 'false');

		if (belongsToCompactPanel && canUseCompactPanel()) {
			setMobileSubmenuHeight(item, open, animate !== false);
			return;
		}

		item.classList.toggle('is-submenu-open', open);
	}

	function closeSubmenus(exceptItem, animate) {
		header.querySelectorAll('.menu-item-has-children.is-submenu-open').forEach(function (item) {
			if (item === exceptItem) {
				return;
			}
			setSubmenuState(item, false, animate);
		});
	}

	function finishCompactMenuClose() {
		if (!mobilePanel) {
			return;
		}

		window.clearTimeout(compactMenuCloseTimer);
		compactMenuCloseTimer = null;
		mobilePanel.classList.remove('is-open', 'is-closing');
		header.classList.remove('is-mobile-menu-open');
		closeSubmenus(null, false);
	}

	function setCompactMenu(open, returnFocus, closeImmediately) {
		if (!toggle || !mobilePanel) {
			return;
		}

		var shouldOpen = Boolean(open && canUseCompactPanel());
		window.clearTimeout(compactMenuCloseTimer);
		compactMenuCloseTimer = null;

		if (shouldOpen) {
			menuOpen = true;
			mobilePanel.classList.remove('is-closing');
			mobilePanel.classList.add('is-open');
			mobilePanel.setAttribute('aria-hidden', 'false');
			toggle.setAttribute('aria-expanded', 'true');
			toggle.setAttribute('aria-label', 'Close navigation');
			header.classList.add('is-mobile-menu-open');
			return;
		}

		menuOpen = false;
		mobilePanel.setAttribute('aria-hidden', 'true');
		toggle.setAttribute('aria-expanded', 'false');
		toggle.setAttribute('aria-label', 'Open navigation');

		if (returnFocus && canUseCompactPanel()) {
			toggle.focus();
		}

		if (closeImmediately || reduceMotion || !mobilePanel.classList.contains('is-open')) {
			finishCompactMenuClose();
			return;
		}

		/* Keep the panel expanded until its links have animated out. This avoids
		 * clipping them while the grid track collapses and also makes rapid
		 * close/reopen clicks deterministic. */
		mobilePanel.classList.add('is-closing');
		header.classList.remove('is-mobile-menu-open');
		compactMenuCloseTimer = window.setTimeout(finishCompactMenuClose, compactMenuCloseDuration);
	}

	function cancelDesktopSettle() {
		window.cancelAnimationFrame(desktopSettleFrame);
		desktopSettleFrame = null;
	}

	function settleDesktopLayout() {
		cancelDesktopSettle();
		if (reduceMotion || typeof header.getAnimations !== 'function') {
			return;
		}

		var container = header.querySelector('.biz-header__container');
		if (!container) {
			return;
		}

		function settle() {
			desktopSettleFrame = null;
			if (mobileHeader.matches || !header.classList.contains('is-desktop-returning')) {
				return;
			}

			var widthMotion = container.getAnimations().find(function (animation) {
				return animation.transitionProperty === 'max-width';
			});
			if (!widthMotion) {
				return;
			}

			var frames = widthMotion.effect.getKeyframes();
			var from = parseFloat(frames[0].maxWidth);
			var to = parseFloat(frames[frames.length - 1].maxWidth);
			var current = parseFloat(window.getComputedStyle(container).maxWidth);
			var distance = Math.max(Math.abs(to - from), Math.abs(header.clientWidth - from));
			// The centered container moves each edge by half its width change.
			var remaining = Math.abs(to - current) / Math.abs(to - from) * distance / 2;

			/* At the last physical pixel, simultaneous height/padding/centering
			 * rounding can oscillate in Firefox (including the logo mask). Settle
			 * the remaining layout transitions together, not one rounded box at a
			 * time. Keep all visible motion and the separate background fade intact.
			 * No inline geometry survives completion, reversal or a breakpoint. */
			if (Number.isFinite(remaining) && remaining <= 1 / (window.devicePixelRatio || 1)) {
				header.getAnimations({subtree: true}).forEach(function (animation) {
					if (/^(width|max-width|height|padding-(top|right|bottom|left)|row-gap|column-gap|flex-basis)$/.test(animation.transitionProperty)) {
						animation.finish();
					}
				});
				return;
			}

			desktopSettleFrame = window.requestAnimationFrame(settle);
		}

		desktopSettleFrame = window.requestAnimationFrame(settle);
	}

	function setDesktopCompact(compact) {
		if (mobileHeader.matches) {
			compact = false;
		}

		var currentlyCompact = header.classList.contains('is-desktop-compact');
		if (currentlyCompact === compact) {
			return;
		}

		if (compact) {
			/* Never carry an open desktop dropdown into the compact shell. */
			cancelDesktopSettle();
			window.clearTimeout(desktopReturnTimer);
			desktopReturnTimer = null;
			header.classList.remove('is-desktop-returning');
			closeSubmenus(null, false);
			header.classList.add('is-desktop-compact');
			return;
		}

		/* The compact panel must close before the full desktop navigation returns. */
		setCompactMenu(false, false, true);
		window.clearTimeout(desktopReturnTimer);
		header.classList.add('is-desktop-returning');
		header.classList.remove('is-desktop-compact');
		settleDesktopLayout();
		desktopReturnTimer = window.setTimeout(function () {
			header.classList.remove('is-desktop-returning');
			desktopReturnTimer = null;
		}, 1100);
	}

	function updateScrollState() {
		if (mobileHeader.matches) {
			setDesktopCompact(false);
			header.classList.toggle('is-mobile-scrolled', compactMobileHeader.matches && window.scrollY >= 60);
			return;
		}

		header.classList.remove('is-mobile-scrolled');

		var scrollY = Math.max(0, window.scrollY || window.pageYOffset || 0);
		var currentlyCompact = header.classList.contains('is-desktop-compact');

		/* Start the desktop morph on the first real scroll movement. */
		if (!currentlyCompact && scrollY > desktopCompactStartOffset) {
			setDesktopCompact(true);
		} else if (currentlyCompact && scrollY <= desktopCompactEndOffset) {
			setDesktopCompact(false);
		}
	}

	function requestScrollUpdate() {
		if (scrollTicking) {
			return;
		}

		scrollTicking = true;
		requestAnimationFrame(function () {
			updateScrollState();
			scrollTicking = false;
		});
	}

	if (toggle && mobilePanel) {
		toggle.addEventListener('click', function () {
			setCompactMenu(!menuOpen, false);
		});
	}

	header.querySelectorAll('.menu-item-has-children').forEach(function (item) {
		var link = directChild(item, 'a');
		if (!link) {
			return;
		}

		var belongsToCompactPanel = Boolean(item.closest('.biz-mobile-panel'));
		var submenu = directChild(item, '.sub-menu');
		link.setAttribute('aria-haspopup', 'true');
		link.setAttribute('aria-expanded', 'false');

		if (submenu) {
			submenuCounter += 1;
			if (!submenu.id) {
				submenu.id = 'iperq-header-submenu-' + submenuCounter;
			}
			link.setAttribute('aria-controls', submenu.id);
		}

		link.addEventListener('click', function (event) {
			var shouldHandleCompactPanel = canUseCompactPanel() && belongsToCompactPanel;
			var shouldHandleDesktop = !mobileHeader.matches && !isDesktopCompact() && !belongsToCompactPanel;

			if (!shouldHandleCompactPanel && !shouldHandleDesktop) {
				return;
			}

			/* Parent rows are navigation-group controls in both desktop and compact menus. */
			event.preventDefault();
			var opening = !item.classList.contains('is-submenu-open');
			closeSubmenus(item, true);
			setSubmenuState(item, opening, true);
		});

		item.addEventListener('keydown', function (event) {
			if (event.key !== 'Escape' || !item.classList.contains('is-submenu-open')) {
				return;
			}

			event.stopPropagation();
			setSubmenuState(item, false, false);
			link.focus();
		});
	});

	if (mobilePanel) {
		mobilePanel.addEventListener('click', function (event) {
			var link = event.target.closest('a');
			if (!link) {
				return;
			}

			var parentItem = link.parentElement;
			var isParentToggle = parentItem &&
				parentItem.classList.contains('menu-item-has-children') &&
				link === directChild(parentItem, 'a');

			if (!isParentToggle) {
				setCompactMenu(false, false);
			}
		});
	}

	document.addEventListener('click', function (event) {
		if (header.contains(event.target)) {
			return;
		}

		if (menuOpen) {
			setCompactMenu(false, false);
			return;
		}

		closeSubmenus(null, true);
	});

	document.addEventListener('keydown', function (event) {
		if (event.key !== 'Escape') {
			return;
		}

		if (menuOpen) {
			event.preventDefault();
			setCompactMenu(false, true);
			return;
		}

		closeSubmenus(null, false);
	});

	function handleBreakpointChange() {
		cancelDesktopSettle();
		window.clearTimeout(desktopReturnTimer);
		desktopReturnTimer = null;
		header.classList.remove('is-desktop-returning');
		setCompactMenu(false, false, true);
		closeSubmenus(null, false);

		header.querySelectorAll('.biz-mobile-nav__menu .sub-menu').forEach(function (submenu) {
			submenu.style.removeProperty('height');
		});

		updateScrollState();
	}

	if (typeof mobileHeader.addEventListener === 'function') {
		mobileHeader.addEventListener('change', handleBreakpointChange);
	} else if (typeof mobileHeader.addListener === 'function') {
		mobileHeader.addListener(handleBreakpointChange);
	}

	if (typeof compactMobileHeader.addEventListener === 'function') {
		compactMobileHeader.addEventListener('change', updateScrollState);
	} else if (typeof compactMobileHeader.addListener === 'function') {
		compactMobileHeader.addListener(updateScrollState);
	}

	window.addEventListener('scroll', requestScrollUpdate, {passive: true});
	window.addEventListener('resize', requestScrollUpdate, {passive: true});

	/* Correct state for refreshed/anchored pages without waiting for the first scroll event. */
	updateScrollState();
});
