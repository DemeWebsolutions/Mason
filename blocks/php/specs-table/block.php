<?php
/**
 * Specs Table Block
 * Technical specifications table for products
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Specs Table Block
 */
function stone_mason_register_specs_table_block() {
	register_block_type(
		'stone-mason/specs-table',
		array(
			'api_version'     => 3,
			'title'           => __( 'Specs Table', 'stone-mason' ),
			'description'     => __( 'Display technical specifications in a clean table format', 'stone-mason' ),
			'category'        => 'stone-mason',
			'icon'            => 'editor-table',
			'keywords'        => array( 'specs', 'specifications', 'table', 'technical', 'details' ),
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
				'title'           => array(
					'type'    => 'string',
					'default' => '',
				),
				'specs'           => array(
					'type'    => 'array',
					'default' => array(
						array(
							'label' => __( 'Dimensions', 'stone-mason' ),
							'value' => '10 x 5 x 2 inches',
						),
						array(
							'label' => __( 'Weight', 'stone-mason' ),
							'value' => '1.5 lbs',
						),
						array(
							'label' => __( 'Material', 'stone-mason' ),
							'value' => 'Aluminum',
						),
					),
				),
				'striped'         => array(
					'type'    => 'boolean',
					'default' => true,
				),
			),
			'render_callback' => 'stone_mason_render_specs_table_block',
		)
	);
}
add_action( 'init', 'stone_mason_register_specs_table_block' );

/**
 * Render Specs Table Block
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Block HTML.
 */
function stone_mason_render_specs_table_block( $attributes, $content ) {
	$title   = isset( $attributes['title'] ) ? esc_html( $attributes['title'] ) : '';
	$specs   = isset( $attributes['specs'] ) ? $attributes['specs'] : array();
	$striped = isset( $attributes['striped'] ) ? (bool) $attributes['striped'] : true;

	// Ensure we have at least default specs.
	if ( empty( $specs ) ) {
		$specs = array(
			array(
				'label' => __( 'Dimensions', 'stone-mason' ),
				'value' => '10 x 5 x 2 inches',
			),
			array(
				'label' => __( 'Weight', 'stone-mason' ),
				'value' => '1.5 lbs',
			),
			array(
				'label' => __( 'Material', 'stone-mason' ),
				'value' => 'Aluminum',
			),
		);
	}

	// Build wrapper classes.
	$wrapper_classes = array(
		'mason-specs-table',
	);
	
	if ( $striped ) {
		$wrapper_classes[] = 'mason-specs-table--striped';
	}

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
		<?php if ( ! empty( $title ) ) : ?>
			<h3 class="mason-specs-table__title">
				<?php echo $title; ?>
			</h3>
		<?php endif; ?>

		<table class="mason-specs-table__table">
			<tbody>
				<?php foreach ( $specs as $index => $spec ) : ?>
					<?php if ( ! empty( $spec['label'] ) && ! empty( $spec['value'] ) ) : ?>
						<tr class="mason-specs-table__row">
							<th class="mason-specs-table__label" scope="row">
								<?php echo esc_html( $spec['label'] ); ?>
							</th>
							<td class="mason-specs-table__value">
								<?php echo esc_html( $spec['value'] ); ?>
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
	return ob_get_clean();
}
