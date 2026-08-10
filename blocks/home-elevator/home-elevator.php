<?php
/**
 * Home Elevator Block Template.
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
$media_position = "right";


$headline = get_field( 'headline' );
if(!$headline){
    $headline = "Placeholder Headline";
}

$text = get_field( 'text' );
if(!$text){
    $text = "<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs.</p>";
}

?>


<div class="home-elevator-wrap <?php get_block_options('block_size_full');?>" <?php render_block_anchor(); ?>>
<div class="home-elevator <?php echo esc_attr($media_position);?>">

    <div class="media">
        <?php
            $image = get_field( 'image' );
            if(!$image){
                $image = get_placeholder_image(600,400);
            }
            $image_alt = get_field( 'image_alt' );
            if(!$image_alt){
                $image_alt = "Temp ALT Text";
            }
            ?>
            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>">

    </div>

    <div class="text">
        <div class="text-inner clear-both">
            <div class="h2"><?php echo wp_kses_post($headline); ?></div>
            <?php echo wp_kses_post($text); ?>
            <?php displayShowLink("p", false, "none"); ?>
        </div>
    </div>

</div>
</div>