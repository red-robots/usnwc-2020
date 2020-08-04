<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); 
$post_type = get_post_type();
$customPostTypes = array('activity');
?>
<div id="primary" class="content-area-full content-default post-type-<?php echo $post_type;?>">
	
	<?php if ($post_type=='post') { ?>
		<main id="main" class="site-main wrapper" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></header>
					<div class="entry-content"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		</main>
	<?php } else { ?>
			
		<?php foreach ($customPostTypes as $pt) {
			get_template_part('parts/post-type',$pt);
		} ?>

	<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
