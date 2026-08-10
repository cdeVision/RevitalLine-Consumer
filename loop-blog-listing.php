
<a href="<?php the_permalink(); ?>" class="blogitem" rel="bookmark" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

<div class="object-fit-image">
    <?php if ( get_field('thumbnail') ) { ?>	
    <?php // get thumbnail
    $image = get_field('thumbnail');
    $size = 'cdev_post_thumb';
    $thumb = $image['sizes'][ $size ];
    $alt = get_the_title();
    ?>
    <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
    <?php } else { ?>
    <img src="<?php echo get_bloginfo('template_directory'); ?>/images/press_default.png" alt="<?php echo $alt; ?>" />
    <?php } ?>
</div>

<div class="text">
    <div class="postcatsingle">
    <?php
    $catstep = 1;
    foreach((get_the_category()) as $category) {
        
        if ($catstep == 1){
            echo $category->cat_name;
        } else {
            echo ', ' . $category->cat_name;
        }
        $catstep ++;
    }
    ?>
    </div>
    <h3 class="h4"><?php the_title();?></h3>
</div>

</a>