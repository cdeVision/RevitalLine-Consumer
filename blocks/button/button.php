<?php
/**
 * Button Block Template.
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
$button_alignment = get_field( 'button_alignment' );
?>

<div class="button-block <?php echo $button_alignment;?> <?php get_block_options();?>">

<?php 
// displayShowLink($wrapper = "p",$sub = true,$prefix = "none")
displayShowLink("none",false,"none");
?>
    
</div>