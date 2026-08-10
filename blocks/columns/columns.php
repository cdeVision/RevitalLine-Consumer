<?php
/**
 * Columns Block Template.
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


<div class="columns-block <?php get_block_options();?>" <?php render_block_anchor(); ?>>
<?php // full size limit text to wide container
$block_size = get_field('block_size');
if ( $block_size == 'block_size_full' ) { ?>
<div class="full_inner_alignwide">
<?php } ?>


<?php 
// Column settings ////////////
$column_number = get_field('column_number');
if ( !$column_number ) {
    $column_number = 2;
}
$column_images = get_field('column_images');
$column_links = get_field('column_links');
$column_links_position = get_field('column_links_position');

$column_headline = get_field('column_headline');
$headline = get_field('headline');
if (!$headline) {
    $headline = "Placeholder Headline";
}

// Heading settings ///////////////
$heading_size = get_field('heading_size');
if (!$heading_size) {
    $heading_size = "h3";
}

$heading_alignment = get_field('heading_alignment');
if (!$heading_alignment) {
    $heading_alignment = "left";
}
?>

<?php if ( $column_headline == "yes" ) { ?>
<<?php echo $heading_size; ?> class="column_headline <?php echo esc_attr($heading_alignment); ?>">
    <?php echo wp_kses_post($headline); ?>
</<?php echo $heading_size; ?>>
<?php } ?>

    <div class="columns colnum-<?php echo $column_number; ?> <?php echo $column_links_position; ?>">
    <?php 
    // loop
    for ($c = 1; $c <= $column_number; $c++) {
    ?>

    <div class="col block_content <?php echo $column_links; ?>">

            <?php 
            if( $column_images == "yes" ){
            // image
            $column_image = get_field('column_image_' . $c);
            if( ! $column_image ) {
                // Get placeholder image from theme options
                $column_image = get_placeholder_image();
                $column_image_alt = "placeholder image";
            } else {
                $column_image_alt = get_sub_field('column_image_alt_' . $c);
            }
            ?>
                    <div class="column_image">
                    <img src="<?php echo $column_image; ?>" width="600" height="400" alt="<?php echo $column_image_alt; ?>">
                    </div>
            <?php } ?>

            <?php 
            if( $column_images == "icon" ){
            // image
            $column_icon = get_field('column_icon_' . $c);
            ?>
                    <div class="column_icon">
                    <?php echo $column_icon; ?>
                    </div>
            <?php } ?>

            <?php // Get column text
            $coltext = get_field('column_' . $c);
            if( !$coltext ){
                $coltext = "<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs. Cras lobortis ipsum nibh, a venenatis arcu pellentesque ut. Cras feugiat suscipit elit nec imperdiet. Nulla a ligula nec velit lobortis cursus. Fusce pellentesque hendrerit elit a euismod. Phasellus volutpat augue non dui eleifend egestas.</p>";
            } 
            echo wp_kses_post($coltext);
            ?>

            <?php // if link
                    //echo "LINK_1: " . print_r(get_sub_field('link_1'));
                    if( $column_links != "no" ) {
                    if( have_rows('link_' . $c) ) {
                        while( have_rows('link_' . $c) ) {
                        the_row();
                        // displayShowLink($wrapper = "p", $sub = true, $prefix = "none", $class = "")
                        displayShowLink();
                    }
                    }
                    } // end if column links ?>

    </div>


    <?php } ?>

    </div>

<?php if ( $block_size == 'block_size_full' ) { // end full size limit text to wide container?>
</div>
<?php } ?>
</div>
