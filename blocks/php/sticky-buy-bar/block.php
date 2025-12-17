<?php
/**
 * Sticky Buy Bar Block
 * Floating add-to-cart bar for product pages
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Sticky Buy Bar Block
 */
function stone_mason_register_sticky_buy_bar_block() {
	register_block_type(
		'stone-mason/sticky-buy-bar',
		array(
			'api_version'     => 3,
			'title'           => __( 'Sticky Buy Bar', 'stone-mason' ),
			'description'     => __( 'Floating add-to-cart bar that appears on scroll', 'stone-mason' ),
			'category'        => 'stone-mason',
			'icon'            => 'admin-post',
			'keywords'        => array( 'sticky', 'cart', 'buy', 'floating', 'woocommerce' ),
			'supports'        => array(
				'align'      => false,
				'anchor'     => true,
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
				'showImage'       => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showPrice'       => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'buttonText'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'threshold'       => array(
					'type'    => 'number',
					'default' => 500,
				),
			),
			'render_callback' => 'stone_mason_render_sticky_buy_bar_block',
		)
	);
}
add_action( 'init', 'stone_mason_register_sticky_buy_bar_block' );

/**
 * Render Sticky Buy Bar Block
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Block HTML.
 */
function stone_mason_render_sticky_buy_bar_block( $attributes, $content ) {
	$product_id  = isset( $attributes['productId'] ) ? absint( $attributes['productId'] ) : 0;
	$show_image  = isset( $attributes['showImage'] ) ? (bool) $attributes['showImage'] : true;
	$show_price  = isset( $attributes['showPrice'] ) ? (bool) $attributes['showPrice'] : true;
	$button_text = isset( $attributes['buttonText'] ) ? esc_html( $attributes['buttonText'] ) : '';
	$threshold   = isset( $attributes['threshold'] ) ? absint( $attributes['threshold'] ) : 500;

	// Try to get product from current post if not specified.
	if ( ! $product_id && is_singular( 'product' ) ) {
		$product_id = get_the_ID();
	}

	// Bail if no product ID or WooCommerce not active.
	if ( ! $product_id || ! function_exists( 'wc_get_product' ) ) {
		return '';
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

	// Build wrapper attributes.
	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class'         => 'mason-sticky-buy-bar',
			'data-threshold' => $threshold,
			'role'          => 'complementary',
			'aria-label'    => __( 'Quick purchase options', 'stone-mason' ),
		)
	);

	// Build output.
	ob_start();
	?>
	<div <?php echo $wrapper_attributes; ?>>
		<div class="mason-sticky-buy-bar__container">
			<?php if ( $show_image && $product->get_image_id() ) : ?>
				<div class="mason-sticky-buy-bar__image">
					<?php
					echo wp_get_attachment_image(
						$product->get_image_id(),
						'thumbnail',
						false,
						array(
							'alt'     => esc_attr( $product->get_name() ),
							'loading' => 'lazy',
						)
					);
					?>
				</div>
			<?php endif; ?>

			<div class="mason-sticky-buy-bar__info">
				<h3 class="mason-sticky-buy-bar__title">
					<?php echo esc_html( $product->get_name() ); ?>
				</h3>
				
				<?php if ( $show_price ) : ?>
					<div class="mason-sticky-buy-bar__price">
						<?php echo $product->get_price_html(); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="mason-sticky-buy-bar__actions">
				<a 
					href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
					class="mason-sticky-buy-bar__button wp-block-button__link"
					data-product-id="<?php echo esc_attr( $product_id ); ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'stone-mason' ), $product->get_name() ) ); ?>"
				>
					<?php echo $button_text; ?>
				</a>
			</div>
		</div>
	</div>

	<script>
	(function() {
		'use strict';
		
		// Initialize sticky bar on DOM ready
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initStickyBar);
		} else {
			initStickyBar();
		}
		
		function initStickyBar() {
			const stickyBar = document.querySelector('.mason-sticky-buy-bar');
			if (!stickyBar) return;
			
			const threshold = parseInt(stickyBar.dataset.threshold || '500', 10);
			let ticking = false;
			
			function updateStickyBar() {
				const scrollY = window.scrollY || window.pageYOffset;
				
				if (scrollY > threshold) {
					stickyBar.classList.add('is-visible');
				} else {
					stickyBar.classList.remove('is-visible');
				}
				
				ticking = false;
			}
			
			function requestUpdate() {
				if (!ticking) {
					window.requestAnimationFrame(updateStickyBar);
					ticking = true;
				}
			}
			
			window.addEventListener('scroll', requestUpdate, { passive: true });
			updateStickyBar(); // Initial check
		}
	})();
	</script>
	<?php
	return ob_get_clean();
}
