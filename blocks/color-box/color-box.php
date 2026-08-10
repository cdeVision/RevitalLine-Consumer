<?php
/**
 * Color Box Block Template
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
$image = get_field( 'image' );
if(!$image){
    $image = get_placeholder_image(600,600);
}

$image_alt = get_field( 'image_alt' );
if(!$image_alt){
    $image_alt = "Temp ALT Text";
}

$headline = get_field( 'headline' );
if(!$headline){
    $headline = "Placeholder Headline";
}

$text = get_field( 'text' );
if(!$text){
    $text = "<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs.</p>";
}

$block_theme_color = get_field( 'block_theme_color' );
$preview_block_theme_color = "";
if(!$block_theme_color){
    $preview_block_theme_color = "block_theme_color_1";
}
?>

<div class="color-box <?php get_block_options();?> <?php echo $preview_block_theme_color; ?>" <?php render_block_anchor(); ?>>
    
    <div class="image">
        <img src="<?php echo $image; ?>" width="600" height="600" alt="<?php echo $image_alt; ?>">
    </div>

    <div class="text">
        <div class="wrap clear-both">
        <div class="h4"><?php echo $headline; ?></div>
        <?php echo $text; ?>

        <?php 
        // displayShowLink($wrapper = "p",$sub = true,$prefix = "none")
        displayShowLink("p",false,"none");
        ?>
        </div>
    </div>

</div>