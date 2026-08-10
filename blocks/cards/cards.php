<?php
/**
 * Cards Block Template.
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
$card_headline = get_field('card_headline');
$headline = get_field('headline');

$card_columns = get_field('card_columns') ?: 'grid-3';
$card_background = get_field('card_background') ?: 'block_theme_color_1';
$cards = get_field('cards');

// If no cards array, set default cards
if (!$cards) {
    if($card_columns == 'grid-2') {
        $num_cards = 2; // default to 2 cards
    } elseif($card_columns == 'grid-4') {
        $num_cards = 4; // default to 4 cards
    } else {
        $num_cards = 3; // default to 3 cards
    }

    $cards = array_map(function($i) {
        return [
            'headline' => 'Headline ' . $i,
            'text' => '<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs.</p>',
            'image' => get_placeholder_image(600, 400),
            'image_alt' => 'Temp ALT Text'
        ];
    }, range(1, $num_cards));
}

$block_size = get_field('block_size');
$block_background_image = get_field('block_background_image');
if($block_background_image) {
    $style = ' style="background-image: url(' . esc_url($block_background_image) . ');"';
} else {
    $style = '';
}
?>


<div class="cards-block <?php echo esc_attr(get_block_options()); ?>"<?php echo $style; ?> <?php render_block_anchor(); ?>>

    <?php if ($block_size == 'block_size_full') : ?>
        <div class="inner_alignwide">
    <?php endif; ?>
    
    <?php if ($card_headline == 'yes') : ?>
        <div class="card_headline">
        <h2 class="h2"><?php echo esc_html($headline); ?></h2>
        <?php displayShowLink("none",false,"none"); ?>
        </div>
    <?php endif; ?>

    <?php if ($cards) : ?>
        <div class="cards-grid <?php echo esc_attr($card_columns); ?>">

            <?php foreach ($cards as $card) :
                $headline = $card['headline'] ?: 'Headline';
                $text = $card['text'] ?: '<p>This is placeholder text. Add your content here by selecting this block and entering your text. Customize the text style, formatting, and layout to fit your needs.</p>';
                $image = $card['image'] ?: get_placeholder_image(600, 400);
                $image_alt = $card['image_alt'] ?: 'Temp ALT Text';
                $show_link = $card['show_link'] ?: false;
            ?>
                <div class="card-item <?php echo esc_attr($card_background); ?>">
                    <div class="card-image">
                        <img src="<?php echo esc_url($image); ?>" width="600" height="400" alt="<?php echo esc_attr($image_alt); ?>">
                    </div>
                    <div class="card-text clear-both">
                        <h3 class="h4"><?php echo esc_html($headline); ?></h3>
                        <?php echo wp_kses_post($text); ?>
                    </div>
                    <div class="card-button">
                        <?php 
                        // If show link is not none
                        if ($show_link != "none" ) {

                        // URL
                        if ($show_link == "url") {
                            echo '<a href="' . $card['show_link_url'] . '" target="' . $card['show_link_target'] . '" class="box ' . $card['class'] . '">' . $card['show_link_title'] . '</a>';
                        }

                        // 
                        if ($show_link == "pdf") {
                            echo '<a href="' . $card['show_pdf'] . '" target="_blank" class="box pdf ' . $card['class'] . '">' . $card['show_link_title'] . '</a>';
                        }

                        // Post
                        if ($show_link == "post") {
                            echo '<a href="' . $card['show_post'] . '" class="box ' . $card['class'] . '">' . $card['show_link_title'] . '</a>';
                        }

                        // Email
                        if ($show_link == "email") {
                            $emailtitle = $card['show_link_title'];
                            $emailaddress = $card['show_email_address'];
                            if ($emailtitle == "") {
                                $emailtitle = $emailaddress;
                            }
                            echo '<a href="mailto:' . $emailaddress . '" class="box ' . $card['class'] . '">' . $emailtitle . '</a>';
                        }

                        // Anchor
                        if ($show_link == "anchor") {
                            $show_anchor = $card['show_anchor'];
                            $show_link_title = $card['show_link_title'];
                            $anchor_type = $card['anchor_type'];
                            if (strpos($show_anchor, 'http') !== false) {
                                echo '<a href="' . $show_anchor . '" class="box ' . $anchor_type . ' ' . $card['class'] . '">' . $show_link_title . '</a>';
                            } else {
                                echo '<a href="#' . $show_anchor . '" class="box ' . $anchor_type . ' ' . $card['class'] . '">' . $show_link_title . '</a>';
                            }
                        }

                        // End if show link is not none
                        }
                        ?>


                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <?php if ($block_size == 'block_size_full') : ?>
    </div>
    <?php endif; ?>
    
</div>