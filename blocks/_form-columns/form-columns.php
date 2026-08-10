<?php
/**
 * Form Columns Block Template.
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
$headline = get_field('headline');
if (!$headline) {
    $headline = "Placeholder Headline";
}
$headline_size = get_field('headline_size');
if (!$headline_size) {
    $headline_size = "h2";
}
$headline_position = get_field('headline_position');
if (!$headline_position) {
    $headline_position = "before";
}
$text = get_field('text');
if (!$text) {
    $text = "<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs. Cras lobortis ipsum nibh, a venenatis arcu pellentesque ut.</p>";
}

?>


<div class="form-columns-block <?php get_block_options();?>" <?php render_block_anchor(); ?>>

    <?php if ($headline_position == "before") { ?>
        <<?php echo $headline_size;?>><?php echo wp_kses_post($headline);?></<?php echo $headline_size;?>>
    <?php } ?>
    <div class="columns colnum-2">

        <div class="col block_content clear-top">
            <?php if ($headline_position == "inside") { ?>
                <<?php echo $headline_size;?>><?php echo $headline;?></<?php echo $headline_size;?>>
            <?php } ?>
            <?php
            echo '<InnerBlocks 
                area="form_columns_content" 
                template=\'[["cdev/column-one"],["cdev/columns"]]\'
                allowedBlocks=\'["cdev/column-one","cdev/columns"]\'
                templateLock="false"
            />';
            ?>
            
        </div>
        
        <div class="col block_content clear-top flexible-content-small">
            
            <?php // Get form
            $form = get_field('gf_form_id'); 
            if ( $form ){
                if ( $is_preview ) {
                    echo get_placeholder_image(600, 600, "Form", true, true);
                } else {
                    // Render Gravity Form shortcode
                    echo do_shortcode( '[gravityform id=' . $form . ' title=false description=false ajax=true]' );
                }
            } else {
                echo get_placeholder_image(600, 600, "Form", true, true);
            } ?>


        </div>
        
    </div>
    
</div>