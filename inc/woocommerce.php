<?php
/**
 * WooCommerce Customizations
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare WooCommerce support
 */
function stone_mason_woocommerce_support() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 400,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 8,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
}
add_action( 'after_setup_theme', 'stone_mason_woocommerce_support' );

/**
 * WooCommerce Blocks: Add custom CSS classes
 */
function stone_mason_woocommerce_blocks_product_grid_item_html( $html, $data, $product ) {
	// Add custom classes for styling
	return str_replace( 'wc-block-grid__product', 'wc-block-grid__product mason-product-card', $html );
}
add_filter( 'woocommerce_blocks_product_grid_item_html', 'stone_mason_woocommerce_blocks_product_grid_item_html', 10, 3 );

/**
 * Remove WooCommerce breadcrumbs (use block-based navigation instead)
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Remove WooCommerce sidebar (use block-based layouts)
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Optimize product gallery for performance
 */
function stone_mason_woocommerce_gallery_thumbnail_size() {
	return 'mason-product-thumb';
}
add_filter( 'woocommerce_gallery_thumbnail_size', 'stone_mason_woocommerce_gallery_thumbnail_size' );

/**
 * Add custom wrapper for WooCommerce content
 */
function stone_mason_woocommerce_wrapper_start() {
	echo '<div class="woocommerce-wrapper mason-woo-container">';
}
add_action( 'woocommerce_before_main_content', 'stone_mason_woocommerce_wrapper_start', 10 );

function stone_mason_woocommerce_wrapper_end() {
	echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'stone_mason_woocommerce_wrapper_end', 10 );

/**
 * Semantic HTML: Add proper product schema
 */
function stone_mason_product_schema( $markup, $product ) {
	// Enhance product schema for better SEO and accessibility
	return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'stone_mason_product_schema', 10, 2 );

/**
 * Performance: Disable WooCommerce select2
 */
function stone_mason_disable_woocommerce_select2() {
	if ( class_exists( 'woocommerce' ) ) {
		wp_dequeue_style( 'select2' );
		wp_deregister_style( 'select2' );
		wp_dequeue_script( 'select2' );
		wp_deregister_script( 'select2' );
	}
}
add_action( 'wp_enqueue_scripts', 'stone_mason_disable_woocommerce_select2', 100 );

/**
 * Performance: Optimize WooCommerce scripts loading
 */
function stone_mason_optimize_woocommerce_scripts() {
	// Remove password strength meter on checkout (unless on account page)
	if ( ! is_account_page() ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}

	// Remove unnecessary WooCommerce scripts
	if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'woocommerce-general' );
	}
}
add_action( 'wp_enqueue_scripts', 'stone_mason_optimize_woocommerce_scripts', 99 );

/**
 * Add product attributes to blocks
 */
function stone_mason_register_product_attributes() {
	if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				register_taxonomy_for_object_type( 'pa_' . $tax->attribute_name, 'product' );
			}
		}
	}
}
add_action( 'init', 'stone_mason_register_product_attributes' );

/**
 * WooCommerce Blocks: Customize product query
 */
function stone_mason_blocks_product_query( $query_args, $request, $block ) {
	// Optimize query for performance
	$query_args['no_found_rows'] = true;
	$query_args['update_post_meta_cache'] = false;
	$query_args['update_post_term_cache'] = false;
	
	return $query_args;
}
add_filter( 'woocommerce_blocks_product_query', 'stone_mason_blocks_product_query', 10, 3 );

/**
 * Apple-style product display
 * Add custom product card styling for block-based layouts
 */
function stone_mason_product_card_classes( $classes ) {
	$classes[] = 'mason-card';
	$classes[] = 'mason-card--product';
	return $classes;
}
add_filter( 'woocommerce_post_class', 'stone_mason_product_card_classes' );
