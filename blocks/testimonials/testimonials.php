<?php
/**
 * Testimonials Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */


// Get the preview image if it exists
if (display_preview_image()) {
    return;
}

// Get Vars
$headline = get_field('headline');
if ( ! $headline ) {
    $headline = 'What Homeowners Are Saying';
}

$image = get_field('image');
if ( ! $image ) {
    global $placeholder_color;
    global $placeholder_text;
    $width = 1980;
    $height = 800;
    $title = "Image";
    $image = "https://placehold.co/{$width}x{$height}/" . $placeholder_color . "/" . $placeholder_text . "/?text=" . $title;
}

$args = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => -1,
    'orderby'        => array(
        'menu_order' => 'ASC',
        'date'       => 'DESC',
    ),
    'post_status'    => 'publish',
);

$reviews = new WP_Query($args);
?>

<div class="testimonials-block <?php get_block_options('block_size_full'); ?>" <?php render_block_anchor(); ?>>
    <div class="testimonials-block-inner" style="background-image: url(<?php echo esc_url($image); ?>)">
        <div class="inner_alignwide">
            <?php if ( $headline ) : ?>
                <h2 class="testimonials-headline white-text"><?php echo esc_html($headline); ?></h2>
            <?php endif; ?>

            <?php if ( $reviews->have_posts() ) : ?>
                <div class="testimonials-slider">
                    <?php while ( $reviews->have_posts() ) : $reviews->the_post();
                        $name     = get_field('name', get_the_ID());
                        $quote    = get_field('quote', get_the_ID());
                        $location = get_field('location', get_the_ID());
                        $type     = get_field('type', get_the_ID());
                        ?>
                        <div class="testimonial-slide">
                            <div class="testimonial-item">
                                <?php if ( $quote ) : ?>
                                    <div class="testimonial-quote">
                                        <div class="testimonial-quote-text">
                                            <p><?php echo esc_html($quote); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="testimonial-footer">
                                    <div class="testimonial-meta">
                                        <?php if ( $name ) : ?>
                                            <p class="testimonial-author"><?php echo esc_html($name); ?></p>
                                        <?php endif; ?>
                                        <?php if ( $location ) : ?>
                                            <p class="testimonial-location"><?php echo esc_html($location); ?></p>
                                        <?php endif; ?>
                                        <p class="testimonial-type"><?php echo $type ? esc_html($type) : '&nbsp;'; ?></p>
                                    </div>
                                    <span class="testimonial-stars" aria-label="5 star rating">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p class="white-text">No testimonials found.</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>
