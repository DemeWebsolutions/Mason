<?php
/**
 * Block Patterns
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register block patterns
 */
function stone_mason_register_patterns() {
	
	/**
	 * Hero Section Pattern
	 */
	register_block_pattern(
		'stone-mason/hero-section',
		array(
			'title'       => __( 'Hero Section', 'stone-mason' ),
			'description' => __( 'A full-width hero section with heading, text, and CTA button', 'stone-mason' ),
			'categories'  => array( 'stone-mason', 'featured' ),
			'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"accent","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-accent-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"xxx-large"} -->
<h1 class="wp-block-heading has-text-align-center has-xxx-large-font-size">Welcome to Stone Mason</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Build beautiful, high-performance WooCommerce sites with block-first architecture</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Get Started</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
		)
	);

	/**
	 * Product Showcase Pattern
	 */
	register_block_pattern(
		'stone-mason/product-showcase',
		array(
			'title'       => __( 'Product Showcase', 'stone-mason' ),
			'description' => __( 'A product showcase section with image and details', 'stone-mason' ),
			'categories'  => array( 'stone-mason', 'woocommerce' ),
			'content'     => '<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading -->
<h2 class="wp-block-heading">Featured Product</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Discover our latest product with cutting-edge features and exceptional quality.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Shop Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
		)
	);

	/**
	 * Feature Grid Pattern
	 */
	register_block_pattern(
		'stone-mason/feature-grid',
		array(
			'title'       => __( 'Feature Grid', 'stone-mason' ),
			'description' => __( 'A grid layout showcasing features or services', 'stone-mason' ),
			'categories'  => array( 'stone-mason' ),
			'content'     => '<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Our Features</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Performance</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lightning-fast load times with 95+ Lighthouse scores</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Accessibility</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>WCAG 2.1 AA compliant with semantic HTML</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Flexibility</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Block-first architecture with zero vendor lock-in</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
		)
	);

	/**
	 * Product Page Layout Pattern
	 */
	register_block_pattern(
		'stone-mason/product-page-layout',
		array(
			'title'       => __( 'Product Page Layout', 'stone-mason' ),
			'description' => __( 'Complete product page with spotlight, specs table, and sticky buy bar', 'stone-mason' ),
			'categories'  => array( 'stone-mason', 'woocommerce' ),
			'content'     => '<!-- wp:stone-mason/product-spotlight /-->

<!-- wp:stone-mason/section-divider /-->

<!-- wp:stone-mason/specs-table /-->

<!-- wp:stone-mason/section-divider /-->

<!-- wp:stone-mason/feature-grid /-->

<!-- wp:stone-mason/sticky-buy-bar /-->',
		)
	);
}
add_action( 'init', 'stone_mason_register_patterns' );
