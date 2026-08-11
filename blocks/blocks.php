<?php
/**
 * cdev Block functions and definitions
 */

//////////////////////////////////////////////////////////////////////////////////////
// Register Block Scripts

function cdev_register_block_scripts() {

	// Register Slick JS early so iframe block-script dependency resolution works.
	wp_register_script( 'slick-js', get_template_directory_uri() . '/includes/slick/slick.min.js', array( 'jquery' ), '1.8.0', true );

	// Shared: scroll/fade animations (.has-animation → .visible)
	wp_register_script( 'animation-js', get_template_directory_uri() . '/includes/js/has-animation.js', array( 'jquery' ), '', true );

	// Page Banner
	wp_register_script( 'banner-slider-js', get_template_directory_uri() . '/blocks/page-header/banner-slider.js', array( 'jquery', 'slick-js' ), '', true );
	wp_register_script( 'banner-video-js', get_template_directory_uri() . '/blocks/page-header/banner-video.js', array( 'jquery' ), '', true );

	// Home Header
	wp_register_script( 'home-slider-js', get_template_directory_uri() . '/blocks/home-header/home-slider.js', array( 'jquery', 'slick-js' ), '', true );
	wp_register_script( 'home-video-js', get_template_directory_uri() . '/blocks/home-header/home-video.js', array( 'jquery' ), '', true );

	// Logo Slider / Slideshow / Testimonials
	wp_register_script( 'logo-slider-js', get_template_directory_uri() . '/blocks/logo-slider/logo-slider.js', array( 'jquery', 'slick-js' ), '', true );
	wp_register_script( 'slideshow-js', get_template_directory_uri() . '/blocks/slideshow/slideshow.js', array( 'jquery', 'slick-js' ), '', true );
	wp_register_script( 'testimonials-js', get_template_directory_uri() . '/blocks/testimonials/testimonials-slider.js', array( 'jquery', 'slick-js' ), '', true );

	// Accordion / Gallery
	wp_register_script( 'accordion-js', get_template_directory_uri() . '/blocks/accordion/accordion.js', array( 'jquery' ), '', true );
	wp_register_script( 'gallery-js', get_template_directory_uri() . '/blocks/gallery/gallery.js', array( 'jquery' ), '', true );

	// Resources Center (AJAX load more)
	wp_register_script( 'resources-center-js', get_template_directory_uri() . '/blocks/resources-center/resources-center.js', array( 'jquery' ), '', true );
	wp_localize_script( 'resources-center-js', 'cdev_resources_params', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );

}
// Register early so block.json "script" handles exist before register_block_type() on init (priority 10).
add_action( 'init', 'cdev_register_block_scripts', 5 );

//////////////////////////////////////////////////////////////////////////////////////
// Editor canvas styles (WP 7+ iframe) — post title / canvas background
//////////////////////////////////////////////////////////////////////////////////////

function cdev_enqueue_editor_canvas_styles() {
	if ( ! is_admin() ) {
		return;
	}
	$path = get_template_directory() . '/style-editor.css';
	if ( ! file_exists( $path ) ) {
		return;
	}
	wp_enqueue_style(
		'cdev-editor-canvas',
		get_template_directory_uri() . '/style-editor.css',
		array(),
		filemtime( $path )
	);

	// Any block can get .has-animation via get_block_options(); load in editor iframe.
	wp_enqueue_script( 'animation-js' );
}
add_action( 'enqueue_block_assets', 'cdev_enqueue_editor_canvas_styles' );


//////////////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////////
// Register Gutenberg Editor Styles
///////////////////////////////////////////////////////////////////////////////////

function cdevblock_full_site_basic_editor_styles() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'block-style.css' );
}
add_action( 'after_setup_theme', 'cdevblock_full_site_basic_editor_styles' );

///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
// Add custom classes to blocks
///////////////////////////////////////////////////////////////////////////////////

function get_block_options($block_size_override = null, $echo = true) {
    $classes = array('cdev_block');

    $block_size = $block_size_override ?: (get_field('block_size') ?: 'block_size_wide');
    $block_text_width = get_field('block_text_width') ?: '';
    $block_intro = get_field('block_intro') ? 'block_intro' : '';

    $block_list_style_field = get_field('block_list_style');
    $block_list_style = $block_list_style_field === 'block_ul_one' ? '' : $block_list_style_field;

    $block_background = get_field('block_background');
    $block_background = $block_background === 'block_background_none' ? '' : $block_background;

    $block_theme_color = get_field('block_theme_color') ?: '';

    $block_padding_before_field = get_field('block_padding_block_padding_before');
    $block_padding_before = $block_padding_before_field === 'block_pad_before_none' ? '' : $block_padding_before_field;

    $block_padding_after_field = get_field('block_padding_block_padding_after');
    $block_padding_after = $block_padding_after_field === 'block_pad_after_none' ? '' : $block_padding_after_field;

    $block_margin_before_field = get_field('block_margin_block_margin_before');
    $block_margin_before = $block_margin_before_field === 'block_mar_before_none' ? '' : $block_margin_before_field;

    $block_margin_after_field = get_field('block_margin_block_margin_after');
    $block_margin_after = $block_margin_after_field === 'block_mar_after_none' ? '' : $block_margin_after_field;

    $block_animation_type = '';
    $block_animation = get_field('block_animation_animation');
    if ($block_animation) {
        $block_animation_type = $block_animation;
        $block_animation = 'has-animation';
    }

    $classes = array_filter(array(
        $classes[0],
        $block_size,
        $block_text_width,
        $block_background,
        $block_theme_color,
        $block_intro,
        $block_list_style,
        $block_margin_before,
        $block_margin_after,
        $block_padding_before,
        $block_padding_after,
        $block_animation,
        $block_animation_type
    ));

    $classes = array_map('sanitize_html_class', $classes);
    $out = implode(' ', $classes);

    if ($echo) echo esc_attr($out);
    return $out;
}

///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
// Block Anchor
function render_block_anchor() {
    $anchor = get_field('block_anchor_anchor');
    if ($anchor) {
        echo 'id="' . esc_attr($anchor) . '"';
    }
}
///////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////
// Register block categories
add_filter( 'block_categories_all', 'cdev_block_categories', 10, 2 );
function cdev_block_categories( $categories, $block_editor_context ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'cdev-content-blocks',
                'title' => __( 'Content Blocks', 'cdev' ),
            ),
            array(
                'slug'  => 'cdev-page-banners',
                'title' => __( 'Page Banners', 'cdev' ),
            ),
        )
    );
}


////////////////////////////////////////////////////////////////
// Register Blocks

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
    
    // Register page header block with custom attributes and category
    register_block_type(
        get_template_directory() . '/blocks/page-header',
        array(
            'category'       => 'cdev-page-banners',
            'attributes'     => array(
                '_refresh' => array(
                    'type'    => 'number',
                    'default' => 0,
                ),
            )
        )
    );
    
    // Register blocks that start with "home-"
    $home_blocks = glob(get_template_directory() . '/blocks/home-*', GLOB_ONLYDIR);
    foreach ($home_blocks as $block) {
        register_block_type($block, array(
            'category' => 'cdev-page-banners',
            'attributes' => array(
                '_refresh' => array(
                    'type' => 'number',
                    'default' => 0,
                ),
            ),
            'mode' => 'auto', // Ensures block updates automatically
            'supports' => array(
                'align' => false,
                'jsx' => true // Enables JavaScript-based preview
            ),
            'usesContext' => ['postId'],
        ));
    }
    
    // Register all other blocks - use _ to hide from block inserter
    $blocks = glob(get_template_directory() . '/blocks/*', GLOB_ONLYDIR);
    foreach ($blocks as $block) {
        if ( basename($block) !== 'page-header' && strpos(basename($block), 'home-') !== 0 && strpos(basename($block), '_') !== 0 ) {
            register_block_type($block, array(
                'category' => 'cdev-content-blocks',
                'mode'              => 'auto', // Ensures block updates automatically
                'supports'          => array(
                    'align' => false,
                    'jsx'   => true // Enables JavaScript-based preview
                ),
                'usesContext' => ['postId'],
            ));
        }
    }

    

}

////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////
/*
 * Whitelist specific Gutenberg blocks only
 *
 */

function cdev_allowed_block_types( $allowed_blocks, $editor_context ) {
    $allowed_blocks = array(
        //'cdev/page-header',
        'core/block'
    );

    $blocks = glob(get_template_directory() . '/blocks/*', GLOB_ONLYDIR);
    foreach ($blocks as $block) {
        if (basename($block) !== 'page-header' && strpos(basename($block), 'home-') !== 0 && strpos(basename($block), '_') !== 0) {
            $allowed_blocks[] = 'cdev/' . basename($block);
        }
    }

    return $allowed_blocks;
}
add_filter( 'allowed_block_types_all', 'cdev_allowed_block_types', 25, 2 );

////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////
// Enqueue block editor JS assets

// Refresh page header block on page title change
function my_theme_enqueue_block_editor_js_assets() {
    wp_enqueue_script(
        'reload-block-script',
        get_template_directory_uri() . '/blocks/custom-admin.js', // Adjust path as necessary.
        [ 'wp-data', 'wp-api-fetch', 'wp-block-editor' ],
        filemtime( get_template_directory() . '/blocks/custom-admin.js' ),
        true
    );
}
add_action( 'enqueue_block_editor_assets', 'my_theme_enqueue_block_editor_js_assets' );

////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////
// Create page template with blocks
// Info:
// https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/#api
// https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
// https://fullsiteediting.com/how-to-lock-blocks-and-templates/
// https://gutenbergtimes.com/how-to-disable-theme-features-and-lock-block-templates-for-full-site-editing-in-wordpress/

// Block example:
// https://www.billerickson.net/building-acf-blocks-with-block-json/



////////////////////////////////////////////////////////////////
// Apply blocks to page templates

/**
 * Default block markup for new (non-home) pages.
 */
function cdev_get_default_page_blocks() {
	return '<!-- wp:cdev/page-header {"lock":{"move":true,"remove":true}} /-->' . "\n"
		. '<!-- wp:cdev/column-one /-->';
}

/**
 * Register editor block template for pages.
 * Required for WP iframe editor: client applies this when a new empty page is created.
 */
function cdev_register_page_block_template() {
	$post_type_object = get_post_type_object( 'page' );
	if ( ! $post_type_object ) {
		return;
	}

	$post_type_object->template = array(
		array(
			'cdev/page-header',
			array(
				'lock' => array(
					'move'   => true,
					'remove' => true,
				),
			),
		),
		array( 'cdev/column-one' ),
	);
}
add_action( 'init', 'cdev_register_page_block_template' );

/**
 * Seed default block markup when WordPress creates a new empty page (auto-draft).
 * Runs during insert (not after via wp_update_post) so REST/iframe editor receives content.
 */
function cdev_default_page_content_on_insert( $data, $postarr ) {
	if ( ( $data['post_type'] ?? '' ) !== 'page' ) {
		return $data;
	}

	// Only new inserts — never re-populate an existing page the user cleared.
	if ( ! empty( $postarr['ID'] ) ) {
		return $data;
	}

	if ( ! empty( $data['post_content'] ) ) {
		return $data;
	}

	$data['post_content'] = cdev_get_default_page_blocks();

	return $data;
}
add_filter( 'wp_insert_post_data', 'cdev_default_page_content_on_insert', 10, 2 );

/**
 * Fallback for classic get_default_post_to_edit() path.
 */
function cdev_filter_default_page_content( $content, $post ) {
	if ( ! $post || ( $post->post_type ?? '' ) !== 'page' ) {
		return $content;
	}

	if ( ! empty( $content ) ) {
		return $content;
	}

	return cdev_get_default_page_blocks();
}
add_filter( 'default_content', 'cdev_filter_default_page_content', 10, 2 );

function create_home_page($redirect = true) {
    global $page_template;

    // Define home page-specific block content
    $home_page_content = '
    <!-- wp:cdev/home-header {"lock":{"move":true,"remove":true}} /-->
    <!-- wp:cdev/home-elevator /-->
    ';

    // Create a new untitled home page
    $new_page_id = wp_insert_post([
        'post_title'          => 'Home', // Set title explicitly
        'post_status'         => 'publish', // Set as published
        'post_type'           => 'page',
        'post_author'         => get_current_user_id(),
        'post_content'        => $home_page_content,
    ]);

    if ($new_page_id) {
        // Assign the home page template
        update_post_meta($new_page_id, '_wp_page_template', 'page-home.php'); // Explicitly set

        // Store a flag so we know this was created as a home page
        update_post_meta($new_page_id, '_is_custom_home_page', true);

        // Redirect to edit the new page if enabled
        if ($redirect) {
            wp_redirect(admin_url('post.php?post=' . $new_page_id . '&action=edit'));
            exit;
        }
    }
}

// Add menu item under "Pages" in admin
function add_create_home_page_menu() {
    add_submenu_page(
        'edit.php?post_type=page',
        'Create Home Page',
        'Create Home Page',
        'manage_options',
        'create-home-page',
        'trigger_create_home_page'
    );
}
// Function to trigger home page creation
function trigger_create_home_page() {
    create_home_page();
}
//add_action('admin_menu', 'add_create_home_page_menu');


////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
// Prevent users from changing page templates
function disable_page_template_dropdown() {
    $screen = get_current_screen();
    if ( $screen && $screen->post_type === 'page' ) {
        ?>
        <style>
            .editor-post-template__dropdown {
                display: none !important;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'disable_page_template_dropdown');

////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////
// Prevent users from unlocking blocks
// Blocks with lock attributes (like page-header) cannot be unlocked by users
add_filter(
	'block_editor_settings_all',
	static function( $settings, $context ) {
		// Disable ability to lock/unlock blocks for all users
		$settings['canLockBlocks'] = false;
		return $settings;
	},
	10,
	2
);

////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////
// Editor Thumb Preview Image
function display_preview_image() {
    $preview = get_field('preview');
    if ($preview) {
        $preview_thumb = get_field($preview, 'options_editor_thumbs') ?: get_field('placeholder_image', 'options_editor_thumbs') ?: 'https://placehold.co/500x300/efefef/000000?text=' . str_replace(' ', '+', get_bloginfo('name'));
        echo '<div class="cdev-preview-image"><img src="' . $preview_thumb . '" style="max-width:100%;height: auto;"/></div>';
        return true;
    }
    return false;
}

// Change upload direcotry for editor thumbs
// get content editor layouts from json file

function my_acf_get_group_layouts_prefilter($group){

	$jsonPath = get_template_directory() . "/acf-json/" . $group . ".json";
	$contents = file_get_contents($jsonPath);
	$data =  json_decode($contents);

	// add layouts to an array
	$availableOptions = [];
	foreach($data->fields as $field) {
			//foreach($field->layouts as $layout) {
					array_push($availableOptions, $field->key);
			//}
	}
	// loop array to make filters
	foreach ($availableOptions as $key) {
		add_filter('acf/upload_prefilter/key=' . $key, 'field_key_upload_prefilter');
	}

}
my_acf_get_group_layouts_prefilter("group_64aee35931ff6");

function field_key_upload_prefilter($errors) {
  // in this filter we add a WP filter that alters the upload path
  add_filter('upload_dir', 'field_key_upload_dir');
  return $errors;
}
// second filter
function field_key_upload_dir($uploads) {
  // here is where we later the path
  $uploads['path'] = $uploads['basedir'].'/editor-thumbs';
  $uploads['url'] = $uploads['baseurl'].'/editor-thumbs';
  $uploads['subdir'] = '';
  return $uploads;
}

// Hide upload folder from media library
function media_library_hide_editor_thumbs($where) {
	if(isset($_POST['action']) && ( $_POST['action'] == 'query-attachments')) {
		 $where .= ' AND guid NOT LIKE "%wp-content/uploads/editor-thumbs%"';
	}

	return $where;
}

add_filter('posts_where', 'media_library_hide_editor_thumbs');

////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////
// Remove the view icon and menu from edit page
//add_action( 'admin_head', 'cdev_remove_menu_icons' );
function cdev_remove_menu_icons() {
    echo '<style>
        .components-dropdown.components-dropdown-menu.editor-preview-dropdown {
            display: none !important;
        }
        .editor-header__settings .components-dropdown.components-dropdown-menu {
            display: none !important;
        }
        .css-if8s8t[aria-controls="tabs-0-edit-post/block-view"] {
            display: none !important;
        }
        button.components-button.editor-post-featured-image__toggle {
            display: none !important;
        }
        #tabs-1-outline {
            display: none !important;
        }

        
    </style>';
}

////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////
// Admin Styles for Gutenberg Editor

// Disable fullscreen mode in editor
function disable_fullscreen_mode_inline() {
    ?>
    <script>
        wp.domReady(() => {
            const isFullscreen = wp.data.select('core/edit-post').isFeatureActive('fullscreenMode');
            if (isFullscreen) {
                wp.data.dispatch('core/edit-post').toggleFeature('fullscreenMode');
            }
        });
    </script>
    <?php
}
add_action('admin_footer', 'disable_fullscreen_mode_inline');

// Styles for parent editor shell only (inserter, sidebar, ACF modal).
// Post title / canvas background rules live in style-editor.css (enqueue_block_assets → iframe).
function cdev_block_admin_styles() {
    echo '
        <style>
        .block-editor-inserter__preview-container {
				width: 532px;
		}

		.acf-block-fields p {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
		}

        .components-tip {
            display: none !important;
        }

        #tabs-1-media {
            display: none !important;
        }

        .block-editor-inserter__search {
            display: none !important;
        }

        .block-editor-block-icon svg {
            max-height: 32px;
            max-width: 32px;
        }

        .interface-interface-skeleton__content {
            scroll-behavior: smooth !important;
        }

        .acf-block-form-modal {
            width: min(80%, 1200px) !important;
        }
        @media (min-width: 600px) and (min-width: 782px) {
            .acf-block-form-modal {
                width: min(80%, 1200px) !important;
            }
        }
        </style>
    ';
}
add_action('admin_head', 'cdev_block_admin_styles');

////////////////////////////////////////////////////////////////


?>