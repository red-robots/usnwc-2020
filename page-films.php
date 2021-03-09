<?php
/**
 * Template Name: Film Series
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full film-series-page festival-page">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if( get_the_content() ) { ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>
		<?php endwhile;  ?>

		<?php get_template_part("parts/film-series-filter"); ?>

</div><!-- #primary -->

<?php
get_footer();
