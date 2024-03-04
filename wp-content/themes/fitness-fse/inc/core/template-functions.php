<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Fitness FSE
 */

/**
 * Add customizer default values.
 *
 * @param array $default_options
 * @return array
 */
function fitness_fse_customizer_add_defaults( $default_options) {
	$defaults = array(
		// Excerpt Options
		'fitness_fse_excerpt_length'    => 30,
	);


	$updated_defaults = wp_parse_args( $defaults, $default_options );

	return $updated_defaults;
}
add_filter( 'fitness_fse_customizer_defaults', 'fitness_fse_customizer_add_defaults' );

/**
 * Returns theme mod value saved for option merging with default option if available.
 * @since 1.0
 */
function fitness_fse_gtm( $option ) {
	// Get our Customizer defaults
	$defaults = apply_filters( 'fitness_fse_customizer_defaults', true );

	return isset( $defaults[ $option ] ) ? get_theme_mod( $option, $defaults[ $option ] ) : get_theme_mod( $option );
}

if ( ! function_exists( 'fitness_fse_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 */
	function fitness_fse_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Theme Options
		$length	= fitness_fse_gtm( 'fitness_fse_excerpt_length' );

		return absint( $length );
	} // fitness_fse_excerpt_length.
endif;
add_filter( 'excerpt_length', 'fitness_fse_excerpt_length', 999 );

if ( ! function_exists( 'fitness_fse_footer_copyright' ) ){

    /**
     * Footer Copyright Information
     *
     * @since 1.0.0
     */
    function fitness_fse_footer_copyright() {

        echo esc_html( apply_filters( 'fitness_fse_copyright_text', $content = esc_html__('Copyright  &copy; ','fitness-fse') . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) .' - ' ) );

         printf( ' WordPress Theme : by %1$s', '<a href=" ' . esc_url('https://sparklewp.com/fitness-gym-websites-wordpress-themes/') . ' " rel="designer" target="_blank">'.esc_html__('Fitness & Gym Themes','fitness-fse').'</a>' );
    }
}
add_action( 'fitness_fse_footer_copyright', 'fitness_fse_footer_copyright', 5 );
