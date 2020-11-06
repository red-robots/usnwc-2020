<?php
/**
 * Template Name: Summer Camps
 */
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>

<div id="primary" class="content-area-full summer-camps <?php echo $has_banner ?>">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$short_description = get_the_content();
			if($banner) {
				
				if($short_description) { ?>
				<section class="text-centered-section">
					<div class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php echo anti_email_spam($short_description); ?>
					</div>
				</section>
				<?php } ?>

			<?php } else { ?>

				<section class="text-centered-section noBanner">
					<div class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php echo anti_email_spam($short_description); ?>
					</div>
				</section>

			<?php } ?>

			
		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
