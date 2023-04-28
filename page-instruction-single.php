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

		<?php if( have_rows('schedule_days') ): ?>
			<section class="instr-schedule">
				<?php while (have_rows('schedule_days')): the_row(); 
					$day_name = get_sub_field('day_name');
				?>
				<div class="day">
					<h3><?php echo $day_name ?></h3>
					<?php if( have_rows('coursetime') ): while( have_rows('coursetime') ): the_row(); 
						$course = get_sub_field('course');
						$time = get_sub_field('time');
						?>
						<div class="row">
							<div class="left"><?php echo $course; ?></div>
							<div class="right"><?php echo $time; ?></div>
						</div>
					<?php endwhile; endif; ?>
				</div>
				<?php endwhile; ?>
			</section>
		<?php endif; ?>

		<?php
			if ( have_rows('programs') ) { ?>
			<section class="flex-container store-listings full">
				<?php $i=1; while ( have_rows('programs') ) : the_row(); ?>
					<?php 
					$title = get_sub_field('program_name'); 
					$text = get_sub_field('description');
					$slides = get_sub_field("gallery");
					$details = get_sub_field("popup_details");
					$columnClass = ( $slides && ($text || $brands) ) ? 'half':'full';
					$columnClass .= ($i % 2) ? ' odd':' even';
					?>
					<div id="entry<?php echo $i ?>" data-section="<?php echo $title ?>" class="entry <?php echo $columnClass ?>">
						<div class="flexwrap wow fadeIn">
							
							<?php if ($text) { ?>
							<div class="block textcol">
								<div class="inside">
									<div class="wrap">
										<div class="text text-center">
											<h2 class="stitle"><?php echo $title ?></h2>
											<?php if ($text) { ?>
												<?php echo $text; ?>
											<?php } ?>
										</div>
										
										<?php if ($details) { ?>
											<div class="text-center">
												<div class="button inline">
													<a href="#instr-details<?php echo $i; ?>" class="btn-sm xs instr" id="inline">
														<span>See Details</span>
													</a>
												</div>
												<div class="button inline">
													<a href="#instr-details<?php echo $i; ?>" class="btn-sm xs instr">
														<span>See Details</span>
													</a>
												</div>
											</div>
											<div style="display: none;">
												<div id="instr-details<?php echo $i; ?>" class="instr-details">
													<?php echo $details; ?>
												</div>
											</div>
										<?php } ?>
										
									</div>
								</div>r
							</div>	
							<?php } ?>

							<?php if ($slides) { $count = count($slides); ?>
							<div class="block imagecol">
								<div class="inside">
										<div id="subSlider<?php echo $i?>" class="flexslider posttypeslider <?php echo ($count>1) ? 'doSlider':'noSlider'?>">
											<ul class="slides">
												<?php $helper = THEMEURI . 'images/rectangle-narrow.png'; ?>
												<?php foreach ($slides as $s) { ?>
													<li class="slide-item" style="background-image:url('<?php echo $s['url']?>')">
														<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="placeholder">
														<img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>" class="actual-image" />
													</li>
												<?php } ?>
											</ul>
										</div>
								</div>
							</div>
							<?php } ?>

						</div>
					</div>
				<?php $i++; endwhile; wp_reset_postdata(); ?>
			</section>
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
