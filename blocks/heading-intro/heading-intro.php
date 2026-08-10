<?php
/**
 * Heading Intro Block Template.
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
$headline = get_field('headline');
if (!$headline) {
    $headline = "Placeholder Headline";
}
$small_text = get_field('small_text');
$heading_size = get_field('heading_size');
$heading_alignment = "left";

$one_column = get_field( 'one_column' );
if(!$one_column){
    $one_column = "<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs. Cras lobortis ipsum nibh, a venenatis arcu pellentesque ut. Cras feugiat suscipit elit nec imperdiet. Nulla a ligula nec velit lobortis cursus. Fusce pellentesque hendrerit elit a euismod. Phasellus volutpat augue non dui eleifend egestas.</p>";
}


?>


<div class="heading-intro-box <?php get_block_options();?>" <?php render_block_anchor(); ?>>

    <?php // full size limit text to wide container
    $block_size = get_field('block_size');
    if ( $block_size == 'block_size_full' ) { ?>
    <div class="inner_alignwide">
    <?php } ?>

    <div class="heading-intro-box-wrap">

        <div class="heading-title-wrap">

            <?php if ($small_text) { ?>
                <div class="small-text">
                    <?php echo esc_html($small_text); ?>
                </div>
            <?php } ?>

            <<?php echo esc_attr($heading_size); ?><?php if (!empty($anchor)) { echo ' id="' . esc_attr($anchor) . '"'; } ?> class="<?php echo esc_attr($heading_alignment); ?>">
            <?php echo wp_kses_post($headline); ?>
            </<?php echo esc_attr($heading_size); ?>>

        </div>

        <div class="text clear-both"> 
            <?php echo wp_kses_post($one_column);?>
            <?php 
            // displayShowLink($wrapper = "p",$sub = true,$prefix = "none",$display = true)
            displayShowLink("p",false,"none");
            ?>
        </div>

    </div>

    <?php if ( $block_size == 'block_size_full' ) { // end full size limit text to wide container?>
    </div>
    <?php } ?>

</div>