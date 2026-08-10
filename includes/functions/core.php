<?php
/**
 * Custom theme functions for this theme.
 *
 * @package _cdev
 */


////////////////////////////////////////////////////////
// Theme colors as PHP variables
$primary_color = "464646";
$secondary_color = "202020";
$site_name = get_bloginfo('name');
$placeholder_color = "7D7D7D";
$placeholder_text = "6B6B6B";
// make variables global
$GLOBALS['primary_color'] = $primary_color;
$GLOBALS['secondary_color'] = $secondary_color;
$GLOBALS['site_name'] = $site_name;
$GLOBALS['placeholder_color'] = $placeholder_color;
$GLOBALS['placeholder_text'] = $placeholder_text;
////////////////////////////////////////////////////////


 
///////////////////////////////////////////////////
//  change login logo and link

add_action ( 'login_headerurl', 'cdev_login_headerurl' );
function cdev_login_headerurl() {
    return site_url();
}
add_action("login_head", "custom_login_logo");

function custom_login_logo() {
	echo "
	<style>
	body.login #login h1 a {
		background: url('".get_bloginfo('template_url')."/images/custom-logo.png') no-repeat scroll center top transparent;
		height: 150px;
		width: 300px;
	}
	body.login {
		background: #0E0E0E;
	}
	.login #backtoblog a, .login #nav a {
    text-decoration: none;
    color: #FFF;
	}
	.login #backtoblog a:hover, .login #nav a:hover {
    text-decoration: none;
    color: #4FA852;
	}
	</style>
	";
}

///////////////////////////////////////////////////



///////////////////////////////////////////////////
// Core admin base styles
function admin_base_styles() {
  echo '<style type="text/css">
		#cpt_info_box { display:none !important; }
		#poststuff .stuffbox>h3, #poststuff h2, #poststuff h3.hndle {
		font-size: 16px;
		}
		#plugins-by-dreihochzwo { display:none !important; } 
		#exactmetrics-metabox { display:none !important; } 
	</style>';
}
add_action('admin_head', 'admin_base_styles');

///////////////////////////////////////////////////


///////////////////////////////////////////////////////
// Open Graph

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
global $post, $wp;

$is_url = home_url( $wp->request );
$title = "";
$default_image = get_template_directory_uri() . "/images/og.png";

	// App ID
	// echo '<meta property="fb:app_id" content="Your Facebook App ID" />';

	
    if( is_post_type_archive() ){
		  $title = post_type_archive_title("",false);
	
	} else if( is_tax() ){
			//$tax = get_queried_object();
			$title = get_the_archive_title();
	
	} else if( is_category() ){
		  $title = single_cat_title("", false);

	} else if( is_single() ){
          $image = get_field('thumbnail');
		  if ( $image ){
					// Handle both array and URL string formats
					if ( is_array( $image ) && isset( $image['url'] ) ) {
						$default_image = $image['url'];
					} elseif ( is_string( $image ) ) {
						$default_image = $image;
					}
			}
			$title = get_the_title();

	} else { // default
		if ( is_search() ){
				$title = "Search: " . get_search_query(); 
		} else if ( get_field('override_page_title') ){ 
				$title = get_field('override_page_title'); 
		} else { // else just get the title
				$title = get_the_title(); 
		}
	}

	

	//echo '<meta property="og:title" content="' . strip_tags($title) . '"/>';
	echo '<meta property="og:title" content="' . esc_attr( get_bloginfo( 'name' ) . ' | ' . strip_tags($title) ) . '"/>';
	echo '<meta property="og:image" content="' . esc_url( $default_image ) . '"/>';
	echo '<meta property="og:type" content="article"/>';
	echo '<meta property="og:url" content="' . esc_url( $is_url ) . '"/>';
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '"/>';

}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

///////////////////////////////////////////////////