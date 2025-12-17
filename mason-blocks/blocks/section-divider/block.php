<?php
/**
 * Section Divider Block
 * Visual separation between sections
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Section Divider Block
 */
function stone_mason_register_section_divider_block() {
	register_block_type(
		'stone-mason/section-divider',
		array(
			'api_version'     => 3,
			'title'           => __( 'Section Divider', 'stone-mason' ),
			'description'     => __( 'Visual separator between sections with optional styling', 'stone-mason' ),
			'category'        => 'stone-mason',
			'icon'            => 'minus',
			'keywords'        => array( 'divider', 'separator', 'hr', 'line', 'section' ),
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
				'style'           => array(
					'type'    => 'string',
					'default' => 'line',
				),
				'height'          => array(
					'type'    => 'string',
					'default' => '1px',
				),
				'width'           => array(
					'type'    => 'string',
					'default' => '100%',
				),
				'maxWidth'        => array(
					'type'    => 'string',
					'default' => '200px',
				),
				'alignment'       => array(
					'type'    => 'string',
					'default' => 'center',
				),
				'pattern'         => array(
					'type'    => 'string',
					'default' => 'solid',
				),
			),
			'render_callback' => 'stone_mason_render_section_divider_block',
		)
	);
}
add_action( 'init', 'stone_mason_register_section_divider_block' );

/**
 * Render Section Divider Block
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Block HTML.
 */
function stone_mason_render_section_divider_block( $attributes, $content ) {
	$style     = isset( $attributes['style'] ) ? sanitize_text_field( $attributes['style'] ) : 'line';
	$height    = isset( $attributes['height'] ) ? esc_attr( $attributes['height'] ) : '1px';
	$width     = isset( $attributes['width'] ) ? esc_attr( $attributes['width'] ) : '100%';
	$max_width = isset( $attributes['maxWidth'] ) ? esc_attr( $attributes['maxWidth'] ) : '200px';
	$alignment = isset( $attributes['alignment'] ) ? esc_attr( $attributes['alignment'] ) : 'center';
	$pattern   = isset( $attributes['pattern'] ) ? esc_attr( $attributes['pattern'] ) : 'solid';

	// Build wrapper classes.
	$wrapper_classes = array(
		'mason-section-divider',
		'mason-section-divider--' . $style,
		'mason-section-divider--' . $alignment,
		'mason-section-divider--' . $pattern,
	);

	// Build inline styles.
	$inline_styles = array();
	
	if ( 'line' === $style ) {
		$inline_styles[] = '--divider-height: ' . $height;
		$inline_styles[] = '--divider-width: ' . $width;
		
		if ( '100%' !== $width ) {
			$inline_styles[] = '--divider-max-width: ' . $max_width;
		}
	} elseif ( 'space' === $style ) {
		$inline_styles[] = '--divider-space: ' . $height;
	}

	// Build wrapper attributes.
	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => implode( ' ', $wrapper_classes ),
			'style' => ! empty( $inline_styles ) ? implode( '; ', $inline_styles ) : '',
			'role'  => 'separator',
			'aria-hidden' => 'true',
		)
	);

	// Build output.
	ob_start();
	
	if ( 'line' === $style ) {
		?>
		<div <?php echo $wrapper_attributes; ?>>
			<hr class="mason-section-divider__line" />
		</div>
		<?php
	} elseif ( 'space' === $style ) {
		?>
		<div <?php echo $wrapper_attributes; ?>></div>
		<?php
	} elseif ( 'dots' === $style ) {
		?>
		<div <?php echo $wrapper_attributes; ?>>
			<div class="mason-section-divider__dots">
				<span class="mason-section-divider__dot"></span>
				<span class="mason-section-divider__dot"></span>
				<span class="mason-section-divider__dot"></span>
			</div>
		</div>
		<?php
	}
	
	return ob_get_clean();
}
