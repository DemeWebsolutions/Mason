<?php
/**
 * Customizer Settings
 * Theme customizer configuration
 *
 * @package Mason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function mason_customize_register( $wp_customize ) {
	
	/**
	 * Mason Settings Section
	 */
	$wp_customize->add_section(
		'mason_settings',
		array(
			'title'    => __( 'Mason Settings', 'mason' ),
			'priority' => 30,
		)
	);

	/**
	 * Enable GSAP
	 */
	$wp_customize->add_setting(
		'mason_enable_gsap',
		array(
			'default'           => false,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'mason_enable_gsap',
		array(
			'label'   => __( 'Enable GSAP Animations', 'mason' ),
			'section' => 'mason_settings',
			'type'    => 'checkbox',
		)
	);

	/**
	 * Performance Settings
	 */
	$wp_customize->add_setting(
		'mason_defer_scripts',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'mason_defer_scripts',
		array(
			'label'       => __( 'Defer JavaScript Loading', 'mason' ),
			'description' => __( 'Defer non-critical scripts for better performance', 'mason' ),
			'section'     => 'mason_settings',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'mason_lazy_load',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'mason_lazy_load',
		array(
			'label'       => __( 'Enable Lazy Loading', 'mason' ),
			'description' => __( 'Lazy load images and iframes', 'mason' ),
			'section'     => 'mason_settings',
			'type'        => 'checkbox',
		)
	);

	/**
	 * WooCommerce Settings
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_section(
			'mason_woocommerce',
			array(
				'title'    => __( 'Mason WooCommerce', 'mason' ),
				'priority' => 40,
			)
		);

		$wp_customize->add_setting(
			'mason_wc_cart_fragments',
			array(
				'default'           => false,
				'sanitize_callback' => 'wp_validate_boolean',
			)
		);

		$wp_customize->add_control(
			'mason_wc_cart_fragments',
			array(
				'label'       => __( 'Disable Cart Fragments', 'mason' ),
				'description' => __( 'Disable WooCommerce cart fragments for better performance', 'mason' ),
				'section'     => 'mason_woocommerce',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'mason_wc_product_columns',
			array(
				'default'           => 3,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'mason_wc_product_columns',
			array(
				'label'   => __( 'Products Per Row', 'mason' ),
				'section' => 'mason_woocommerce',
				'type'    => 'number',
				'input_attrs' => array(
					'min'  => 2,
					'max'  => 4,
					'step' => 1,
				),
			)
		);
	}

	/**
	 * Typography Settings
	 */
	$wp_customize->add_section(
		'mason_typography',
		array(
			'title'    => __( 'Mason Typography', 'mason' ),
			'priority' => 50,
		)
	);

	$wp_customize->add_setting(
		'mason_body_font_size',
		array(
			'default'           => '17px',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'mason_body_font_size',
		array(
			'label'   => __( 'Body Font Size', 'mason' ),
			'section' => 'mason_typography',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'mason_heading_font_weight',
		array(
			'default'           => '700',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'mason_heading_font_weight',
		array(
			'label'   => __( 'Heading Font Weight', 'mason' ),
			'section' => 'mason_typography',
			'type'    => 'select',
			'choices' => array(
				'400' => __( 'Normal', 'mason' ),
				'500' => __( 'Medium', 'mason' ),
				'600' => __( 'Semi Bold', 'mason' ),
				'700' => __( 'Bold', 'mason' ),
			),
		)
	);
}
add_action( 'customize_register', 'mason_customize_register' );

/**
 * Bind JS handlers to instantly live-preview changes
 */
function mason_customize_preview_js() {
	wp_enqueue_script(
		'mason-customizer',
		MASON_URL . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		MASON_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'mason_customize_preview_js' );
