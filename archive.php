<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cdev
 */
?>
<?php get_header(); ?>

<?php // include content start
get_template_part( 'page-inc-content-start');
?>

        <?php //if ( function_exists( 'block_template_part' ) ) : ?>
            <?php 
            $title_override = "Blog";
            include get_template_directory() . '/blocks/page-header/cdev-page-header.php'; 
            ?>
        <?php //endif; ?>
    
        

    
        <div class="block_size_wide">
    
            
            DEFAULT ARCHIVE TEMPLATE

        
        </div>
    
        


<?php // include content end
get_template_part( 'page-inc-content-end');
?>
<?php get_footer(); ?>