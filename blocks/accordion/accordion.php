<?php
/**
 * Accordion Block Template.
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
$accordion_title = get_field('accordion_title');
if( ! $accordion_title ) {
    $accordion_title = 'Placeholder Accordion Title';
}
?>

<?php //render_block_anchor(); ?>
<div class="accordion__wrap <?php get_block_options("block_size_wide");?>" <?php render_block_anchor(); ?>>
	<div class="accordion-wrap">
	<div class="accordiontitle">
	<i class="closedicon fa-solid fa-plus" aria-hidden="true"></i>
	<i class="openicon fa-solid fa-minus" aria-hidden="true"></i>
	<h3><?php echo $accordion_title; ?></h3>
	</div>
	
	<div class="accordioncontent">

	<?php
	echo '<InnerBlocks 
		area="accordion_content" 
		template=\'[["cdev/column-one"]]\'
		templateLock="false"
	/>';
	?>

	</div>

</div>
</div>