<?php
/**
 * Hero Section Block (PHP-based)
 *
 * @package StoneMason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Hero Section Block
 */
function stone_mason_register_hero_block() {
	register_block_type(
		'stone-mason/hero-section',
		array(
			'api_version'     => 3,
			'title'           => __( 'Hero Section', 'stone-mason' ),
			'description'     => __( 'A customizable hero section with heading, text, and call-to-action', 'stone-mason' ),
			'category'        => 'stone-mason',
			'icon'            => 'cover-image',
			'keywords'        => array( 'hero', 'banner', 'header', 'cta' ),
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
					'gradients'  => true,
				),
			),
			'attributes'      => array(
				'heading'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'subheading'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonText'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonUrl'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'alignment'       => array(
					'type'    => 'string',
					'default' => 'center',
				),
				'minHeight'       => array(
					'type'    => 'string',
					'default' => '400px',
				),
			),
			'render_callback' => 'stone_mason_render_hero_block',
		)
	);
}
add_action( 'init', 'stone_mason_register_hero_block' );

/**
 * Render Hero Section Block
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Block HTML.
 */
function stone_mason_render_hero_block( $attributes, $content ) {
	$heading     = ! empty( $attributes['heading'] ) ? esc_html( $attributes['heading'] ) : __( 'Welcome', 'stone-mason' );
	$subheading  = ! empty( $attributes['subheading'] ) ? esc_html( $attributes['subheading'] ) : '';
	$button_text = ! empty( $attributes['buttonText'] ) ? esc_html( $attributes['buttonText'] ) : '';
	$button_url  = ! empty( $attributes['buttonUrl'] ) ? esc_url( $attributes['buttonUrl'] ) : '#';
	$alignment   = ! empty( $attributes['alignment'] ) ? esc_attr( $attributes['alignment'] ) : 'center';
	$min_height  = ! empty( $attributes['minHeight'] ) ? esc_attr( $attributes['minHeight'] ) : '400px';

	// Build wrapper classes.
	$wrapper_classes = array(
		'mason-hero-section',
		'mason-hero-section--' . $alignment,
	);

	// Build wrapper attributes.
	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => implode( ' ', $wrapper_classes ),
			'style' => sprintf( 'min-height: %s;', $min_height ),
		)
	);

	// Build output.
	ob_start();
	?>
	<section <?php echo $wrapper_attributes; ?>>
		<div class="mason-hero-section__content">
			<?php if ( $heading ) : ?>
				<h1 class="mason-hero-section__heading">
					<?php echo $heading; ?>
				</h1>
			<?php endif; ?>

			<?php if ( $subheading ) : ?>
				<p class="mason-hero-section__subheading">
					<?php echo $subheading; ?>
				</p>
			<?php endif; ?>

			<?php if ( $button_text && $button_url ) : ?>
				<div class="mason-hero-section__actions">
					<a href="<?php echo $button_url; ?>" class="wp-block-button__link wp-element-button">
						<?php echo $button_text; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
