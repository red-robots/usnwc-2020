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

			<?php
			$mapImage1 = get_field("fm_map_image1");
			$mapImage1width = get_field("fm_map_image1_width");
			if($mapImage1width) {
				$mapw1 = ' style="width:'.$mapImage1width.'%"';
			}

			$mapImage2 = get_field("fm_map_image2");
			$mapImage2width = get_field("fm_map_image2_width");
			if($mapImage2width) {
				$mapw2 = ' style="width:'.$mapImage2width.'%"';
			}
			$mapClass = ($mapImage1 && $mapImage2) ? 'half':'full';
			if($mapImage1 || $mapImage2) { ?>
			<section class="facility-map-section <?php echo $mapClass ?>">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-map"></span></div>
						<h2 class="stitle">MAP</h2>
					</div>
				</div>

				<div class="columns-wrapper">
					<?php if ($mapImage1) { ?>
					<div class="mapcol c1"<?php echo $mapw1 ?>>
						<div class="inside" style="background-image:url('<?php echo $mapImage1['url'] ?>')">
							<a href="<?php echo $mapImage1['url'] ?>" data-fancybox>
								<img src="<?php echo $mapImage1['url'] ?>" alt="<?php echo $mapImage1['title'] ?>" />
								<span class="zoom-icon"><i class="fas fa-search"></i></span>
							</a>
						</div>
					</div>
					<?php } ?>

					<?php if ($mapImage2) { ?>
					<div class="mapcol c2"<?php echo $mapw2 ?>>
						<div class="inside" style="background-image:url('<?php echo $mapImage2['url'] ?>')">
							<a href="<?php echo $mapImage2['url'] ?>" data-fancybox>
								<img src="<?php echo $mapImage2['url'] ?>" alt="<?php echo $mapImage2['title'] ?>" />
								<span class="zoom-icon"><i class="fas fa-search"></i></span>
							</a>
						</div>
					</div>
					<?php } ?>
				</div>

			</section>
			<?php } ?>
		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
