<?php
/**
 * Highlight Box Block Template.
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
$media_position = get_field( 'media_position' );
if(!$media_position){
    $media_position = "left";
}
$media_type = get_field( 'media_type' );
if(!$media_type){
    $media_type = "image";
}

$headline = get_field( 'headline' );
if(!$headline){
    $headline = "Placeholder Headline";
}

$text = get_field( 'text' );
if(!$text){
    $text = "<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs.</p>";
}
?>


<div class="highlight-box-wrap <?php get_block_options();?>" <?php render_block_anchor(); ?>>
<div class="highlight-box <?php echo esc_attr($media_position); ?>">


    <div class="media">
        <?php if( $media_type == "image" ){ 
            $image = get_field( 'image' );
            if(!$image){
                $image = get_placeholder_image(600,400);
            }
            $image_alt = get_field( 'image_alt' );
            if(!$image_alt){
                $image_alt = "Temp ALT Text";
            }
            ?>
            <img src="<?php echo esc_url($image); ?>" width="600" height="400" alt="<?php echo esc_attr($image_alt); ?>">
        <?php } ?>

        <?php if( $media_type == "grid" ){ 
            $image_large = get_field( 'image_large' );
            $image_large_alt = get_field( 'image_large_alt' );
            if(!$image_large){
                $image_large = get_placeholder_image(600,400);
            }
            if(!$image_large_alt){
                $image_large_alt = "Temp ALT Text";
            }

            $image_small_left = get_field( 'image_small_left' );
            $image_small_left_alt = get_field( 'image_small_left_alt' );
            if(!$image_small_left){
                $image_small_left = get_placeholder_image(285,190);
            }
            if(!$image_small_left_alt){
                $image_small_left_alt = "Temp ALT Text";
            }

            $image_small_right = get_field( 'image_small_right' );
            $image_small_right_alt = get_field( 'image_small_right_alt' );
            if(!$image_small_right){
                $image_small_right = get_placeholder_image(285,190);
            }
            if(!$image_small_right_alt){
                $image_small_right_alt = "Temp ALT Text";
            }
            
            ?>
            <div class="grid">
                <div><img src="<?php echo esc_url($image_large); ?>" width="600" height="400" alt="<?php echo esc_attr($image_large_alt); ?>"></div>
                <div><img src="<?php echo esc_url($image_small_left); ?>" width="285" height="190" alt="<?php echo esc_attr($image_small_left_alt); ?>"></div>
                <div><img src="<?php echo esc_url($image_small_right); ?>" width="285" height="190" alt="<?php echo esc_attr($image_small_right_alt); ?>"></div>
            </div>
        <?php } ?>


        <?php if( $media_type == "video_url" || $media_type == "video_file"){ 
        if($media_type == "video_url") {
            $video = get_field('video_url');
        } else {
            $video = get_field('video_file');
            $video_alt = get_field('video_alt');
            if($video) {
                $video = '
                <video width="560" height="315" controls aria-label="' . $video_alt . '">
                <source src="' . $video . '" type="video/mp4">
                Your browser does not support the video tag.
                </video>
                ';
            }
        }
        if( !$video ) {
            global $primary_color;
            $video = '<img src="https://placehold.co/1430x805/' . $primary_color . '/ffffff/?text=Video" alt="Placeholder Image" />';
        }
        ?>
            <div class="video-wrapper">
                <div class="video">
                <?php echo $video; ?>
                </div>
                <?php 
                $video_caption = get_field('video_caption');
                if( $video_caption ) { ?>
                <p class="small-text caption"><?php echo wp_kses_post($video_caption); ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="text">
        <div class="wrapper clear-both">
        <h2><?php echo wp_kses_post($headline); ?></h2>
        <?php echo wp_kses_post($text); ?>
        <?php 
        // displayShowLink($wrapper = "p",$sub = true,$prefix = "none")
        displayShowLink("p",false,"none");
        ?>
        </div>
    </div>

</div>
</div>