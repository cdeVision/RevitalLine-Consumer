<?php
/**
 * Video Block Template.
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
$video_format = get_field('video_format');
$video_caption = get_field('video_caption');

if($video_format == "embed") {
    $video = get_field('video_embed');
} else {
    $video = get_field('video_file');
    if($video) {
        $video = '
        <video width="100%" height="600" controls>
        <source src="' . esc_url($video) . '" type="video/mp4">
        Your browser does not support the video tag.
        </video>
        ';
    }
}
if( !$video ) {
    $video = get_placeholder_image(1430,805,"Video",true,true);
}

?>


<div class="video-block <?php get_block_options();?>" <?php render_block_anchor(); ?>>

    <div class="video-wrapper">
        <div class="video">
        <?php echo $video; ?>
        </div>
        <?php if( $video_caption ) { ?>
        <p class="small-text caption"><?php echo wp_kses_post($video_caption); ?></p>
        <?php } ?>
    </div>
    
</div>