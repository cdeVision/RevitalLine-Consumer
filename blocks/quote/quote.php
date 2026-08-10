<?php
/**
 * Quote Block Template.
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
$quote_text = get_field('quote_text');
if( empty($quote_text) ) {
    $quote_text = '<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nunc nec ultricies ultricies, nunc."</p>';
}
$quote_by = get_field('quote_by');
if( empty($quote_by) ) {
    $quote_by = 'Anonymous';
}
$quote_image = get_field('quote_image');
$quote_image_alt = get_field('quote_image_alt');

?>


<div class="quote-block <?php get_block_options();?>" <?php render_block_anchor(); ?>>

    <div class="quote-text-wrap">
        <?php if ($quote_image) { ?>
        <img src="<?php echo esc_url($quote_image['url']); ?>" width="<?php echo esc_attr($quote_image['width']); ?>" height="<?php echo esc_attr($quote_image['height']); ?>" alt="<?php echo esc_attr($quote_image_alt); ?>">
        <?php } ?>
        <div class="quote-text">
            <?php echo wp_kses_post($quote_text); ?>
            <p class="by">&mdash; <?php echo esc_html($quote_by); ?></p>
        </div>
    </div>

</div>