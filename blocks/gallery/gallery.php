<?php
/**
 * Gallery Block Template.
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
$gallery_grid_layout = get_field('gallery_grid_layout');
$headline = get_field('headline');
$intro = get_field('intro'); 

global $count_gallery_custom;
if (!isset($count_gallery_custom)) {
    $count_gallery_custom = 0;
}
?>


<div class="gallery-block <?php echo $gallery_grid_layout; ?> <?php get_block_options();?> clear-both" <?php render_block_anchor(); ?>>

    <?php if( $headline ) { ?>
    <h3><?php echo wp_kses_post($headline); ?></h3>
    <?php } ?>
    <?php if( $intro ) { ?>
    <?php echo wp_kses_post($intro); ?>
    <?php } ?>
    <?php 
    $image_ids = get_field('gallery', false, false);
    if (is_countable($image_ids)) {
    $image_count = count($image_ids);
    } else {
    $image_count = 0;
    }
    if( $image_ids && $image_count > 0 ) {
        if( $gallery_grid_layout == "two" ){
            //$shortcode = '[gallery link="file" columns="5" size="cdev_highlight" ids="' . implode(',', $image_ids) . '"]';
            ?>
            <div class="gallery_custom">
            <?php
            // loop through images
            foreach( $image_ids as $image ):
                //echo wp_get_attachment_image( $image, 'cdev_highlight' ); 
                $title = get_the_title( $image );
                $thumb_image = wp_get_attachment_image( $image, 'cdev_highlight' );
                $full_image = wp_get_attachment_image_src( $image, 'full' ); 
                echo '<a href="' . esc_url($full_image[0]) . '" data-type="image" data-fancybox="gallery-custom-' . esc_attr($count_gallery_custom) . '">' . $thumb_image . '</a>';
            endforeach;
            ?>
            </div>

            <?php if( $image_count > 4 ){ ?>
            <div class="gallery_view_more"><a href="" class="box down">View More</a></div>
            <?php } ?>

            <?php
            $count_gallery_custom ++; // increase for next gallery custom


        } else {
            $shortcode = '[gallery link="file" columns="5" size="thumbnail" ids="' . implode(',', $image_ids) . '"]';
            echo do_shortcode( $shortcode );
        }
        
    } else { // show placeholder images
        $gallery_id = rand(9000, 10000);
        ?>

        <div id="gallery-<?php echo $gallery_id;?>" class="gallery galleryid-<?php echo $gallery_id;?> gallery-columns-5 gallery-size-thumbnail">
            <?php
            $image_width = 285;
            $image_height = 200;
            global $placeholder_color;
            global $placeholder_text;
            for ($i = 1; $i <= 4; $i++) { ?>
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="<?php echo get_placeholder_image(800,600,"Image " . ($i + 1),false); ?>" data-fancybox="gallery-1" title="" data-caption="">
                            <img fetchpriority="high" decoding="async" width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" src="<?php echo get_placeholder_image($image_width,$image_height,"Image " . ($i + 1),false); ?>" class="attachment-thumbnail size-thumbnail" alt="Placeholder image <?php echo $i; ?>" title="">
                        </a>
                    </dt>
                </dl>
            <?php } ?>
            
			<br style="clear: both">
		</div>



    <?php } ?>
    
</div>