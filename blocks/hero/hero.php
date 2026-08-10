<?php
/**
 * Hero Block Template.
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
$hero_style = get_field('hero_style');
if( ! $hero_style ) {
	$hero_style = 'text';
}
$display_text = get_field('display_text');
if( ! $display_text ) {
    $display_text = 'left';
}

$image = get_field('image');
if( ! $image ) {
	// Get placeholder image
	//$image = get_placeholder_image(1980,800,"Image");
	global $placeholder_color;
	global $placeholder_text;
	$width = 1980;
	$height = 800;
	$title = "Image";
	$image = "https://placehold.co/{$width}x{$height}/" . $placeholder_color . "/" . $placeholder_text . "/?text=" . $title;
}


$headline = get_field('headline');
if( ! $headline ) {
    $headline = 'Placeholder Headline';
}
$text = get_field('text');
if( ! $text ) {
    $text = '<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs. Cras lobortis ipsum nibh, a venenatis arcu pellentesque ut. Cras feugiat suscipit elit nec imperdiet.</p>';
}

$show_link = get_field('show_link');

$quote_text = get_field('quote_text');
if( ! $quote_text ) {
		$quote_text = '"This is a placeholder quote. Cras lobortis ipsum nibh, a venenatis arcu pellentesque ut. Cras feugiat suscipit elit nec imperdiet."';
}
$quote_by = get_field('quote_by');
if( ! $quote_by ) {
		$quote_by = 'Anonymous';
}


?>


<div class="hero-block <?php get_block_options("block_size_full");?>" <?php render_block_anchor(); ?>>
<div class="hero-block-inner" style="background-image: url(<?php echo esc_url($image); ?>)">

    <div class="inner_alignwide">
		<div class="text <?php echo esc_attr($display_text); ?>">
			<?php if( $hero_style == 'text' ) { // Text ?>
			<div class="hero-block-inner-wrap white-text clear-both">
			<h3><?php echo wp_kses_post($headline); ?></h3>
			<?php echo wp_kses_post($text); ?>
			<?php 
			if($show_link != "none"){
			// displayShowLink($wrapper = "p", $sub = true, $prefix = "none", $class = "")
			displayShowLink("none", false, "none");
			}
			?>
			</div>
			<?php } else { // Quote ?>
			<div class="hero-block-inner-quote-wrap white-text clear-both">
			<p class="quote-text h3"><?php echo wp_kses_post($quote_text); ?></p>
			<p class="quote-by">- <?php echo wp_kses_post($quote_by); ?></p>
			</div>
			<?php } ?>
		</div>
	</div>

</div>
</div>