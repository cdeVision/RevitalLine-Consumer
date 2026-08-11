<?php
/**
 * Resources Center Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

// Get the preview image if it exists
if ( display_preview_image() ) {
	return;
}

// Block fields
$featured_heading = get_field( 'featured_heading' );
if ( ! $featured_heading ) {
	$featured_heading = 'Featured';
}

$grid_heading = get_field( 'grid_heading' );
if ( ! $grid_heading ) {
	$grid_heading = 'More How-to Resources';
}

$load_more_text = get_field( 'load_more_text' );
if ( ! $load_more_text ) {
	$load_more_text = 'VIEW MORE RESOURCES';
}

// Items per page — change to 8 after testing
$posts_per_page = 8;

// Featured resources
$featured_query = new WP_Query(
	array(
		'post_type'      => 'resource',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_query'     => array(
			array(
				'key'     => 'featured',
				'value'   => '1',
				'compare' => '=',
			),
		),
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$excluded_ids = array();
if ( $featured_query->have_posts() ) {
	$excluded_ids = wp_list_pluck( $featured_query->posts, 'ID' );
}

// Grid resources (exclude featured)
$grid_args = array(
	'post_type'      => 'resource',
	'post_status'    => 'publish',
	'posts_per_page' => $posts_per_page,
	'paged'          => 1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
);

if ( ! empty( $excluded_ids ) ) {
	$grid_args['post__not_in'] = $excluded_ids;
}

$grid_query = new WP_Query( $grid_args );
$max_pages  = (int) $grid_query->max_num_pages;
?>

<div class="resources-center-block <?php get_block_options(); ?>" <?php render_block_anchor(); ?>>

	<?php if ( $featured_query->have_posts() ) : ?>
		<section class="resources-center-featured">
			<h2 class="resources-center-heading"><?php echo esc_html( $featured_heading ); ?></h2>

			<?php
			while ( $featured_query->have_posts() ) :
				$featured_query->the_post();
				$loop_id = get_the_ID();

				$image   = get_field( 'thumbnail', $loop_id );
				$img_url = '';
				$img_alt = get_the_title();

				if ( is_array( $image ) ) {
					$img_url = ! empty( $image['url'] ) ? $image['url'] : '';
					if ( ! empty( $image['alt'] ) ) {
						$img_alt = $image['alt'];
					}
				} elseif ( is_string( $image ) && $image ) {
					$img_url = $image;
				}

				if ( ! $img_url ) {
					$img_url = get_placeholder_image( 600, 400, 'Featured' );
				}

				$excerpt = get_field( 'excerpt', $loop_id );
				?>
				<div class="resources-featured-item highlight-box left">
					<div class="media">
						<img src="<?php echo esc_url( $img_url ); ?>" width="600" height="400" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy" />
					</div>
					<div class="text">
						<div class="wrapper clear-both">
							<h3><?php the_title(); ?></h3>
							<?php if ( $excerpt ) : ?>
								<?php echo wp_kses_post( $excerpt ); ?>
							<?php endif; ?>
							<p><a href="<?php the_permalink(); ?>" class="box">VIEW INFORMATION</a></p>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</section>
	<?php endif; ?>

	<section class="resources-center-grid-section">
		<?php if ( $grid_heading ) : ?>
			<h2 class="resources-center-heading"><?php echo esc_html( $grid_heading ); ?></h2>
		<?php endif; ?>

		<div class="resources-center-grid"
			data-page="1"
			data-max="<?php echo esc_attr( $max_pages ); ?>"
			data-per-page="<?php echo esc_attr( $posts_per_page ); ?>"
			data-excluded="<?php echo esc_attr( implode( ',', $excluded_ids ) ); ?>">

			<?php
			if ( $grid_query->have_posts() ) :
				while ( $grid_query->have_posts() ) :
					$grid_query->the_post();
					get_template_part( 'loop', 'resource-listing' );
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

		<?php if ( $max_pages > 1 ) : ?>
			<div class="cdev_loadmore_wrap resources-center-loadmore">
				<a href="#" class="box down cdev_resources_loadmore"><?php echo esc_html( $load_more_text ); ?></a>
			</div>
		<?php endif; ?>
	</section>

</div>
