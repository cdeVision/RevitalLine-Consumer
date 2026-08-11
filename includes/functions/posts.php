<?php
/**
 * Post functions and definitions
 */


////////////////////////////////////////////////////////
// Stop WordPress re-ordering my categories/taxonomies when I select them    

function stop_reordering_my_categories($args) {
	$args['checked_ontop'] = false;
	return $args;
}
add_filter('wp_terms_checklist_args','stop_reordering_my_categories');

////////////////////////////////////////////////////////


////////////////////////////////////////////////////////
// Remove checkbox for main post category

function wpse_22836_remove_top_categories_checkbox()
{
    global $post_type;

    if ( 'post' != $post_type )
        return;
    ?>
        <script type="text/javascript">
            jQuery("#categorychecklist>li>label input").each(function(){
                jQuery(this).remove();
            });
        </script>
    <?php
}
//add_action( 'admin_footer-post.php', 'wpse_22836_remove_top_categories_checkbox' );
//add_action( 'admin_footer-post-new.php', 'wpse_22836_remove_top_categories_checkbox' );

////////////////////////////////////////////////////////



////////////////////////////////////////////////////////
// Force a post category to be selected

function force_post_categ_init() 
{
  wp_enqueue_script('jquery');
}
function force_post_categ() 
{
  echo "<script type='text/javascript'>\n";
  echo "
  jQuery('#publish').click(function() 
  {
    var cats = jQuery('[id^=\"taxonomy\"]')
      .find('.selectit')
      .find('input');
    category_selected=false;
    for (counter=0; counter<cats.length; counter++) 
    {
        if (cats.get(counter).checked==true) 
        {
            category_selected=true;
            break;
        }
    }
    if(category_selected==false) 
    {
      alert('You have not selected any category for the post. Please select post category.');
      setTimeout(\"jQuery('#ajax-loading').css('visibility', 'hidden');\", 100);
      jQuery('[id^=\"taxonomy\"]').find('.tabs-panel').css('background', '#F96');
      setTimeout(\"jQuery('#publish').removeClass('button-primary-disabled');\", 100);
      return false;
    }
  });
  ";
   echo "</script>\n";
}
//add_action('admin_init', 'force_post_categ_init');
//add_action('edit_form_advanced', 'force_post_categ');

////////////////////////////////////////////////////////
// AJAX - Load More Resources Center Posts

function cdev_resources_loadmore_ajax_handler() {

	$page     = absint( $_POST['page'] ?? 0 ) + 1;
	$per_page = absint( $_POST['per_page'] ?? 2 );
	if ( $per_page < 1 ) {
		$per_page = 2;
	}

	$excluded_raw = sanitize_text_field( wp_unslash( $_POST['excluded'] ?? '' ) );
	$excluded     = array_filter( array_map( 'absint', explode( ',', $excluded_raw ) ) );

	$args = array(
		'post_type'      => 'resource',
		'post_status'    => 'publish',
		'posts_per_page' => $per_page,
		'paged'          => $page,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);

	if ( ! empty( $excluded ) ) {
		$args['post__not_in'] = $excluded;
	}

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'loop', 'resource-listing' );
		}
		wp_reset_postdata();
	}

	wp_die();
}
add_action( 'wp_ajax_resources_loadmore', 'cdev_resources_loadmore_ajax_handler' );
add_action( 'wp_ajax_nopriv_resources_loadmore', 'cdev_resources_loadmore_ajax_handler' );

////////////////////////////////////////////////////////


?>