<?php
/**
 * Product Card Block - Server-side render
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register render callback for product card block
 */
function stone_mason_register_product_card_render() {
	add_filter( 'render_block_data', 'stone_mason_product_card_render_callback', 10, 3 );
}
add_action( 'init', 'stone_mason_register_product_card_render', 20 );

/**
 * Render Product Card Block
 *
 * @param array    $parsed_block The block being rendered.
 * @param array    $source_block The original block.
 * @param WP_Block $parent_block The parent block.
 * @return array Modified block data.
 */
function stone_mason_product_card_render_callback( $parsed_block, $source_block, $parent_block ) {
	if ( 'stone-mason/product-card' !== $parsed_block['blockName'] ) {
		return $parsed_block;
	}

	// Set render callback.
	$parsed_block['attrs']['render_callback'] = 'stone_mason_render_product_card';
	
	return $parsed_block;
}

/**
 * Render the product card
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Block HTML.
 */
function stone_mason_render_product_card( $attributes, $content ) {
	$product_id  = isset( $attributes['productId'] ) ? absint( $attributes['productId'] ) : 0;
	$show_price  = isset( $attributes['showPrice'] ) ? (bool) $attributes['showPrice'] : true;
	$show_button = isset( $attributes['showButton'] ) ? (bool) $attributes['showButton'] : true;
	$button_text = isset( $attributes['buttonText'] ) ? esc_html( $attributes['buttonText'] ) : __( 'Add to Cart', 'stone-mason' );

	// Bail if no product ID or WooCommerce not active.
	if ( ! $product_id || ! function_exists( 'wc_get_product' ) ) {
		return '';
	}

	// Get product.
	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		return '';
	}

	// Build wrapper attributes.
	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => 'mason-product-card',
		)
	);

	// Build output.
	ob_start();
	?>
	<article <?php echo $wrapper_attributes; ?> itemscope itemtype="http://schema.org/Product">
		<div class="mason-product-card__image">
			<?php
			if ( $product->get_image_id() ) {
				echo wp_get_attachment_image(
					$product->get_image_id(),
					'mason-product-large',
					false,
					array(
						'alt'      => esc_attr( $product->get_name() ),
						'loading'  => 'lazy',
						'itemprop' => 'image',
					)
				);
			}
			?>
		</div>

		<div class="mason-product-card__content">
			<h3 class="mason-product-card__title" itemprop="name">
				<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo esc_html( $product->get_name() ); ?>
				</a>
			</h3>

			<?php if ( $show_price ) : ?>
				<div class="mason-product-card__price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>">
					<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>">
					<?php echo $product->get_price_html(); ?>
				</div>
			<?php endif; ?>

			<?php if ( $show_button ) : ?>
				<a 
					href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
					class="mason-product-card__button"
					data-product-id="<?php echo esc_attr( $product_id ); ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'stone-mason' ), $product->get_name() ) ); ?>"
				>
					<?php echo $button_text; ?>
				</a>
			<?php endif; ?>
		</div>
	</article>
	<?php
	return ob_get_clean();
}

/**
 * Filter callback for rendering product card block
 *
 * @param string $block_content Block content.
 * @param array  $block         Block data.
 * @return string Modified block content.
 */
function stone_mason_product_card_render_filter( $block_content, $block ) {
	if ( 'stone-mason/product-card' === $block['blockName'] ) {
		return stone_mason_render_product_card( $block['attrs'], $block_content );
	}
	return $block_content;
}

/**
 * Register product card render callback
 */
function stone_mason_register_product_card_callback() {
	if ( function_exists( 'register_block_type' ) ) {
		// Hook into block rendering.
		add_filter( 'render_block', 'stone_mason_product_card_render_filter', 10, 2 );
	}
}
add_action( 'init', 'stone_mason_register_product_card_callback', 100 );
