<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cdev
 */

// vars
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$term_name = $queried_object->name;  
?>
<?php get_header(); ?>

<?php // include content start
get_template_part( 'page-inc-content-start');
?>

        <?php 
        include get_template_directory() . '/blocks/page-header/page-header.php'; 
        ?>
    
        

    
        <div class="block_size_wide">
    
            
            <div class="blog_header">
                <ul class="blogcats">
                
                <?php 
                $category = get_queried_object();
                $current_category_id = $category->term_id;
                $current_category = $category->name;
                //echo $current_category;
                if ( $current_category == "Blog" ){ ?>
                <li class="active"><a href="<?php echo esc_url( home_url() ); ?>/blog/">View All</a></li>
                <?php } else { ?>
                <li><a href="<?php echo esc_url( home_url() ); ?>/blog/">View All</a></li>
                <?php } ?>
                
                <?php // get blog categories
                $categories = get_categories( array(
                    'orderby' => 'name',
                    'parent'  => 1,
                    'hide_empty' => 0
                ) );
                foreach ( $categories as $category ) {
                    $cat_title = esc_html( $category->name );
                    $cat_url = esc_url( get_category_link( $category->term_id ) );
                    $cat_id = $category->term_id;
                    if( $current_category_id == $cat_id ){
                        $cat_class = "active";
                    } else {
                        $cat_class = "";
                    }
                ?>
                <li class="<?php echo $cat_class; ?>"><a href="<?php echo $cat_url; ?>"><?php echo $cat_title; ?></a></li>
                <?php } ?>
                
                </ul>
            </div>
            
            
        
           
            
            <div class="bloggrid">

                    <?php if ( have_posts() ) : ?>

                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'loop', 'blog-listing' );
                    endwhile;
                    else : ?>
                    
                    <?php endif; ?>

            </div>

            <?php
            the_posts_navigation();
            
            ?>

        
        </div>
    
        


<?php // include content end
get_template_part( 'page-inc-content-end');
?>
<?php get_footer(); ?>