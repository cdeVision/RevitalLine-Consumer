<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section
 * @package cdev
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	
	<?php // SEO Optimization
    // get page, post or term id
    $term = get_queried_object();
    $term_id = $term->term_id;
    global $post;
        
    if ( $term_id ){
        $seoid = "term_".$term_id;
    } else if ($post){
        $seoid = $post->ID;
    } else {
        $seoid = "";
    }
    ?>

    <?php // SEO vars
    $seo_title = get_field('seo_title',$seoid);
    $seo_description = get_field('seo_description',$seoid);
    $seo_keywords = get_field('seo_keywords',$seoid);
    $seo_noindex = get_field('seo_noindex',$seoid);
    $browser_no_cache = get_field('browser_no_cache',$seoid);
    ?>

    <?php // SEO Title
    if( $seo_title ){ ?>
    <title><?php echo $seo_title; ?></title>
    <?php } else { ?>
    <title><?php bloginfo('name'); ?> | <?php wp_title(''); ?></title>
    <?php } ?>

    <?php // SEO Description
    if( $seo_description ){ ?>
    <meta name="description" content="<?php echo $seo_description; ?>">
    <?php } ?>

    <?php // SEO Keywords
    if( $seo_keywords ){ ?>
    <meta name="keywords" content="<?php echo $seo_keywords; ?>">
    <?php } ?>

    <?php // SEO No Index / Follow
    if( $seo_noindex == "no" ){ ?>
    <meta name="robots" content="noindex,nofollow"/>
	<?php } ?>

    <?php // Allow browser to cache page
    if( $browser_no_cache == "no" ){ ?>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <?php } ?>

    <?php // Head scripts
    the_field('head_scripts','options'); ?>


	<link rel="icon" type="image/png" href="<?php echo esc_url( home_url() ); ?>/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo esc_url( home_url() ); ?>/favicon-16x16.png" sizes="16x16" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="sr-only" href="#maincontent" tabindex="0">Skip to content</a>


<?php if ( is_front_page() && get_field('pop_up_active','options') == "yes" ) : 
    $pop_up_style = get_field('pop_up_style','options');
?>
<div id="popup-overlay" class="popup-overlay hidden"></div>
<div id="homepage-popup" class="popup hidden">
    <div class="popup-content white-text <?php echo $pop_up_style;?>">
        <button class="popup-close"><i class="fa-solid fa-xmark"></i></button>
        <div class="popup-body clear-both">
            <?php if( $pop_up_style == "text-pop" ) { ?>
            <?php the_field('pop_up_text','options'); ?>
            <?php
            // Get Link
            $show_link = get_field('pop_up_show_link','options');
            // URL
            if ($show_link == "url") {
                echo '<a href="' . get_field('pop_up_show_link_url','options') . '" target="' . get_field('pop_up_show_link_target','options') . '" class="box white">' . get_field('pop_up_show_link_title','options') . '</a>';
            }
        
            // 
            if ($show_link == "pdf") {
                echo '<a href="' . get_field('pop_up_show_pdf','options') . '" target="_blank" class="box white pdf">' . get_field('pop_up_show_link_title','options') . '</a>';
            }
        
            // Post
            if ($show_link == "post") {
                echo '<a href="' . get_field('pop_up_show_post','options') . '" class="box white">' . get_field('pop_up_show_link_title','options') . '</a>';
            }
        
            // Email
            if ($show_link == "email") {
                $emailtitle = get_field('pop_up_show_link_title','options');
                $emailaddress = get_field('pop_up_show_email_address','options');
                if ($emailtitle == "") {
                    $emailtitle = $emailaddress;
                }
                echo '<a href="mailto:' . $emailaddress . '" class="box white">' . $emailtitle . '</a>';
            }
            ?>
            <?php } else if( $pop_up_style == "image-pop" ) { ?>
                <?php 
                $pop_up_image = get_field('pop_up_image','options');
                $pop_up_image_alt = get_field('pop_up_image_alt','options');
                $pop_up_image_link = get_field('pop_up_image_link','options');
                ?>
                <?php if( $pop_up_image_link ) { ?>
                <a href="<?php echo esc_url($pop_up_image_link); ?>">
                <?php } ?>
                <img src="<?php echo $pop_up_image; ?>" alt="<?php echo $pop_up_image_alt; ?>" />
                <?php if( $pop_up_image_link ) { ?>
                </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<?php endif; ?>







<!-- Navigation Mobile -->
<div class="mobile-hamburger" id="hamburger">
    <button class="mobile-hamburger__link" aria-expanded="false" aria-controls="site-navigation" aria-label="Toggle navigation menu">Menu</button>
</div>
<!-- // Navigation Mobile -->



<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?> print logo" class="printlogo showprint" fetchpriority="high">


<header id="masthead" class="site-header hideprint">

<?php // Alert bar
$alert_active = get_field('alert_active','options');
$alert_homepage = get_field('alert_homepage','options');
$alert_text = get_field('alert_text','options');
$alert_show = false; // Initialize $alert_show to false
if ( is_front_page() && $alert_homepage == "yes" && $alert_active == "yes" ) {
    $alert_show = true;
} else if ( $alert_homepage == "no" && $alert_active == "yes" ) {
    $alert_show = true;
} else {
    $alert_show = false; // Ensure $alert_show is false if conditions are not met   
}

if ( $alert_show ){ // If Alert bar is active
?>
<div class="alertbar block_size_full">
    <div class="inner_alignwide">
    <div class="wrap">

        <i class="fa-solid fa-times close" aria-hidden="true"><span class="sr-only">Close</span></i>
        
        <div class="text">
        <?php the_field('alert_text','options'); ?>
        </div>
    
    </div>
    </div>
</div>
<?php } ?>
<?php // Alert bar ?>

<div class="block_size_wide">
<div class="site-header__pad">

    <div class="site-branding">
        <?php if ( is_front_page() ) : ?>
            <h1 class="site-branding__site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php else : ?>
            <p class="site-branding__site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php endif; ?>
    </div><!-- .site-branding -->

    <div class="nav-panel">

    <nav id="site-navigation" class="primary-navigation">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'menu_class'        => 'primary-menu',
        ) );
        ?>
    </nav><!-- #site-navigation -->

    </div><!-- .nav-panel -->
    
</div>
</div>
</header><!-- #masthead -->





