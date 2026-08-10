<?php
/**
 * Brand post type admin customisations
 */


////////////////////////////////////////////////////////
// Customise admin columns for the "brand" post type

function brand_admin_columns( $columns ) {
	$new_columns = array();

	foreach ( $columns as $key => $label ) {
		if ( 'cb' === $key ) {
			$new_columns[ $key ] = $label;
			// Insert Logo column immediately after the checkbox, before Title
			$new_columns['brand_logo'] = __( 'Logo', 'revitalline' );
		} elseif ( 'title' === $key ) {
			$new_columns[ $key ] = $label;
			// Insert Description and URL columns after Title
			$new_columns['brand_description'] = __( 'Description', 'revitalline' );
			$new_columns['brand_url']         = __( 'URL', 'revitalline' );
		} elseif ( 'date' === $key ) {
			// Drop the Date column
			continue;
		} else {
			$new_columns[ $key ] = $label;
		}
	}

	return $new_columns;
}
add_filter( 'manage_brand_posts_columns', 'brand_admin_columns' );

////////////////////////////////////////////////////////


////////////////////////////////////////////////////////
// Populate custom columns for the "brand" post type

function brand_admin_column_content( $column, $post_id ) {
	switch ( $column ) {

		case 'brand_logo':
			$image = get_field( 'logo', $post_id );
			if ( $image ) {
				$src = isset( $image['sizes']['full'] ) ? $image['sizes']['full'] : $image['url'];
				echo '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $image['alt'] ) . '" style="max-width:130px;height:auto;display:block;" />';
			}
			break;

		case 'brand_description':
			$description = get_field( 'description', $post_id );
			echo $description ? wp_kses_post( $description ) : '&mdash;';
			break;

		case 'brand_url':
			$url = get_field( 'url', $post_id );
			if ( $url ) {
				echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $url ) . '</a>';
			} else {
				echo '&mdash;';
			}
			break;
	}
}
add_action( 'manage_brand_posts_custom_column', 'brand_admin_column_content', 10, 2 );

////////////////////////////////////////////////////////


////////////////////////////////////////////////////////
// Constrain the Logo column width in the admin list table

function brand_admin_column_styles() {
	$screen = get_current_screen();
	if ( ! $screen || 'edit-brand' !== $screen->id ) {
		return;
	}
	echo '<style>
		.column-brand_logo { width: 130px; }
	</style>';
}
add_action( 'admin_head', 'brand_admin_column_styles' );

////////////////////////////////////////////////////////
?>
