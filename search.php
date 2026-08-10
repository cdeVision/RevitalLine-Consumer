<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package cdev
 */

get_header();
?>
<?php // include content start
get_template_part( 'page-inc-content-start');
?>
    

		<?php 
		include get_template_directory() . '/blocks/page-header/page-header.php'; 
		?>



		<?php // Use Plugin: ACF: Better Search /////////////////////////////  ?>

				<h2 class="block_size_wide">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'cdev' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h2>

				<div class="block_size_wide search-page-form">
					<?php get_template_part( 'search-form' ); ?>
				</div>

    <?php if ( have_posts() ) : ?>

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
				the_post();

				?>

					<div class="block_size_wide block_text_width_narrow searchresult">

					<h4>	
					<?php
					$blocks = parse_blocks( get_post_field( 'post_content', get_the_ID() ) );
					// Get override_page_title from page-header block (field lives in block, not post).
					$override_title = '';
					$get_page_header_override = function( $blocks ) use ( &$get_page_header_override ) {
						foreach ( $blocks as $block ) {
							if ( ( $block['blockName'] ?? '' ) === 'core/block' && ! empty( $block['attrs']['ref'] ) ) {
								$ref_post = get_post( $block['attrs']['ref'] );
								if ( $ref_post && $ref_post->post_type === 'wp_block' ) {
									$found = $get_page_header_override( parse_blocks( $ref_post->post_content ) );
									if ( $found !== '' ) {
										return $found;
									}
								}
								continue;
							}
							if ( ( $block['blockName'] ?? '' ) === 'cdev/page-header' && isset( $block['attrs']['data']['override_page_title'] ) ) {
								$val = trim( (string) $block['attrs']['data']['override_page_title'] );
								if ( $val !== '' ) {
									return $val;
								}
							}
							if ( ! empty( $block['innerBlocks'] ) ) {
								$found = $get_page_header_override( $block['innerBlocks'] );
								if ( $found !== '' ) {
									return $found;
								}
							}
						}
						return '';
					};
					$override_title = $get_page_header_override( $blocks );
					if ( $override_title ) {
						echo esc_html( $override_title );
					} else {
						the_title();
					}
					?>
					</h4>
					<?php
					// dump vars
					//var_dump($blocks);
					$text_content = '';
					$allowed_fields = [
						'accordion_title', 'banner_headline', 'banner_text',
						'callout_image_caption',
						'callout_quote_by', 'callout_quote_text', 'callout_text',
						'caption',
						'column_1', 'column_2', 'column_3', 'column_4', 'column_5',
						'headline',
						'image_caption',
						'intro', 'left_column',
						'name', 'one_column', 'override_page_title',
						'quote_by', 'quote_text',
						'right_column', 'single_column',
						'text',
						'video_caption',
					];

					// Recursive function to extract text from blocks and innerBlocks
					$extract_block_text = function( $blocks ) use ( &$extract_block_text, $allowed_fields, &$text_content ) {
						foreach ( $blocks as $block ) {
							// $block_name = $block['blockName'] ?? 'unknown'; // testing

							// Handle synced patterns (reusable blocks) — fetch referenced wp_block post content
							if ( $block['blockName'] === 'core/block' && ! empty( $block['attrs']['ref'] ) ) {
								$ref_post = get_post( $block['attrs']['ref'] );
								if ( $ref_post && $ref_post->post_type === 'wp_block' ) {
									$ref_blocks = parse_blocks( $ref_post->post_content );
									$extract_block_text( $ref_blocks );
								}
								continue;
							}

							if ( isset( $block['attrs']['data'] ) && is_array( $block['attrs']['data'] ) ) {
								foreach ( $block['attrs']['data'] as $key => $value ) {
									// Only add content from the allowed fields
									if ( in_array( $key, $allowed_fields, true ) && is_string( $value ) ) {
										$clean = trim( wp_strip_all_tags( $value ) );
										// Skip empty values, ACF falsy returns, and boolean-like strings
										if ( $clean === '' || $clean === '0' || $clean === 'no' || $clean === 'yes' ) {
											continue;
										}
										$text_content .= ' ' . $clean;
										// $text_content .= ' ' . $clean . ' (' . $block_name . ')'; // testing: shows block name
									}
									// TEMP DEBUG: show all string field keys being found
									// if ( is_string( $value ) && ! is_numeric( $key ) ) { $text_content .= ' [field:' . $key . ']'; }
								}
							}
							// Recurse into inner blocks
							if ( ! empty( $block['innerBlocks'] ) ) {
								$extract_block_text( $block['innerBlocks'] );
							}
						}
					};

					$extract_block_text( $blocks );

					$excerpt = wp_trim_words($text_content, 50, '...');
					echo '<p>' . esc_html($excerpt) . '</p>';
					?>
					<p class="linkwrap"><a class="box" href="<?php the_permalink(); ?>">Read More</a></p>

					</div>

				<?php
				endwhile;
				echo get_the_posts_pagination(
					array(
						'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
						'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
					)
				);
				else :
				?>
					<div class="fullwidth block_size_wide searchresult">
						<p>No results</p>
					</div>
				<?php
				endif;
				?>

    
<?php // include content end
get_template_part( 'page-inc-content-end');
?>

<?php get_footer(); ?>
