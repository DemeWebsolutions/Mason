/**
 * Stone Mason - Main JavaScript
 * Minimal, performance-focused scripts
 * 
 * @package StoneMason
 * @since 1.0.0
 */

(function() {
	'use strict';

	/**
	 * Initialize theme functionality
	 */
	function init() {
		// Add loaded class for CSS transitions
		document.body.classList.add('mason-loaded');

		// Lazy load images if IntersectionObserver is supported
		if ('IntersectionObserver' in window) {
			initLazyLoad();
		}

		// Handle skip links for accessibility
		initSkipLinks();

		// Initialize WooCommerce cart updates (if WooCommerce is active)
		initWooCommerceFragments();
	}

	/**
	 * Lazy load images
	 * Performance optimization for images
	 */
	function initLazyLoad() {
		const images = document.querySelectorAll('img[loading="lazy"]');
		
		const imageObserver = new IntersectionObserver((entries, observer) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					const img = entry.target;
					if (img.dataset.src) {
						img.src = img.dataset.src;
						img.removeAttribute('data-src');
					}
					observer.unobserve(img);
				}
			});
		}, {
			rootMargin: '50px 0px',
			threshold: 0.01
		});

		images.forEach(img => imageObserver.observe(img));
	}

	/**
	 * Initialize skip links
	 * Accessibility improvement for keyboard navigation
	 */
	function initSkipLinks() {
		const skipLinks = document.querySelectorAll('a[href^="#"]');
		
		skipLinks.forEach(link => {
			link.addEventListener('click', (e) => {
				const targetId = link.getAttribute('href');
				if (targetId === '#') return;
				
				const target = document.querySelector(targetId);
				if (target) {
					e.preventDefault();
					target.focus();
					target.scrollIntoView({ behavior: 'smooth', block: 'start' });
				}
			});
		});
	}

	/**
	 * WooCommerce cart fragments optimization
	 * Only update when necessary
	 */
	function initWooCommerceFragments() {
		if (typeof wc_add_to_cart_params === 'undefined') {
			return;
		}

		// Debounce cart updates
		let cartUpdateTimer;
		document.addEventListener('added_to_cart', () => {
			clearTimeout(cartUpdateTimer);
			cartUpdateTimer = setTimeout(() => {
				// Cart updated - trigger any necessary UI updates
				document.body.classList.add('mason-cart-updated');
				setTimeout(() => {
					document.body.classList.remove('mason-cart-updated');
				}, 300);
			}, 100);
		});
	}

	/**
	 * Performance: Use requestIdleCallback for non-critical tasks
	 */
	function scheduleLowPriorityTasks() {
		if ('requestIdleCallback' in window) {
			requestIdleCallback(() => {
				// Non-critical initialization tasks
			});
		}
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

	// Schedule low-priority tasks
	scheduleLowPriorityTasks();
})();
