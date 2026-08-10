<?php
/**
 * Image Block Template.
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
global $placeholder_color;
$block_size = get_field('block_size');
if( !$block_size ) {
    $block_size = 'block_size_none';
}
if ( $block_size == 'block_size_none' ) {
    $image = get_field('normal_image');
    if( $image ) {
        $image_url = $image['url'];
    } else {
        $image_url = get_placeholder_image(800,400,"Image",false,true);
    }
} else if ( $block_size == 'block_size_wide' ) {
    $image = get_field('wide_image');
    if( $image ) {
        $image_url = $image['url'];
    } else {
        $image_url = get_placeholder_image(1230,500,"Image",false,true);
    }
} else if ( $block_size == 'block_size_breakout' ) {
    $image = get_field('breakout_image');
    if( $image ) {
        $image_url = $image['url'];
    } else {
        $image_url = get_placeholder_image(1430,600,"Image",false,true);
    }
}



$image_alt = get_field('image_alt');
$image_caption = get_field('image_caption');

$image_width = $image ? $image['width'] : 800;
$image_height = $image ? $image['height'] : 400;
?>


<div class="image-block <?php get_block_options();?>" <?php render_block_anchor(); ?>>

    <img src="<?php echo esc_url($image_url); ?>" width="<?php echo esc_attr($image_width);?>" height="<?php echo esc_attr($image_height);?>" alt="<?php echo esc_attr($image_alt); ?>" />
    <?php if( $image_caption ) { ?>
    <p class="small-text caption"><?php echo wp_kses_post($image_caption); ?></p>
    <?php } ?>
    
</div>