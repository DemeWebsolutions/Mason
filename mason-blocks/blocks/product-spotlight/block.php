<?php
/**
 * Product Spotlight Block
 * WooCommerce product focus with detailed presentation
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Product Spotlight Block
 */
function stone_mason_register_product_spotlight_block() {
	register_block_type(
		'stone-mason/product-spotlight',
		array(
			'api_version'     => 3,
			'title'           => __( 'Product Spotlight', 'stone-mason' ),
			'description'     => __( 'Highlight a single WooCommerce product with detailed presentation', 'stone-mason' ),
			'category'        => 'stone-mason',
			'icon'            => 'star-filled',
			'keywords'        => array( 'product', 'woocommerce', 'spotlight', 'featured' ),
			'supports'        => array(
				'align'      => array( 'wide', 'full' ),
				'anchor'     => true,
				'spacing'    => array(
					'padding'  => true,
					'margin'   => true,
				),
				'color'      => array(
					'background' => true,
					'text'       => true,
				),
			),
			'attributes'      => array(
				'productId'       => array(
					'type'    => 'number',
					'default' => 0,
				),
				'layout'          => array(
					'type'    => 'string',
					'default' => 'image-left',
				),
				'showPrice'       => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showDescription' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showButton'      => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'buttonText'      => array(
					'type'    => 'string',
					'default' => '',
				),
			),
			'render_callback' => 'stone_mason_render_product_spotlight_block',
		)
	);
}
add_action( 'init', 'stone_mason_register_product_spotlight_block' );

/**
 * Render Product Spotlight Block
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Block HTML.
 */
function stone_mason_render_product_spotlight_block( $attributes, $content ) {
	$product_id       = isset( $attributes['productId'] ) ? absint( $attributes['productId'] ) : 0;
	$layout           = isset( $attributes['layout'] ) ? sanitize_text_field( $attributes['layout'] ) : 'image-left';
	$show_price       = isset( $attributes['showPrice'] ) ? (bool) $attributes['showPrice'] : true;
	$show_description = isset( $attributes['showDescription'] ) ? (bool) $attributes['showDescription'] : true;
	$show_button      = isset( $attributes['showButton'] ) ? (bool) $attributes['showButton'] : true;
	$button_text      = isset( $attributes['buttonText'] ) ? esc_html( $attributes['buttonText'] ) : '';

	// Bail if no product ID or WooCommerce not active.
	if ( ! $product_id || ! function_exists( 'wc_get_product' ) ) {
		return '<div class="mason-product-spotlight-placeholder">' . 
		       __( 'Please select a product in the block settings', 'stone-mason' ) . 
		       '</div>';
	}

	// Get product.
	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		return '';
	}

	// Default button text.
	if ( empty( $button_text ) ) {
		$button_text = __( 'Add to Cart', 'stone-mason' );
	}

	// Build wrapper classes.
	$wrapper_classes = array(
		'mason-product-spotlight',
		'mason-product-spotlight--' . $layout,
	);

	// Build wrapper attributes.
	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => implode( ' ', $wrapper_classes ),
		)
	);

	// Build output.
	ob_start();
	?>
	<div <?php echo $wrapper_attributes; ?> itemscope itemtype="http://schema.org/Product">
		<div class="mason-product-spotlight__image">
			<?php
			if ( $product->get_image_id() ) {
				echo wp_get_attachment_image(
					$product->get_image_id(),
					'large',
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

		<div class="mason-product-spotlight__content">
			<h2 class="mason-product-spotlight__title" itemprop="name">
				<?php echo esc_html( $product->get_name() ); ?>
			</h2>

			<?php if ( $show_price ) : ?>
				<div class="mason-product-spotlight__price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>">
					<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>">
					<?php echo $product->get_price_html(); ?>
				</div>
			<?php endif; ?>

			<?php if ( $show_description && $product->get_short_description() ) : ?>
				<div class="mason-product-spotlight__description" itemprop="description">
					<?php echo wp_kses_post( $product->get_short_description() ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $show_button ) : ?>
				<div class="mason-product-spotlight__actions">
					<a 
						href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
						class="mason-product-spotlight__button wp-block-button__link"
						data-product-id="<?php echo esc_attr( $product_id ); ?>"
						aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'stone-mason' ), $product->get_name() ) ); ?>"
					>
						<?php echo $button_text; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
