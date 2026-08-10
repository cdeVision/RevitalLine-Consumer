<?php
/**
 * Slideshow Block Template.
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

?>


<div class="slideshow-block <?php get_block_options();?>" <?php render_block_anchor(); ?>>

    <?php 
    // check if the repeater field has rows of data
    if( have_rows('slides') ):?>
	<div class="slideshow">

        <?php 
        // loop through the rows of data
        while ( have_rows('slides') ) : the_row();?>

            <?php 
            $caption = get_sub_field('caption');
            $image_alt = get_sub_field('image_alt');
            $image = get_sub_field('image');
            if( ! $image ) {
                $image_url = get_placeholder_image(1230,600);
            } else {
                $image_url = $image['url'];
            }
            ?>
                
            <div class="slide">
                <img src="<?php echo esc_url($image_url); ?>" width="<?php echo esc_attr($image['width']);?>" height="<?php echo esc_attr($image['height']);?>" alt="<?php echo esc_attr($image_alt); ?>" />
                <?php if ($caption): ?>
                    <p class="slide-caption">
                        <?php echo esc_html($caption); ?>
                    </p>
                <?php endif; ?>
            </div>
            
        <?php endwhile; ?>

            

        

    </div>

    <?php else : ?>

        <div class="slideshow-placeholder">
        <?php $image = get_placeholder_image(1230,600,"Slideshow"); ?>
        <img src="<?php echo $image ; ?>" width="1230" height="600" alt="Placeholder Image" />
        </div>

    <?php endif; ?>

    
</div>