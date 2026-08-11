<?php
/**
 * Resource grid item template (Resources Center block + AJAX load more).
 *
 * @package cdev
 */

$loop_id   = get_the_ID();
$permalink = get_permalink( $loop_id );
$title     = get_the_title( $loop_id );
$image     = get_field( 'thumbnail', $loop_id );
$img_url   = '';
$img_alt   = $title;

if ( is_array( $image ) ) {
	$img_url = ! empty( $image['url'] ) ? $image['url'] : '';
	if ( ! empty( $image['alt'] ) ) {
		$img_alt = $image['alt'];
	}
} elseif ( is_string( $image ) && $image ) {
	$img_url = $image;
}

if ( ! $img_url ) {
	$img_url = get_placeholder_image( 600, 400, 'Resource' );
}
?>

<a href="<?php echo esc_url( $permalink ); ?>" class="resource-item" rel="bookmark">
	<div class="resource-item__media">
		<img src="<?php echo esc_url( $img_url ); ?>" width="600" height="400" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy" />
	</div>
	<div class="resource-item__text">
		<h3 class="resource-item__title"><?php echo esc_html( $title ); ?></h3>
	</div>
</a>
