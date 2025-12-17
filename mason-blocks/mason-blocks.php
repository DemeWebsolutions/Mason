<?php
/**
 * Plugin Name: Mason Blocks
 * Plugin URI: https://demewebsolutions.com/mason-blocks
 * Description: Custom Gutenberg blocks for Mason theme. Part of Stone Mason Core - a Blocksy-like enhancement system for WordPress.
 * Version: 1.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: DemeWebsolutions.com
 * Author URI: https://demewebsolutions.com
 * License: Proprietary
 * License URI: https://demewebsolutions.com/license
 * Text Domain: mason-blocks
 * Domain Path: /languages
 *
 * @package MasonBlocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants
 */
define( 'MASON_BLOCKS_VERSION', '1.0.0' );
define( 'MASON_BLOCKS_PATH', plugin_dir_path( __FILE__ ) );
define( 'MASON_BLOCKS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Initialize Mason Blocks
 */
class Mason_Blocks {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
	}

	/**
	 * Load plugin textdomain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'mason-blocks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Register custom blocks
	 */
	public function register_blocks() {
		// Register custom PHP blocks.
		$php_blocks = array(
			'hero-section',
			'feature-grid',
			'product-spotlight',
			'sticky-buy-bar',
			'specs-table',
			'section-divider',
		);

		foreach ( $php_blocks as $block ) {
			$block_file = MASON_BLOCKS_PATH . 'blocks/' . $block . '/block.php';
			if ( file_exists( $block_file ) ) {
				require_once $block_file;
			}
		}

		// Register product card render callback.
		if ( file_exists( MASON_BLOCKS_PATH . 'blocks/product-card/render.php' ) ) {
			require_once MASON_BLOCKS_PATH . 'blocks/product-card/render.php';
		}

		// Register custom React blocks (built blocks).
		if ( file_exists( MASON_BLOCKS_PATH . 'blocks/build' ) ) {
			$blocks = glob( MASON_BLOCKS_PATH . 'blocks/build/*', GLOB_ONLYDIR );
			foreach ( $blocks as $block ) {
				if ( file_exists( $block . '/block.json' ) ) {
					register_block_type( $block );
				}
			}
		}
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_assets() {
		// Enqueue blocks stylesheet.
		if ( file_exists( MASON_BLOCKS_PATH . 'assets/css/blocks.css' ) ) {
			wp_enqueue_style(
				'mason-blocks',
				MASON_BLOCKS_URL . 'assets/css/blocks.css',
				array(),
				MASON_BLOCKS_VERSION
			);
		}
	}

	/**
	 * Enqueue block editor assets
	 */
	public function enqueue_editor_assets() {
		// Enqueue editor styles.
		if ( file_exists( MASON_BLOCKS_PATH . 'assets/css/editor.css' ) ) {
			wp_enqueue_style(
				'mason-blocks-editor',
				MASON_BLOCKS_URL . 'assets/css/editor.css',
				array(),
				MASON_BLOCKS_VERSION
			);
		}
	}
}

// Initialize the plugin.
new Mason_Blocks();

/**
 * Register block category
 */
function mason_blocks_register_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'mason',
				'title' => __( 'Mason Blocks', 'mason-blocks' ),
				'icon'  => 'layout',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'mason_blocks_register_category', 10, 1 );
