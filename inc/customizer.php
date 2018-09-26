<?php
/**
 * mayhem-theme Theme Customizer
 *
 * @package mayhem-theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mayhem_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	mayhem_create_custom_options($wp_customize);
}
add_action( 'customize_register', 'mayhem_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mayhem_customize_preview_js() {
	wp_enqueue_script( 'mayhem-customizer', get_template_directory_uri() . '/src/js/customizer.js', array( 'customize-preview' ), microtime(), true );
}
add_action( 'customize_preview_init', 'mayhem_customize_preview_js' );

/**
 * Injects customizer css into the head tag
 * @return [undefined]
 */
function mayhem_customize_css() {
	?>
		<style type="text/css">
			.menu-toggle-btn span {
				background: <?php echo get_theme_mod('brand_color', '#f8fa2c'); ?>;
			}
		</style>
	<?php
}
add_action( 'wp_head', 'mayhem_customize_css' );

/**
 * Creates custom settings and controls
 * @param  [object] $wp_customize
 * @return [undefined]
 */
function mayhem_create_custom_options($wp_customize) {
	/** Brand Color */
	$wp_customize->add_setting( 'brand_color',
	  array(
	  	'default' => '#f8fa2c',
	    'transport' => 'postMessage',
	    'sanitize_callback' => 'sanitize_hex_color'
	  )
	);
	$wp_customize->add_control( 'brand_color',
		array(
			'label' => __( 'Brand Color' ),
      'description' => esc_html__( "The site's primary color" ),
      'section' => 'colors',
      'type' => 'color'
    )
	);

	/** ... */
}
