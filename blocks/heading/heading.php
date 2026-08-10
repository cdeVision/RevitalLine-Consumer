<?php
/**
 * cdeV Heading Block Template.
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

// Get variables
$headline = get_field('headline');
if (!$headline) {
    $headline = "Placeholder Headline";
}

$heading_size = get_field('heading_size');
if (!$heading_size) {
    $heading_size = "h3";
}

$heading_alignment = get_field('heading_alignment');
if (!$heading_alignment) {
    $heading_alignment = "left";
}

?>


<<?php echo $heading_size; ?> class="<?php echo esc_attr($heading_alignment); ?> <?php get_block_options(); ?>" <?php render_block_anchor(); ?>>
    <?php echo wp_kses_post($headline); ?>
</<?php echo $heading_size; ?>>