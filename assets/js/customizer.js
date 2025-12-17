/**
 * Customizer Live Preview
 * File: assets/js/customizer.js
 *
 * @package Mason
 */

(function ($) {
	'use strict';

	// Body font size
	wp.customize('mason_body_font_size', function (value) {
		value.bind(function (to) {
			document.documentElement.style.setProperty('--mason-body-font-size', to);
		});
	});

	// Heading font weight
	wp.customize('mason_heading_font_weight', function (value) {
		value.bind(function (to) {
			document.documentElement.style.setProperty('--mason-heading-font-weight', to);
		});
	});

})(window.wp.customize);
