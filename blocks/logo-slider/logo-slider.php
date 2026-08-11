<?php
/**
 * Logo Slider Block Template.
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
$text = get_field('text');
$has_text_content = ($headline || $text || (get_field('show_link') && get_field('show_link') !== 'none'));

?>


<div class="logo-slider-block <?php if($has_text_content) echo 'has-text-content'; ?> <?php get_block_options();?>" <?php render_block_anchor(); ?>>

<?php if($has_text_content) : ?>
<div class="logo-slider-text">
    <div class="wrapper">
        <?php if($headline) : ?>
            <h3><?php echo wp_kses_post($headline); ?></h3>
        <?php endif; ?>
        <?php if($text) : ?>
            <?php echo wp_kses_post($text); ?>
        <?php endif; ?>
        <?php 
        // displayShowLink($wrapper = "p",$sub = false,$prefix = "none")
        displayShowLink("p",false,"none");
        ?>
    </div>
</div>
<?php endif; ?>

<div class="logo-slider-logos">

<?php
$number_of_logos = get_field('number_of_logos');
if ( !$number_of_logos ) {
    $number_of_logos = 4;
}
$logos = get_field('logos');
$logo_count = is_array($logos) ? count($logos) : 0;
$is_static = $logo_count > 0 && $logo_count <= 3;
?>
    <?php 
    // check if the repeater field has rows of data
    if( have_rows('logos') ):?>
	<div class="logo_slideshow<?php echo $is_static ? ' is-static' : ''; ?>"<?php if ( ! $is_static ) : ?> data-slick='{
            "slidesToShow": <?php echo esc_attr($number_of_logos); ?>
        }'<?php endif; ?>>

            <?php 
            // loop through the rows of data
            while ( have_rows('logos') ) : the_row();?>

                        <?php 
                        $url = get_sub_field('url');
                        $name = get_sub_field('name');
                        $image = get_sub_field('logo');
                        if( ! $image ) {
                            $image_url = get_placeholder_image(100,100);
                        } else {
                            $image_url = $image['url'];
                        }
                        if ($url){
                        ?>

                            <a class="logo" href="<?php echo esc_url($url); ?>" target="_blank">
                                <img src="<?php echo esc_url($image_url); ?>" width="<?php echo esc_attr($image['width']);?>" height="<?php echo esc_attr($image['height']);?>" alt="<?php echo esc_attr($name); ?>" />
                            </a>

                        <?php } else { ?>
                            
                            <div class="logo">
                                <img src="<?php echo esc_url($image_url); ?>" width="<?php echo esc_attr($image['width']);?>" height="<?php echo esc_attr($image['height']);?>" alt="<?php echo esc_attr($name); ?>" />
                            </div>

                        <?php } ?>
            
        <?php endwhile; ?>

            

        

    </div>
    <?php else : ?>
        <div class="logo-slider-placeholder">
        <?php for ($i = 0; $i < 4; $i++) : ?>
            
            <?php 
            global $placeholder_color;
            global $placeholder_text;
            //$image = 'https://placehold.co/180x100/' . $placeholder_color . '/' . $placeholder_text . '/?text=Logo ' . ($i + 1); 
            $image = get_placeholder_image(100,100,"Logo " . ($i + 1),true,true);
            echo $image;
            ?>
        
        <?php endfor; ?>
        </div>

        <p class="logo-slider-placeholder-note" style="text-align:center;font-size:14px;color: #CCC;">Note: Edit logo slider and add slides</p>

    <?php endif; ?>

</div>
    
</div>