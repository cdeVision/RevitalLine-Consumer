<?php
//////////////////////////////////////////////////////////
// ACF Functions
//////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
// ACF Clear user window state
function clear_user_window_state() {
	// Get all users
	$users = get_users();

	foreach ($users as $user) {
			// Delete the metadata that stores window state
			delete_user_meta($user->ID, 'meta-box-order_post');
			delete_user_meta($user->ID, 'meta-box-order_page');
			delete_user_meta($user->ID, 'closedpostboxes_post');
			delete_user_meta($user->ID, 'closedpostboxes_page');
	}
}
//add_action('admin_init', 'clear_user_window_state');

//////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////
// ACF Option Pages
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> true
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Pop Up',
		'menu_title'	=> 'Pop Up',
		'parent_slug'	=> 'theme-general-settings',
	));
    
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Alert Bar',
		'menu_title'	=> 'Alert Bar',
		'parent_slug'	=> 'theme-general-settings',
	));
    
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Header',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
    
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
    
  acf_add_options_sub_page(array(
		'page_title' 	=> 'SEO',
		'menu_title'	=> 'SEO',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Header/Footer Scripts',
		'menu_title'	=> 'Header/Footer Scripts',
		'parent_slug'	=> 'theme-general-settings',
	));
	
  acf_add_options_sub_page(array(
		'page_title' 	=> '404 Error Page',
		'menu_title'	=> '404 Error Page',
		'parent_slug'	=> 'theme-general-settings',
	));

	// Content editor thumbs
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Content Editor Thumbnails',
		'menu_title'	=> 'Content Editor Thumbs',
		'parent_slug'	=> 'edit.php?post_type=acf-field-group',
		'post_id' 		=> 'options_editor_thumbs'
	));

	// Training Guide
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Training Guide',
		'menu_title'	=> 'Training Guide',
		'parent_slug'	=> 'theme-general-settings'
	));

	// CPT Options page with ID - can use content editor based on ID "contnet", "ID"
	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'CPT Page Options',
	// 	'menu_title'	=> 'CPT Page Options',
	// 	'parent_slug'	=> 'edit.php?post_type=cpt',
	// 	'post_id' 		=> 'options_cpt_page'
	// ));
    

}


/////////////////////////////////////////////////////////////
// Display show Link Function
function displayShowLink($wrapper = "p", $sub = true, $prefix = "none", $class = "") {

	$prefix = ($prefix != "none") ? $prefix . '_' : '';
	$show_link = $sub ? get_sub_field($prefix . 'show_link') : get_field($prefix . 'show_link');
	if (!$show_link && $show_link != "none") {
		$show_link = "post";
	}
	$show_link_url = $sub ? get_sub_field($prefix . 'show_link_url') : get_field($prefix . 'show_link_url');
	$show_link_target = $sub ? get_sub_field($prefix . 'show_link_target') : get_field($prefix . 'show_link_target');
	$show_link_title = $sub ? get_sub_field($prefix . 'show_link_title') : get_field($prefix . 'show_link_title');
	if (!$show_link_title && $show_link != "none") {
		$show_link_title = "Learn More";
	}
	$show_pdf = $sub ? get_sub_field($prefix . 'show_pdf') : get_field($prefix . 'show_pdf');
	$show_post = $sub ? get_sub_field($prefix . 'show_post') : get_field($prefix . 'show_post');
	$show_email_address = $sub ? get_sub_field($prefix . 'show_email_address') : get_field($prefix . 'show_email_address');
	$show_anchor = $sub ? get_sub_field($prefix . 'show_anchor') : get_field($prefix . 'show_anchor');
	$anchor_type = $sub ? get_sub_field($prefix . 'anchor_type') : get_field($prefix . 'anchor_type');

	// echo "show_field: " . $show_link . "<br>";
	// echo "anchor_type: " . $anchor_type . "<br>";
	// echo "show_anchor: " . $show_anchor . "<br>";
	//echo "Button Function<br>";
	//$show_link_title .= " (TEST)";

	// If show link is not none
	if ($show_link != "none" ) {
	// if wrapper is p
	if ($wrapper == "p") {
		echo '<p class="linkwrap">';
	}

	// URL
	if ($show_link == "url") {
		echo '<a href="' . esc_url($show_link_url) . '" target="' . esc_attr($show_link_target) . '" class="box ' . esc_attr($class) . '">' . esc_html($show_link_title) . '</a>';
	}

	// PDF
	if ($show_link == "pdf") {
		echo '<a href="' . esc_url($show_pdf) . '" target="_blank" class="box pdf ' . esc_attr($class) . '">' . esc_html($show_link_title) . '</a>';
	}

	// Post
	if ($show_link == "post") {
		echo '<a href="' . esc_url($show_post) . '" class="box ' . esc_attr($class) . '">' . esc_html($show_link_title) . '</a>';
	}

	// Email
	if ($show_link == "email") {
		$emailtitle = $show_link_title;
		$emailaddress = $show_email_address;
		if ($emailtitle == "") {
			$emailtitle = $emailaddress;
		}
		echo '<a href="mailto:' . esc_attr($emailaddress) . '" class="box ' . esc_attr($class) . '">' . esc_html($emailtitle) . '</a>';
	}

	// Anchor
	if ($show_link == "anchor") {
		
		if (strpos($show_anchor, 'http') !== false) {
			echo '<a href="' . esc_url($show_anchor) . '" class="box ' . esc_attr($anchor_type) . ' ' . esc_attr($class) . '">' . esc_html($show_link_title) . '</a>';
		} else {
			echo '<a href="#' . esc_attr($show_anchor) . '" class="box ' . esc_attr($anchor_type) . ' ' . esc_attr($class) . '">' . esc_html($show_link_title) . '</a>';
		}
	}

	// if wrapper is p
	if ($wrapper == "p") {
		echo '</p>';
	}

	// End if show link is not none
	}
	
}

/////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////
// Placeholder Image function

function get_placeholder_image($width = 600, $height = 600,$title = "Image",$return_tag = false,$force_placeholder = false) {
	$image = get_field('placeholder_image', 'options_editor_thumbs');
	if( ! $image || $force_placeholder ){
		global $placeholder_color;
		global $placeholder_text;
		$image = "https://placehold.co/{$width}x{$height}/" . $placeholder_color . "/" . $placeholder_text . "/?text=" . $title;
		if ($return_tag) {
			$image = '<img src="' . $image . '" alt="' . $title . '" class="placeholder-image" />';
		}
	}
	return $image;
}
//////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////
// Social media function
function cdev_social_links($class = '', $show_labels = true, $show_title = false) {
    $soc_fb = get_field('facebook','options');
    $soc_inst = get_field('instagram','options');
    $soc_tw = get_field('twitter','options');
    $soc_yt = get_field('youtube','options');
    $soc_li = get_field('linkedin','options');
    $soc_c = get_field('contact','options');
    echo '<div class="social' . ($class ? ' ' . esc_attr($class) : '') . '">';
		if ($show_title) {
			$feed_title = get_field('feed_title','options');
			if ($feed_title) {
				echo '<span>' . esc_html($feed_title) . '</span>';
			}
		}
    if ($soc_fb) {
        echo '<a href="' . esc_url($soc_fb) . '" class="fa-brands fa-facebook-square" target="_blank">';
        if ($show_labels) echo '<span class="sr-only">Facebook</span>';
        echo '</a>';
    }
    if ($soc_inst) {
        echo '<a href="' . esc_url($soc_inst) . '" class="fa-brands fa-instagram" target="_blank">';
        if ($show_labels) echo '<span class="sr-only">Instagram</span>';
        echo '</a>';
    }
    if ($soc_tw) {
        echo '<a href="' . esc_url($soc_tw) . '" class="fa-brands fa-x-twitter" target="_blank">';
        if ($show_labels) echo '<span class="sr-only">Twitter</span>';
        echo '</a>';
    }
    if ($soc_yt) {
        echo '<a href="' . esc_url($soc_yt) . '" class="fa-brands fa-youtube" target="_blank">';
        if ($show_labels) echo '<span class="sr-only">YouTube</span>';
        echo '</a>';
    }
    if ($soc_li) {
        echo '<a href="' . esc_url($soc_li) . '" class="fa-brands fa-linkedin" target="_blank">';
        if ($show_labels) echo '<span class="sr-only">LinkedIn</span>';
        echo '</a>';
    }
    if ($soc_c) {
        echo '<a href="' . esc_url($soc_c) . '" class="fa fa-envelope-open">';
        if ($show_labels) echo '<span class="sr-only">Contact</span>';
        echo '</a>';
    }
    echo '</div>';
}
///////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////
/**
 * Protect a specific page from deletion, hide it from admin list, and redirect front-end access.
 *
 * @param int $page_id The ID of the page to protect.
 */
function cdev_protect_page($page_id) {
    // Prevent deletion or trashing
    add_action('before_delete_post', function($post_id) use ($page_id) {
        if ($post_id == $page_id) {
            wp_die(__('You cannot delete this page.'));
        }
    }, 10, 1);

    add_action('wp_trash_post', function($post_id) use ($page_id) {
        if ($post_id == $page_id) {
            wp_die(__('You cannot delete this page.'));
        }
    }, 10, 1);

    // Hide from admin page list
    add_action('pre_get_posts', function($query) use ($page_id) {
        if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'page') {
            $not_in = (array) $query->get('post__not_in', []);
            $not_in[] = $page_id;
            $query->set('post__not_in', $not_in);
        }
    });

    // Redirect front-end access
    add_action('template_redirect', function() use ($page_id) {
        if (is_page($page_id)) {
            wp_redirect(home_url());
            exit;
        }
    });
}

//////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////
// Add new Very Simple wysiwyg toolbar option

add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
	// Uncomment to view format of $toolbars
	/*
	echo '< pre >';
		print_r($toolbars);
	echo '< /pre >';
	die;
	*/

	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Very Simple' ] = array();
	$toolbars['Very Simple' ][1] = array('bold' , 'italic' , 'underline' );

	// Edit the "Full" toolbar and remove 'code'
	// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
	//if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
	//{
	//    unset( $toolbars['Full' ][2][$key] );
	//}

	// remove the 'Basic' toolbar completely
	//unset( $toolbars['Basic' ] );

	// return $toolbars - IMPORTANT!
	return $toolbars;
}

///////////////////////////////////////////////////////////



///////////////////////////////////////////////////
// ACF admin styles
function admin_acf_styles() {
  echo '<style type="text/css">
		a.acf-hndle-cog { display: none; visibility: hidden }
		.acf-postbox > .hndle .acf-hndle-cog { display:none !important; }
		.acf-fields > .acf-field-5604635ab534d { background: #F5F5F5; }
		.acf-image-crop img { max-width:100% !important; }
		.client_logo_edit .acf-image-uploader { background: #EFEFEF; }
		.acf-image-uploader .image-wrap img {background: #efefef;}

		.acf-fields.acfe-column-wrapper>.acf-field.acf-field-acfe-column {
				border-top: 1px solid #eee;
		}
		.acf-accordion .acf-accordion-title {
				background: #f3f4f5;
		}
		.acf-accordion .acf-accordion-title:hover {
				background: #D3D6DA;
		}
	</style>';
}
add_action('admin_head', 'admin_acf_styles');

///////////////////////////////////////////////////


/////////////////////////////////////////////////////////////
// Override ACF escaping for specific WYSIWYG fields that need iframes/embeds
// Only allow unsafe HTML for known WYSIWYG fields, not all fields

add_filter( 'acf/the_field/allow_unsafe_html', function( $allowed, $selector ) {
	// List of field names that need to allow HTML (WYSIWYG fields with embeds)
	$allowed_fields = array(
		'content',
		'wysiwyg',
		'text_content',
		'body',
		'description',
		'embed_code',
		'video_embed',
		'head_scripts',
		'footer_scripts',
	);
	return in_array( $selector, $allowed_fields, true );
}, 10, 2);

// remove admin notice
add_filter( 'acf/admin/prevent_escaped_html_notice', '__return_true' );

/////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////
// Clean up ACF JSON files 
// Path to the acf-json folder in the active theme

/*
$json_folder = get_template_directory() . '/acf-json/';

// Get all field groups from the database
$field_groups = acf_get_field_groups();
$existing_keys = [];

foreach ($field_groups as $group) {
    $existing_keys[] = $group['key']; // Collect active field group keys
}

// Get all JSON files in the acf-json folder
$json_files = glob($json_folder . '/*.json');

foreach ($json_files as $file) {
    $filename = basename($file, '.json'); // Extract the file name (which is the group key)

    // If the file does not match an existing field group, delete it
    if (!in_array($filename, $existing_keys)) {
        unlink($file);
        echo "Deleted: " . $file . "<br>";
    }
}
*/

?>