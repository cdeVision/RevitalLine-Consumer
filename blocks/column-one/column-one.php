<?php
/**
 * One Column Block Template.
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
$one_column = get_field( 'one_column' );
if(!$one_column){
    $one_column = "<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs. Cras lobortis ipsum nibh, a venenatis arcu pellentesque ut. Cras feugiat suscipit elit nec imperdiet. Nulla a ligula nec velit lobortis cursus. Fusce pellentesque hendrerit elit a euismod. Phasellus volutpat augue non dui eleifend egestas.</p>";
}


?>


<div class="one-column-block <?php get_block_options();?>" <?php render_block_anchor(); ?>>

        <?php // full size limit text to wide container
        $block_size = get_field('block_size');
        if ( $block_size == 'block_size_full' ) { ?>
        <div class="inner_alignwide">
        <?php } ?>
    
        <?php // Callout
        $callout = get_field('callout');
        if ( $callout ) { ?>
        <div class="block_callout">
        <div class="content-wrap clear-top">
        <?php } ?>
        

        <?php echo wp_kses_post($one_column);?>
        
        
        <?php if ( $callout ) { // If Callout ?>
        </div>

        <div class="callout_content clear-both">
            
            <?php if ($callout == "text") { // Callout text ?>
                <div class="callout_text_wrap">
                    <div class="text">
                    <?php echo wp_kses_post(get_field('callout_text'));?>
                    </div>
                </div>
                <?php } else if ($callout == "quote") { // Callout quote ?>
                <div class="callout_quote_wrap">
                    <div class="text">
                    <?php the_field('callout_quote_text');?>
                    <p class="quote-by">- <?php the_field('callout_quote_by');?></p>
                    </div>
                </div>
            <?php } else { // Callout image
                $callout_image = get_field('callout_image');
                // Thumbnail size attributes.
                $size = 'cdev_callout';
                $thumb = $callout_image['sizes'][ $size ];
                $thumb_width = $callout_image['sizes'][ $size . '-width' ];
                $thumb_height = $callout_image['sizes'][ $size . '-height' ];
                $callout_image_caption = get_field('callout_image_caption');
                $callout_image_alt = get_field('callout_image_alt');
                ?>
                    <img src="<?php echo esc_url($thumb); ?>" width="<?php echo $thumb_width;?>" height="<?php echo $thumb_height;?>" alt="<?php echo esc_attr($callout_image_alt); ?>" />
                    <?php if( $callout_image_caption ) { ?>
                    <p class="small-text caption"><?php echo $callout_image_caption; ?></p>
                    <?php } ?>
            <?php } ?>
            
        </div>
        </div>
        <?php } // End if callout ?>

        <?php if ( $block_size == 'block_size_full' ) { // end full size limit text to wide container?>
        </div>
        <?php } ?>

</div>