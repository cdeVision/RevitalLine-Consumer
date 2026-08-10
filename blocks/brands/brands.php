<?php
/**
 * Brands Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

// Get the preview image if it exists
if (display_preview_image()) {
    return;
}

// Query all brand posts ordered alphabetically
$brands_query = new WP_Query(array(
    'post_type'      => 'brand',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'post_status'    => 'publish',
));
?>

<div class="brands-block <?php echo esc_attr(get_block_options()); ?>" <?php render_block_anchor(); ?>>

    <?php if ($brands_query->have_posts()) : ?>

        <div class="brands-grid">

            <?php while ($brands_query->have_posts()) : $brands_query->the_post(); ?>

                <?php
                $brand_id    = get_the_ID();
                $logo        = get_field('logo', $brand_id);
                $description = get_field('description', $brand_id);
                $url         = get_field('url', $brand_id);
                ?>

                <div class="brand-item">

                    <div class="brand-logo">
                        <?php if ($logo) : ?>
                            <img
                                src="<?php echo esc_url($logo['url']); ?>"
                                alt="<?php echo esc_attr($logo['alt'] ?: get_the_title()); ?>"
                                width="<?php echo esc_attr($logo['width']); ?>"
                                height="<?php echo esc_attr($logo['height']); ?>"
                            >
                        <?php endif; ?>
                    </div>

                    <h3 class="h5"><?php echo esc_html(get_the_title()); ?></h3>

                    <div class="brand-description">
                        <?php echo $description ? wp_kses_post($description) : ''; ?>
                    </div>

                    <div class="brand-link">
                        <?php if ($url) : ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="box">View Brand Website</a>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

        </div>

    <?php else : ?>

        <?php if (is_admin() || is_preview()) : ?>
            <p><?php esc_html_e('No brands found. Add brands via the Brands post type.', 'revitalline'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

</div>
