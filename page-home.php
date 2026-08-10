<?php
   
  /*
  Template Name: Home Page Template
  */

?>
<?php get_header(); ?>
<?php // include content start
get_template_part( 'page-inc-content-start');
?>

        <?php while ( have_posts() ) : the_post(); ?>
            <?php the_content();?>
        <?php endwhile; // end of the loop. ?>

<?php // include content end
get_template_part( 'page-inc-content-end');
?>
<?php get_footer(); ?>
