<?php
/**
 * Resource post type functions
 */


////////////////////////////////////////////////////////
// Admin columns — Image, Title, Featured (no Date)

/**
 * @param array $columns Default columns.
 * @return array
 */
function cdev_resource_admin_columns( $columns ) {
	return array(
		'cb'             => $columns['cb'],
		'cdev_thumbnail' => __( 'Image' ),
		'title'          => __( 'Title' ),
		'cdev_featured'  => __( 'Featured' ),
	);
}
add_filter( 'manage_resource_posts_columns', 'cdev_resource_admin_columns' );

/**
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function cdev_resource_admin_column_content( $column, $post_id ) {
	if ( 'cdev_thumbnail' === $column ) {
		$image = function_exists( 'get_field' ) ? get_field( 'thumbnail', $post_id ) : null;
		$url   = '';

		if ( is_array( $image ) ) {
			if ( ! empty( $image['url'] ) ) {
				$url = $image['url'];
			} elseif ( ! empty( $image['sizes']['thumbnail'] ) ) {
				$url = $image['sizes']['thumbnail'];
			}
		} elseif ( is_string( $image ) && $image ) {
			$url = $image;
		}

		if ( $url ) {
			printf(
				'<img src="%s" alt="" width="100" height="67" style="max-width:100px;width:100%%;height:auto;display:block;object-fit:cover;" />',
				esc_url( $url )
			);
		}
		return;
	}

	if ( 'cdev_featured' === $column ) {
		$featured = function_exists( 'get_field' ) ? get_field( 'featured', $post_id ) : false;
		if ( $featured ) {
			echo '<span class="dashicons dashicons-yes" style="color:#46b450;" aria-label="' . esc_attr__( 'Featured', 'revitalline' ) . '"></span>';
		}
	}
}
add_action( 'manage_resource_posts_custom_column', 'cdev_resource_admin_column_content', 10, 2 );

/**
 * Constrain Image column width in the admin list table.
 */
function cdev_resource_admin_column_styles() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen || 'edit-resource' !== $screen->id ) {
		return;
	}

	echo '<style>
		.wp-list-table .column-cdev_thumbnail { width: 100px; max-width: 100px; }
		.wp-list-table .column-cdev_thumbnail img { max-width: 100px; height: auto; display: block; }
		.wp-list-table .column-cdev_featured { width: 80px; text-align: center; }
		.wp-list-table .column-cdev_featured .dashicons { font-size: 24px; width: 24px; height: 24px; }
	</style>';
}
add_action( 'admin_head', 'cdev_resource_admin_column_styles' );

////////////////////////////////////////////////////////


////////////////////////////////////////////////////////
// Default block template for new resources

/**
 * Register editor block template for the resource CPT.
 * New resources start with a Column (One) block.
 */
function cdev_register_resource_block_template() {
	$post_type_object = get_post_type_object( 'resource' );
	if ( ! $post_type_object ) {
		return;
	}

	$post_type_object->template = array(
		array( 'cdev/column-one' ),
	);
}
add_action( 'init', 'cdev_register_resource_block_template', 20 );

////////////////////////////////////////////////////////
