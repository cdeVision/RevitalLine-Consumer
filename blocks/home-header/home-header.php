<?php
/**
 * cdev Home Header Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

if (display_preview_image()) {
    return;
}

$title_tag = 'h2';

?>
<div class="home-header-block block_size_full">

    <div class="home-header white-text header-slideshow">

        <?php // Display the slideshow ///////////////////////// ?>
        <?php if (have_rows('banner_slideshow')): ?>
            <div class="banner_slideshow_wrapper">
                <div class="home_slideshow">
                    <?php while (have_rows('banner_slideshow')): the_row();
                        $slide_headline = get_sub_field('banner_headline') ?: "Home Headline Placeholder";
                    ?>
                        <div class="slide">
                            <img src="<?php echo esc_url(get_sub_field('image')); ?>" width="1980" height="600" alt="<?php echo esc_attr(get_sub_field('image_alt')); ?>">
                            <div class="wrapper inner_alignwide">
                                <div class="header-banner-text">
                                    <<?php echo $title_tag; ?> class="h1"><?php echo esc_html($slide_headline); ?></<?php echo $title_tag; ?>>
                                    <?php the_sub_field('banner_text'); ?>
                                    <?php
                                    $link_title = get_sub_field('link_title');
                                    $link_url   = get_sub_field('link_url');
                                    if ($link_title && $link_url):
                                    ?>
                                        <a href="<?php echo esc_url($link_url); ?>" class="box"><?php echo esc_html($link_title); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else: ?>
            <?php echo get_placeholder_image(1980, 600, "Slideshow", true, true); ?>
            <div class="wrapper inner_alignwide">
                <div class="header-banner-text has-animation fade-in">
                    <<?php echo $title_tag; ?> class="h1">Home Headline Placeholder</<?php echo $title_tag; ?>>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
