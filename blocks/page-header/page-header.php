<?php
/**
 * cdev Page Header Block Template.
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

// Determine the title to display
// Limit blog logic to the post type so other CPT singles (e.g. resource) are not treated as blog
$is_blog = is_singular( 'post' ) || is_category() || is_archive() || ( is_admin() && get_post_type() == 'post' );

// Allow templates to pass $title_override / $title_tag before include
if ( empty( $title_override ) ) {
	$title_override = '';

	// If this is a blog page, set the title to "Blog"
	if ( $is_blog ) {
		$title_override = is_category() || is_archive() ? single_cat_title( '', false ) : 'Blog';
	}
	// If this is a search page, set the title to "Search"
	if ( is_search() ) {
		$title_override = 'Search';
	}
	// if this is the 404 page, set the title to "404"
	if ( is_404() ) {
		$title_override = get_field( 'error_headline', 'options' );
		if ( ! $title_override ) {
			$title_override = '404 Page Not Found';
		}
	}
}

$override_page_title = get_field( 'override_page_title' );
$title               = $title_override ?: $override_page_title ?: get_the_title();
$title_tag           = $title_tag ?? 'h1';
$has_title_override  = ! empty( $title_override ) || ! empty( $override_page_title );

// Get header style and background (templates may pass $header_style before include)
if ( empty( $header_style ) ) {
	$header_style = get_field( 'header_style' );
}

if ($header_style == 'header-simple' || $header_style == 'header-banner' || $header_style == 'header-banner-jumbo'){
    $header_banner_text_animation = 'has-animation fade-in';
}
if ($header_style == 'header-video' && !get_field('banner_video')){
    $header_banner_text_animation = 'has-animation fade-in';
}
if ($header_style == 'header-slideshow' && !have_rows('banner_slideshow')){
    $header_banner_text_animation = 'has-animation fade-in';
}
?>
<div class="page-header-block block_size_full">
    <div class="page-header white-text <?php echo esc_attr($header_style); ?>">

        <?php // Display the banner text ///////////////////////// ?>
        <div class="wrapper inner_alignwide">
            <div class="header-banner-text clear-both <?php echo esc_attr($header_banner_text_animation); ?>">
                <<?php echo $title_tag; ?> class="h2"<?php echo $has_title_override ? ' data-title-override="true"' : ''; ?>><?php echo $title; ?></<?php echo $title_tag; ?>>
                <?php if (in_array($header_style, ['header-banner-jumbo', 'header-video', 'header-slideshow'])): ?>
                    <?php the_field('banner_text'); ?>
                    <?php displayShowLink("p", false, "none"); ?>
                <?php endif; ?>
            </div>
        </div>


        <?php // Display the banner image ///////////////////////// ?>
        <?php if ($header_style == 'header-banner' || $header_style == 'header-banner-jumbo'): 
            $image = get_field($header_style == 'header-banner' ? 'banner_thin' : 'banner_jumbo');
            $image_height = $header_style == 'header-banner' ? 200 : 400;
            if (!$image) {
                $image = get_placeholder_image(1980, $image_height, "Image", false, true);
            }
            ?>
            <img class="banner-image has-animation fade-in" width="1980" height="<?php echo $image_height;?>" src="<?php echo esc_url($image); ?>" alt="page banner image">
        <?php endif; ?>

        <?php // Display the video ///////////////////////// ?>
        <?php if ($header_style == 'header-video'): 
            $video = get_field('banner_video'); ?>
            <div class="loading-spinner"></div>
            <?php if ($video): ?>
                <video id="banner-video" width="1980" height="600" autoplay muted loop playsinline preload="auto" importance="high">
                    <source src="<?php echo esc_url($video); ?>" type="video/mp4">
                </video>
            <?php else: ?>
                <?php
                echo get_placeholder_image(1980, 600, "Video", true, true);
                ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php // Display the slideshow ///////////////////////// ?>
        <?php if ($header_style == 'header-slideshow' && have_rows('banner_slideshow')): ?>
            <div class="banner_slideshow_wrapper">
                <div class="banner_slideshow">
                    <?php while (have_rows('banner_slideshow')): the_row(); ?>
                        <div class="slide">
                            <img src="<?php echo esc_url(get_sub_field('image')); ?>" width="1980" height="600" alt="<?php echo esc_attr(get_sub_field('image_alt')); ?>">
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php elseif ($header_style == 'header-slideshow'): ?>
            <?php
            echo get_placeholder_image(1980, 600, "Slideshow", true, true);
            ?>
        <?php endif; ?>


    </div>
</div>

<?php // Display H1 if single // ?>
<?php if ($is_blog && !is_category() && !is_archive()): ?>
    <h1 class="block_size_wide"><?php the_title(); ?></h1>
<?php endif; ?>