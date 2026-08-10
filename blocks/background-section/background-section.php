<?php
/**
 * Background Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

// Get the preview image if it exists
if (display_preview_image()) {
    return;
}

// Vars
$background_image = get_field('background_image');
$background_image_position = get_field('background_image_position') ?: 'fixed';
if ($background_image) {
    $style_attr = ' style="background-image: url(' . esc_url($background_image) . ');"';
} else {
    $style_attr = '';
}
$position_class = $background_image_position === 'scroll' ? ' bg-scroll' : '';
?>

<div class="wrapper-background-block<?php echo $position_class; ?> <?php get_block_options(); ?>" <?php echo $style_attr; ?> <?php render_block_anchor(); ?>>
    
    <?php
	echo '<InnerBlocks 
		area="background_section_content" 
		template=\'[["cdev/column-one"]]\'
		templateLock="false"
	/>';
	?>

</div>