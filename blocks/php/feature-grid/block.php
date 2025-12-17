<?php
/**
 * Feature Grid Block
 * 2-3 column highlights with icons/images
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Feature Grid Block
 */
function stone_mason_register_feature_grid_block() {
	register_block_type(
		'stone-mason/feature-grid',
		array(
			'api_version'     => 3,
			'title'           => __( 'Feature Grid', 'stone-mason' ),
			'description'     => __( '2-3 column feature highlights with icons and descriptions', 'stone-mason' ),
			'category'        => 'stone-mason',
			'icon'            => 'grid-view',
			'keywords'        => array( 'features', 'grid', 'columns', 'highlights' ),
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
				'columns'         => array(
					'type'    => 'number',
					'default' => 3,
				),
				'features'        => array(
					'type'    => 'array',
					'default' => array(
						array(
							'icon'        => '⚡',
							'title'       => __( 'Fast Performance', 'stone-mason' ),
							'description' => __( 'Lightning-fast load times', 'stone-mason' ),
						),
						array(
							'icon'        => '🔒',
							'title'       => __( 'Secure', 'stone-mason' ),
							'description' => __( 'Enterprise-grade security', 'stone-mason' ),
						),
						array(
							'icon'        => '♿',
							'title'       => __( 'Accessible', 'stone-mason' ),
							'description' => __( 'WCAG 2.1 AA compliant', 'stone-mason' ),
						),
					),
				),
			),
			'render_callback' => 'stone_mason_render_feature_grid_block',
		)
	);
}
add_action( 'init', 'stone_mason_register_feature_grid_block' );

/**
 * Render Feature Grid Block
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Block HTML.
 */
function stone_mason_render_feature_grid_block( $attributes, $content ) {
	$columns  = isset( $attributes['columns'] ) ? absint( $attributes['columns'] ) : 3;
	$features = isset( $attributes['features'] ) ? $attributes['features'] : array();

	// Ensure we have at least the default features.
	if ( empty( $features ) ) {
		$features = array(
			array(
				'icon'        => '⚡',
				'title'       => __( 'Fast Performance', 'stone-mason' ),
				'description' => __( 'Lightning-fast load times', 'stone-mason' ),
			),
			array(
				'icon'        => '🔒',
				'title'       => __( 'Secure', 'stone-mason' ),
				'description' => __( 'Enterprise-grade security', 'stone-mason' ),
			),
			array(
				'icon'        => '♿',
				'title'       => __( 'Accessible', 'stone-mason' ),
				'description' => __( 'WCAG 2.1 AA compliant', 'stone-mason' ),
			),
		);
	}

	// Build wrapper classes.
	$wrapper_classes = array(
		'mason-feature-grid',
		'mason-feature-grid--columns-' . $columns,
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
	<div <?php echo $wrapper_attributes; ?>>
		<div class="mason-feature-grid__container">
			<?php foreach ( $features as $index => $feature ) : ?>
				<div class="mason-feature-grid__item" data-index="<?php echo esc_attr( $index ); ?>">
					<?php if ( ! empty( $feature['icon'] ) ) : ?>
						<div class="mason-feature-grid__icon" aria-hidden="true">
							<?php echo wp_kses_post( $feature['icon'] ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( ! empty( $feature['title'] ) ) : ?>
						<h3 class="mason-feature-grid__title">
							<?php echo esc_html( $feature['title'] ); ?>
						</h3>
					<?php endif; ?>
					
					<?php if ( ! empty( $feature['description'] ) ) : ?>
						<p class="mason-feature-grid__description">
							<?php echo esc_html( $feature['description'] ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
