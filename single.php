<?php
/**
 * The template for displaying all single posts
 */
?>

<?php get_header(); ?>

<?php // include content start
get_template_part( 'page-inc-content-start');
?>
    
    <?php while ( have_posts() ) : the_post(); ?>
        
            <?php the_content();?>
            
    <!-- #post-## -->
    <?php endwhile; // end of the loop. ?>

    
    <div class="block_size_wide">
        <nav role="navigation" id="nav-below" class="paging-navigation fullwidth" itemprop="navigation">
        <h3 class="screen-reader-text">Post navigation</h3>
        <ul class="pager">			
        <li class="nav-previous previous"><a href="javascript:history.back()">Back</a></li>
        </ul>
        </nav><!-- #nav-below -->
    </div>
    
    
    
<?php // include content end
get_template_part( 'page-inc-content-end');
?>


<?php get_footer(); ?>