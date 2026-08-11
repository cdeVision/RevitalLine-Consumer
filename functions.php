<?php
/**
 * cdev functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cdev
 */


//////////////////////////////////////////////////////////////////////////////////////
// Image tweaks
// Remove Wordpress image upload resizing
add_filter( 'big_image_size_threshold', '__return_false' );

// Set image compression - default 85
add_filter('jpeg_quality', function($arg){return 85;});


//////////////////////////////////////////////////////////////////////////////////////
// Theme setup
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */

// Add preconnect and dns-prefetch for HTTP2 
function gg_gfonts_prefetch() {
	echo '<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>';
	echo '<link rel="preconnect" href="https://fonts.googleapis.com/" crossorigin>';
	echo '<link rel="preconnect" href="https://www.google-analytics.com/" crossorigin>';
	echo '<link rel="dns-prefetch" href="https://fonts.gstatic.com/">';
	echo '<link rel="dns-prefetch" href="https://fonts.googleapis.com/">';
	echo '<link rel="dns-prefetch" href="https://www.google-analytics.com/">';
}
add_action( 'wp_head', 'gg_gfonts_prefetch', 1 );

if ( ! function_exists( 'cdev_setup' ) ) :
	function cdev_setup() {
        
		// remove WP 4.9+ dns-prefetch nonsense
		remove_action( 'wp_head', 'wp_resource_hints', 2 );
        
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( $name = 'cdev_highlight', $width = 600, $height = 400, $crop = true ); // highlight images
		add_image_size( $name = 'cdev_post_thumb', $width = 285, $height = 200, $crop = true ); // post thumbs and ACF image previews
		add_image_size( $name = 'cdev_callout', $width = 390, $height = 800, $crop = false ); // callout image size
        
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Main Menu', 'cdev' ),
		) );

	}
endif;
add_action( 'after_setup_theme', 'cdev_setup' );

//////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
// Clean up WordPress Header for better performance

// Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	//wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

// Remove WP scripts
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

// Clean Head section links
/* Removes RSD, XMLRPC, WLW, WP Generator, ShortLink and Comment Feed links */
remove_action ('wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head');
//remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
if (!is_admin()) {
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
}
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action( 'rest_api_init', 'wp_oembed_register_route');
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_action( 'wp_head', 'wp_shortlink_wp_head'); // Removes shortlink.
remove_action( 'wp_head', 'feed_links', 2 ); // Removes feed links.
remove_action( 'wp_head', 'feed_links_extra', 3 );  // Removes comments feed.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head'); // Removes prev and next links

// Disable pingbacks
add_filter( 'xmlrpc_methods', function( $methods ) {
	unset( $methods['pingback.ping'] );
	return $methods;
} );

// Remove jQuery migrate
function remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff(
					$scripts->registered['jquery']->deps,
					array( 'jquery-migrate' )
			);
	}
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

//////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
// Enqueue scripts and styles.

$default_font_stack = 'https://use.typekit.net/dsd3vmx.css';
$fontawesome_path = get_template_directory_uri() . '/includes/fontawesome-6.5.2/css/all.css';


function cdev_scripts() {
    global $default_font_stack, $fontawesome_path;
    
    ///////////////////////// load CSS ////////////////////////
    
    // load Google Fonts (works with new Google font URL structure)
    wp_enqueue_style('_cdev-fonts', $default_font_stack, [], null );

    // load SLICK css
    wp_enqueue_style('slick', get_template_directory_uri() . '/includes/slick/slick.css');

    // load SLICK default theme css
    wp_enqueue_style('slick-theme', get_template_directory_uri() . '/includes/slick/slick-theme.css');

    // Font awesome 6.5.2 - also load in admin below
		wp_enqueue_style('_cdev-fontawesome', $fontawesome_path); // if regular 400 needed

    // load _cdev styles - last
    wp_enqueue_style( '_cdev-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
    
    ///////////////////////// load JS ////////////////////////

		// load SLICK js
		wp_enqueue_script('slick-js', get_template_directory_uri() . '/includes/slick/slick.min.js', array('jquery'), '1.8.0', true);

		// Has Animation (registered in blocks/blocks.php; also via block.json in editor iframe)
		wp_enqueue_script( 'animation-js' );

		// Site scripts
		wp_enqueue_script('site-js', get_template_directory_uri() . '/includes/js/core.js', array('jquery'), filemtime(get_template_directory() . '/includes/js/core.js'), true);

}
add_action( 'wp_enqueue_scripts', 'cdev_scripts' );

//////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
// Load admin scripts
function cdev_admin_scripts($hook) {

	// Load the scripts only in Gutenberg editor
	if ($hook === 'post.php' || $hook === 'post-new.php') {

		// animation-js here loads in the parent admin frame only.
		// WP 7+ block preview runs in an iframe — also enqueued via enqueue_block_assets
		// and listed in block.json "script" on blocks that use .has-animation.
		wp_enqueue_script( 'animation-js' );

	} // end if hook

	// Load Font Awesome
	global $fontawesome_path, $default_font_stack;
	wp_enqueue_style('_cdev-fontawesome', $fontawesome_path);

	// Load Google Fonts for TinyMCE editor
	add_filter( 'mce_css', function( $mce_css ) use ($default_font_stack, $fontawesome_path) {
		if ( ! empty( $mce_css ) ) {
			$mce_css .= ',';
		}
		$mce_css .= $default_font_stack;
		// Add Font Awesome to TinyMCE
		$mce_css .= ',' . $fontawesome_path;
		return $mce_css;
	});

}
add_action('admin_enqueue_scripts', 'cdev_admin_scripts');

//////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////
// Block Editor Assets 

function cdev_block_editor_scripts() {

	// Block Editor fonts 
	global $default_font_stack;
	wp_enqueue_style('_cdev-editor-fonts', $default_font_stack, [], null);

	// load SLICK js and css in block editor
	wp_enqueue_script(
			'slick-js',
			get_template_directory_uri() . '/includes/slick/slick.min.js',
			array('jquery', 'wp-editor'), // Ensure wp-editor (and thus quicktags) is loaded before
			'1.8.0',
			true
	);
	wp_enqueue_style('slick', get_template_directory_uri() . '/includes/slick/slick.css');
	wp_enqueue_style('slick-theme', get_template_directory_uri() . '/includes/slick/slick-theme.css');

}
add_action('enqueue_block_editor_assets', 'cdev_block_editor_scripts', 20);

// Load Slick CSS inside the Site Editor / pattern editor iframe canvas.
// enqueue_block_assets fires for both the frontend and the editor iframe,
// ensuring the Slick layout rules are present wherever blocks render.
function cdev_slick_block_assets() {
    global $fontawesome_path;
    wp_enqueue_style('slick', get_template_directory_uri() . '/includes/slick/slick.css');
    wp_enqueue_style('slick-theme', get_template_directory_uri() . '/includes/slick/slick-theme.css');
    wp_enqueue_style('_cdev-fontawesome', $fontawesome_path);
}
add_action('enqueue_block_assets', 'cdev_slick_block_assets');

//////////////////////////////////////////////////////////////////////////////////////





//////////////////////////////////////////////////////////////////////////////////////
// Load additional code snippets

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/functions/core.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/functions/extras.php';

/**
 * WordPress Cleanup (replaces Disable Comments, Disable Emojis, Remove Category URL plugins)
 */
require get_template_directory() . '/includes/functions/cleanup.php';

/**
 * Advanced Custom Fields
 */
require get_template_directory() . '/includes/functions/acf.php';

 /**
 * Blocks for this theme.
 */
require get_template_directory() . '/blocks/blocks.php';

 /**
 * Posts for this theme.
 */
require get_template_directory() . '/includes/functions/posts.php';

/**
 * Gravity Forms
 */
require get_template_directory() . '/includes/functions/gravity-forms.php';

/**
 * Testimonials
 */
require get_template_directory() . '/includes/functions/testimonials.php';

/**
 * Brand post type functions
 */
require get_template_directory() . '/includes/functions/brands.php';

/**
 * Resource post type functions
 */
require get_template_directory() . '/includes/functions/resources.php';