<?php
/**
 * Performance Utilities
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add preconnect for performance
 */
function stone_mason_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		// Preconnect to CDN if GSAP is enabled
		if ( apply_filters( 'stone_mason_load_gsap', false ) ) {
			$urls[] = array(
				'href' => 'https://cdn.jsdelivr.net',
			);
		}
	}
	
	return $urls;
}
add_filter( 'wp_resource_hints', 'stone_mason_resource_hints', 10, 2 );

/**
 * Add defer/async attributes to scripts
 */
function stone_mason_defer_scripts( $tag, $handle, $src ) {
	// List of scripts to defer
	$defer_scripts = array(
		'stone-mason-main',
	);

	// Defer specified scripts
	if ( in_array( $handle, $defer_scripts, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'stone_mason_defer_scripts', 10, 3 );

/**
 * Disable WordPress embeds
 */
function stone_mason_disable_embeds() {
	// Remove the REST API endpoint
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );

	// Turn off oEmbed auto discovery
	add_filter( 'embed_oembed_discover', '__return_false' );

	// Remove oEmbed discovery links
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	// Remove oEmbed-specific JavaScript
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	// Remove filter of the oEmbed result before any HTTP requests are made
	remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}
add_action( 'init', 'stone_mason_disable_embeds', 9999 );

/**
 * Add fetchpriority to main content image
 */
function stone_mason_add_fetchpriority( $attr, $attachment, $size ) {
	// Add high priority to first image in content
	static $first_image = true;
	
	if ( $first_image && is_singular() && in_the_loop() && is_main_query() ) {
		$attr['fetchpriority'] = 'high';
		$first_image = false;
	}
	
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'stone_mason_add_fetchpriority', 10, 3 );

/**
 * Clean up head
 */
function stone_mason_cleanup_head() {
	// Remove adjacent posts links
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

	// Remove random post link
	remove_action( 'wp_head', 'start_post_rel_link', 10 );

	// Remove parent post link
	remove_action( 'wp_head', 'parent_post_rel_link', 10 );
}
add_action( 'init', 'stone_mason_cleanup_head' );

/**
 * Optimize Google Fonts loading if used
 */
function stone_mason_google_fonts_optimization() {
	// Add preconnect to Google Fonts if theme uses them
	// Currently using system fonts, but keeping this for future use
	return;
}
add_action( 'wp_head', 'stone_mason_google_fonts_optimization', 1 );

/**
 * Lazy load iframes
 */
function stone_mason_lazy_load_iframes( $content ) {
	if ( is_admin() ) {
		return $content;
	}

	// Add loading="lazy" to iframes
	$content = preg_replace( '/<iframe(.*?)>/', '<iframe loading="lazy"$1>', $content );
	
	return $content;
}
add_filter( 'the_content', 'stone_mason_lazy_load_iframes' );

/**
 * Add width and height to images for CLS prevention
 */
function stone_mason_add_image_dimensions( $html, $post_id, $post_thumbnail_id ) {
	if ( ! $post_thumbnail_id ) {
		return $html;
	}

	$image_meta = wp_get_attachment_metadata( $post_thumbnail_id );
	
	if ( ! empty( $image_meta['width'] ) && ! empty( $image_meta['height'] ) ) {
		// Image already has dimensions
		return $html;
	}

	return $html;
}
add_filter( 'post_thumbnail_html', 'stone_mason_add_image_dimensions', 10, 3 );

/**
 * DNS prefetch for external domains
 */
function stone_mason_dns_prefetch() {
	echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
	echo '<link rel="dns-prefetch" href="//cdn.jsdelivr.net">';
}
add_action( 'wp_head', 'stone_mason_dns_prefetch', 1 );

/**
 * Critical CSS inline (to be populated with actual critical CSS)
 */
function stone_mason_inline_critical_css() {
	// Only on frontend
	if ( is_admin() ) {
		return;
	}

	// Add critical CSS inline for above-the-fold content
	echo '<style id="stone-mason-critical-css">';
	echo 'body{margin:0;padding:0;}';
	echo '.wp-site-blocks{padding:0;}';
	echo '</style>';
}
add_action( 'wp_head', 'stone_mason_inline_critical_css', 1 );
