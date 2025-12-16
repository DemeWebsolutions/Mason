<?php
/**
 * Stone Mason Theme Functions
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants
 */
define( 'STONE_MASON_VERSION', '1.0.0' );
define( 'STONE_MASON_PATH', get_stylesheet_directory() );
define( 'STONE_MASON_URL', get_stylesheet_directory_uri() );

/**
 * Theme setup
 */
function stone_mason_setup() {
	// Load child theme text domain.
	load_child_theme_textdomain( 'stone-mason', STONE_MASON_PATH . '/languages' );

	// Add support for block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style.css' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for WooCommerce.
	add_theme_support( 'woocommerce' );

	// Add support for WooCommerce product gallery features.
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Declare WooCommerce Blocks compatibility.
	add_theme_support( 'woocommerce-blocks' );
}
add_action( 'after_setup_theme', 'stone_mason_setup' );

/**
 * Enqueue scripts and styles
 * Following strict performance rules - minimal, deferred, conditionally loaded
 */
function stone_mason_enqueue_assets() {
	// Enqueue child theme stylesheet.
	wp_enqueue_style(
		'stone-mason-style',
		STONE_MASON_URL . '/style.css',
		array(),
		STONE_MASON_VERSION
	);

	// WooCommerce styles (only if WooCommerce is active).
	if ( class_exists( 'WooCommerce' ) && file_exists( STONE_MASON_PATH . '/assets/css/woocommerce.css' ) ) {
		wp_enqueue_style(
			'stone-mason-woocommerce',
			STONE_MASON_URL . '/assets/css/woocommerce.css',
			array( 'stone-mason-style' ),
			STONE_MASON_VERSION
		);
	}

	// Optional GSAP - only load when needed (can be controlled via admin or specific templates).
	if ( apply_filters( 'stone_mason_load_gsap', false ) ) {
		wp_enqueue_script(
			'gsap',
			'https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js',
			array(),
			'3.12.5',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}

	// Deferred, minimal custom scripts.
	if ( file_exists( STONE_MASON_PATH . '/assets/js/main.js' ) ) {
		wp_enqueue_script(
			'stone-mason-main',
			STONE_MASON_URL . '/assets/js/main.js',
			array(),
			STONE_MASON_VERSION,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'stone_mason_enqueue_assets' );

/**
 * Register custom block patterns category
 */
function stone_mason_register_block_patterns_category() {
	register_block_pattern_category(
		'stone-mason',
		array(
			'label' => __( 'Stone Mason', 'stone-mason' ),
		)
	);
}
add_action( 'init', 'stone_mason_register_block_patterns_category' );

/**
 * Register custom blocks
 */
function stone_mason_register_blocks() {
	// Register custom PHP blocks.
	if ( file_exists( STONE_MASON_PATH . '/blocks/php/hero-section/block.php' ) ) {
		require_once STONE_MASON_PATH . '/blocks/php/hero-section/block.php';
	}

	// Register product card render callback.
	if ( file_exists( STONE_MASON_PATH . '/blocks/php/product-card/render.php' ) ) {
		require_once STONE_MASON_PATH . '/blocks/php/product-card/render.php';
	}

	// Register custom React blocks (built blocks).
	if ( file_exists( STONE_MASON_PATH . '/blocks/build' ) ) {
		$blocks = glob( STONE_MASON_PATH . '/blocks/build/*', GLOB_ONLYDIR );
		foreach ( $blocks as $block ) {
			if ( file_exists( $block . '/block.json' ) ) {
				register_block_type( $block );
			}
		}
	}
}
add_action( 'init', 'stone_mason_register_blocks' );

/**
 * Performance: Remove unnecessary WordPress features
 */
function stone_mason_performance_optimizations() {
	// Remove emoji scripts.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Remove REST API link.
	remove_action( 'wp_head', 'rest_output_link_wp_head' );

	// Remove oEmbed scripts.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	// Remove generator tag.
	remove_action( 'wp_head', 'wp_generator' );

	// Remove shortlink.
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// Remove RSD link.
	remove_action( 'wp_head', 'rsd_link' );

	// Remove WLW manifest link.
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
add_action( 'init', 'stone_mason_performance_optimizations' );

/**
 * WooCommerce: Disable default styles (use blocks-based styling)
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * WooCommerce: Optimize cart fragments
 */
function stone_mason_optimize_cart_fragments( $fragments ) {
	// Only update necessary fragments.
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'stone_mason_optimize_cart_fragments' );

/**
 * WooCommerce: Disable cart fragmentation on non-cart pages
 */
function stone_mason_disable_cart_fragmentation() {
	if ( is_admin() || is_cart() || is_checkout() ) {
		return;
	}
	wp_dequeue_script( 'wc-cart-fragments' );
}
add_action( 'wp_enqueue_scripts', 'stone_mason_disable_cart_fragmentation', 100 );

/**
 * Add custom image sizes for performance
 */
function stone_mason_custom_image_sizes() {
	// Product thumbnails optimized for performance.
	add_image_size( 'mason-product-thumb', 400, 400, true );
	add_image_size( 'mason-product-large', 800, 800, true );
	add_image_size( 'mason-hero', 1920, 1080, true );
}
add_action( 'after_setup_theme', 'stone_mason_custom_image_sizes' );

/**
 * Security: Remove WordPress version from scripts and styles
 */
function stone_mason_remove_version_scripts_styles( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'stone_mason_remove_version_scripts_styles', 9999 );
add_filter( 'script_loader_src', 'stone_mason_remove_version_scripts_styles', 9999 );

/**
 * Include additional theme files
 */
// Include custom block patterns.
if ( file_exists( STONE_MASON_PATH . '/inc/block-patterns.php' ) ) {
	require_once STONE_MASON_PATH . '/inc/block-patterns.php';
}

// Include WooCommerce customizations.
if ( file_exists( STONE_MASON_PATH . '/inc/woocommerce.php' ) ) {
	require_once STONE_MASON_PATH . '/inc/woocommerce.php';
}

// Include performance utilities.
if ( file_exists( STONE_MASON_PATH . '/inc/performance.php' ) ) {
	require_once STONE_MASON_PATH . '/inc/performance.php';
}
