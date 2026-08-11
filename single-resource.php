<?php
/**
 * The template for displaying single Resource posts
 */
?>

<?php get_header(); ?>

<?php // include content start
get_template_part( 'page-inc-content-start' );
?>

	<?php
	$title_override = 'How-to Resources';
	$title_tag      = 'div'; // Real H1 is the resource title below
	$header_style   = 'header-simple';
	include get_template_directory() . '/blocks/page-header/page-header.php';
	?>

	<?php while ( have_posts() ) : the_post(); ?>

		<h1 class="h2 block_size_wide"><?php the_title(); ?></h1>

		<?php the_content(); ?>

	<?php endwhile; ?>

	<div class="block_size_wide">
		<nav role="navigation" id="nav-below" class="paging-navigation fullwidth" itemprop="navigation">
			<h3 class="screen-reader-text">Post navigation</h3>
			<ul class="pager">
				<li class="nav-previous previous"><a href="javascript:history.back()">Back</a></li>
			</ul>
		</nav><!-- #nav-below -->
	</div>

<?php // include content end
get_template_part( 'page-inc-content-end' );
?>

<?php get_footer(); ?>
