<?php
// redirect to 1st sub page
$pagekids = get_pages("child_of=".$post->ID."&sort_column=menu_order");
if ($pagekids) {
$firstchild = $pagekids[0];
wp_redirect(get_permalink($firstchild->ID));
} else {
// Do whatever templating you want as a fall-back.
}


/**
 * The template for displaying all pages
 */
?>
<?php get_header(); ?>

<?php // include content start
get_template_part( 'page-inc-content-start');
?>
        
    <?php // Check if login required and form
    if ( post_password_required() ) { ?>

        <div>
        <?php echo get_the_password_form(); ?>
        </div>

    <?php // Logged in show content 
    } else { ?>

        <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content();?>
        <?php endwhile; // end of the loop. ?>

    <?php } ?>


<?php // include content end
get_template_part( 'page-inc-content-end');
?>
<?php get_footer(); ?>