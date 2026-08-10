<?php
/**
 * Button Bar Template.
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

// Get Vars
$button_alignment = esc_attr(get_field('button_alignment'));
$block_size = get_field('block_size');
?>


<div class="button-bar-block <?php echo esc_attr(get_block_options()); ?>" <?php render_block_anchor(); ?>>

    <?php if ($block_size == 'block_size_full') : ?>
        <div class="inner_alignwide">
    <?php endif; ?>

    <div class="button_bar <?php echo $button_alignment; ?>">
        <?php if (have_rows('buttons')) : ?>
            <?php while (have_rows('buttons')) : the_row(); ?>
                <?php displayShowLink("nowrapper"); ?>
            <?php endwhile; ?>
        <?php else : ?>
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <?php displayShowLink("nowrapper"); ?>
            <?php endfor; ?>
        <?php endif; ?>
    </div>

    <?php if ($block_size == 'block_size_full') : ?>
        </div>
    <?php endif; ?>

</div>