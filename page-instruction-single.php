<?php
/**
 * Template Name: Instruction Single
 */
$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>
<div id="primary" class="content-area-full outfitters <?php echo $has_banner ?>">
	<main id="main" class="site-main fw-left" role="main">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php if( get_the_content() ) { ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>

			<?php get_template_part("parts/subpage-tabs"); ?>

		<?php endwhile; ?>

		<?php 
		function sortCourseByDay($courses) {
		    // Get the current day of the week (0 = Sunday, 1 = Monday, etc.)
		    $currentDayOfWeek = date('w');

		    // Split the array into two parts: the days before the current day and the days after
		    $daysBeforeCurrentDay = array_slice($courses, $currentDayOfWeek);
		    $daysAfterCurrentDay = array_slice($courses, 0, $currentDayOfWeek);

		    // Combine the two parts and return the sorted array
		    $sortedCourses = array_merge($daysBeforeCurrentDay, $daysAfterCurrentDay);

		    return $sortedCourses;
		}

		$myDays = get_field('schedule_days');

		$sortedCourses = sortCourseByDay($myDays);
		// echo '<pre>';
		// print_r($myDays);
		// echo '</pre>';


		if( have_rows('schedule_days') ): ?>
			<section class="instr-schedule">
				<div class="wwrapper">
					<div class="shead-icon text-center">
						<h2 class="stitle">Upcoming</h2>
					</div>
				</div>
				<div id="inst-sched" class="flexslider-instr flexslider carousel">
					<ul class="slides">
					<?php foreach($sortedCourses as $day) { 
						$courseinfo = $day['coursetime'];
						$day_image = $day['day_image'];
					?>
						<li id="<?php echo $day['day_name'] ?>" class="slide-item">
							<div class="day">
								<?php if($day_image){ ?>
									<div class="image">
										<img src="<?php echo $day_image['url']; ?>">
									</div>
								<?php } ?>
								<div class="contents js-blocks">
									<h3><?php echo $day['day_name'] ?></h3>
									<?php foreach( $courseinfo as $c ) { 
										$product_link = $c['product_link'];
										?>
										<div class="row">
											<div class="left"><?php echo $c['time']; ?></div>
											<div class="right">
												<?php if($product_link){ echo '<a data-accesso-keyword="'.$product_link.'" href="#">'; } ?>
												<?php echo $c['course']; ?>
												<?php if($product_link){ echo '</a>'; }?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</li>
					<?php } ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<?php include(locate_template('parts/text-image-blocks-instruction.php')); ?>

				<?php  
				/* WHAT TO BRING */
				$wb_title = get_field("wb_title");
				$wb_text = get_field("wb_text");
				if ( $wb_title && $wb_text ) { ?>
				<section id="section-whattobring" data-section="<?php echo $wb_title ?>" class="section-content dining-section-whattobring">
					<div class="flexwrap">
						<div class="wrapper narrow text-center">
							<?php if ($wb_title) { ?>
								<div class="shead-icon text-center">
									<div class="icon"><span class="ci-backpack"></span></div>
									<h2 class="stitle"><?php echo $wb_title ?></h2>
								</div>
							<?php } ?>
							<div class="text"><?php echo $wb_text ?></div>
						</div>
					</div>
				</section>
				<?php } ?>

				<?php /* FAQ */ ?>
				<?php 
				$faq_title = get_field("faq_title");
				if( $faqs = get_faq_listings($post_id) ) { ?>
					<?php
						$customFAQTitle = $faq_title;
						include( locate_template('parts/content-faqs.php') ); 
						include( locate_template('inc/faqs.php') ); 
					?>
				<?php } ?>

		

			<?php /* FAQ */ ?>
			<?php 
				$customFAQTitle = get_field("faq_section_title");
				//get_template_part("parts/content-faqs"); 
				include( locate_template('parts/content-faqs.php') ); 
			?>

			<?php
			/* FAQS JAVASCRIPT */ 
			include( locate_template('inc/faqs-script.php') ); 
			?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php include( locate_template('inc/pagetabs-script.php') );  ?>
<?php
get_footer();
