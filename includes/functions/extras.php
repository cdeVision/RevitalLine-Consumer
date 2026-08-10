<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package _cdev
 */


 
//////////////////////////////////////////////////////////////////
// Disable all RSS/Atom feeds and remove feed links from the head section.

function fb_disable_feed() {
	wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

add_action('do_feed', 'fb_disable_feed', 1);
add_action('do_feed_rdf', 'fb_disable_feed', 1);
add_action('do_feed_rss', 'fb_disable_feed', 1);
add_action('do_feed_rss2', 'fb_disable_feed', 1);
add_action('do_feed_atom', 'fb_disable_feed', 1);


remove_action('wp_head', 'feed_links', 2 );
remove_action('wp_head', 'feed_links_extra', 3 );

//////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////
// Remove users and from XML Feed

add_filter(
  'wp_sitemaps_add_provider',
  function( $provider, $name ) {
      if ( 'users' === $name ) {
          return false;
      }
      return $provider;
  },
  10,
  2
);

//////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////
// Remove Heading 1 from Tiny MCE

function remove_h1_from_heading($args) {
	// Just omit h1 from the list
	$args['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';
	return $args;
}
add_filter('tiny_mce_before_init', 'remove_h1_from_heading' );

///////////////////////////////////////////////////////


/////////////////////////////////////////////
// Removes or edits the 'Protected:' part from posts titles

add_filter( 'protected_title_format', 'remove_protected_text' );
function remove_protected_text() {
	//return __('Protected: %s');
	return __('%s');
}



///////////////////////////////////////////
// Hide "Howdy"
add_filter('gettext', 'change_howdy', 10, 3);

function change_howdy($translated, $text, $domain) {

    if (!is_admin() || 'default' != $domain)
        return $translated;

    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy', 'Welcome', $translated);

    return $translated;
}


///////////////////////////////////////////
// Remove default dashboard widgets
remove_action('welcome_panel', 'wp_welcome_panel');

function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Removes QuickPress
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']); // Removes Activity
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // Incoming Links
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // Removes Right Now
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // Removes Plugins
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // Removes Recent Drafts
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Removes Recent Comments
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // Removes the WordPress Developer Blog
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // Removes the WordPress Blog Updates
  unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] ); // Removes site health
	//Remove the "SEO News" widget.
  remove_meta_box('themeisle', 'dashboard', 'normal');
	remove_meta_box('semperplugins-rss-feed', 'dashboard', 'normal');
	remove_meta_box('rcua_dashboard_widget', 'dashboard', 'normal'); // Removes WordPress Guides/Tutorials widget
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


 
// Disable WordPress version reporting as a basic protection against attacks
function remove_generators() {
	return '';
}		
add_filter('the_generator','remove_generators');


//////////////////////////////////////////////
// Limit words
function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit) {
  array_pop($words);
  //add a ... at last article when more than limit word count
  echo implode(' ', $words)."[...]"; } else {
  //otherwise
  echo implode(' ', $words); }
}


//////////////////////////////////////////////
// Remove title in galleries
function cdev_gallery_filter( $attr ) { 
//$attr['alt'] = ""; 
$attr['title'] = ""; 
return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'cdev_gallery_filter' );



// Copyright year format //////////////////////////////////
function auto_copyright($year = 'auto'){
   if(intval($year) == 'auto'){ $year = date('Y'); }
   if(intval($year) == date('Y')){ echo intval($year); }
   if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
   if(intval($year) > date('Y')){ echo date('Y'); }
}

// Dashboard Footer ////////////////////
if (! function_exists('dashboard_footer') ){
function dashboard_footer () {
echo 'Wordpress customized by <a href="http://www.cdevision.com" target="_blank">cdeVision</a>';
}
}
add_filter('admin_footer_text', 'dashboard_footer');

?>