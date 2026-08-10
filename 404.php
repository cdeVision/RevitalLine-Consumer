<?php
/**
 * 404 Template
 */
?>
<?php get_header(); ?>

<?php // include content start
get_template_part( 'page-inc-content-start');
?>

    <?php include get_template_directory() . '/blocks/page-header/page-header.php'; ?>
    
        
    <div class="block_size_wide" style="min-height:600px;">

    <?php 
    $error_text = get_field('error_text', 'options');
    echo $error_text ? $error_text : "<p><b>Oops! Page Not Found (404 Error)</b><br>It looks like the page you're looking for doesn't exist. It may have been moved, deleted, or never existed in the first place.</p>";
    ?>

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="box" target="_self">
        <?php 
        $error_link_text = get_field('error_link_text', 'options');
        echo $error_link_text ? $error_link_text : "Home"; 
        ?>
    </a>

    </div>


<?php // include content end
get_template_part( 'page-inc-content-end');
?>
<?php get_footer(); ?>