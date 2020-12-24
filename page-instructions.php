<?php
/**
 * Template Name: Instruction
 */

get_header(); 
$rectangle = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full instruction-page">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="intro-text-wrap">
				<div class="wrapper">
					<h1 class="page-title"><span><?php the_title(); ?></span></h1>
					<?php if ( get_the_content() ) { ?>
					<div class="intro-text"><?php the_content(); ?></div>
					<?php } ?>
				</div>
			</div>
		<?php endwhile;  ?>

		
</div><!-- #primary -->

<?php
get_footer();
